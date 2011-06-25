<?php

class Theatre_Troupe_Actors extends Theatre_Troupe {


    /**
     * Return information about the actors
     * @return mixed
     */
    public function get() {
        return get_users();
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
}

?>