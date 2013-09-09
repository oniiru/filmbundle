<?php get_header(); ?>
<div class="clearthing"></div>
<img class="homelogo littlelogo" src="<?php echo get_template_directory_uri(); ?>/img/whitehmmm.png">

<div class="leftthing">
 <div class="inner-leftthing">
	 <a href="http://filmbundle.com/blog"><h1>FilmBundle Blog </h1>
	 <h2> Ramblings about the state of film and home of FilmBundle.TV </h2>
	 <a class="indexbutton1" href="http://filmbundle.tv"> Watch FilmBundle.TV </a>
	 <a class="indexbutton2" href="http://filmbundle.com"> Back to FilmBundle </a>
		
 </div>
</div>
         <div id="post" class="postindex">
			 <div class="wrapper-inner">
				 <div class="mainsharing white_box box_info">
				 	<div class="socialstuff">
				 		<p>Like, follow and subscribe to get the latest great stuff.</p>
		
				 		<div class="fbstuff">
				 <iframe class="fbthing translucent-modal" src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Ffacebook.com%2Ffilmbundle&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21&amp;appId=194791007338880" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></div>
				 <div class="chimpform">
				 	<?php mailchimpSF_signup_form(); ?>
				 </div>
				 	<div class="twitterbutton">
				 	<a href="https://twitter.com/filmbundle" class="twitter-follow-button translucent-modal" data-show-count="false" data-size="large" data-show-screen-name="false">Follow @filmbundle</a>
				 	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
				 	</div>
				 	</div>
				 </div>
				 <!-- <?php

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

				 ?> -->
				 
           <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			   <div class="post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				   <div class="post-image">
					 <a href="<?php the_permalink(); ?>">   <?php the_post_thumbnail('full'); ?></a>
				   </div>
			     <div class="post-title">

			      <a href="<?php the_permalink(); ?>"> <h2><?php the_title(); ?></h2> </a>

			     </div><!-- .post-title -->

			     <div class="post-content">

			         <?php the_excerpt();?>
				<span>	written by <?php the_author()?> <?php the_tags('- re: ',' > '); ?></span>

			     </div><!-- .post-content -->
				
			   </div><!-- /.post -->
   

            <?php endwhile; else: ?>

           <p>Sorry, no posts matched your criteria.</p>

           <?php endif; ?>

            <div class="navigation"></div><!-- AJAX navigation -->
  	  </div>
            
          </div><!-- #post -->
<?php get_footer(); ?>