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
				<a class="zocial facebook" href="https://www.facebook.com/sharer/sharer.php?u=filmbundle.com" target="_blank">
				  Share on Facebook
				</a>
				<a href="https://twitter.com/share" class="zocial twitter" data-text="Hi there!" data-via="FilmBundle" data-size="large" 					data-related="filmbundle">Share on Twitter</a>
				<a href="http://www.reddit.com/submit" onclick="window.location = 'http://www.reddit.com/submit?url=' + encodeURIComponent(window.location); return false"> <img style="height:36px" src="http://www.reddit.com/static/spreddit14.gif" alt="submit to reddit" border="0" /> </a>
				
			</div>
			
			<div class="post_single_inner">
			<h1><?php the_title(); ?></h1>
			
			<div class="post_meta">
				<span class="user"><?php _e('by','presslayer');?> <?php the_author_posts_link(); ?></span> 
				<span class="comment"><?php comments_popup_link(__('No Comments','presslayer'), __('1 Comment','presslayer'), __('% Comments','presslayer'),'post_comment'); ?></span>
				<span class="cats"><?php the_category(', ') ?></span>
			</div>
			<div class="post_entry">
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
			
			<?php edit_post_link('Edit this entry','<p>','</p>'); ?>
			</div>
			<div class="post_single_bottom_wrapper">	
				<div class="post_tag"><?php the_tags( 'Tags: ', ' ', ''); ?></div>
				<span class="time"><?php the_time(get_option('date_format')) ?></span>
				<span class="like"><?php printLikes(get_the_ID()); ?></span>
			</div>
			<div class="clear"></div>
			</div>	
		<?php endwhile; endif; ?>
		</div><!-- post item -->
		
		<?php
		if(get_post_meta($post->ID, 'pl_related', true)=='default' or get_post_meta($post->ID, 'pl_related', true)==''){
			$related = $pl_data['enable_related_posts'];
		}else{
			$related = get_post_meta($post->ID, 'pl_related', true);
		}
		if($related!='no') get_template_part( 'inc/related_posts');
		?>

		
		<?php comments_template(); ?>
	</div>
</div>
<?php get_sidebar('custom');?>
<?php get_footer();?>