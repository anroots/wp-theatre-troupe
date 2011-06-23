<?php
/**
 * Main plugin class
 */
class Theatre_Troupe {

	function Theatre_Troupe() {
		global $wpdb;
		if ( !isset($wpdb->ttroupe_series) ) {
			$wpdb->ttroupe_series = $wpdb->prefix . 'ttroupe_series';
		}
	}


	/**
	 * Prints the configuration page for wp-admin
	 * @return void
	 */
	public function print_admin_page() {
		if ( !current_user_can('manage_options') ) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}
		$series = $this->get_series();
		include(WP_PLUGIN_DIR . TTROUPE_DIR . '/templates/admin.php');
	}


	/**
	 * Returns series
	 * @param string $status
	 * @return mixed
	 */
	public function get_series($status = 'active') {
		global $wpdb;
		return $wpdb->get_results("SELECT title, status FROM $wpdb->ttroupe_series
				WHERE status = 'active'", OBJECT);
	}

	/**
	 * Create database tables during the installation of the plugin
	 * @return void
	 * @todo Call this function from the installation script
	 */
	function install() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'ttroupe_series';
		$sql = "CREATE TABLE " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  title VARCHAR(55) DEFAULT 'No Name' NOT NULL,
		  status VARCHAR(20) DEFAULT 'active' NOT NULL
		  UNIQUE KEY id (id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
}


?>