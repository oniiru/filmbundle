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
	<h1 class="page_title"><?php the_title(); ?></h1>
</div><!-- end #title_container -->

<div <?php post_class('post_full clearfix'); ?>">

<!--Begin Slider-->		
<script>
	jQuery(window).load(function(){
		jQuery('#flexid_<?php the_ID(); ?>').flexslider({
            animation: 'fade',
            controlNav: false,
			directionNav: true,
			prevText: "&larr;",
			nextText: "&rarr;", 
            slideshow: false,
            slideshowSpeed: 4000,
            animationSpeed: 300,
            controlsContainer: '.slider-container',
            smoothHeight: true,
            before: function(slider) {
                slideHeight = $(slider.slides[slider.animatingTo]).outerHeight();
                slider.css({
                    height: slideHeight
                });
            }
		});
	});
</script>
<!--Begin Gallery-->
<div id="flexid_<?php the_ID(); ?>" class="flexslider">
	<?php 
		$args = array(
			'orderby'		 => 'menu_order',
			'post_type'      => 'attachment',
			'post_parent'    => get_the_ID(),
			'post_mime_type' => 'image',
			'post_status'    => null,
			'numberposts'    => -1,
		);
		$attachments = get_posts($args);
	?>
	<ul class="slides">
	<?php foreach ($attachments as $attachment) : ?>
			<?php $src = wp_get_attachment_image_src( $attachment->ID, 'blog_single'); ?>
			<li>
				<img alt="<?php echo apply_filters('the_title', $attachment->post_title); ?>" src="<?php echo $src[0]; ?>">
			</li>
	<?php endforeach; ?>
	</ul>
</div>
<!--End Gallery-->

<div class="two_third">
	<?php
	   ob_start();
	   the_content('');
	   $postOutput = preg_replace('/<img[^>]+./','', ob_get_contents());
	   ob_end_clean();
	   echo $postOutput;
	?>