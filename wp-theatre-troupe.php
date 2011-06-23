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
$i18n_dir = basename(dirname(__FILE__)).'/translations/';
load_plugin_textdomain( 'theatre-troupe', false, $i18n_dir );

// Include the main plugin class file
if ( !class_exists('Theatre_Troupe') ) {
	include('includes/class-theatre-troupe.php');
}

// Create a new instance of the main class file
if ( class_exists('TheatreTroupe') ) {
	$theatreTroupe = new TheatreTroupe();
}

// Registrer admin page
add_action('admin_menu', 'theatre_troupe_menu');

function theatre_troupe_menu() {
	add_management_page( __('Theatre Troupe Options', 'theatre-troupe'), __('Theatre Troupe', 'theatre-troupe'), 'manage_options', 'theatre_troupe_menu', 'print_theatre_troupe_options');
}

function print_theatre_troupe_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	echo file_get_contents('templates/admin.php');
}

//Actions and Filters
if ( isset($theatreTroupe) ) {
	//Actions
	//Filters
}

?>