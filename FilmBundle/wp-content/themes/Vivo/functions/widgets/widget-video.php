<?php
/**
 * Plugin Name: Example Widget
 * Plugin URI: http://example.com/widget
 * Description: A widget that serves as an example for developing more advanced widgets.
 * Version: 0.1
 * Author: Justin Tadlock
 * Author URI: http://justintadlock.com
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'md_load_widget_video' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function md_load_widget_video() {
	register_widget( 'Video_Widget' );
}

/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Video_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Video_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'example', 'description' => 'Display an embedded video from Vimeo, YouTube etc.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 400, 'height' => 350, 'id_base' => 'md-video-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'md-video-widget', 'Custom Video Widget', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		
		$video = $instance['video'];
		$caption = $instance['caption'];
		

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		/* Display video if one was input correctly. */
		?>
		<div class="video_container">
		<?php echo $video ?>
		<?php if($caption) { ?>
		<p><?php echo $caption ?></p><?php } ?>
		</div>
		
		
		<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		$instance['video'] = stripslashes( $new_instance['video'] );
		$instance['caption'] = strip_tags( $new_instance['caption'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'My Custom video', 'video' => 'Paste the embed code from Vimeo/YouTube etc, here.', 'caption' => 'Enter a caption here if you wish', );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>" style="width:80px; float: left; padding-top: 5px;"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:65%;" />
		</p><br/>

		<!-- Video code: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'video' ); ?>" style="width:80px; float: left; padding-top: 5px;">Video embed code</label>
			<p style="width:80px; float: left; padding-top: 5px; clear: left; font-size: 11px;">Remove width/height attributes to enable responsiveness.</p>
			<textarea id="<?php echo $this->get_field_id( 'video' ); ?>" name="<?php echo $this->get_field_name( 'video' ); ?>" rows="6" cols="40"><?php echo stripslashes(htmlspecialchars_decode($instance['video'])); ?></textarea>
		</p>

			<!-- Caption: Text Input -->
			<p>
				<label for="<?php echo $this->get_field_id( 'caption' ); ?>" style="width:80px; float: left; padding-top: 5px;">Caption</label>
				<input id="<?php echo $this->get_field_id( 'caption' ); ?>" name="<?php echo $this->get_field_name( 'caption' ); ?>" value="<?php echo $instance['caption']; ?>" style="width:65%;" />
			</p><br/>

	<?php
	}
}
?>