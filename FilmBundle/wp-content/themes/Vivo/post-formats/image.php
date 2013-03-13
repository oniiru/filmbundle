<div <?php post_class('post_item'); ?>>

	<?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) { /* if the post has a WP 2.9+ Thumbnail */
		//Get the Thumbnail URL
		$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); ?>
		<a href="<?php echo $src[0]; ?>" rel="prettyPhoto" title="<?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?>">
			<?php the_post_thumbnail('blog_index'); ?>
		</a>
	<?php } ?>

	<div class="post-footer clearfix">
		<span class="post-date"><?php the_time(); ?></span>
		<?php echo getPostLikeLink(get_the_ID());?>
		<span class="post-comments"><?php comments_number('0','1','%'); ?></span>
	</div><!-- end .post-footer -->
	
</div>