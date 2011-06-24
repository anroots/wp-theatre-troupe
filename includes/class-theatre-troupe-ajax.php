<?php

/**
 * Ajax controller class. Validates AJAX queries and
 * calls appropriate actions from the Theatre_Troupe class.
 */

class Theatre_Troupe_Ajax {

	public function Theatre_Troupe_Ajax() {

	}


	/**
	 * Series deletion
	 * @todo Implement nounces
	 * @return void
	 */
	public function delete_series() {
		global $theatreTroupe;

		$series_id = (int) @$_POST['series_id'];
		if ( $series_id <= 0 ) {
			die('System error #0x001');
		}

		if ( $theatreTroupe->delete_series($series_id) ) {
			die('1');
		}
		die('0');
	}


	/**
	 * Series deletion
	 * @todo Implement nounces
	 * @return void
	 */
	public function delete_show() {
		global $theatreTroupe;

		$show_id = (int) @$_POST['show_id'];
		if ( $show_id <= 0 ) {
			die('System error #0x003');
		}

		if ( $theatreTroupe->delete_show($show_id) ) {
			die('1');
		}
		die('0');
	}


	/**
	 * Saves plugin settings
	 * @return void
	 */
	public function save_settings() {
		global $theatreTroupe;
		$actors_main_page = (int) @$_POST['actors_main_page'];
		if ( $actors_main_page <= 0 ) {
			die('System error #0x002');
		}
		$theatreTroupe->options['actors_main_page'] = $actors_main_page;
		$theatreTroupe->save_options();
		die('1');
	}
}

?>