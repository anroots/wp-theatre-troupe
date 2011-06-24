<?php

/**
 * Helper file for generating HTML
 * and formatting strings
 **/

/**
 * Generates selectbox options for series list
 * @param int $active ID of the selected series
 * @return null|string
 */
function ttroupe_series_options($active = NULL) {
	global $theatreTroupe;
	$series = $theatreTroupe->get_series();

	$html = NULL;
	if ( !empty ($series) ) {
		foreach ( $series as $row ) {
			$selected = NULL;
			if ( $row->id == $active ) {
				$selected = ' selected';
			}
			$html .= "<option value=\"$row->id\"$selected>$row->title</option>";
		}
	}
	return $html;
}

/**
 * Generate rows for the actors table in the admin panel
 * @return null|string
 */
function ttroupe_actor_rows() {
	global $theatreTroupe;
	$actors = $theatreTroupe->get_actors();

	$html = NULL;

	if ( !empty($actors) ) {
		foreach ( $actors as $actor ) {
			$html .= "
	<tr>
			<td>$actor->post_title</td>
			<td>
				<select name=\"\">
					<option value=\"\">Aktiivne</option>
					<option value=\"\">Passiivne</option>
					<option value=\"\">Endine liige</option>
					<option value=\"\">Kustutatud</option>
				</select>
				<input type=\"button\" name=\"change-actor-status\" class=\"button-secondary\"
				       value=\"" . __('Save', 'theatre-troupe') . "\"/>
			</td>
		</tr>";
		}
	}
	return $html;
}


/**
 * Generates selectbox options for selecting the main actors page.
 * Selected option is the already saved main actors page.
 * The main actors page is assumed to have subpages for each actor.
 * @return void
 */
function ttroupe_actor_page_options() {
	global $theatreTroupe;
	$pages = get_pages();

	$html = NULL;

	if ( !empty($pages) ) {
		foreach ( $pages as $page ) {

			$selected = NULL;
			if ( $page->ID == $theatreTroupe->options['actors_main_page'] ) {
				$selected = ' selected';
			}

			$html .= "<option value=\"$page->ID\"$selected>$page->post_title</option>";
		}
	}
	return $html;
}

?>