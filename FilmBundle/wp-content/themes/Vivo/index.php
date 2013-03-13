<?php get_header(); ?>
<?php get_search_form(); ?>
<?php number_pagination(); ?>
</div><!-- end #main_sidebar -->

	<div id="content" class="clearfix">
		<div id="loader"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/misc/loader.gif"></div>
		<div id="posts_container">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
				<?php 
	                // The following determines what the post format is and shows the correct file accordingly
	                $format = get_post_format();
	                get_template_part( 'post-formats/'.$format );
	                
	                if($format == '')
	                get_template_part( 'post-formats/standard' );
	            ?>
				
				<?php endwhile; ?>
				
				<?php else : ?>
				<div class="post">
					<h2>Nothing Found</h2>
					<p>Sorry, but you are looking for something that isn't here.</p>
					<p><a href="<?php echo home_url(); ?>">Return to the homepage</a></p>
				</div>
			<?php endif; ?>
		</div><!-- end #posts_container -->

	</div><!-- end #content -->
</div><!-- end #container -->
<?php get_footer(); ?>