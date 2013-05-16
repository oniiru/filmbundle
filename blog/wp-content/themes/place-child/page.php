<?php get_header();?>
<div id="leftContent">
	<div class="inner">
		<div class="post_item post_single white_box">
			<?php if (have_posts()) : while (have_posts()) : the_post(); 
			$title_top_class = ' post_top_element';
			$video_embed = get_post_meta($post->ID, 'pl_video_embed', true) ;
			if($video_embed!=''){
			$title_top_class = '';
			?>
				<div class="fit post_video_wrapper"><?php echo $video_embed;?></div>
			<?php 
			} else { 
				$title_top_class = ' post_top_element';
				if ( has_post_thumbnail()){
				$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'fulls-size');
				$new_image = aq_resize( $image[0], 800, NULL, FALSE, FALSE );
				$title_top_class = '';
				?>
				<div class="large_thumb">
						
						<div class="img_wrapper"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><img src="<?php echo $new_image[0];?>" width="<?php echo $new_image[1];?>" height="<?php echo $new_image[2];?>" alt="<?php the_title_attribute();?>" class="post_top_element thumb" /></a></div>
				</div>
				
				<?php } ?>
				
				<?php get_template_part( 'content', 'audio'); ?>
				
			<?php } // if(video_embed) ;?>	
			<div class="social_share <?php echo $title_top_class ;?>">
			<?php social_share();?>
			</div>
			
			<div class="post_single_inner">
			<h1><?php the_title(); ?></h1>
			
			
			<div class="post_entry">
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
			<?php edit_post_link('Edit this entry','<p>','</p>'); ?>
			</div>
			<div class="clear"></div>
			</div>	
		<?php endwhile; endif; ?>
		</div><!-- post item -->
		
		<?php comments_template(); ?>
	</div>
</div>
<?php get_sidebar('custom');?>
<?php get_footer();?>