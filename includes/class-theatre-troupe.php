<?php
/**
 * Main plugin class
 */
class Theatre_Troupe {

	function Theatre_Troupe() {
		global $wpdb;
		//$this->install();

		// Set database table names
		if ( !isset($wpdb->ttroupe_series) ) {
			$wpdb->ttroupe_series = $wpdb->prefix . 'ttroupe_series';
			$wpdb->ttroupe_shows = $wpdb->prefix . 'ttroupe_shows';
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
		return $wpdb->get_results("SELECT * FROM $wpdb->ttroupe_series
				WHERE status = 'active'", OBJECT);
	}


	/**
	 * Return information about the actors
	 * @return mixed
	 */
	public function get_actors() {
		// @todo: Make this variable changable in the admin panel
		$profile_parent = 2; // ID of the page whose subpages are actors.
		return get_pages('child_of=' . $profile_parent);
	}


	/**
	 * Insert a new series to the database.
	 * @param string $title
	 * @return bool|int New row ID
	 */
	public function add_series($title) {
		if ( empty($title) ) {
			return FALSE;
		}
		global $wpdb;
		$wpdb->insert($wpdb->ttroupe_series, array( 'title' => $title ));
		return $wpdb->insert_id;
	}


	/**
	 * Change series status to deleted
	 * @param int $series_id
	 * @return bool
	 */
	public function delete_series($series_id) {
		global $wpdb;
		$wpdb->update($wpdb->ttroupe_series, array('status' => 'deleted'), array('id' => $series_id));
		return TRUE;
	}


	/**
	 * Create a new show
	 * @param string $title Required
	 * @param string $location
	 * @param string $start Required
	 * @param string $end
	 * @return int|bool New show ID
	 */
	public function create_show($title, $location, $start, $end) {
		if ( empty($title) ||
		     empty($start)
		) {
			return FALSE;
		}

		global $wpdb;
		$wpdb->insert($wpdb->ttroupe_shows, array( 'title' => $title,
		                                         'location' => $location,
		                                         'start_date' => $start,
		                                         'end_date' => $end ));
		return $wpdb->insert_id;
	}


	/**
	 * Create database tables during the installation of the plugin
	 * @return void
	 * @todo Call this function from the installation script
	 */
	function install() {
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		$table_name = $wpdb->prefix . 'ttroupe_series';
		$sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  title VARCHAR(55) DEFAULT 'No Name' NOT NULL,
		  status VARCHAR(15) DEFAULT 'active' NOT NULL,
		  UNIQUE KEY id (id)
		);";
		dbDelta($sql);

		$table_name = $wpdb->prefix . 'ttroupe_shows';
		$sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  title VARCHAR(255) DEFAULT 'No Name' NOT NULL,
		  location VARCHAR(255) DEFAULT 'The usual' NOT NULL,
		  start_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  end_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  UNIQUE KEY id (id)
		);";
		dbDelta($sql);
	}
}


?>