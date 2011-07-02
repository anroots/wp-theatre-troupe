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
                $date = mysql2date('d.m.y', $show_data->start_date);
                $html .= "<li><i>$date</i> <strong>$show_data->title</strong></li>";
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
                        $html .= "<li><i>$date</i> <strong>$show->title</strong></li>";
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
                        $html .= "<li>$actor_data->display_name <i>($play_cnt " . __('shows', 'theatre-troupe') . ")</i></li>";
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

        if (!isset($status) || !array_key_exists($status, $statuses)) {
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
                $html .= "<li><strong>$actor->display_name</strong></li>";
            }
            $html .= '</ul>';
        } else {
            $html .= __('No actors in this category.', 'theatre-troupe');
        }
        return $html;
    }
}

?>