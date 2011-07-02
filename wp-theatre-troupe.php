<?php
/*
Plugin Name: WP Theatre Troupe
Plugin URI: http://jaa.ee/
Description: This plugin will enable small theatre troups and other performing groups to list their shows and participating actors.
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

// Load in translation strings
load_plugin_textdomain('theatre-troupe', false, TTROUPE_DIR . '/languages/');

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


// Registrer admin page
add_action('admin_menu', array( &$display, 'attach_menus' ));

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


//Widgets
add_action('widgets_init', 'theatre_troupe_load_widgets');

function theatre_troupe_load_widgets() {
    include('includes/shows_widget.php');
    include('includes/next_show_widget.php');
    register_widget('Theatre_Troupe_Shows_Widget');
    register_widget('Theatre_Troupe_Next_Show_Widget');
}

?>
