<?php

/**
 * Ajax controller class. Validates AJAX queries and
 * calls appropriate actions from the Theatre_Troupe class.
 */

class Theatre_Troupe_Ajax {

    public function Theatre_Troupe_Ajax() {

    }


    /**
     * Series deletion
     * @todo Implement nounces
     * @return void
     */
    public function delete() {
        global $theatreTroupe;

        $id = (int) @$_POST['id'];
        $what = @$_POST['what'];

        if ( !in_array($what, array( 'shows', 'series' )) || !check_ajax_referer('delete_item') ) {
            die('0');
        }
        if ( $theatreTroupe->change_status($what, $id, 'deleted') ) {
            die('1');
        }
        die('0');
    }


    /**
     * Restore a show/series from deleted status to active
     * @return void
     */
    public function restore() {
        global $theatreTroupe;

        $id = (int) @$_POST['id'];
        $what = @$_POST['what'];

        if ( !in_array($what, array( 'shows', 'series' )) || !check_ajax_referer('restore_item') ) {
            die('0');
        }
        if ( $theatreTroupe->change_status($what, $id, 'active') ) {
            die('1');
        }
        die('0');
    }


    /**
     * Add or remove actors from shows
     * @return void
     */
    public function manage_show_participants() {
        global $model_actors;
        $actor_id = (int) @$_POST['actor_id'];
        $show_id = (int) @$_POST['show_id'];

        check_ajax_referer('manage_participants');

        if ( $_POST['type'] == 'add' ) {
            $result = $model_actors->add_to_show($show_id, $actor_id);
        } else {
            $result = $model_actors->remove_from_show($show_id, $actor_id);
        }

        if ( $result ) {
            die('1');
        }
        die('0');
    }


    /**
     * Change actor's status
     * @return void
     */
    public function change_actor_status() {
        global $model_actors;

        check_ajax_referer('manage_actor_status');

        if ( $model_actors->change_status((int) @$_POST['actor_id'], @$_POST['status']) ) {
            die('1');
        }
        die('0');
    }
}

?>