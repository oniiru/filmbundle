<?php get_header(); ?>
<div class="clearthing"></div>
<img class="homelogo littlelogo" src="<?php echo get_template_directory_uri(); ?>/img/whitehmmm.png">

<div class="leftthing">
 <div class="inner-leftthing">
	 <h1>FilmBundle Blog </h1>
	 <h2> Ramblings about the state of film and home of FilmBundle.TV </h2>
	 <a class="indexbutton1" href="http://filmbundle.tv"> Watch FilmBundle.TV </a>
	 <a class="indexbutton2" href="http://filmbundle.tv"> Back to FilmBundle </a>
		
 </div>
</div>
         <div id="post" class="postindex">
			 <div class="wrapper-inner">
				 
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
                 <div id="search-term">
                   <?php printf( __( '%d %s' ), $wp_query->found_posts, _n( 'search result', 'search results', $wp_query->found_posts), get_search_query() ); ?> for <?php echo ' &quot;'.wp_specialchars($s).'&quot;'; ?>
                 </div><!-- #search-term -->    
    
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








