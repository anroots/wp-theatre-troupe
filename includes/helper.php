<?php

/**
 * Helper file for generating HTML
 * and formatting strings
 **/



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
    if (empty($profile_link)) {
        return $model_actors->full_name($actor_id);
    }
    return '<a href="' .$profile_link.'" title="'.__("Profile page", "theatre-troupe").'">'. $model_actors->full_name($actor_id) . '</a>';
}

?>
