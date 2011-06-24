<?php
/*
Plugin Name: WP Theatre Troupe
Plugin URI: http://jaa.ee/
Description: This plugin will enable small theatre troups and other performing groups to list their shows and participating actors.
Author: Ando Roots
Version: 0.1
Author URI: http://ando.roots.ee/
*/

// Translations
define('TTROUPE_DIR', '/wp-theatre-troupe');

load_plugin_textdomain('theatre-troupe', false, TTROUPE_DIR . '/languages/');

// Include the main plugin class file
if ( !class_exists('Theatre_Troupe') ) {
	include('includes/class-theatre-troupe.php');
}
include_once('includes/helper.php');


// Create a new instance of the main class file
if ( class_exists('Theatre_Troupe') ) {
	$theatreTroupe = new Theatre_Troupe();
}


// Check $_POST actions
if ( isset($_POST['add-series']) ) {
	// New series
	$theatreTroupe->add_series(@$_POST['series-title']);
} elseif ( isset($_POST['create-show']) ) {
	// New show
	$theatreTroupe->create_show(@$_POST['title'], @$_POST['location'], @$_POST['start-date'], @$_POST['end-date']);
}


// Registrer admin page
add_action('admin_menu', 'ttroupe_menu');

function ttroupe_menu() {
	global $theatreTroupe;
	add_management_page(__('Theatre Troupe Options', 'theatre-troupe'), __('Theatre Troupe', 'theatre-troupe'), 'manage_options', 'ttroupe_admin', array( &$theatreTroupe, 'print_admin_page' ));
}


?>