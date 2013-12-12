<?php get_header(); ?>
<div class="clearthing"></div>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<img class="fixedlogo littlelogo" src="<?php echo get_template_directory_uri(); ?>/img/hmmm.png">
         <div class="postsingle" id="post">
			 <div class="wrapper-inner">

				<div class="post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				  <!-- <div class="post-date">

				    <a href="<?php the_permalink(); ?>"><?php echo the_time('j F Y') ?></a>

				  </div>-->
	 				 <?php

	 				 $defaults = array(
	 				 	'theme_location'  => 'header',
	 				 	'menu'            => 'header',
	 				 	'container'       => 'div',
	 				 	'container_class' => 'headermenu',
	 				 	'menu_class'      => 'menu',
	 				 	'menu_id'         => '',
	 				 	'echo'            => true,
	 				 	'fallback_cb'     => 'wp_page_menu',
	 				 	'before'          => ' | ',
	 				 	'after'           => '',
	 				 	'link_before'     => '',
	 				 	'link_after'      => '',
	 				 	'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s |</ul>',
	 				 	'depth'           => 0,
	 				 	'walker'          => ''
	 				 );

	 				 wp_nav_menu( $defaults );

	 				 ?> 
   				   <div class="post-image">
				       <?php  global $custom_select_mb;
				         		 $techniquemeta = $custom_select_mb->the_meta(); 
								 if($techniquemeta['type'] == 'Post') {
					the_post_thumbnail('full');  }
					else{
					
						echo do_shortcode( '[youtube id="'.$techniquemeta['youtube'].'"]' );
					}?>
   				   </div>
	               <div class="social_share <?php echo $title_top_class ;?>">
	                   <?php
	                       // Setup share urls
	                       $facebook_share = "http://www.facebook.com/sharer.php?s=100&amp;p[title]=".urlencode(get_the_title())."&amp;p[summary]=".urlencode(get_the_excerpt())."&amp;p[url]=".get_permalink();
	                       $twitter_share = "https://twitter.com/share?url=".get_permalink()."&amp;text=".urlencode("This is awesome - ".get_the_title());
	                   ?>
	                   <a class="zocial facebook" href="<?php echo $facebook_share; ?>" onclick="return !handleSocialWin('<?php echo $facebook_share; ?>', 'Facebook');" target="_blank">Share on Facebook</a>

	                   <a class="zocial twitter" href="<?php echo $twitter_share; ?>" onclick="return !handleSocialWin('<?php echo $twitter_share; ?>', 'Twitter');" target="_blank">Share on Twitter</a>
	               </div>
				  <div class="post-title">

				   <h2><?php the_title(); ?></h2>

				  </div><!-- .post-title -->

				  <div class="post-content">

				      <?php the_content();?>

				  </div><!-- .post-content -->
				  <div class="leftthingsingle">
				  	<div class="authorinfo">
	
				  	<?php echo get_avatar( get_the_author_meta('email') , 75 ); ?>
				  	<p class="authorname"><?php the_author()?></p>
				  	<div class="authordescriphelper"><p class="authordescription"><?php echo get_the_author_meta('description');?></p></div>
				  	<div class="socialleftthingbtns">
				   <a href="https://twitter.com/FilmBundle" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @FilmBundle</a>
				  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
				  	<div class="fb-like" data-href="http://facebook.com/filmbundle" data-width="100" data-layout="button_count" data-show-faces="false" data-send="false"></div>
	 
				  </div>
				  </div>
				  </div>
	              <div style="text-align:center;border-bottom: 1px solid #ddd;padding-bottom: 4px;">
	                  <a class="zocial facebook" href="<?php echo $facebook_share; ?>" onclick="return !handleSocialWin('<?php echo $facebook_share; ?>', 'Facebook');" target="_blank">Share on Facebook</a>

	                  <a class="zocial twitter" href="<?php echo $twitter_share; ?>" onclick="return !handleSocialWin('<?php echo $twitter_share; ?>', 'Twitter');" target="_blank">Share on Twitter</a>
                
	                  <a class="zocial reddit" href="http://www.reddit.com/submit" onclick="window.location = 'http://www.reddit.com/submit?url=' + encodeURIComponent(window.location); return false"> Submit on Reddit </a>
	              </div>
		          <div class="fbcoms">
<?php comments_template(); ?>
			</div>
	          <div class="mainsharing2 white_box box_info">
	              <div class="socialstuff2">
	                  <h3>Love it<span>?</span> Keep it coming!</h3>
	                      <p>Sign up and we'll send you exclusive articles and interviews.</p>
      
      
	              <?php mailchimpSF_signup_form(); ?>
  
	              </div>
	          </div>
				</div><!-- /.post -->
           

            <?php endwhile; else: ?>

            <p>Sorry, no posts matched your criteria.</p>

            <?php endif; ?>
            
            <div id="post-tags"><?php the_tags('Tags: ', ', ', ' '); ?></div>

		</div>
        </div><!-- #post -->

   </div><!-- /#content -->

<?php get_footer(); ?>