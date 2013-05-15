<?php get_header(); ?>
</div><!-- end #main_sidebar -->

<div id="content" class="fixed_page clearfix">
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
		<?php if (get_option('of_titles_off') == "false") { ?>
			<h1 class="page_title"><?php the_title(); ?></h1>
			<div class="divider"></div>
		<?php } ?>
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p><strong>'. 'Pages:' .'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php edit_post_link('Edit this page...', '<strong>', '</strong>'); ?>
	<?php endwhile; else : ?>
		<div class="post">
			<h2>Nothing Found</h2>
			<p>Sorry, but you are looking for something that isn't here.</p>
			<p><a href="<?php echo home_url(); ?>">Return to the homepage</a></p>
			<div><?php get_search_form(); ?></div>
		</div>
	<?php endif; ?>
</div><!-- end #content -->		
</div><!-- end #wrapper -->
<?php get_footer(); ?>