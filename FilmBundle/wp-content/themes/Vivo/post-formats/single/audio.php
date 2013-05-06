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
			
<?php
//Get all metabox data (project link/images/video)
$post_meta_data = get_post_custom($post->ID);
//Get embed audio value
$audiomp3 = $post_meta_data['mb_audiomp3'][0];
$audiooga = $post_meta_data['mb_audiooga'][0];
?>

<script type="text/javascript">
jQuery(document).ready(function(){
  jQuery("#jquery_jplayer_<?php the_ID(); ?>").jPlayer({
	ready: function () {
	  jQuery(this).jPlayer("setMedia", {
		mp3: "<?php echo $audiomp3; ?>",
		oga: "<?php echo $audiooga; ?>"
	  });
	},
	swfPath: "<?php echo get_template_directory_uri(); ?>/js",
	cssSelectorAncestor: "#jp_interface_<?php the_ID(); ?>",
	supplied: "mp3, oga"
  });
});
</script>

<!--Begin Audio-->
<div id="jquery_jplayer_<?php the_ID(); ?>" class="jp-jplayer"></div>
		<div class="jp-audio-container">
			<div class="jp-audio">
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
	<!--End audio-->
	
	<?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) { /* if the post has a WP 2.9+ Thumbnail */ ?>
		<div class="blog_banner"><?php the_post_thumbnail('blog_single'); ?></div>
	<?php } ?>

<div class="two_third">
	<?php the_content('Read More...'); ?>