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
			
<!--Begin Video-->
<?php
	//Get all metabox data (project link/images/video)
	$post_meta_data = get_post_custom($post->ID);
	//Get embed video value
	$video_m4v = $post_meta_data['mb_videom4v'][0];
	$video_ogv = $post_meta_data['mb_videoogv'][0];
	$video_poster = $post_meta_data['mb_vidposter'][0];
	$poster_src = wp_get_attachment_image_src($video_poster, 'full');
	$video = $post_meta_data['mb_video'][0];
	if($video == '') { //if blank must be an m4v or ogv video
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
	  jQuery("#jquery_jplayer_<?php the_ID(); ?>").jPlayer({
		ready: function () {
		  jQuery(this).jPlayer("setMedia", {
			m4v: "<?php echo $video_m4v; ?>",
			ogv: "<?php echo $video_ogv; ?>",
			poster: "<?php echo $poster_src[0]; ?>"
		  });
		},
		swfPath: "<?php echo get_template_directory_uri(); ?>/js",
		cssSelectorAncestor: "#jp_interface_<?php the_ID(); ?>",
		supplied: "m4v, ogv"
	  });
	});
</script>
<div id="jquery_jplayer_<?php the_ID(); ?>" class="jp-jplayer jp-jplayer-video"></div>
	<div class="jp-video-container">
		<div class="jp-video">
			<div class="jp-type-single">
				<div id="jp_interface_<?php the_ID(); ?>" class="jp-interface">
					<ul class="jp-controls">
						<li><a href="#" class="jp-play" tabindex="1">play</a></li>
						<li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
						<li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
						<li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
					</ul>
					<div class="jp-progress-container">
						<div class="jp-progress">
							<div class="jp-seek-bar">
								<div class="jp-play-bar"></div>
							</div>
						</div>
					</div>
					<div class="jp-volume-bar-container">
						<div class="jp-volume-bar">
							<div class="jp-volume-bar-value"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php //else the user must have used embed code, so show that instead
	} else { ?>
		<div class="video_container">
			<?php echo stripslashes(htmlspecialchars_decode($video)); ?>
		</div>
	<?php } ?>
<!--End video-->

<div class="two_third">
	<?php the_content('Read More...'); ?>