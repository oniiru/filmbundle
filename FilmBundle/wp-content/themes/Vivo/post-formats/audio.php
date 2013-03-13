<div <?php post_class('post_item'); ?>>

	<?php
	//Get all metabox data (project link/images/video)
	$post_meta_data = get_post_custom($post->ID);
	//Get embed video value
	$audiomp3 = $post_meta_data['mb_audiomp3'][0];
	$audiooga = $post_meta_data['mb_audiooga'][0];
	?>

	<!--Begin Audio player-->
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
	<!-- End Audio player-->

	<div class="post-meta clearfix">
		<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
	</div><!--end .post-meta-->	

	<div class="post-footer clearfix">
		<span class="post-date"><?php the_time(); ?></span>
		<?php echo getPostLikeLink(get_the_ID());?>
		<span class="post-comments"><?php comments_number('0','1','%'); ?></span>
	</div><!-- end .post-footer -->

</div>