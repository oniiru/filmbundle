<div <?php post_class('post_item'); ?>>

	<?php
	//Get all metabox data (project link/images/video)
	$post_meta_data = get_post_custom($post->ID);
	//Get embed video value
	$quote_by = $post_meta_data['mb_quote'][0];
	?>

	<div class="post-meta clearfix">
		<div class="post-quote"><?php the_content(''); ?></div>
		<h5 class="quote-by">- <?php echo $quote_by; ?></h5>
	</div><!--end .post-meta-->	
	
	<div class="post-footer clearfix">
		<span class="post-date"><?php the_time(); ?></span>
		<?php echo getPostLikeLink(get_the_ID());?>
		<span class="post-comments"><?php comments_number('0','1','%'); ?></span>
	</div><!-- end .post-footer -->	
				
</div>