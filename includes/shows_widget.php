<?php
/**
 * Sidebar Widget class
 * Implements a widget to show previous or
 * upcoming shows
 */


class Theatre_Troupe_Shows_Widget extends WP_Widget {


    public function Theatre_Troupe_Shows_Widget() {

        /* Widget settings. */
        $widget_ops = array(
            'classname' => 'shows',
            'description' => __('Displays previous or upcoming shows',
                                'theatre-troupe') );

        /* Widget control settings. */
        $control_ops = array(
            'width' => 300,
            'height' => 350,
            'id_base' => 'shows-widget' );

        /* Create the widget. */
        $this->WP_Widget('shows-widget', __('Theatre Troupe Shows', 'theatre-troupe'), $widget_ops, $control_ops);
    }


    /**
     * Displays the widget in the sidebar (non-admin side)
     * @param  $args
     * @param  $instance
     * @return void
     */
    public function widget($args, $instance) {
        extract($args);

        $title = apply_filters('title', @$instance['title']);
        $type = (int) @$instance['type'];

        echo $before_widget;


        echo $before_title . $title . $after_title;

        echo $this->widget_content($type);

        echo $after_widget;
    }


    /**
     * Update widget settings
     * @param  $new_instance
     * @param  $old_instance
     * @return
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['type'] = (bool) $new_instance['type'];
        return $instance;
    }


    /**
     * Echo form for changing widget settings
     * in Admin panel Widgets Manager
     * @param  $instance
     * @return void
     */
    public function form($instance) {

        /* Set up some default widget settings. */
        $defaults = array( 'title' => __('Previous Shows', 'theatre-troupe'), 'type' => 0 );
        $instance = wp_parse_args((array) $instance, $defaults); ?>

    <p>
        <?php _e('Title:', 'theatre-troupe') ?>
        <input name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>"
               value="<?php echo $instance['title']; ?>"/>
    </p>

    <p>
        <?php _e('Widget type', 'theatre-troupe') ?>:
        <select name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>">
            <option value="0" <?php selected($instance['type'], 0)?>><?php _e('Past shows', 'theatre-troupe')?></option>
            <option value="1" <?php selected($instance['type'], 1)?>><?php _e('Upcoming shows', 'theatre-troupe')?></option>
        </select>
    </p>

    <?php

    }

    private function format_date($datetime, $onlyTime = false) {
        if ( WPLANG == 'et_EE' ) {
            $fmt = '%H.%M';
            if ( !$onlyTime ) {
                $fmt = '%e. %B (%A) kell ' . $fmt;
            }
        } else {
            if ( $onlyTime ) {
                $fmt = '%X';
            } else {
                $fmt = '%c';
            }
        }
        $res = strftime($fmt, $datetime);

        // Temporary fix - Estonian umlauts weren't showing correctly
        return htmlentities($res);
    }


    /**
     * @todo: Remove this, move to native WP functions
     * @param $start_date
     * @param $end_date
     * @return array
     */
    private function format_start_end_dates($start_date, $end_date) {
        $startDateNumeric = strtotime($start_date);
        $endDateNumeric = strtotime($end_date);

        $startDateStr = $this->format_date($startDateNumeric);
        if ( $endDateNumeric > $startDateNumeric ) {
            if ( date('d:m:Y', $endDateNumeric) == date('d:m:Y', $startDateNumeric) ) {
                // If end date is on same day as start date, only display the end TIME
                $onlyTime = true;
            } else {
                $onlyTime = false;
            }
            $endDateStr = ' - ' . $this->format_date($endDateNumeric, $onlyTime);
        } else {
            $endDateStr = '';
        }

        return array( $startDateStr, $endDateStr );
    }


    /**
     * Output widget content to the visitor
     * @param int $type Whether to return past or future shows. 0 = past, 1 = future
     * @return void
     */
    private function widget_content($type = 0) {
        global $model_shows;

        $type = ($type == 0) ? 'past' : 'future';

        $shows = $model_shows->get(NULL, array( 'status' => 'active', 'timeline' => $type ));

        $html = '<ul>';
        if ( !empty($shows) ) {

            // Add this to the sidebar for each active show of type $type
            foreach ( $shows as $show ) {
                list($startDateStr, $endDateStr) = $this->format_start_end_dates(
                    $show->start_date, $show->end_date);

                // Actual HTML for each show
                $html .= "<li><strong>$show->series_title</strong>: $show->title<br />"
                         . "<i>
                         ".ttroupe_show_details_link($show->id, $startDateStr) ."
                         ". $endDateStr . "</i><br />"
                         . "$show->location";
                if ( $show->linkurl ) {
                    $html .= ' <a href="' . $show->linkurl . '">' . $show->linkname
                             . '</a>';
                }
                $html .= "</li>";

            }

        } else {
            $html .= __('No shows listed yet', 'theatre-troupe');
        }
        $html .= '</ul>';

        return $html;
    }
}

?>
