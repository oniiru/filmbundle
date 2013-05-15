<?php
/**
 *
 * Description: 404 Page Template.
 *
 */

get_header(); ?>

	<div id="main">
			
		<section id="content">
		
			<div class="container">
			
				<div id="page-not-found" class="sixteen columns">
				
					<i class="icon-warning-sign"></i>
					
					<h2 class="post-title"><?php _e('<span>Woops! It seems a page is missing.</span>', 'nash'); ?></h2>
					<p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Please try using one of the navigation links above.', 'nash'); ?></p>
					<a class="return-home-btn" href="<?php echo home_url(); ?>">&larr; <?php _e('Go to the Homepage', 'nash'); ?></a>
			
				</div><!-- end .sixteen columns -->
		
			</div><!-- end .container -->
		
		</section><!-- end #content -->
	
	</div><!-- end #main -->
		
<?php get_footer(); ?>