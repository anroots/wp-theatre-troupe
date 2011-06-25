<?php
/**
 * Main plugin class
 */
class Theatre_Troupe {

    public $options = array( 'actors_main_page' => 2 ); // Plugin settings

    function Theatre_Troupe() {
        global $wpdb;

        //$this->install(); // Uncomment to create SQL tables

        // Set database table names
        if ( !isset($wpdb->ttroupe_series) ) {
            $wpdb->ttroupe_series = $wpdb->prefix . 'ttroupe_series';
            $wpdb->ttroupe_shows = $wpdb->prefix . 'ttroupe_shows';
        }


        // Overwrite default settings with those saved by the user
        $storedOptions = get_option('theatre_troupe_options');
        if ( !empty($storedOptions) && is_array($storedOptions) ) {
            foreach ( $storedOptions as $key => $value ) {
                $this->options[$key] = $value;
            }
        }
    }


    /**
     * Saves plugin settings to the WP options table
     * @return void
     */
    public function save_options() {
        update_option('theatre_troupe_options', $this->options);
    }


    /**
     * Returns series
     * @param int $series_id
     * @param string $status
     * @return mixed
     */
    public function get_series($series_id = NULL, $status = 'active') {
        global $wpdb;
        if ( !empty($series_id) ) {
            $series_id = " AND id='$series_id'";
        }
        return $wpdb->get_results("SELECT * FROM $wpdb->ttroupe_series
				WHERE status = '$status' $series_id", OBJECT);
    }


    /**
     * Returns shows
     * @param int $show_id If specified, return info about a specific show
     * @param string $status Allows to view deleted or active shows
     * @return mixed
     */
    public function get_shows($show_id = NULL, $status = 'active') {
        global $wpdb;
        if ( !empty($show_id) ) {
            $show_id = " AND $wpdb->ttroupe_shows.id = '$show_id'";
        }

        $sql = "SELECT $wpdb->ttroupe_shows.*, $wpdb->ttroupe_series.title AS series_title
									FROM $wpdb->ttroupe_shows
									LEFT JOIN $wpdb->ttroupe_series ON ($wpdb->ttroupe_series.id = $wpdb->ttroupe_shows.series_id)
									WHERE $wpdb->ttroupe_shows.status = '$status'$show_id";
        if ( $status == 'active' ) {
            $sql .= "AND $wpdb->ttroupe_series.status = '$status'$show_id";
        }

        $query = $wpdb->get_results($sql, OBJECT);
        if ( empty($show_id) ) {
            return $query;
        }
        return $query[0];
    }


    /**
     * Return information about the actors
     * @return mixed
     */
    public function get_actors() {
        $profile_parent = $this->options['actors_main_page']; // ID of the page whose subpages are actors.
        return get_pages('child_of=' . $profile_parent);
    }


    /**
     * Insert a new series to the database.
     * @param string $title
     * @return bool|int New row ID
     */
    public function add_series($title) {
        if ( empty($title) ) {
            return FALSE;
        }
        global $wpdb;
        $wpdb->insert($wpdb->ttroupe_series, array( 'title' => $title ));
        return $wpdb->insert_id;
    }


    /**
     * Delete an object (show, actor, series)
     * @param string $where Which table to use
     * @param int $id
     * @param string $status New status
     * @return bool
     */
    public function change_status($where = 'shows', $id, $status = 'active') {
        if ( !$this->check_existence($where, $id)
             || !in_array($status, array( 'active', 'deleted' ))
             || !is_numeric($id)
        ) {
            return FALSE;
        }
        global $wpdb;

        if ( $where == 'series' ) {
            $table = $wpdb->ttroupe_series;
        } else {
            $table = $wpdb->ttroupe_shows;
        }

        // If status is already deleted, the 2nd call deletes the record permanently.
        if ( $status == 'deleted' ) {
            $prev_status = $wpdb->get_var("SELECT status FROM $table WHERE id='$id'");
            if ( $prev_status == 'deleted' ) {

                $wpdb->query("DELETE FROM $table WHERE id='$id'");

                // Deleting a series cascades to shows
                if ( $where == 'series' ) {
                    $wpdb->query("DELETE FROM $wpdb->ttroupe_shows WHERE series_id='$id'");
                }
            }
        }

        $wpdb->update($table, array( 'status' => $status ), array( 'id' => $id ));
        return TRUE;
    }


    /**
     * Create a new show
     * @param int $series_id Required, links shows with series
     * @param string $title Required
     * @param string $location
     * @param string $start Required
     * @param string $end
     * @return int|bool New show ID
     */
    public function create_show($series_id, $title, $location, $start, $end) {
        $series_id = (int) $series_id;
        if ( empty($start) ||
             empty($series_id) ||
             !$this->check_existence('series', $series_id)
        ) {
            return FALSE;
        }

        global $wpdb;
        $wpdb->insert($wpdb->ttroupe_shows, array( 'series_id' => $series_id,
                                                 'title' => $title,
                                                 'location' => $location,
                                                 'start_date' => $start,
                                                 'end_date' => $end ));
        return $wpdb->insert_id;
    }


    /**
     * Update show info
     * @param  $show_id
     * @param  $series_id
     * @param  $title
     * @param  $location
     * @param  $start
     * @param  $end
     * @return bool
     */
    public function update_show($show_id, $series_id, $title, $location, $start, $end) {
        $series_id = (int) $series_id;
        if ( empty($title) ||
             empty($start) ||
             empty($series_id) ||
             !$this->check_existence('series', $series_id) ||
             !$this->check_existence('shows', $show_id)
        ) {
            return FALSE;
        }

        global $wpdb;
        $wpdb->update($wpdb->ttroupe_shows, array( 'series_id' => $series_id,
                                                 'title' => $title,
                                                 'location' => $location,
                                                 'start_date' => $start,
                                                 'end_date' => $end ), array( 'id' => $show_id ));
        return TRUE;
    }


    /**
     * Check for series/show existence
     * @param string $where Either series or shows
     * @param int $id
     * @return bool
     */
    public function check_existence($where, $id) {
        global $wpdb;

        if ( $where == 'series' ) {
            $table = $wpdb->ttroupe_series;
        } else {
            $table = $wpdb->ttroupe_shows;
        }
        $result = $wpdb->get_row("SELECT id FROM $table WHERE id='$id'");
        if ( !empty($result) ) {
            return TRUE;
        }
        return FALSE;
    }


    /**
     * Create database tables during the installation of the plugin
     * @return void
     * @todo Call this function from the installation script
     */
    function install() {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $table_name = $wpdb->prefix . 'ttroupe_series';
        $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  title VARCHAR(55) DEFAULT 'No Name' NOT NULL,
		  status VARCHAR(15) DEFAULT 'active' NOT NULL,
		  UNIQUE KEY id (id)
		);";
        dbDelta($sql);

        $table_name = $wpdb->prefix . 'ttroupe_shows';
        $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  series_id mediumint(9) NOT NULL,
		  title VARCHAR(255) DEFAULT 'No Name' NOT NULL,
		  location VARCHAR(255) DEFAULT 'The usual' NOT NULL,
		  start_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  end_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  status VARCHAR(15) DEFAULT 'active' NOT NULL,
		  UNIQUE KEY id (id)
		);";
        dbDelta($sql);
    }
}


?>