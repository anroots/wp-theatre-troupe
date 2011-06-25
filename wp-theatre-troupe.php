<?php
/*
Plugin Name: WP Theatre Troupe
Plugin URI: http://jaa.ee/
Description: This plugin will enable small theatre troups and other performing groups to list their shows and participating actors.
Author: Ando Roots
Version: 0.1
Author URI: http://ando.roots.ee/
*/


define('TTROUPE_DIR', '/wp-theatre-troupe');

// Translations
load_plugin_textdomain('theatre-troupe', false, TTROUPE_DIR . '/languages/');

// Include plugin classes and helpers
if ( !class_exists('Theatre_Troupe') ) {
    include('includes/class-theatre-troupe.php');
    include('includes/class-theatre-troupe-ajax.php');
    include('includes/display_controller.php');
    include_once('includes/helper.php');
}


// Create a new instance of the main class files
if ( class_exists('Theatre_Troupe') ) {
    $theatreTroupe = new Theatre_Troupe();
    $ajax = new Theatre_Troupe_Ajax();
    $display = new Display_Controller();
}



// Registrer admin page
add_action('admin_menu', array( &$display, 'attach_menus' ));

// AJAX bindings
add_action('wp_ajax_ttroupe_save_settings', array( &$ajax, 'save_settings' ));
add_action('wp_ajax_ttroupe_delete', array( &$ajax, 'delete' ));
add_action('wp_ajax_ttroupe_restore', array( &$ajax, 'restore' ));



?>