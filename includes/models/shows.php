<?php

class Theatre_Troupe_Shows extends Theatre_Troupe {


    /**
     * Returns shows
     * @param int $show_id If specified, return info about a specific show
     * @param string $status Allows to view deleted or active shows
     * @return mixed
     */
    public function get($show_id = NULL, $status = 'active') {
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
     * Update show info
     * @param  $show_id
     * @param  $series_id
     * @param  $title
     * @param  $location
     * @param  $start
     * @param  $end
     * @return bool
     */
    public function update($show_id, $series_id, $title, $location, $start, $end) {
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
     * Create a new show
     * @param int $series_id Required, links shows with series
     * @param string $title Required
     * @param string $location
     * @param string $start Required
     * @param string $end
     * @return int|bool New show ID
     */
    public function create($series_id, $title, $location, $start, $end) {
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
     * Returns actors who are participants of a given show
     * @param int $show_id
     * @return bool|mixed An array of objects containing user information
     */
    public function get_actors($show_id) {
        global $wpdb;
        if ( empty($show_id) || $show_id < 1 ) {
            return FALSE;
        }

        $actors = NULL;

        $query = $wpdb->get_results("SELECT actor_id FROM $wpdb->ttroupe_show_participants WHERE show_id='$show_id'", OBJECT);
        if ( count($query) > 0 ) {
            foreach ( $query as $participant ) {
                $actors[] = get_userdata($participant->actor_id);
            }
        }
        return $actors;
    }


    /**
     * Check if a actor is participant in a show
     * @param int $show_id
     * @param int $actor_id
     * @return bool Returns TRUE if a actor is a participant in a show, FALSE otherwise
     */
    public function has_actor($show_id, $actor_id) {
        if ( !$this->check_existence('shows', $show_id)
             || !$this->check_existence('actors', $actor_id)
        ) {
            return FALSE;
        }
        global $wpdb;

        $query = $wpdb->get_var("SELECT id FROM $wpdb->ttroupe_show_participants WHERE actor_id='$actor_id' AND show_id='$show_id'");

        if ( empty($query) ) {
            return FALSE;
        }
        return TRUE;
    }

}

?>