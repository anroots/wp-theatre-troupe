<?php

/**
 * Helper file for generating HTML
 * and formatting strings
 **/

/**
 * Generates selectbox options for series list
 * @return null|string
 */
function ttroupe_series_options() {
	global $theatreTroupe;
	$series = $theatreTroupe->get_series();

	$html = NULL;
	if ( !empty ($series) ) {
		foreach ( $series as $row ) {
			$html .= "<option value=\"$row->id\">$row->title</option>";
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

?>