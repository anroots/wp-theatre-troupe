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
            $actor_status = get_user_meta($actor->ID, 'ttroupe_status', TRUE);
            $full_name = $model_actors->full_name($actor->ID);

            foreach ( $model_actors->actor_statuses() as $key => $status ) {
                $s = ($actor_status == $key) ? ' selected' : '';
                $options .= "<option value=\"$key\"$s>$status</option>";
            }
            $profile_page = get_user_meta($actor->ID, 'ttroupe_profile_page', TRUE);
            $page_options = ttroupe_pages_options($profile_page);

            $html .= "
	<tr class=\"aaa\">
			<td>#$actor->ID</td>
			<td>" . $full_name . "</td>
			<td>
                <select class=\"page_select\">
                    <option value=\"\"></option>
                    $page_options
                </select>
                </td>
                <td>
                <select class=\"status_select\">
				    $options
                </select>
                <td>
				<button class=\"button-secondary\" onclick=\"change_actor_info($actor->ID, this);\">
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

    if ( empty($actors) ) {
        $html .= "<option value=\"-1\">No actors assigned</option>";
    } else {
        foreach ( $actors as $actor ) {
            $html .= '<option value="' . $actor->ID . '">' . $model_actors->full_name($actor->ID) . '</option>';
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
    global $model_shows, $model_actors;
    $html = NULL;
    $actors = $model_shows->get_actors($show_id);
    if ( !empty($actors) ) {
        foreach ( $actors as $actor ) {
            $html .= "<tr><td>" . $model_actors->full_name($actor->ID) . "</td>
            <td><button class=\"button-secondary\" onclick=\"manage_show_participants('remove', $show_id, $actor->ID, this);\">" . __('Remove', 'theatre-troupe') . "</button></td>
            </tr>";
        }
    } else {
        $html = '<tr><td colspan="2">' . __("Empty", "theatre-troupe") . '</td> </tr>';
    }
    return $html;
}


/**
 * Generates options for selecting the page for the shortcode [ttroupe-show-details]
 * @param string $selected
 * @return null|string
 */
function ttroupe_pages_options($selected = NULL) {
    $pages = get_pages();

    $html = NULL;

    if ( !empty($pages) ) {
        foreach ( $pages as $page ) {
            $sel = ($selected == get_permalink($page->ID)) ? ' selected = "selected"' : '';
            $html .= "<option value=\"$page->ID\" " . $sel . ">$page->post_title</option>";
        }
    }
    return $html;
}


/**
 * Returns the HTML link for a show's details page.
 * @param int $show_id
 * @param null $link_text Optional link text
 * @return string
 */
function ttroupe_show_details_link($show_id, $link_text = NULL) {
    $details = __('Details', 'theatre-troupe');
    if ( empty($link_text) ) {
        $link_text = $details;
    }
    $url = add_query_arg('show_id', $show_id, get_option('ttroupe_show_details_url'));
    if ( empty($url) ) {
        $url = '#';
    }
    return '<a href="' . $url . '" title="' . $details . '">' . $link_text . '</a>';
}


/**
 * Return a list of actors who participate in the show as HTML UL list.
 * Actor's names are links to profile pages
 * @param $show_id
 * @return null|string
 */
function ttroupe_actors_list($show_id) {
    global $model_shows, $model_actors;
    $html = NULL;
    $actors = $model_shows->get_actors($show_id);

    if ( !empty($actors) ) {
        $html .= "<h2>" . __('Actors', 'theatre-troupe') . "</h2><ul>";
        foreach ( $actors as $actor ) {

            $html .= '<li>'.ttroupe_profile_link($actor->ID).'</li>';
        }
        $html .= '</ul>';
    }
    return $html;
}

function ttroupe_profile_link($actor_id) {
    global $model_actors;
    $profile_link = get_user_meta($actor_id, 'ttroupe_profile_page', TRUE);
    return '<a href="' .$profile_link.'" title="'.__("Profile page", "theatre-troupe").'">'. $model_actors->full_name($actor_id) . '</a>';
}

?>
