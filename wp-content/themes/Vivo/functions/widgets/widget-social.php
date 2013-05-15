<?php
/**
 * Plugin Name: Social Media Widget
 * Plugin URI: http://martinburdon.co.uk
 * Description: A widget to display links to social media places
 * Version: 0.1
 * Author: Martin Burdon
 * Author URI: http://martinburdon.co.uk
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'md_load_widget_social' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function md_load_widget_social() {
	register_widget( 'Social_Widget' );
}

/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Social_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Social_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'example', 'description' => 'Display links to your social media profiles, accounts are pulled in from the Theme Options.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 350, 'height' => 350, 'id_base' => 'md-social-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'md-social-widget', 'Social Widget', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );		

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		/* Display icons if account details are supplied */
		?>
			<ul id="social">
	          <?php if(get_option('of_sm_facebook') != "") { ?><li><a href="http://facebook.com/<?php echo get_option('of_sm_facebook'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/facebook_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_vimeo') != "") { ?><li><a href="http://vimeo.com/<?php echo get_option('of_sm_vimeo'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/vimeo_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_twitter') != "") { ?><li><a href="http://twitter.com/<?php echo get_option('of_sm_twitter'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/twitter_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_tumblr') != "") { ?><li><a href="http://<?php echo get_option('of_sm_tumblr'); ?>.tumblr.com/"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/tumblr_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_linkedin') != "") { ?><li><a href="<?php echo get_option('of_sm_linkedin'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/linkedin_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_flickr') != "") { ?><li><a href="http://www.flickr.com/photos/<?php echo get_option('of_sm_flickr'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/flickr_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_dribbble') != "") { ?><li><a href="http://www.dribbble.com/<?php echo get_option('of_sm_dribbble'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/dribbble_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_rss') != "") { ?><li><a href="<?php echo get_option('of_sm_rss'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/rss_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_forrst') != "") { ?><li><a href="http://forrst.com/people/<?php echo get_option('of_sm_forrst'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/forrst_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_devart') != "") { ?><li><a href="http://<?php echo get_option('of_sm_devart'); ?>.deviantart.com"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/deviantart_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_google') != "") { ?><li><a href="http://plus.google.com/<?php echo get_option('of_sm_google'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/google_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_lastfm') != "") { ?><li><a href="http://last.fm/user/<?php echo get_option('of_sm_lastfm'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/lastfm_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_myspace') != "") { ?><li><a href="http://www.myspace.com/<?php echo get_option('of_sm_myspace'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/myspace_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_pinterest') != "") { ?><li><a href="http://pinterest.com/<?php echo get_option('of_sm_pinterest'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/pinterest_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_skype') != "") { ?><li><a href="callto://<?php echo get_option('of_sm_skype'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/skype_hover.png" /></a></li><?php } ?>
	          <?php if(get_option('of_sm_youtube') != "") { ?><li><a href="<?php echo get_option('of_sm_youtube'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/youtube_hover.png" /></a></li><?php } ?>
	        </ul>
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

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:80%;" />
		</p><br/>

	<?php
	}
}
?>