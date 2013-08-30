<?php
/*
Template Name: Videoplayer Template
*/

get_header(); 
global $full_mb;
$videometa = $full_mb->the_meta(); 
?>
<div style="background-image:url('<?php echo $videometa['backgroundimage']?>')" id="filmbackground">
	<div class="bg-trans">
	<video id="thevideo" class="video-js vjs-default-skin"
	  controls preload="auto" autoplay width="640" height="264"
	  poster="http://video-js.zencoder.com/oceans-clip.png"
	  data-setup='{}'>
      <source src="http://player.vimeo.com/external/72915570.hd.mp4?s=0be98efecfe889d1c2c167bc74af8f1c" type='video/mp4' data-res="HD" data-default="true">
      <source src="http://player.vimeo.com/external/72915570.hd.mp4?s=0be98efecfe889d1c2c167bc74af8f1c" type='video/mp4' data-res="SD">
	  
	
	 
	</video>
	</div>
</div>
<div class="undervidstripe">
hello
</div>
<?php get_footer(); ?>