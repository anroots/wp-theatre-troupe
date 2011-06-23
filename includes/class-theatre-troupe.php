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
	
}

?>