<?php
class Display_Controller extends Theatre_Troupe {
    /**
     * Handles displaying functions such as printing
     * the Admin actors or shows pages
     */


    /**
     * Prints the configuration page for the plugin
     * @return void
     */
    public function print_admin() {

        if (isset($_POST['save_settings'])) {
            $link = get_permalink(@$_POST['show_details_page']);
            update_option('ttroupe_show_details_url', $link);
            update_option('ttroupe_insert_shows', (int)@$_POST['insert_shows']); // Insert a list of played shows?
        }
        include(TTROUPE_PATH . 'templates/admin.php');
    }




    /**
     * Actors page
     * @return void
     */
    public function print_actors() {
        if ( !current_user_can('manage_options') ) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        include(TTROUPE_PATH .'templates/actors.php');

    }


}

?>
