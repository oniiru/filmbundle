<div id="title_container" class="clearfix">	
	<?php
	$back = get_option('of_blog_link');
	//Get the next and previous post objects
	$prev_post_id = get_previous_post()->ID;
	$next_post_id = get_next_post()->ID;
	//Get the permalinks from the objects
	$prev = get_permalink($prev_post_id);
	$next = get_permalink($next_post_id);
	?>
	<?php
	if($next_post_id) { ?>
		<a id="nextPortItem" href="<?php echo $next; ?>">&rarr;</a>
	<?php }
	if($prev_post_id) { ?>
		<a id="prevPortItem" href="<?php echo $prev; ?>">&larr;</a>
	<?php }
	if($back) { ?>
		<a id="backToPort" href="<?php echo $back; ?>">Back to the Blog</a>
	<?php } ?>
</div><!-- end #title_container -->

<div <?php post_class('post_full clearfix'); ?>">

	<?php
	//Get all metabox data (project link/images/video)
	$post_meta_data = get_post_custom($post->ID);
	//Get embed video value
	$quote_by = $post_meta_data['mb_quote'][0];
	?>

	
	<div class="two_third">
		<div class="post-quote"><?php the_content(''); ?></div>
		<h5 class="quote-by">- <?php echo $quote_by; ?></h5>