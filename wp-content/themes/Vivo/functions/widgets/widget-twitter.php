<?php
	/* Add our function to the widgets_init hook. */
	add_action( 'widgets_init', 'md_load_widget_twitter' );

	/* Function that registers our widget. */
	function md_load_widget_twitter() {
		register_widget( 'md_Twitter_Widget' );
	}

	class md_Twitter_Widget extends WP_Widget {

		function md_Twitter_Widget() {
				/* Widget settings. */
				$widget_ops = array( 'classname' => 'example', 'description' => 'Display your latest tweets' );

				/* Widget control settings. */
				$control_ops = array( 'width' => 200, 'height' => 150, 'id_base' => 'md_twitter_widget' );

				/* Create the widget. */
				$this->WP_Widget( 'md_twitter_widget', 'Custom Twitter', $widget_ops, $control_ops );
			}
			
		function widget( $args, $instance ) {
			extract( $args );

			/* User-selected settings. */
			$title = apply_filters('widget_title', $instance['title'] );
			$username = $instance['username'];
			$tweetcount = $instance['tweetcount'];
			$followtext = $instance['followtext'];
			

			/* Before widget (defined by themes). */
			echo $before_widget;

			/* Title of widget (before and after defined by themes). */
			if ( $title )
				echo $before_title . $title . $after_title;
			?>

			<script>
			jQuery(window).load(function(){
				jQuery('#twitter-tweets').flexslider({
		            animation: 'slide',
		            controlNav: false,
					directionNav: false,
		            slideshow: true,
		            slideshowSpeed: 3000,
		            animationSpeed: 300,
		            smoothHeight: true
				});
			});
			</script>
			<div id="twitter-tweets" class="flexslider">	
				<ul id="twitter_update_list" class="slides">
					<li>&nbsp;</li>
				</ul>
			</div>
			<?php if ( $followtext ) { //if follow me text supplied, display it ?>
				<a class ="followme" href="http://twitter.com/<?php echo $username; ?>"><?php echo $followtext ?></a>
			<?php } ?>
			
			
			<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
			<script type="text/javascript" src="http://api.twitter.com/1/statuses/user_timeline.json?callback=twitterCallback2&count=<?php echo $tweetcount; ?>&include_rts=true&screen_name=<?php echo $username; ?>"></script>

			<?php

			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['username'] = strip_tags( $new_instance['username'] );
			$instance['tweetcount'] = strip_tags( $new_instance['tweetcount'] );
			$instance['followtext'] = strip_tags( $new_instance['followtext'] );

			return $instance;
		}
		
		function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Twitter', 'username' => 'martin870', 'tweetcount' => '2', 'followtext' => 'Follow Me' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>">Username:</label>
			<p style="float: left; margin-right: 3px; padding-top: 5px;">@</p><input id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" style="width:70%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'tweetcount' ); ?>">Tweets to show:</label>
			<input id="<?php echo $this->get_field_id( 'tweetcount' ); ?>" name="<?php echo $this->get_field_name( 'tweetcount' ); ?>" value="<?php echo $instance['tweetcount']; ?>" style="width:10%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'followtext' ); ?>">Follow Me Text:</label>
			<input id="<?php echo $this->get_field_id( 'followtext' ); ?>" name="<?php echo $this->get_field_name( 'followtext' ); ?>" value="<?php echo $instance['followtext']; ?>" style="width:70%;" />
		</p>

		<?php
		}
	}
?>