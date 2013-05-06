<div <?php post_class('post_item'); ?>>	
	
	<?php
	//Get all metabox data (project link/images/video)
	$post_meta_data = get_post_custom($post->ID);
	//Get embed video value
	$link = $post_meta_data['mb_link'][0];
	?>

	<div class="post-meta clearfix">
		<a href="<?php echo $link; ?>"><h3><?php the_title(); ?> [LINK]</h3></a>
		<p class="the_link"><?php echo $link; ?></p>
		<?php the_content(''); ?>
	</div><!--end .post-meta-->		

	<div class="post-footer clearfix">
		<span class="post-date"><?php the_time(); ?></span>
		<?php echo getPostLikeLink(get_the_ID());?>
		<span class="post-comments"><?php comments_number('0','1','%'); ?></span>
	</div><!-- end .post-footer -->
	
</div>