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
    global $model_series;
    $series = $model_series->get();

    $html = NULL;
    if ( !empty ($series) ) {
        foreach ( $series as $row ) {
            $html .= "<option value=\"$row->id\" " . selected($row->id, $active) . ">$row->title</option>";
        }
    }
    return $html;
}

/**
 * Generate rows for the actors
 * table in the admin panel Actors section
 * @return null|string
 */
function ttroupe_actor_rows() {
    global $model_actors;
    $actors = $model_actors->get();

    $html = NULL;

    if ( !empty($actors) ) {
        foreach ( $actors as $actor ) {

            // Generate status selectbox
            $options = NULL;
            $actor_status = get_user_meta($actor->ID, 'ttroupe_status');

            foreach ( $model_actors->actor_statuses() as $key => $status ) {
                $options .= "<option value=\"$key\" " . selected($actor_status, $key) . ">$status</option>";
            }

            $html .= "
	<tr>
			<td>$actor->display_name</td>
			<td>
				<select>
				    $options
                </select>
				<button class=\"button-secondary\" onclick=\"change_actor_status($actor->ID, jQuery(this).prev().val(), this);\">
				       " . __('Save', 'theatre-troupe') . "</button>
			</td>
		</tr>";
        }
    }
    return $html;
}


/**
 * Generates selectbox options of actors
 * @return null|string
 */
function ttroupe_actor_options() {
    global $model_actors;
    $actors = $model_actors->get('active');

    $html = NULL;

    if ( !empty($actors) ) {
        foreach ( $actors as $actor ) {
            $html .= "<option value=\"$actor->ID\">$actor->display_name</option>";
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
            $html .= "<option value=\"$page->ID\" " . selected($theatreTroupe->options['actors_main_page'], $page->ID) . ">$page->post_title</option>";
        }
    }
    return $html;
}


/**
 * Generates table rows for admin panel show participants table
 * @param  $show_id
 * @return null|string
 */
function ttroupe_show_actors($show_id) {
    global $model_shows;
    $html = NULL;
    $actors = $model_shows->get_actors($show_id);
    if ( !empty($actors) ) {
        foreach ( $actors as $actor ) {
            $html .= "<tr><td>$actor->display_name</td>
            <td><button class=\"button-secondary\" onclick=\"manage_show_participants('remove', $show_id, $actor->ID, this);\">" . __('Remove', 'theatre-troupe') . "</button></td>
            </tr>";
        }
    }
    return $html;
}

?>