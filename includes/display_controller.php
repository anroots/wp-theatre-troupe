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
        if ( !current_user_can('manage_options') ) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        $series = $this->get_series();

        include(WP_PLUGIN_DIR . TTROUPE_DIR . '/templates/admin.php');
    }


    /**
     * Prints the page for managing shows
     * @return void
     */
    public function print_shows() {
        if ( !current_user_can('manage_options') ) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        global $theatreTroupe;

        if ( isset($_POST['save-show']) ) {
            $this->update_show(@$_POST['show_id'], @$_POST['series_id'], @$_POST['title'], @$_POST['location'], @$_POST['start-date'], @$_POST['end-date']);

        } elseif ( isset($_POST['create-show']) ) {
            // New show
            $theatreTroupe->create_show(@$_POST['series_id'], @$_POST['title'], @$_POST['location'], @$_POST['start-date'], @$_POST['end-date']);
        }


        if ( isset($_GET['edit']) && $this->check_existence('shows', $_GET['edit']) ) {
            $show = $this->get_shows($_GET['edit']);
            include(WP_PLUGIN_DIR . TTROUPE_DIR . '/templates/edit_show.php');

        } else {
            if ( isset($_GET['deleted']) ) {
                $shows = $this->get_shows(NULL, 'deleted');
            } else {
                $shows = $this->get_shows();
            }

            $series = $this->get_series();
            include(WP_PLUGIN_DIR . TTROUPE_DIR . '/templates/shows.php');
        }
    }


    /**
     * Actors page
     * @return void
     */
    public function print_actors() {
        if ( !current_user_can('manage_options') ) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        include(WP_PLUGIN_DIR . TTROUPE_DIR . '/templates/actors.php');

    }


    /**
     * Series page
     * @return void
     */
    public function print_series() {
        if ( !current_user_can('manage_options') ) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        if ( isset($_GET['deleted']) ) {
            $series = $this->get_series(NULL, 'deleted');
        } else {
            $series = $this->get_series();
        }
        include(WP_PLUGIN_DIR . TTROUPE_DIR . '/templates/series.php');

    }

// Attaches admin menus
    function attach_menus() {
        global $display;

        $ttroupe_hook = add_menu_page(__('Theatre Troupe Options', 'theatre-troupe'), __('Theatre Troupe', 'theatre-troupe'), 'manage_options', 'ttroupe_admin', array( &$display, 'print_admin' ));
        add_action("admin_print_scripts-$ttroupe_hook", array( &$display, 'admin_head' ));

        $ttroupe_hook = add_submenu_page('ttroupe_admin', __('Theatre Troupe Shows', 'theatre-troupe'), __('Shows', 'theatre-troupe'), 'manage_options', 'ttroupe_shows', array( &$display, 'print_shows' ));
        add_action("admin_print_scripts-$ttroupe_hook", array( &$display, 'admin_head' ));

        $ttroupe_hook = add_submenu_page('ttroupe_admin', __('Theatre Troupe Actors', 'theatre-troupe'), __('Actors', 'theatre-troupe'), 'manage_options', 'ttroupe_actors', array( &$display, 'print_actors' ));
        add_action("admin_print_scripts-$ttroupe_hook", array( &$display, 'admin_head' ));

        $ttroupe_hook = add_submenu_page('ttroupe_admin', __('Theatre Troupe Series', 'theatre-troupe'), __('Series', 'theatre-troupe'), 'manage_options', 'ttroupe_series', array( &$display, 'print_series' ));
        add_action("admin_print_scripts-$ttroupe_hook", array( &$display, 'admin_head' ));
    }


// Echo JavaScript in plugin page header
    function admin_head() {
        wp_enqueue_script('ttroupe_admin', plugins_url() . TTROUPE_DIR . '/js/script.js', array( 'jquery' ));
    }


}

?>