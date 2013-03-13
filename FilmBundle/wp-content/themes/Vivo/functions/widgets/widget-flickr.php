<?php
	/* Add our function to the widgets_init hook. */
	add_action( 'widgets_init', 'md_load_widget_flickr' );

	/* Function that registers our widget. */
	function md_load_widget_flickr() {
		register_widget( 'md_Flickr_Widget' );
	}

	class md_Flickr_Widget extends WP_Widget {

		function md_Flickr_Widget() {
				/* Widget settings. */
				$widget_ops = array( 'classname' => 'example', 'description' => 'Display your Flickr images' );

				/* Widget control settings. */
				$control_ops = array( 'width' => 200, 'height' => 150, 'id_base' => 'md_flickr_widget' );

				/* Create the widget. */
				$this->WP_Widget( 'md_flickr_widget', 'Custom Flickr', $widget_ops, $control_ops );
			}
			
		function widget( $args, $instance ) {
			extract( $args );

			/* User-selected settings. */
			$title = apply_filters('widget_title', $instance['title'] );
			$flickrID = $instance['flickrID'];
			$imgCount = $instance['imgCount'];
			$type = $instance['type'];
			$displayType = $instance['displayType'];
			

			/* Before widget (defined by themes). */
			echo $before_widget;

			/* Title of widget (before and after defined by themes). */
			if ( $title )
				echo $before_title . $title . $after_title;
			?>
			
			<div class="flickr_widget clearfix">
				<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $imgCount ?>&amp;display=<?php echo $displayType ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>
			</div><!--end #flickr_widget-->

			<?php
			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
			$instance['imgCount'] = $new_instance['imgCount'];
			$instance['type'] = $new_instance['type'];
			$instance['displayType'] = $new_instance['displayType'];

			return $instance;
		}
		
		function form( $instance ) {

		/* Set up the default settings. */
		$defaults = array( 'title' => 'My pics', 'flickrID' => '38597611@N03', 'imgCount' => '8', 'type' => 'user', 'display' => 'latest' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>" style="width:80px; float: left;">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:55%;" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>" style="width:80px; float: left; padding-top:5px;">Flickr ID: <span style="display: block; font-size: 11px;"><a href="http://idgettr.com/" target="_blank">Get it</a></span></label>
			<input id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $instance['flickrID']; ?>" style="width:55%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'imgCount' ); ?>" style="width:80px; float: left; padding-top:5px;">Image count:</label>
			<select id="<?php echo $this->get_field_id( 'imgCount' ); ?>" name="<?php echo $this->get_field_name( 'imgCount' ); ?>" style="width:55%;">
				<option <?php if ($instance['imgCount'] == '4') echo 'selected="selected"'; ?>>4</option>
				<option <?php if ($instance['imgCount'] == '8') echo 'selected="selected"'; ?>>8</option>
				<option <?php if ($instance['imgCount'] == '12') echo 'selected="selected"'; ?>>12</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>" style="width:80px; float: left; padding-top:5px;">User type:</label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" style="width:55%;">
				<option <?php if ($instance['type'] == 'user') echo 'selected="selected"'; ?>>user</option>
				<option <?php if ($instance['type'] == 'group') echo 'selected="selected"'; ?>>group</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'displayType' ); ?>" style="width:80px; float: left; padding-top:5px;">Display type:</label>
			<select id="<?php echo $this->get_field_id( 'displayType' ); ?>" name="<?php echo $this->get_field_name( 'displayType' ); ?>" style="width:55%;">
				<option <?php if ($instance['displayType'] == 'latest') echo 'selected="selected"'; ?>>latest</option>
				<option <?php if ($instance['displayType'] == 'random') echo 'selected="selected"'; ?>>random</option>
			</select>
		</p>

		<?php
		}
	}
?>