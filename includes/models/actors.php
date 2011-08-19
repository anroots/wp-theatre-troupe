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

        $link = get_permalink($profile_page);

        if (!empty($link)) {
            update_user_meta($actor_id, 'ttroupe_profile_page', $link);
        }
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
