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

        if ( !in_array($what, array( 'shows', 'series' )) ) {
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

        if ( !in_array($what, array( 'shows', 'series' )) ) {
            die('0');
        }
        if ( $theatreTroupe->change_status($what, $id, 'active') ) {
            die('1');
        }
        die('0');
    }

    /**
     * Saves plugin settings
     * @return void
     */
    public function save_settings() {
        global $theatreTroupe;
        $actors_main_page = (int) @$_POST['actors_main_page'];
        if ( $actors_main_page <= 0 ) {
            die('System error #0x002');
        }
        $theatreTroupe->options['actors_main_page'] = $actors_main_page;
        $theatreTroupe->save_options();
        die('1');
    }


    /**
     * Add or remove actors from shows
     * @return void
     */
    public function manage_show_participants() {
        global $model_actors;
        $actor_id = (int) @$_POST['actor_id'];
        $show_id = (int) @$_POST['show_id'];


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
}

?>