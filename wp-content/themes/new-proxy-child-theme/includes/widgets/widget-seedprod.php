<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_seedprod");'));

class stag_section_seedprod extends WP_Widget{
  function stag_section_seedprod(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Show info about your site from specific page.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_seedprod');
    $this->WP_Widget('stag_section_seedprod', __('Homepage: Seedprod Section', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = $instance['title'];
    $subtitle = $instance['subtitle'];
    $color = $instance['color'];
    $bg = $instance['bg'];
    $link = $instance['link'];
    $page = $instance['page'];
    $id = $instance['id'];
    $facebook_share_text = $instance['facebook_share_text'];
    $twitter_share_text = $instance['twitter_share_text'];

    echo $before_widget;

    ?>

    <!-- BEGIN #about.section-block -->
    <section id="<?php echo stag_to_slug($id); ?>" class="section-block content-section">

      <div class="inner-section">

        <?php

        $the_page = get_page($page);

            echo '<h1 id="bigone">'.$title.'</h1>';
			if($subtitle != '') echo '<p class="shared-sub-title">'.$subtitle.'</p>';
		
        // echo '<div class="entry-content">'.apply_filters('the_content', $the_page->post_content).'</div>';
    include_once(SEED_CSP3_PLUGIN_PATH.'/themes/default/functions.php' );
   	 echo seed_cs3_head(); 
   ?>
    <div class="centerthis">
    <?php
        if (is_user_logged_in()) {
            // Get relevant info for current user
            $user = wp_get_current_user();
            $email = $user->user_email;

            // Retrieve the user from the subscriber DB
            global $wpdb;
            $tablename = $wpdb->prefix . SEED_CSP3_TABLENAME;
            $sql = "SELECT * FROM $tablename WHERE email = %s;";
            $safe_sql = $wpdb->prepare($sql, $email);
            $result = $wpdb->get_row($safe_sql);

            if ($result) {
                // Calc referrer url
                $ref = $result->id+1000;
                $referrer_url = home_url() . '?ref='.base_convert($ref, 10, 36);
                ?>
				<div class="bigstatsbox grid-9">
					<div class="statstitle">
						<p>Help us spread the word to get 
              <span id="seedprod_title_link"><a href="#myModal3" data-toggle="modal">unique prizes and invites!</a></span>
              <span id="seedprod_title_desc">(like 1-on-1 skype sessions with Sundance winners)</span>
</p>
					</div>
					<div class="statsleft grid-6">
		                <?php
		                    // Setup share urls
		                    $facebook_share = "http://www.facebook.com/sharer.php?s=100&amp;p[title]=FilmBundle&amp;p[summary]=".urlencode($facebook_share_text)."&amp;p[url]=".urlencode($referrer_url);
		                    $twitter_share = "https://twitter.com/share?url=".urlencode($referrer_url)."&amp;text=".urlencode($twitter_share_text);
		                ?>
		                <a class="zocial facebook" href="<?php echo $facebook_share; ?>" onclick="return !handleSocialWin('<?php echo $facebook_share; ?>', 'Facebook');" target="_blank">Share on Facebook</a>

		                <a class="zocial twitter" href="<?php echo $twitter_share; ?>" onclick="return !handleSocialWin('<?php echo $twitter_share; ?>', 'Twitter');" target="_blank">Share on Twitter</a>
                <div class="translucent-modal tranlink">
                    <p title="Your unique url. Click the button to copy." data-placement="top" data-toggle="tooltip" class="littletooltip"><?php echo $referrer_url; ?></p><a data-clipboard-text="<?php echo $referrer_url; ?>" class="btn btn-small btn-inverse zclipbtn"> Copy</a></div>
				<script type="text/javascript">
				    jQuery(function () {
				        jQuery(".littletooltip").tooltip();
						
				    });
					
					
				</script>
				<script language="JavaScript">
				      var clip = new ZeroClipboard( jQuery('a.zclipbtn'), {
  							moviePath: "<?php echo get_stylesheet_directory_uri(); ?>/assets/js/ZeroClipboard.swf",
					} );

				      clip.on( 'load', function(client) {
				        // alert( "movie is loaded" );
				      } );

				      clip.on( 'complete', function(client, args) {
				        alert("Copied text to clipboard: " + args.text + " Time to send an email. :-)");
				      } );

				      clip.on( 'mouseover', function(client) {
				        // alert("mouse over");
				      } );

				      clip.on( 'mouseout', function(client) {
				        // alert("mouse out");
				      } );

				      clip.on( 'mousedown', function(client) {

				        // alert("mouse down");
				      } );

				      clip.on( 'mouseup', function(client) {
				        // alert("mouse up");
				      } );

				    </script>
                <br/>

                
			</div>
			<div class="statsright grid-6">
                <div class="translucent-modal tranlink2">
                    <span id="seedprod_stats_text">Your stats so far...</span>
                    <br/>
					<div class="thestats">
						<div class="thestatsleft">
                   <?php echo $result->clicks; ?><span>Clicks</span>
			   </div>
			   <div class="thestatsright">
                  <?php echo $result->conversions; ?><span>Sign-ups</span>
				</div>
				</div>
                </div>
			</div>
                <?php
            } else {
              ?>
              <div class="translucent-modal">
                  <?php echo seed_cs3_form(); ?>
              </div>
              <?php
            }
        } else {
            ?>
            <div class="translucent-modal">
                <?php echo seed_cs3_form(); ?>
            </div>
            <?php
        }
    ?>
</div>
    <?php
    echo seed_cs3_footer();



        ?>

      </div>
  </div>

  

  <div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal3Label" aria-hidden="true">
    <div class="modal-header">  <button type="button" class="closeit" data-dismiss="modal" aria-hidden="true">X</button>
      <h3 id="myModal3Label">Join the inner circle</h3>
    </div>
    <div class="modal-body">
		<p> We built FilmBundle from the ground up with the goal of supporting independent film and arts driven charities. This isn't about us selling something, it's about building a community, and we need lots of help. The good news? <strong>A few shares on Facebook, Twitter, or email from awesome folks like you is all it takes.</strong>  </p>
		
		<p> If you get just 3 friends to sign up, we'll send you - </p> <ul><li>early access to our bundles</li><li>first news about curators<li> exclusive video content like behind the scenes footage, extras, and filmmaking courses.</li></ul> <p>Help us build the community even more, and you'll start getting invites to our events (both online and off), where you can - </p><ul><li>hang out with the filmmakers</li><li> watch exclusive screenings</li> <li>who knows what else!!? (We are always dreaming up new events, and you'll be on the ground floor.)</li></ul> <p></p>
		<center>
		<p style="text-align:center">Be awesome. Share away.</p>
        <a class="zocial facebook" href="<?php echo $facebook_share; ?>" onclick="return !handleSocialWin('<?php echo $facebook_share; ?>', 'Facebook');" target="_blank">Share on Facebook</a>

        <a class="zocial twitter" href="<?php echo $twitter_share; ?>" onclick="return !handleSocialWin('<?php echo $twitter_share; ?>', 'Twitter');" target="_blank">Share on Twitter</a>
	</center>
    </div>
    <div class="modal-footer">
    </div>
  </div>
  
      <!-- END #about.section-block -->
    </section>
  <div class="topshelf grid-12"></div>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = $new_instance['title'];
    $instance['subtitle'] = $new_instance['subtitle'];
    $instance['color'] = strip_tags($new_instance['color']);
    $instance['bg'] = strip_tags($new_instance['bg']);
    $instance['link'] = strip_tags($new_instance['link']);
    $instance['page'] = strip_tags($new_instance['page']);
    $instance['id'] = strip_tags($new_instance['id']);
    $instance['facebook_share_text'] = strip_tags($new_instance['facebook_share_text']);
    $instance['twitter_share_text'] = strip_tags($new_instance['twitter_share_text']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      /* Deafult options goes here */
      'page' => 0,
      'id' => 'about',
      'color' => '',
      'bg' => '',
      'link' => '',
      'facebook_share_text' => '',
      'twitter_share_text' => '',
    );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo @$instance['title']; ?>" />
      <span class="description">Leave blank to use default page title.</span>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
      <textarea class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo @$instance['subtitle']; ?>" /><?php echo @$instance['subtitle']; ?></textarea>
    </p>


    <p>
      <label for="<?php echo $this->get_field_id('facebook_share_text'); ?>"><?php _e('Facebook Share Text:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'facebook_share_text' ); ?>" name="<?php echo $this->get_field_name( 'facebook_share_text' ); ?>" value="<?php echo @$instance['facebook_share_text']; ?>" />
    </p>


    <p>
      <label for="<?php echo $this->get_field_id('twitter_share_text'); ?>"><?php _e('Twitter Share Text:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'twitter_share_text' ); ?>" name="<?php echo $this->get_field_name( 'twitter_share_text' ); ?>" value="<?php echo @$instance['twitter_share_text']; ?>" />
    </p>




    <p>
      <label for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Select Page:', 'stag'); ?></label>

      <select id="<?php echo $this->get_field_id( 'page' ); ?>" name="<?php echo $this->get_field_name( 'page' ); ?>" class="widefat">
      <?php

        $args = array(
          'sort_order' => 'ASC',
          'sort_column' => 'post_title',
          );
        $pages = get_pages($args);

        foreach($pages as $paged){ ?>
          <option value="<?php echo $paged->ID; ?>" <?php if($instance['page'] == $paged->ID) echo "selected"; ?>><?php echo $paged->post_title; ?></option>
        <?php }

       ?>
     </select>
     <span class="description">This page will be used to display content.</span>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Section ID:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo @$instance['id']; ?>" />
      <span class="description"><?php _e('Section ID is required if you want to use this section as a navigation. e.g. about, and add a custom link under Menus with link #about.', 'stag') ?></span>
    </p>

    <?php include('helper-widget-colors.php'); ?>

    <?php
  }
}

?>
