<?php
/**
 * The template for displaying all pages.
 *
 * Template Name: Default Page
 * Description: Page template with a content container and right sidebar
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header(); ?>
	
<?php while ( have_posts() ) : the_post(); ?>
<div class="bodypage">
		<div class="innerpage">
			<div class="titleboxpage">
				<h1><?php the_title();?></h1>
				
			</div>       
		
		<div class="content1page">
			
			   <?php the_content();?>
<?php endwhile; // end of the loop. ?>
        
		</div>
		<div class="content2page">
			<div class="pagefooterleft">
				<ul>
					<li><a href="/about">About</a></li>
					<li><a href="/support">Support</a></li>
					<li><a href="/contact">Contact</a></li>
				</ul>
			</div>
			<div class="pagefootermiddle">
				<ul>
					<li><a href="/blog">Blog</a></li>
					<li><a href="/terms">Terms and Conditions</a></li>
					<li><a href="/privacy">Privacy Policy</a></li>
				</ul>
			</div>
				<div class="pagefootermiddle">
				<ul>
					<li><a href="/suggest">Suggest a Film</a></li>
					<li><a href="/submit">Submit a Film</a></li>
				</ul>
			</div>
			<div class="pagefooterright">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Twitter.png">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Facebook.png">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/img/YouTube.png">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Vimeo.png">

			</div>
		</div>
 
        </div>

         


<?php get_footer(); ?>