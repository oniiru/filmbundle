<?php get_header(); ?>
</div><!-- end #main_sidebar -->

<div id="content" class="fixed_page clearfix">
	<?php if (get_option('of_titles_off') == "false") { ?>
		<h1 class="page_title">		
			<?php if ( is_day() ) : ?>
			<?php printf( __( 'Daily Archives: %s', 'elemis' ), get_the_date() ); ?>
			<?php elseif ( is_month() ) : ?>
			<?php printf( __( 'Monthly Archives: %s', 'elemis' ), get_the_date('F Y') ); ?>
			<?php elseif ( is_year() ) : ?>
			<?php printf( __( 'Yearly Archives: %s', 'elemis' ), get_the_date('Y') ); ?>
			<?php else : ?>
			<?php _e( 'Blog Archives', 'elemis' ); ?>
			<?php endif; ?>
		</h1>
		<div class="divider"></div>
	<?php } ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post-archive">
			<a class="post-title" href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a>
			<p class="post-time">&raquo;
				<?php the_time( get_option('date_format') ); ?> &middot;
				<?php the_author_posts_link(); ?> &middot;
				<?php the_category(', '); ?> &raquo;
				<?php comments_number('no responses','one response','% responses'); ?></p>
		</div>
		
		<?php endwhile; ?>
		
		<?php number_pagination(); ?>
		<!-- Uncomment the following and comment out the function above for traditional pagination -->
		<!--<div class="pagination">
			<p class="newer"><?php previous_posts_link('Newer &raquo;'); ?></p>
			<p class="older"><?php next_posts_link('&laquo; Older'); ?></p>
		</div>-->
		
		<?php else : ?>
		<div class="post">
			<h2>Nothing Found</h2>
			<p>Sorry, but you are looking for something that isn't here.</p>
			<p><a href="<?php echo home_url(); ?>">Return to the homepage</a></p>
		</div>
	<?php endif; ?>
</div><!-- end #content -->
</div><!-- end #wrapper -->
<?php get_footer(); ?>