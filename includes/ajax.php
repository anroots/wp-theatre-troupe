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
     * Change actor's status and/or profile page
     * @return void
     */
    public function change_actor_info() {
        global $model_actors;
        
        check_ajax_referer('manage_actor_info');

        if ($model_actors->change_info((int) @$_POST['actor_id'], @$_POST['status'], @$_POST['profile_page']) ) {
            die('1');
        }
        die('0');
    }
}

?>