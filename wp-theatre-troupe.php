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

load_plugin_textdomain( 'theatre-troupe', false, TTROUPE_DIR.'/languages/' );

// Include the main plugin class file
if ( !class_exists('Theatre_Troupe') ) {
	include('includes/class-theatre-troupe.php');
}

// Create a new instance of the main class file
if ( class_exists('Theatre_Troupe') ) {
	$theatreTroupe = new Theatre_Troupe();
}

// Registrer admin page
add_action('admin_menu', 'ttroupe_menu');

function ttroupe_menu() {
	global $theatreTroupe;
	add_management_page( __('Theatre Troupe Options', 'theatre-troupe'), __('Theatre Troupe', 'theatre-troupe'), 'manage_options', 'theatre_troupe_menu', array(&$theatreTroupe, 'print_admin_page'));
}

function ttroupe_print_admin_page() {

	global $theatreTroupe;
	echo $theatreTroupe->print_admin_page();
}



//Actions and Filters
if ( isset($theatreTroupe) ) {
	//Actions
	//Filters
}


?>