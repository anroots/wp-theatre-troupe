<?php
/*
Plugin Name: WP Theatre Troupe
Plugin URI: http://wordpress.org/extend/plugins/theatre-troupe/
Description: This plugin will enable small theatre troups and other performing groups to manage actor profile pages.
Author: Ando Roots
Version: 1.4
Author URI: http://ando.roots.ee/
Licence: GPL2
*/

/*
Copyright 2011     Ando Roots  (email : andoroots+dev@gmail.com)

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
$dir = explode('/', plugin_basename(__FILE__));
define('TTROUPE_DIR', '/'.$dir[0].'/');

define('TTROUPE_PATH', WP_PLUGIN_DIR.TTROUPE_DIR);
define('TTROUPE_VERSION', '1.3');


// Registrer a new top-level admin menu
add_action('admin_menu', 'ttroupe_attach_menus');

/**
 * Attaches admin menus and enqueues JS
 * @return void
 */
function ttroupe_attach_menus() {
    global $display;

    add_menu_page(__('Theatre Troupe', 'theatre-troupe'), __('Theatre Troupe', 'theatre-troupe'), 'manage_options', 'ttroupe_admin', array( &$display, 'print_admin' ));
    add_submenu_page('ttroupe_admin', __('Theatre Troupe Actors', 'theatre-troupe'), __('Actors', 'theatre-troupe'), 'manage_options', 'ttroupe_actors', array( &$display, 'print_actors' ));

    add_action("admin_print_scripts", 'ttroupe_admin_head');
}


/**
 * Echo JavaScript in plugin page header
 * @return void
 */
function ttroupe_admin_head() {
    if ( stristr($_SERVER["REQUEST_URI"], 'ttroupe') ) {
        wp_enqueue_script('ttroupe_admin', plugins_url() . TTROUPE_DIR . 'js/script.js', array( 'jquery' ));
    }
}


// A hack to not load the plugin files where they aren't needed.
// @todo: Think of a way to do this for non-admin pages too
if ( is_admin()
    && (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
     && !stristr($_SERVER['REQUEST_URI'], 'ttroupe')
     && !stristr($_SERVER['REQUEST_URI'], 'widgets') ) {
    return TRUE;
}


// Load in translation strings
load_plugin_textdomain('theatre-troupe', false, TTROUPE_PATH . 'languages');

setlocale(LC_TIME, WPLANG);

// Include plugin classes and helpers
if ( !class_exists('Theatre_Troupe') ) {
    include('includes/models/main.php');
    include('includes/models/actors.php');
    include('includes/ajax.php');
    include('includes/display_controller.php');
    include('includes/helper.php');
}


// Create a new instance of the main class files
if ( class_exists('Theatre_Troupe') ) {
    $theatreTroupe = new Theatre_Troupe();
    $model_actors = new Theatre_Troupe_Actors();
    $ajax = new Theatre_Troupe_Ajax();
    $display = new Display_Controller();
}


// AJAX bindings
add_action('wp_ajax_ttroupe_change_actor_info', array( &$ajax, 'change_actor_info' ));
add_action('wp_ajax_ttroupe_delete', array( &$ajax, 'delete' ));
add_action('wp_ajax_ttroupe_restore', array( &$ajax, 'restore' ));

add_filter('get_pages','ttroupe_hide_actor_pages');

register_activation_hook(__FILE__, array( &$theatreTroupe, 'install' ));


// Shortcodes
include('includes/shortcodes.php');
$shortCode = new Theatre_Troupe_Shortcode();
add_shortcode('ttroupe-actors-list', array( &$shortCode, 'actors_list' ));


/**
 * Filter method.
 * 
 * Hides inactive actors from pages menu
 * @param array $pages Array of WP stdClass pages
 * @return array $pages
 */
function ttroupe_hide_actor_pages($pages) {
    global $model_actors;

    if (!empty($pages)) {
        foreach ($pages as $key => $page) {

            $actor_name = preg_replace('/[^a-zA-Z]/', '', $model_actors->full_name($page->post_author));
            $post_name = preg_replace('/[^a-zA-Z]/', '', $page->post_name);
            $status = get_user_meta($page->post_author, 'ttroupe_status', TRUE);

            if (($status == 'passive' || $status == 'previous') && stristr($post_name, $actor_name)) {
               unset($pages[$key]);
            }
        }
    }
    return $pages;
}
?>
