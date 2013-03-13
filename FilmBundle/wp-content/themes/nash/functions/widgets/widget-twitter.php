<?php
/*
Plugin Name: Twitter Widget
Description: Twitter Widget to display a list of your latest tweets.
Author: GuuThemes
Version: 1.0
Author URI: http://guuhuu.com/
*/

class gt_twitter_widget extends WP_Widget {

	function gt_twitter_widget() {

		$widget_ops = array(
			'classname' => 'gt_twitter_widget',
			'description' => __('Display a list of your latest Tweets', 'hanna')
		);

		$control_ops = array();

		$this->WP_Widget('gt_twitter_widget', __('Twitter', 'hanna'), $widget_ops, $control_ops);
	}

	function form($instance) {
	
		$instance = wp_parse_args((array) $instance, array(
			'gt_twitter_title' => '',
			'gt_twitter_username' => '',
			'gt_twitter_no_tweets' => '1',
			'gt_twitter_show_avatar' => false,
			'gt_twitter_cache_duration' => 0
		));
			
		$show_avatar_checked = ' checked="checked"';
		if ( $instance['gt_twitter_show_avatar'] == false )
			$show_avatar_checked = '';

		// Title
		$gtoutput .= '
			<p style="border-bottom: 1px solid #DFDFDF;">
				<label for="' . $this->get_field_id('gt_twitter_title') . '"><strong>' . __('Title', 'hanna') . '</strong></label>
			</p>
			<p>
				<input id="' . $this->get_field_id('gt_twitter_title') . '" name="' . $this->get_field_name('gt_twitter_title') . '" type="text" value="' . $instance['gt_twitter_title'] . '" />
			</p>
		';

		// Settings
		$gtoutput .= '
			<p style="border-bottom: 1px solid #DFDFDF;"><strong><label>' . __('Username', 'hanna') . '</label></strong></p>
	
			<p>
				<span style="color:#999;">@</span><input id="' . $this->get_field_id('gt_twitter_username') . '" name="' . $this->get_field_name('gt_twitter_username') . '" type="text" value="' . $instance['gt_twitter_username'] . '" />
			</p>
			
			<p style="border-bottom: 1px solid #DFDFDF;"><strong><label>' . __('Number of tweets to show', 'hanna') . '</label></strong></p>
				<input id="' . $this->get_field_id('gt_twitter_no_tweets') . '" name="' . $this->get_field_name('gt_twitter_no_tweets') . '" type="text" value="' . $instance['gt_twitter_no_tweets'] . '" />
			</p>
			
			<p style="border-bottom: 1px solid #DFDFDF;"><strong><label>' . __('Duration of cache', 'hanna') . '</label></strong></p>
				<input style="text-align:right;" id="' . $this->get_field_id('gt_twitter_cache_duration') . '" name="' . $this->get_field_name('gt_twitter_cache_duration') . '" type="text" size="10" value="' . $instance['gt_twitter_cache_duration'] . '" /> '.__('Seconds', 'hanna').'
			</p>
			
			<p>
				<label>' . __('Show your avatar?', 'hanna') . ' 
				<input type="checkbox" name="' . $this->get_field_name('gt_twitter_show_avatar') . '" id="' . $this->get_field_id('gt_twitter_show_avatar') . '"'.$show_avatar_checked.' /></label>
			</p>
		';
		
		echo $gtoutput;
	}

	function update($new_instance, $old_instance) {
		
		$instance = $old_instance;

		$new_instance = wp_parse_args((array) $new_instance, array(
			'gt_twitter_title' => '',
			'gt_twitter_username' => '',
			'gt_twitter_no_tweets' => '1',
			'gt_twitter_show_avatar' => false,
			'gt_twitter_cache_duration' => 0
		));

		$instance['plugin-version'] = strip_tags($new_instance['gt_twitter-version']);
		$instance['gt_twitter_title'] = strip_tags($new_instance['gt_twitter_title']);
		$instance['gt_twitter_username'] = strip_tags($new_instance['gt_twitter_username']);
		$instance['gt_twitter_no_tweets'] = strip_tags($new_instance['gt_twitter_no_tweets']);
		$instance['gt_twitter_show_avatar'] = strip_tags($new_instance['gt_twitter_show_avatar']);
		$instance['gt_twitter_cache_duration'] = $new_instance['my_cache_duration'];

		return $instance;
	}

	function widget($args, $instance) {
		extract($args);

		echo $before_widget;

		$title = (empty($instance['gt_twitter_title'])) ? '' : apply_filters('widget_title', $instance['gt_twitter_title']);

		if(!empty($title)) {
			echo $before_title . $title . $after_title;
		}

		echo $this->gt_twitter_output($instance, 'widget');
		echo $after_widget;
	}

	function gt_twitter_output($args = array(), $position) {
		
		$the_username = $args['gt_twitter_username'];
		$the_username = preg_replace('#^@(.+)#', '$1', $the_username);
		$the_nb_tweet = $args['gt_twitter_no_tweets'];
		$need_cache = ($args['gt_twitter_cache_duration']!='0') ? true : false;
		$show_avatar = ($args['gt_twitter_show_avatar']) ? true : false;




		if ( !function_exists ('gt_tw_filter_handler') ) {
			function gt_tw_filter_handler ( $seconds ) {
				// change the default feed cache recreation period to 2 hours
				return intval(isset($args['gt_twitter_cache_duration'])); //seconds
			}
		}
		add_filter( 'wp_feed_cache_transient_lifetime' , 'gt_tw_filter_handler' ); 
		 
		
			function gttw_format_since($date){
				
				$timestamp = strtotime($date);
				
				$the_date = '';
				$now = time();
				$diff = $now - $timestamp;
				
				if($diff < 60 ) {
					$the_date .= $diff.' ';
					$the_date .= ($diff > 1) ?  __('Seconds ago', 'hanna') :  __('Second ago', 'hanna');
				}
				elseif($diff < 3600 ) {
					$the_date .= round($diff/60).' ';
					$the_date .= (round($diff/60) > 1) ?  __('Minutes ago', 'hanna') :  __('Minute ago', 'hanna');
				}
				elseif($diff < 86400 ) {
					$the_date .=  round($diff/3600).' ';
					$the_date .= (round($diff/3600) > 1) ?  __('Hours ago', 'hanna') :  __('Hour ago', 'hanna');
				}
				else {
					$the_date .=  round($diff/86400).' ';
					$the_date .= (round($diff/86400) > 1) ?  __('Days ago', 'hanna') :  __('Day ago', 'hanna');
				}
			
				return $the_date;
			}
			
			function gttw_format_tweettext($raw_tweet, $username) {

				$i_text = htmlspecialchars_decode($raw_tweet);
				/* $i_text = preg_replace('#(([a-zA-Z0-9_-]{1,130})\.([a-z]{2,4})(/[a-zA-Z0-9_-]+)?((\#)([a-zA-Z0-9_-]+))?)#','<a href="//$1">$1</a>',$i_text); */
				$i_text = preg_replace('#(((https?|ftp)://(w{3}\.)?)(?<!www)(\w+-?)*\.([a-z]{2,4})(/[a-zA-Z0-9_-]+)?)#',' <a href="$1" rel="nofollow" class="gt_twitter_url">$5.$6$7</a>',$i_text);
				$i_text = preg_replace('#@([a-zA-z0-9_]+)#i','<a href="http://twitter.com/$1" class="gt_twitter_tweetos" rel="nofollow">@$1</a>',$i_text);
				$i_text = preg_replace('#[^&]\#([a-zA-z0-9_]+)#i',' <a href="http://twitter.com/#!/search/%23$1" class="gt_twitter_hashtag" rel="nofollow">#$1</a>',$i_text);
				$i_text = preg_replace( '#^'.$username.': #i', '', $i_text );
				
				return $i_text;
			
			}
			
			function gttw_format_tweetsource($raw_source) {
			
				$i_source = htmlspecialchars_decode($raw_source);
				$i_source = preg_replace('#^web$#','<a href="http://twitter.com">Twitter</a>', $i_source);
				
				return $i_source;
			
			}
			
			
			function gttw_get_the_user_timeline($username, $nb_tweets, $show_avatar) {
				
				$username = (empty($username)) ? 'wordpress' : $username;
				$nb_tweets = (empty($nb_tweets) OR $nb_tweets == 0) ? 1 : $nb_tweets;
				$xml_result = $the_best_feed = '';
				
				// include of WP's feed functions
				include_once(ABSPATH . WPINC . '/feed.php');
				
				// some RSS feed with timeline user
				$search_feed1 = "http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=".$username."&count=".intval($nb_tweets);
				$search_feed2 = "http://search.twitter.com/search.rss?q=from%3A".$username."&rpp=".intval($nb_tweets);

				
				// get the better feed
				// try with the first one
				
				$sf_rss = fetch_feed ( $search_feed1 );
				if ( is_wp_error($sf_rss) ) {
					// if first one is not ok, try with the second one
					$sf_rss = fetch_feed ( $search_feed2 );
					
					if ( is_wp_error($sf_rss) ) $the_best_feed = false;
					else $the_best_feed = '2';
				}
				else $the_best_feed = '1';
				
				// if one of the rss is readable
				if ( $the_best_feed ) {
					$max_i = $sf_rss -> get_item_quantity($nb_tweets);
					$rss_i = $sf_rss -> get_items(0, $max_i);
					$i = 0;
					foreach ( $rss_i as $tweet ) {
						$i++;
						$i_title = gttw_format_tweettext($tweet -> get_title() , $username);
						$i_creat = gttw_format_since( $tweet -> get_date() );
						
						$i_guid = $tweet->get_link();
						
						$author_tag = $tweet->get_item_tags('','author');
						$author_a = $author_tag[0]['data'];
						$author = substr($author_a, 0, stripos($author_a, "@") );
						
						$source_tag = $tweet->get_item_tags('http://api.twitter.com','source');
						$i_source = $source_tag[0]['data'];
						$i_source = gttw_format_tweetsource($i_source);
						$i_source = ($i_source) ? '<span class="my_source">via ' . $i_source : '</span>';
						
						if ( $the_best_feed == '1' && $show_avatar) {
							$avatar = "http://api.twitter.com/1/users/profile_image/". $username .".xml?size=normal";
						}
						elseif ($the_best_feed == '2' && $show_avatar) {
							$avatar_tag = $tweet->get_item_tags('http://base.google.com/ns/1.0','image_link');
							$avatar = $avatar_tag[0]['data'];
						}
						
						$html_avatar = ($show_avatar && $avatar) ? '<a class="tweet_avatar" href="http://twitter.com/' . $username . '" title="' . __('Follow', 'hanna') . ' @'.$username.' ' . __('on twitter.', 'hanna') . '"><img src="'.$avatar.'" alt="'.$username.'" width="48" height="48" /></a>' : '';
						$xml_result .= '
							<li>
								'.$html_avatar.'
								<span class="twitter_content">' . $i_title . '</span>
								<br />
								<em class="gt_twitter_inner">
									<a href="'.$i_guid .'" target="_blank">' . $i_creat . '</a>
									'. $i_source .'
								</em>
							</li>
						';
					}
				}
				// if any feed is readable
				else 
					$xml_result = '<li><em>'.__('The RSS feed for this twitter account is not loadable for the moment.', 'hanna').'</em></li>';

				return $xml_result;
			}
			
			// display the widget front content
			echo '
				<div class="tweets">
					<ul class="tweet_list">
						'. gttw_get_the_user_timeline($the_username, $the_nb_tweet, $show_avatar) .'
				</div>					
					</ul>
				<p class="gt_twitter_follow_us" style="margin: 10px 0;"> 
						<span class="gt_tw_follow"><i class="icon-twitter"></i> ' . __('Follow', 'hanna') . '</span>
						<a class="gt_tw_username" href="http://twitter.com/' . $the_username . '">@' . $the_username . '</a>
						<span class="gt_tw_ontwitter">' . __('on Twitter.', 'hanna') . '</span>
					</p>
			';
	}
}

add_action('widgets_init', create_function('', 'return register_widget("gt_twitter_widget");'));

?>