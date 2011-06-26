<?php
/**
 * Main plugin class
 */
class Theatre_Troupe {

    //public $options = array( 'actors_main_page' => 2 ); // Plugin settings

    function Theatre_Troupe() {
        global $wpdb;

        // Set database table names
        if ( !isset($wpdb->ttroupe_series) ) {
            $wpdb->ttroupe_series = $wpdb->prefix . 'ttroupe_series';
            $wpdb->ttroupe_shows = $wpdb->prefix . 'ttroupe_shows';
            $wpdb->ttroupe_show_participants = $wpdb->prefix . 'ttroupe_show_participants';
        }

        /*// Overwrite default settings with those saved by the user
        $storedOptions = get_option('theatre_troupe_options');
        if ( !empty($storedOptions) && is_array($storedOptions) ) {
            foreach ( $storedOptions as $key => $value ) {
                $this->options[$key] = $value;
            }
        }*/
    }


    /**
     * Saves plugin settings to the WP options table
     * @return void
     */
    public function save_options() {
        update_option('theatre_troupe_options', $this->options);
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
     * Check for series/show existence
     * @param string $where Either series or shows
     * @param int $id
     * @return bool
     */
    public function check_existence($where, $id) {
        global $wpdb;

        if ( $where == 'series' ) {
            $table = $wpdb->ttroupe_series;
        } elseif ( $where == 'actors' ) {
            $table = $wpdb->prefix . 'users';
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
     * Create database tables during the activation of the plugin
     * @static
     * @return void
     */
    static function install() {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->ttroupe_series . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  title VARCHAR(55) DEFAULT 'No Name' NOT NULL,
		  description TEXT NULL DEFAULT NULL,
		  status VARCHAR(15) DEFAULT 'active' NOT NULL,
		  UNIQUE KEY id (id)
		);";
        dbDelta($sql);

        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->ttroupe_shows . " (
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

        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->ttroupe_show_participants . " (
                id INT( 10 ) NOT NULL AUTO_INCREMENT,
                actor_id INT( 8 ) UNSIGNED NOT NULL,
                show_id INT( 8 ) UNSIGNED NOT NULL,
                UNIQUE KEY id (id)
		        );";
        dbDelta($sql);
    }
}


?>