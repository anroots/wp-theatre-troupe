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
        }
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

        global $model_series, $model_shows;

        $postArgs = array( 'series_id', 'title', 'location', 'linkurl', 'linkname',
                           'start_date', 'end_date' );

        if ( isset($_POST['save-show']) && check_admin_referer('edit-shows') ) {
            $postArgs[] = 'show_id';
            $updatedArgs = array( );
            foreach ( $postArgs as $key ) {
                $updatedArgs[$key] = @$_POST[$key];
            }
            $model_shows->update($updatedArgs);
        } elseif ( isset($_POST['create-show']) && check_admin_referer('create-show') ) {
            // New show
            $newArgs = array( );
            foreach ( $postArgs as $key ) {
                $newArgs[$key] = @$_POST[$key];
            }

            $result = $model_shows->create($newArgs);
            if ( !$result ) {
                $error = '<div class="error below-h2">' . __('Did you fill all the required fields?', 'theatre-troupe') . '</div>';
            }
        }


        if ( isset($_GET['edit']) && $this->check_existence('shows', $_GET['edit']) ) {
            $show = $model_shows->get($_GET['edit']);
            include(WP_PLUGIN_DIR . TTROUPE_DIR . '/templates/edit_show.php');

        } else {
            if ( isset($_GET['deleted']) ) {
                $shows = $model_shows->get(NULL, array( 'status' => 'deleted' ));
            } else {
                $shows = $model_shows->get();
            }

            $series = $model_series->get();
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

        global $model_series;

        // New series
        if ( isset($_POST['add-series']) && check_admin_referer('add-series') ) {
            $model_series->add(@$_POST['series-title'], @$_POST['series-description']);

        } elseif ( isset($_POST['save-series']) && check_admin_referer('edit-series') ) {
            $model_series->update(@$_POST['series_id'], @$_POST['title'], @$_POST['description']);
        }

        if ( isset($_GET['edit']) && $this->check_existence('series', $_GET['edit']) ) {
            $series = $model_series->get($_GET['edit']);
            include(WP_PLUGIN_DIR . TTROUPE_DIR . '/templates/edit_series.php');

        } else {
            if ( isset($_GET['deleted']) ) {
                $series = $model_series->get(NULL, 'deleted');
            } else {
                $series = $model_series->get();
            }
            include(WP_PLUGIN_DIR . TTROUPE_DIR . '/templates/series.php');
        }

    }



}

?>
