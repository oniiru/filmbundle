<?php 
$audio = get_post_meta($post->ID, 'pl_audio', true) ;
$audio_embed = get_post_meta($post->ID, 'pl_audio_embed', true) ;
if($audio_embed!=''){ ?>
<div class="fit audio_embed"><?php echo $audio_embed;?></div>
<?php }
if($audio!=''){ ?>
<div class="player_wrapper">
	<audio id="player-<?php echo $post->ID;?>" src="<?php echo $audio;?>" controls="controls" style="width: 100%; height: 100%;"></audio>
</div>
<?php } ?>

