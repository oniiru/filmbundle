<?php
global $theme_url;
$args = array(
	'post_type' => 'slider',
	'paged' => $paged,
	'orderby'=>'menu_order',
	'order'=>'ASC'
);

$slider = new WP_Query($args);
?>

<div class="slider white_box">
	<div class="flexslider">
		<ul class="slides">
			<?php 
			$str = '';
			$i = 0;	
			while($slider->have_posts()): $slider->the_post();
			$i++;
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full-size');
			$new_image = aq_resize( $image[0], 800, 400, FALSE, FALSE );
			$link = get_post_meta($post->ID, 'pl_link', true) ;
			
			$str .= '<div class="caption" id="cp_'.$i.'"><h3 class="title" ><a href="'.$link.'">'. get_the_title() .'</a></h3>
	<div class="slider_content_inner">'. get_the_content() .'</div></div>';
			
			?>
			<li>
				<div><a href="<?php echo $link;?>"><img src="<?php echo $new_image[0];?>" width="<?php echo $new_image[1];?>" height="<?php echo $new_image[2];?>" alt="<?php the_title_attribute();?>" /></a></div>
				
			</li>
			<?php endwhile;	wp_reset_query(); ?>	
		</ul>
	</div>
	
	<?php echo $str;?>
	
	
	<script type="text/javascript">
	$(window).load(function(){
	  
	  $('.flexslider').flexslider({
		animation: "fade",
		start: function(slider){
		  $('#cp_1').fadeIn();
		},
		after: function(slider) {
		  $('.caption').hide();
		  $('#cp_' + (slider.currentSlide+1)).fadeIn();
		  
		}
	  });
	});
  </script>
	
</div>