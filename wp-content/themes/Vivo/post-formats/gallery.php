<div <?php post_class('post_item'); ?>>

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
	
	<!-- Begin Gallery -->
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
				<?php $src = wp_get_attachment_image_src( $attachment->ID, 'gallery_index'); ?>
				<li>
					<img alt="<?php echo apply_filters('the_title', $attachment->post_title); ?>" src="<?php echo $src[0]; ?>">
				</li>
		<?php endforeach; ?>
		</ul>
	</div>
	<!-- End Gallery -->
	<?php //Removing images from the post
	   ob_start();
	   the_content('');
	   $postOutput = preg_replace('/<img[^>]+./','', ob_get_contents());
	   ob_end_clean();
	?>

	<div class="post-meta clearfix">
		<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
		<?php echo $postOutput; ?>
	</div><!--end .post-meta-->	

	<div class="post-footer clearfix">
		<span class="post-date"><?php the_time(); ?></span>
		<?php echo getPostLikeLink(get_the_ID());?>
		<span class="post-comments"><?php comments_number('0','1','%'); ?></span>
	</div><!-- end .post-footer -->	
	
</div>