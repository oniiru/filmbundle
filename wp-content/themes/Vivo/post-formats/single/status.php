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
	<?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) { /* if the post has a WP 2.9+ Thumbnail */ ?>
		<div class="blog_banner"><?php the_post_thumbnail('blog_single'); ?></div>
	<?php } ?>
	<div class="two_third">
		<div class="status"><?php the_content(''); ?></div>