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
            return get_users(array( 'meta_key' => 'ttroupe_status', 'meta_value' => $status ));
        }
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
     * Change actor's status
     * @param int $actor_id
     * @param string $status active|passive|previous
     * @return bool
     */
    public function change_status($actor_id, $status) {

        if ( !$this->check_existence('actors', $actor_id)
             || !array_key_exists($status, $this->actor_statuses())
        ) {
            return FALSE;
        }

        if ( !current_user_can('manage_options') ) {
            die(__('Sorry, only Admin can do that', 'theatre-troupe'));
        }
        return update_user_meta($actor_id, 'ttroupe_status', $status);
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
     * Returns a list of all statuses an actor can have
     * @return array
     */
    public function actor_statuses() {
        return array(
            'active' => __('Active', 'theatre-troupe'),
            'passive' => __('Passive', 'theatre-troupe'),
            'previous' => __('Previous Member', 'theatre-troupe')
        );
    }
}

?>