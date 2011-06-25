<?php
/**
 * Sidebar Widget class
 * Implements a widget to show previous or
 * upcoming shows
 */
add_action( 'widgets_init', 'theatre_troupe_load_widgets' );

function theatre_troupe_load_widgets() {
	register_widget( 'Theatre_Troupe_Widget' );
}


class Theatre_Troupe_Widget extends WP_Widget {


	public function Theatre_Troupe_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'shows', 'description' => __('Displays previous or upcoming shows', 'theatre-troupe') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'shows-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'shows-widget', __('Theatre Troupe Shows', 'theatre-troupe'), $widget_ops, $control_ops );
	}


    /**
     * Displays the widget in the sidebar (non-admin side)
     * @param  $args
     * @param  $instance
     * @return void
     */
	public function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('title', @$instance['title'] );
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
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['type'] = (bool) $new_instance['type'];
		return $instance;
	}

	
    /**
     * Echo form for changing widget settings
     * in Admin panel Widgets Manager
     * @param  $instance
     * @return void
     */
	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Upcoming Shows', 'theatre-troupe'), 'type' => 0 );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<?php _e('Title:', 'theatre-troupe') ?>
			<input name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<?php _e('Widget type', 'theatre-troupe') ?>:
			<select name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>">
				<option value="0" <?php selected($instance['type'], 0)?>><?php _e('Upcoming shows', 'theatre-troupe')?></option>
				<option value="1" <?php selected($instance['type'], 1)?>><?php _e('Past shows', 'theatre-troupe')?></option>
			</select>
		</p>

	<?php
	}


    private function widget_content($type = 0) {
        echo 'IT WORKS!';
    }
}

?>