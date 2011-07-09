<?php

class Theatre_Troupe_Actors extends Theatre_Troupe {


    /**
     * Return information about the actors
     * @param string $status Return only actors with a status active|passive|previous
     * @return mixed
     */
    public function get($status = NULL) {
        global $model_actors;

        if ( $status != NULL && array_key_exists($status, $model_actors->actor_statuses()) ) {
            $args = array( 'meta_key' => 'ttroupe_status', 'meta_value' => $status );
        } else {
            $args = array( );
        }

        return get_users($args);
    }


    /**
     * Get the user's full name (from user_meta)
     * @param $user_id
     * @return bool|object|string
     */
    public function full_name($user_id) {
        $full_name = get_user_meta($user_id, 'first_name', TRUE).' '.get_user_meta($user_id, 'last_name', TRUE);
        $full_name = trim($full_name);
        
        if (empty($full_name)) {
            $full_name = get_userdata($user_id);
            $full_name = $full_name->display_name;
        }
        return $full_name;
    }

    /**
     * Get a list of show_id's the actor has participated in
     * @param $actor_id
     * @return null|DB result
     */
    public function get_actor_shows($actor_id) {
        global $wpdb;
        if ( empty($actor_id) ) {
            return NULL;
        }

        $sql = "SELECT show_id
                    FROM $wpdb->ttroupe_show_participants
                    LEFT JOIN $wpdb->ttroupe_shows ON ($wpdb->ttroupe_shows.id = $wpdb->ttroupe_show_participants.show_id)
                    WHERE $wpdb->ttroupe_show_participants.actor_id = '$actor_id'
                    AND $wpdb->ttroupe_shows.status = 'active'";

        $query = $wpdb->get_results($sql, OBJECT);

        return $query;
    }

    /**
     * Make an actor a participant in a show
     * @param int $show_id
     * @param int $actor_id
     * @return bool|int
     */
    public function add_to_show($show_id, $actor_id) { 

        global $wpdb, $model_shows;

        if ( !$this->check_existence('shows', $show_id)
             || !$this->check_existence('actors', $actor_id)
             || $model_shows->has_actor($show_id, $actor_id)
        ) {
            return FALSE;
        }


        $wpdb->insert($wpdb->ttroupe_show_participants, array( 'show_id' => $show_id, 'actor_id' => $actor_id ));
        return $wpdb->insert_id;
    }


    /**
     * Change actor's status and/or profile page
     * @param int $actor_id
     * @param string $status active|passive|previous
     * @param int $profile_page
     * @return bool
     */
    public function change_info($actor_id, $status, $profile_page) {

        if ( !$this->check_existence('actors', $actor_id)
             || !array_key_exists($status, $this->actor_statuses())
        ) {
            return FALSE;
        }

        if ( !current_user_can('manage_options') ) {
            die(__('Sorry, only Admin can do that', 'theatre-troupe'));
        }

        if ( $this->get_status($actor_id) != $status ) {
            update_user_meta($actor_id, 'ttroupe_status', $status);
        }

        $link = get_permalink(@$_POST['profile_page']);

        if (!empty($link)) {
            return update_user_meta($actor_id, 'ttroupe_profile_page', $link);
        }
        return TRUE;
    }


    /**
     * Remove an actor from a show's participants list
     * @param  $show_id
     * @param  $actor_id
     * @return bool
     */
    public function remove_from_show($show_id, $actor_id) {
        if ( !$this->check_existence('shows', $show_id)
             || !$this->check_existence('actors', $actor_id)
        ) {
            return FALSE;
        }
        global $wpdb;
        $wpdb->query("DELETE FROM $wpdb->ttroupe_show_participants WHERE show_id='$show_id' AND actor_id='$actor_id'");
        return TRUE;
    }


    /**
     * Returns the actor's current status
     * @param int $actor_id
     * @return mixed
     */
    public function get_status($actor_id) {
        return get_user_meta($actor_id, 'ttroupe_status', TRUE);
    }

    /**
     * Returns a list of all statuses an actor can have
     * @return array
     */
    public function actor_statuses() {
        return array(
            'unassigned' => __('Unassigned', 'theatre-troupe'),
            'active' => __('Active', 'theatre-troupe'),
            'passive' => __('Passive', 'theatre-troupe'),
            'previous' => __('Previous Member', 'theatre-troupe')
        );
    }


    /**
     * Returns an array containing the number of times each actor has played in each series.
     * Array structure: array(SERIES_ID => array(ACTOR_ID => TOTAL_PLAY_COUNT))
     * The play count is calculated by summing up the times an actor has participated in a show belonging to a series.
     * @return array
     * @todo Omptimize. Maybe it could be solved with a SQL query?
     */
    public function series_play_counts() {
        global $model_shows, $model_series;

        $series_actors = array( );

        $series = $model_series->get();
        if ( !empty($series) ) {

            foreach ( $series as $serie ) { // Loop over all series
                $series_actors[(int) $serie->id] = array( );
                $shows = $model_series->get_children($serie->id);
                if ( !empty($shows) ) {

                    foreach ( $shows as $show ) { // Loop over all shows belonging to the series
                        $actors = $model_shows->get_actors($show->id);
                        if ( !empty($actors) ) {
                            foreach ( $actors as $actor ) { // Loop over all the actors who have played in the show

                                $cnt = (isset($series_actors[$serie->id][$actor->ID]))
                                        ? $series_actors[$serie->id][$actor->ID] : 0;
                                $series_actors[$serie->id][$actor->ID] = $cnt + 1; // Increase actor play count by 1
                            }
                        }
                    }
                }
            }
        }
        return $series_actors;
    }


    /**
     * Wrapper for serie_play_counts
     * Returns an array with actor play count in the series
     * Array structure: array(ACTOR_ID => PLAY_CNT)
     * @param $serie_id
     * @return null|array
     */
    public function serie_play_counts($serie_id) {
        $play_counts = $this->series_play_counts();
        if ( isset($play_counts[$serie_id]) ) {
            arsort($play_counts[$serie_id]);
            return $play_counts[$serie_id];
        }
        return NULL;
    }



    /**
     * Checks whether the current URL is a profile page.
     * If so, return the user_id of the actor, FALSE otherwise.
     * @return bool|int
     */
    public function is_profile_page() {
        global $wpdb;

        $current_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

        $table = $wpdb->prefix.'usermeta';
        $sql = "SELECT meta_value, user_id FROM $table WHERE meta_key = 'ttroupe_profile_page'";
        $query = $wpdb->get_results($sql, OBJECT);

        if (!empty($query)) {
            foreach ($query as $meta) {
                if ($meta->meta_value == $current_url) {
                    return $meta->user_id;
                }
            }
        }
        return FALSE;
    }
}

?>
