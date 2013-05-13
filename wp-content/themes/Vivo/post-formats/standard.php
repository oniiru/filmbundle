<div <?php post_class('post_item'); ?>>

	<?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) { /* if the post has a WP 2.9+ Thumbnail */ ?>
		<?php the_post_thumbnail('blog_single'); ?>
	<?php } ?>
	<div class="post-meta clearfix">
		<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
		<?php the_content(''); ?>
	</div><!--end .post-meta-->

	<div class="post-footer clearfix">
		<span class="post-date"><?php the_time(); ?></span>
		<?php echo getPostLikeLink(get_the_ID());?>
		<span class="post-comments"><?php comments_number('0','1','%'); ?></span>
	</div><!-- end .post-footer -->
	
</div>