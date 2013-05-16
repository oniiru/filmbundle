<?php 
	global $pl_data, $theme_url;
	if (have_posts()) :?>
	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h3 class="heading_title white_box"><?php single_cat_title(); ?></h3>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h3 class="heading_title white_box"><?php _e('Posts Tagged','presslayer');?>: <?php single_tag_title(); ?></h3>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h3 class="heading_title white_box"><?php _e('Archive for','presslayer');?> <?php the_time('F jS, Y'); ?></h3>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h3 class="heading_title white_box"><?php _e('Archive for','presslayer');?> <?php the_time('F, Y'); ?></h3>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h3 class="heading_title white_box"><?php _e('Archive for','presslayer');?> <?php the_time('Y'); ?></h3>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h3 class="heading_title white_box"><?php _e('Blog Archives','presslayer');?></h3>
 	  <?php } elseif (is_search()){ ?>
	  <h3 class="heading_title white_box"><?php _e('Search Results','presslayer');?></h3>
	  <?php } ?>
	  
<div id="post_grids" class="post_content clearfix">
	
	<?php while (have_posts()) : the_post();
	$audio = get_post_meta($post->ID, 'pl_audio', true) ;
	$audio_embed = get_post_meta($post->ID, 'pl_audio_embed', true) ;
	$video_embed = get_post_meta($post->ID, 'pl_video_embed', true) ;
	?>

	<div class="post_col">
	<?php if(get_post_format()!='quote'){?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('post_item white_box'); ?>>
		<?php
		if($video_embed!=''){
		?>
			<div class="fit post_video_wrapper"><?php echo $video_embed;?></div>
		<?php 
		} else {  ?>	
			
			<?php 
			$title_top_class = ' post_top_element';
			if ( has_post_thumbnail()){
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'fulls-size');
			$new_image = aq_resize( $image[0], 710, NULL, FALSE, FALSE );
			$title_top_class = '';
			?>
			<div class="large_thumb thumb_hover">
					<div class="icon_bar for_link">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="icon link"></a> 
					</div>
					<div class="icon_bar for_view">
						<a href="<?php echo $image[0];?>" class="icon view fancybox"></a> 
					</div>
					
					<div class="img_wrapper"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><img src="<?php echo $new_image[0];?>" width="<?php echo $new_image[1];?>" height="<?php echo $new_image[2];?>" alt="<?php the_title_attribute();?>" class="post_top_element thumb" /></a></div>
			</div>
			
			<?php } ?>
			
			<?php get_template_part( 'content', 'audio'); ?>
			
		<?php } // if(video_embed) ;?>	
			
			<h3 class="post_item_title<?php echo $title_top_class;?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			
			<div class="post_item_inner">
				<div class="post_meta">
					<span class="user"><?php _e('by','presslayer');?> <?php the_author_posts_link(); ?></span> 
					<span class="time"><?php the_time(get_option('date_format')) ?></span>
				</div>	
				<p><?php 
				$ex_length = $pl_data['ex_length'];
				if($ex_length=='') $ex_length = 35;
				echo text_trim(get_the_excerpt(), $ex_length, '...');?></p>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="button green"><?php _e('Read More','presslayer');?></a>
				
				<span class="like"><?php printLikes(get_the_ID()); ?></span>
			
			</div>
		</div>
		<?php } else {
			get_template_part( 'content', get_post_format());
		}?>
	</div><!-- // post col -->
	<?php endwhile; ?>
	
</div>

<script>
	$( function(){
		
		var gutWidth = set_gutWidth();
		$(window).resize(function(){
			var gutWidth = set_gutWidth();
			$container.masonry( 'reloadItems' );
		});
		
		
		function set_gutWidth(){
			if( $(window).width() < 767 ){
				var gutWidth = 10;
			}else if($(window).width() < 959){
				var gutWidth = 20;
			}else {
				var gutWidth = 30;
			}
			
			return gutWidth;
		}
		
		var $container = $('#post_grids');

		$container.imagesLoaded( function(){
		  $container.masonry({
			itemSelector : '.post_col',
			gutterWidth: gutWidth,
			columnWidth: function(containerWidth) {
				var box_width = $( '#post_grids' ).children('.post_col').width();
				return box_width;
			}
		  });
		});
		
	
	$container.infinitescroll({
	  navSelector  : '#page-nav',    // selector for the paged navigation 
	  nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
	  itemSelector : '.post_col',     // selector for all items you'll retrieve
	  loading: {
		  msgText  : '<?php _e('Loading new posts','presslayer');?> ...',   
		  finishedMsg: '<?php _e('No more pages to load','presslayer');?>.',
		  img: 'http://i.imgur.com/6RMhx.gif'
		}
	  },
	  // trigger Masonry as a callback
	  function( newElements ) {
		var $newElems = $( newElements ).css({ opacity: 0 });
		$newElems.imagesLoaded(function(){
		  $newElems.animate({ opacity: 1 });
		  $container.masonry( 'appended', $newElems, true ); 
		  theme_init();
		  thumb_hover('.thumb_hover');
		});
		$('#page-nav').show();
	});
	
	// kill scroll binding
	$(window).unbind('.infscr');
	$("#page-nav a").click(function(){
		$container.infinitescroll('retrieve');
		return false;
	});

	// remove the paginator when we're done.
	$(document).ajaxError(function(e,xhr,opt){
	  if (xhr.status == 404) $('#page-nav a').remove();
	});
	
			
});
</script>

				
<!-- infinite scroll -->
<div class="load_more">	
	<nav id="page-nav">
		<?php next_posts_link(__('Load more posts','presslayer').' ...') ?>
	</nav>
</div>
<!-- end infinite scroll -->

<?php else : ?>
	<?php get_search_form(); ?>
<?php endif; ?>  