<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
</div><!-- end #main_sidebar -->

<div id="content" class="fixed_page archives clearfix">
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
		<?php if (get_option('of_titles_off') == "false") { ?>
			<h1 class="page_title"><?php the_title(); ?></h1>
			<div class="divider"></div>
		<?php } ?>
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p><strong>'. 'Pages:' .'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php edit_post_link('Edit this page...', '<strong>', '</strong>'); ?>
	<?php endwhile; endif; ?>

	<div class="one_third">
		<h2>Last 10 Posts</h2>
		<ul>
			<?php $recentBlog = new WP_Query();
			$recentBlog -> query('ignore_sticky_posts=1&showposts=10');
			if($recentBlog->have_posts()) : while($recentBlog->have_posts()) : $recentBlog->the_post(); ?>
			<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endwhile; ?>
				<?php else : ?>
				<h3>Uh-Oh!</h3>
				<p>There are no posts in this blog yet!<p>
			<?php endif; ?>
		</ul>
	</div>

	<div class="one_third">
		<h2>Posts by Month</h2>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</div>

	<div class="one_third last">
		<h2>Posts by Category</h2>
		<ul>
			<?php wp_list_categories( 'title_li=' ); ?>
		</ul>
	</div>

</div><!-- end #content -->		
</div><!-- end #wrapper -->
<?php get_footer(); ?>