<?php
/**
 * Sidebar Widget class
 * Implements a widget to show information about the next upcoming show
 * If there is no upcoming show, display data about the last show.
 */


class Theatre_Troupe_Next_Show_Widget extends WP_Widget {


    public function Theatre_Troupe_Next_Show_Widget() {

        /* Widget settings. */
        $widget_ops = array(
            'classname' => 'next_show',
            'description' => __('Displays information about the next or latest show.',
                                'theatre-troupe') );

        /* Widget control settings. */
        $control_ops = array(
            'width' => 300,
            'height' => 350,
            'id_base' => 'next-show-widget' );

        /* Create the widget. */
        $this->WP_Widget('next-show-widget', __('Theatre Troupe Next Show', 'theatre-troupe'), $widget_ops, $control_ops);
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

        echo $before_widget;


        echo $before_title . $title . $after_title;

        echo $this->widget_content();

        echo $after_widget;
    }


    /**
     * Update widget settings
     * @param  $new_instance
     * @param  $old_instance
     * @return mixed
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
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
        $defaults = array( 'title' => __('Next Show', 'theatre-troupe') );
        $instance = wp_parse_args((array) $instance, $defaults); ?>

    <p>
        <?php _e('Title:', 'theatre-troupe') ?>
        <input name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>"
               value="<?php echo $instance['title']; ?>"/>
    </p>
    <?php

    }


    /**
     * Output widget content to the visitor
     * @return void
     */
    private function widget_content() {
        global $model_shows;

        $show_id = $model_shows->get_closest('next');
        $title = __('Next show', 'theatre-troupe');

        if ( empty($show_id) ) {
            $show_id = $model_shows->get_closest('prev');
            $title = __('Previous show', 'theatre-troupe');
        }
        if ( empty($show_id) ) {
            return __('No shows found', 'theatre-troupe');
        }
        $show = $model_shows->get($show_id);

        $start_date = date_i18n(get_option('date_format'), strtotime($show->start_date));
        $html = "<h1>$title</h1><br /> <strong>$start_date</strong> <br />$show->title<br />";
        if ( !empty($show->location) ) {
            $html .= __('Location', 'theatre-troupe') . ": $show->location";
        }

        $html .= "<h2>" . __('Participating actors', 'theatre-troupe') . "</h2><ul>";

        $actors = $model_shows->get_actors($show_id);
        if ( !empty($actors) ) {

            foreach ( $actors as $actor ) {
                $html .= "<li>$actor->display_name</li>";
            }
        } else {
            $html .= "<li>" . __('None added yet...', 'theatre-troupe') . "</li>";
        }

        $html .= '</ul>';

        return $html;
    }
}

?>
