<?php get_header(); ?>
<?php get_search_form(); ?>
</div><!-- end #main_sidebar -->

<div id="content" class="fixed_page clearfix">
	<?php if(have_posts()) : while (have_posts()) : the_post(); ?>
						
		<?php 
			// The following determines what the post format is and shows the correct file accordingly
			$format = get_post_format();
			get_template_part( 'post-formats/single/'.$format );
			
			if($format == '')
			get_template_part( 'post-formats/single/standard' );
		?>
		
		<?php edit_post_link('Edit this post...', '<p>', '</p>'); ?>
		
		<?php if (get_option('of_auth_info_off') == "false") { ?>
			<!-- Author info box -->
			<div id="author-info">
				<div id="author-info-content">
					<div id="author-image">
						<a href="<?php the_author_meta('user_url'); ?>"><?php echo get_avatar( get_the_author_meta('user_email'), '60', '' ); ?></a>
					</div>   
					<div id="author-bio">
						<h4>Written by <?php the_author_link(); ?></h4>
						<p><?php the_author_meta('description'); ?></p>
					</div>
				</div>
			</div><!--Author Info-->
		<?php } ?>

<!-- Closing off divs from the post-format files -->
</div><!--end .one_third -->
<div class="one_third last">
	<div class="post-meta clearfix">
		<p class="post-author">Written by <?php the_author_posts_link(); ?></p>
		<span class="post-date"><?php the_time(); ?></span>
		<?php echo getPostLikeLink(get_the_ID());?>
		<span class="post-comments"><?php comments_number('0','1','%'); ?></span>
	</div>
</div>
</div><!-- end .post_class, post_full -->
					
		<?php comments_template(); ?>
				
		<?php endwhile; else: ?>
			<div class="post">
				<h2>Nothing Found</h2>
				<p>Sorry, but you are looking for something that isn't here.</p>
				<p><a href="<?php echo home_url(); ?>">Return to the homepage</a></p>
				<div><?php get_search_form(); ?></div>
			</div>
		<?php endif; ?>

</div><!--end #content-->
</div><!--end #wrapper-->
<?php get_footer(); ?>