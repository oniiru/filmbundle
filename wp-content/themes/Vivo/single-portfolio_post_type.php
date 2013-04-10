<?php get_header(); ?>
</div><!-- end #main_sidebar -->

<div id="content" class="fixed_page clearfix">
	<div id="portfolio_single">
		<div id="title_container" class="clearfix">
			<?php if(have_posts()) : while (have_posts()) : the_post(); ?>

			<?php
			//Get the next and previous post objects
			$next  = get_adjacent_post('','',false);
			$previous = get_adjacent_post('','',true);
			$back = get_option('of_portfolio_link');
			//Get the permalinks from the objects
			$prevLink = $previous->guid;
			$prevTitle = $previous->post_title;
			$nextLink = $next->guid;
			$nextTitle = $next->post_title;
			//print_r($next);
			//If next/prev objects exist, show them...
			if($next) { ?>
				<a id="nextPortItem" href="<?php echo $nextLink; ?>">&rarr;</a>
			<?php }
			if($previous) { ?>
				<a id="prevPortItem" href="<?php echo $prevLink; ?>">&larr;</a>
			<?php }
			if($back) { ?>
				<a id="backToPort" href="<?php echo $back; ?>">Back to Portfolio</a>
			<?php } ?>

			<h1 class="page_title"><?php the_title(); ?></h1>
		</div><!-- end #title_container -->

		<!-- Retrieve all the meta box values -->
		<?php
		//Get all metabox data (project link/images/video)
		$post_meta_data = get_post_custom($post->ID);

		//Get embed video value
		$video = $post_meta_data['mb_video'][0];

		//Get image values
		$image1 = $post_meta_data['mb_image_port1'][0];
		$image2 = $post_meta_data['mb_image_port2'][0];
		$image3 = $post_meta_data['mb_image_port3'][0];
		$image4 = $post_meta_data['mb_image_port4'][0];
		$image5 = $post_meta_data['mb_image_port5'][0];
		?>

			<?php
			//If there is a video supplied, display it (overriding the images slideshow)
			if($video != "") { ?>
			<div class="video_container">
				<?php echo stripslashes(htmlspecialchars_decode($video)); ?>
			</div>
			<?php }
			else if ($image1 || $image2 || $image3 || $image4 || $image5) { //otherwise display images (if there's no video)
			?>
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

			<div id="flexid_<?php the_ID(); ?>" class="flexslider">
				<ul class="slides">
					<?php			
					//Echo out the images if they exist
					if($image1 != "") { ?><li><?php echo wp_get_attachment_image($image1, 'portfolio_single'); ?></li><?php }
					if($image2 != "") { ?><li><?php echo wp_get_attachment_image($image2, 'portfolio_single'); ?></li><?php }
					if($image3 != "") { ?><li><?php echo wp_get_attachment_image($image3, 'portfolio_single'); ?></li><?php }
					if($image4 != "") { ?><li><?php echo wp_get_attachment_image($image4, 'portfolio_single'); ?></li><?php }
					if($image5 != "") { ?><li><?php echo wp_get_attachment_image($image5, 'portfolio_single'); ?></li><?php }
					?>
				</ul>
			</div><!-- end .flexslider -->
			<?php } //end else ?>

			<div>
				<?php the_content('Read More...'); ?>
			</div><!-- end .two_thirds last -->

			<div>
				<?php
				$taxo_text = "";

				// Variables to store each of our possible taxonomy lists
				// This one checks for an project-type classification
				$tax_list = get_the_term_list( $post->ID, 'project-type', '<li>', '</li><li>', '</li>' );
						
				// Add project-type list if this post was so tagged
				if ( '' != $tax_list ) {
					$taxo_text .= "$tax_list<br />\n";
				}
					
				// Output taxonomy information if there was any
				// NOTE: We won't even open a div or display the What We Did title if there's nothing to put inside it.
				if ( '' != $taxo_text ) {	?>
					<ul class="portfolio_tags clearfix">
						<?php echo strip_tags($taxo_text, '<li></li>'); ?>
					</ul>
				<?php } ?>

				<!--Project Link-->
				<!-- <?php
					$project_link = get_post_meta($post->ID, 'mb_text', true); 
					if($project_link != ""){  
				?>  
					<p><a href="<?php echo $project_link; ?>"><?php echo get_option('of_port_proj_link') ?></a></p>  
				<?php }else{ ?>  
					<p><em><?php echo get_option('of_port_proj_nolink') ?></em></p>  
				<?php } ?> -->
				<!--End Project Link-->
			</div><!-- end .one_fourth -->

		<?php endwhile; else: ?>
			<div class="post">
				<h2>Nothing Found</h2>
				<p>Sorry, but you are looking for something that isn't here.</p>
				<p><a href="<?php echo home_url(); ?>">Return to the homepage</a></p>
				<div><?php get_search_form(); ?></div>
			</div>
		<?php endif; ?>
	</div><!-- end #portfolio_single -->
</div><!-- end #content -->
</div><!-- end #wrapper -->

<?php get_footer(); ?>