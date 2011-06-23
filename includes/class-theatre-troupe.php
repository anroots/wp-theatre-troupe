<?php
/**
 * Main plugin class
 */
class Theatre_Troupe {

	private $options_name = 'theatre_troupe';

	function Theatre_Troupe() {

	}

	/*// Returns an array of admin options
	function get_options() {
		$options = array( 'show_header' => 'true',
		                                'add_content' => 'true',
		                                'comment_author' => 'true',
		                                'content' => '' );
		$devOptions = get_option($this->adminOptionsName);
		if ( !empty($devOptions) ) {
			foreach ( $devOptions as $key => $option )
				$options[$key] = $option;
		}
		update_option($this->adminOptionsName, $options);
		return $options;
	}*/


	public function print_admin_page() {
		if ( !current_user_can('manage_options') ) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}
		include(WP_PLUGIN_DIR . TTROUPE_DIR . '/templates/admin.php');
	}
}


?>