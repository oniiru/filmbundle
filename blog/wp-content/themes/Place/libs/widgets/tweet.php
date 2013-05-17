<?php
add_action('widgets_init', 'tweets_load_widgets');

function tweets_load_widgets()
{
	register_widget('Tweets_Widget');
}

class Tweets_Widget extends WP_Widget {
	
	function Tweets_Widget()
	{
		$widget_ops = array('classname' => 'twitter_widget', 'description' => 'Tweets widget let you display Twitter updates.');

		$control_ops = array('id_base' => 'tweets-widget');

		$this->WP_Widget('tweets-widget', '&rArr; PressLayer: Tweets', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$twitter_id = $instance['twitter_id'];
		$number = $instance['number'];
		$follow = $instance['follow'];
		$tweet_count = $instance['tweet_count'];
		
		echo $before_widget;

		if($title) echo $before_title.$title.$after_title;

		if($twitter_id) { ?>
		
		
		<?php
		// Twitter updates
			$tw_updates = get_transient('tw_updates');
			if ($tw_updates !== false) { 
			
				echo $tw_updates;
			
			}else{
				$tw_updates = '';
				
				$get_tweets = wp_remote_get('http://api.twitter.com/1/statuses/user_timeline/'.$twitter_id.'.json?count='.$number.'&callback=?');
				$tweets = json_decode($get_tweets['body']);
				if($tweets): $tweets = array_slice($tweets, 0, $number); 
				$tw_updates .= '<ul>';
					foreach($tweets as $tweet):
					$tw_updates .= '<li>';
						$tw_time = strtotime($tweet->created_at);
						$new_time = date(get_option('date_format') . ' '. get_option('time_format'), $tw_time);
						$tw_updates .= make_clickable($tweet->text).' &mdash; <em>'.$new_time.'</em>';
					$tw_updates .= '</li>';
					 endforeach;
				$tw_updates .= '</ul>';
				endif;
			
			
				set_transient('tw_updates', $tw_updates, 35);
				
				echo $tw_updates; 
			}
		
		?>
		
		   <?php if($follow == 'yes'){?> 
			<div class="tw_btn">
			<a href="https://twitter.com/<?php echo $twitter_id; ?>" class="twitter-follow-button" data-show-count="<?php echo $tweet_count;?>" >Follow @<?php echo $twitter_id; ?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			 </div>
		  <?php } ?>	
			
			<?php
		}
		
		echo $after_widget;
	}
	
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['twitter_id'] = $new_instance['twitter_id'];
		$instance['number'] = $new_instance['number'];
		$instance['follow'] = $new_instance['follow'];
		$instance['tweet_count'] = $new_instance['tweet_count'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Recent Tweets', 'twitter_id' => 'presslayer', 'number' => 5, 'follow' => 'yes', 'tweet_count'=>'false');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('twitter_id'); ?>">Twitter ID:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" value="<?php echo $instance['twitter_id']; ?>" type="text" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">Number of tweets to show:</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $instance['number']; ?>" type="text" />
		</p>
		
		<p>
			
			<label for="<?php echo $this->get_field_id('follow'); ?>">Follow button:</label> 
			<select id="<?php echo $this->get_field_id('follow'); ?>" name="<?php echo $this->get_field_name('follow'); ?>" class="widefat follow" style="width:100%;">
				<option value='yes' <?php if ('yes' == $instance['follow']) echo 'selected="selected"'; ?>>Yes</option>
				<option value='no' <?php if ('no' == $instance['follow']) echo 'selected="selected"'; ?>>No</option>
			</select>
		</p>
		
		<p>
			
			<label for="<?php echo $this->get_field_id('tweet_count'); ?>">Tweets count:</label> 
			<select id="<?php echo $this->get_field_id('tweet_count'); ?>" name="<?php echo $this->get_field_name('tweet_count'); ?>" class="widefat follow" style="width:100%;">
				<option value='true' <?php if ('true' == $instance['tweet_count']) echo 'selected="selected"'; ?>>Yes</option>
				<option value='false' <?php if ('false' == $instance['tweet_count']) echo 'selected="selected"'; ?>>No</option>
			</select>
		</p>
		
	<?php
	}
}
?>