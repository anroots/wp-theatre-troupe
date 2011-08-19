<?php

/**
 * Handles output of shortcode data.
 */
class Theatre_Troupe_Shortcode {


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


}

?>