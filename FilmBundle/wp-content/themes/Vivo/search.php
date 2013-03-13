<?php get_header(); ?>
<?php get_search_form(); ?>
</div><!-- end #main_sidebar -->

<div id="content" class="fixed_page clearfix">
	<h1 class="page_title"><?php echo "Search results for '$s'" ?></h1>
	<div class="divider"></div>
			
		<?php if ( $post->post_type == 'post' ) : ?>
			<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
				<div class="post-archive">
					<a class="post-title" href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a>
					<p class="post-time">&raquo;
						<?php the_time( get_option('date_format') ); ?> &middot;
						<?php the_author_posts_link(); ?> &middot;
						<?php the_category(', '); ?> &raquo;
						<?php comments_number('no responses','one response','% responses'); ?></p>
				</div>
			<?php endwhile; endif; ?>
				<?php number_pagination(); ?>
				<!-- Uncomment the following and comment out the function above for traditional pagination -->
				<!--<div class="pagination">
					<p class="newer"><?php previous_posts_link('Newer &raquo;'); ?></p>
					<p class="older"><?php next_posts_link('&laquo; Older'); ?></p>
				</div>-->
		<?php else : ?>
			<div class="post">
				<h3>Nothing Found</h3>
				<p>Sorry, nothing matched your search term.</p>
				<p><a href="<?php echo home_url(); ?>">Return to the homepage</a></p>
			</div>
		<?php endif; ?>

</div><!-- end #content -->	
</div><!-- end #wrapper -->
<?php get_footer(); ?>