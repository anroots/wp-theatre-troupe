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
			die(__('System error #0x001', 'theatre-troupe'));
		}

		if ($theatreTroupe->delete_series($series_id)) {
			die('1');
		}
		die('0');
	}
}

?>