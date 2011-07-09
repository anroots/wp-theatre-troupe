<?php

/**
 * Handles output of shortcode data.
 */
class Theatre_Troupe_Shortcode {


    /**
     * Generates a list of shows the actor has participated in
     * Shortcode: [actor-shows-list actor_id="XXX"]Shows:[/actor-shows-list]
     * @param $attrs Only a single actor ID (actor_id) attribute is supported
     * @param string $content Optionally, a custom heading is included as content
     * @return string Output HTML of the list
     */
    public function actor_shows($attrs, $content = NULL) {
        extract(shortcode_atts(array(
                                    'actor_id' => '0'
                               ), $attrs));

        if ( empty($content) ) {
            $content = __('Actor\'s Shows', 'theatre-troupe');
        }

        global $model_actors, $model_shows;


        $html = "<h2>$content</h2>";


        $shows = $model_actors->get_actor_shows($actor_id);

        if ( !empty($shows) ) {
            $html .= '<ul>';

            foreach ( $shows as $show ) {
                $show_data = $model_shows->get($show->show_id);
                $date = date_i18n(get_option('date_format'), strtotime($show_data->start_date));
                $html .= "<li><i>".ttroupe_show_details_link($show->show_id, $date)."</i> <strong>$show_data->title</strong></li>";
            }

            $html .= '</ul>';
        } else {
            $html .= __('The actor has not yet participated in any shows.', 'theatre-troupe');
        }

        return $html;
    }


    /**
     * Prints a list of all series, each including a list of shows
     * belonging to the series and all actors who have played in at least one of the shows
     * @param $attrs Is null (no params accepted)
     * @param $content A custom heading
     * @return string HTML content
     */
    public function series_list($attrs, $content = NULL) {

        global $model_series, $model_shows, $model_actors;
        if ( empty($content) ) {
            $content = __('List of all shows', 'theatre-troupe');
        }

        $html = "<h2>$content</h2>";

        $series = $model_series->get();

        if ( !empty($series) ) {
            foreach ( $series as $serie ) {
                $html .= "<h3>" . __('Series', 'theatre-troupe') . ": $serie->title</h3><blockquote>$serie->description</blockquote>";

                // Print a list of all shows belonging to the series
                $shows = $model_shows->get(NULL, array( 'series_id' => $serie->id ));

                if ( !empty($shows) ) {
                    $html .= "<h4>" . __('List of shows', 'theatre-troupe') . "</h4><ul>";

                    foreach ( $shows as $show ) {
                        $date = date_i18n(get_option('date_format'), strtotime($show->start_date));
                        $html .= "<li><i>".ttroupe_show_details_link($show->id, $date)."</i> <strong>$show->title</strong></li>";
                    }
                } else {
                    $html .= "<ul><li>" . __('There are now shows here.', 'theatre-troupe') . "</li>";
                }

                $html .= '</ul>';


                // Print a list of all actors who have played in at least one of the shows
                $html .= "<h4>" . __('Participating actors', 'theatre-troupe') . "</h4><ul>";
                $series_count = $model_actors->serie_play_counts($serie->id); // array(ACTOR_ID => PLAY_CNT))

                if ( !empty($series_count) ) {
                    foreach ( $series_count as $actor_id => $play_cnt ) {
                        $actor_data = get_userdata($actor_id);
                        $html .= "<li>".$model_actors->full_name($actor_id)."<i>($play_cnt " . __('shows', 'theatre-troupe') . ")</i></li>";
                    }
                } else {
                    $html .= '<li>' . __('No-one has participated in this series!', 'theatre-troupe') . '</li>';
                }
                $html .= '</ul><hr />';
            }

        } else {
            $html .= "<p>" . __('No series have been added.', 'theatre-troupe') . "</p>";
        }

        return $html;
    }


    /**
     * Prints out a list of actors by actor status
     * @param $attrs contains @param status as a string
     * @param string $content Custom heading
     * @return null|string|void
     */
    public function actors_list($attrs, $content = NULL) {
        extract(shortcode_atts(array(
                                    'status' => 'active'
                               ), $attrs));

        global $model_actors;

        $statuses = $model_actors->actor_statuses();

        if ( !isset($status) || !array_key_exists($status, $statuses) || $status == 'unassigned') {
            return NULL;
        }

        if ( empty($content) ) {
            $content = $statuses[$status];
        }

        $html = "<h2>$content</h2>";
        $actors = $model_actors->get($status);

        if ( !empty($actors) ) {
            $html .= '<ul>';

            foreach ( $actors as $actor ) {
                $html .= '<li><strong>'.ttroupe_profile_link($actor->ID).'</strong></li>';
            }
            $html .= '</ul>';
        } else {
            $html .= __('No actors in this category.', 'theatre-troupe');
        }
        return $html;
    }


    /**
     * Prints all the information available for a given show.
     * The page containing the matching shortcode should not be directly accessed,
     * but rather referenced by other shortcodes/widgets so that the show_id param can
     * be added to the URL.
     * If no show_id is present the page defaults to the closest show in regards to NOW() or dies.
     * @return string
     */
    public function show_details() {
        global $model_shows, $model_series, $model_actors;
        $show_id = (isset($_GET['show_id'])) ? $_GET['show_id'] : $model_shows->get_closest('prev');
        if ( empty($show_id) ) {
            return '';
        }

        $show = $model_shows->get($show_id);
        $series = $model_series->get($show->series_id);

        $start_date = strtotime($show->start_date);
        $end_date = strtotime($show->end_date);
        $end_date = ($end_date > $start_date) ? ' - '.date_i18n(get_option('links_updated_date_format'), $end_date) : NULL;
        $start_date = date_i18n(get_option('links_updated_date_format'), $start_date);

        
        include(TTROUPE_PATH . 'templates/show_details.php');
    }


    /**
     * Inserts the output of [ttroupe-actor-shows] to the bottom of the page
     * if the page is listed as a profile page.
     * The function must be set as enabled from settings.
     * @param $content
     * @return string
     */
    public function auto_insert_actor_shows($content) {
        if (!get_option('ttroupe_insert_shows')) {
            return $content;
        }
        global $model_actors;
        $actor_id = $model_actors->is_profile_page();
        if (empty($actor_id)) {
            return $content;
        }

        $content .= $this->actor_shows(array('actor_id' => $actor_id));
        return $content;
    }

}

?>