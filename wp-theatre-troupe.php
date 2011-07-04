<?php
/*
Plugin Name: WP Theatre Troupe
Plugin URI: http://jaa.ee/
Description: This plugin will enable small theatre troups and other performing groups to list their past and upcoming shows and participating actors.
Author: Ando Roots
Version: 1.1
Author URI: http://ando.roots.ee/
Licence: GPL2
*/

/*
Copyright 2011     Ando Roots  (email : ando@roots.ee)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
define('TTROUPE_DIR', '/wp-theatre-troupe');
define('TTROUPE_VERSION', '1.1');


// Registrer a new top-level admin menu
add_action('admin_menu', 'ttroupe_attach_menus');

/**
 * Attaches admin menus
 * @return void
 * @todo Think of a way to optimize script.js loading
 */
function ttroupe_attach_menus() {
    global $display;

    $ttroupe_hook = add_menu_page(__('Theatre Troupe', 'theatre-troupe'), __('Theatre Troupe', 'theatre-troupe'), 'manage_options', 'ttroupe_admin', array( &$display, 'print_admin' ));
    add_action("admin_print_scripts-$ttroupe_hook", 'ttroupe_admin_head');

    $ttroupe_hook = add_submenu_page('ttroupe_admin', __('Theatre Troupe Shows', 'theatre-troupe'), __('Shows', 'theatre-troupe'), 'manage_options', 'ttroupe_shows', array( &$display, 'print_shows' ));
    add_action("admin_print_scripts-$ttroupe_hook", 'ttroupe_admin_head');

    $ttroupe_hook = add_submenu_page('ttroupe_admin', __('Theatre Troupe Actors', 'theatre-troupe'), __('Actors', 'theatre-troupe'), 'manage_options', 'ttroupe_actors', array( &$display, 'print_actors' ));
    add_action("admin_print_scripts-$ttroupe_hook", 'ttroupe_admin_head');

    $ttroupe_hook = add_submenu_page('ttroupe_admin', __('Theatre Troupe Series', 'theatre-troupe'), __('Series', 'theatre-troupe'), 'manage_options', 'ttroupe_series', array( &$display, 'print_series' ));
    add_action("admin_print_scripts-$ttroupe_hook", 'ttroupe_admin_head');
}


/**
 * Echo JavaScript in plugin page header
 * @return void
 */
function ttroupe_admin_head() {
    if ( stristr($_SERVER["REQUEST_URI"], 'ttroupe') ) {
        wp_enqueue_script('ttroupe_admin', plugins_url() . TTROUPE_DIR . '/js/script.js', array( 'jquery' ));
    }
}


// A hack to not load the plugin files where they aren't needed.
// @todo: Think of a way to do this for non-admin pages too
if ( is_admin()
    && (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
     && !stristr($_SERVER['REQUEST_URI'], 'ttroupe')
     && !stristr($_SERVER['REQUEST_URI'], 'widgets') ) {
    //return TRUE;
}


// Load in translation strings
load_plugin_textdomain('theatre-troupe', false, TTROUPE_DIR . '/languages');

setlocale(LC_TIME, WPLANG);

// Include plugin classes and helpers
if ( !class_exists('Theatre_Troupe') ) {
    include('includes/models/main.php');
    include('includes/models/series.php');
    include('includes/models/shows.php');
    include('includes/models/actors.php');
    include('includes/ajax.php');
    include('includes/display_controller.php');
    include('includes/helper.php');
}


// Create a new instance of the main class files
if ( class_exists('Theatre_Troupe') ) {
    $theatreTroupe = new Theatre_Troupe();
    $model_series = new Theatre_Troupe_Series();
    $model_shows = new Theatre_Troupe_Shows();
    $model_actors = new Theatre_Troupe_Actors();
    $ajax = new Theatre_Troupe_Ajax();
    $display = new Display_Controller();
}


// AJAX bindings
add_action('wp_ajax_ttroupe_manage_show_participants', array( &$ajax, 'manage_show_participants' ));
add_action('wp_ajax_ttroupe_change_actor_status', array( &$ajax, 'change_actor_status' ));
add_action('wp_ajax_ttroupe_delete', array( &$ajax, 'delete' ));
add_action('wp_ajax_ttroupe_restore', array( &$ajax, 'restore' ));

register_activation_hook(__FILE__, array( &$theatreTroupe, 'install' ));


// Shortcodes
include('includes/shortcodes.php');
$shortCode = new Theatre_Troupe_Shortcode();
add_shortcode('ttroupe-actor-shows', array( &$shortCode, 'actor_shows' ));
add_shortcode('ttroupe-series-list', array( &$shortCode, 'series_list' ));
add_shortcode('ttroupe-actors-list', array( &$shortCode, 'actors_list' ));
add_shortcode('ttroupe-show-details', array( &$shortCode, 'show_details' ));


//Widgets
add_action('widgets_init', 'theatre_troupe_load_widgets');

// Widgets loader
function theatre_troupe_load_widgets() {
    include('includes/shows_widget.php');
    include('includes/next_show_widget.php');
    register_widget('Theatre_Troupe_Shows_Widget');
    register_widget('Theatre_Troupe_Next_Show_Widget');
}

?>
