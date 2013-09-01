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
		<div class="video-holder">
	<video id="thevideo" class="video-js vjs-default-skin"
	  controls preload="auto"
	  poster="http://video-js.zencoder.com/oceans-clip.png"
	  data-setup='{}'>
      <source src="http://player.vimeo.com/external/72915570.hd.mp4?s=0be98efecfe889d1c2c167bc74af8f1c" type='video/mp4' data-res="HD" data-default="true">
      <source src="http://player.vimeo.com/external/72915570.hd.mp4?s=0be98efecfe889d1c2c167bc74af8f1c" type='video/mp4' data-res="SD">
	  
	
	 
	</video>
</div>
	</div>
</div>
<div class="undervidstripe">
hello
</div>

<script type="text/javascript">
  // Once the video is ready
  _V_("thevideo").ready(function(){

    var myPlayer = this;    // Store the video object
    var aspectRatio = 264/640; // Make up an aspect ratio

    function resizeVideoJS(){
      // Get the parent element's actual width
      var width = document.getElementById('thevideo').parentElement.offsetWidth;
      // Set width to fill parent element, Set height
      myPlayer.width(width).height( width * aspectRatio );
    }

    resizeVideoJS(); // Initialize the function
    window.onresize = resizeVideoJS; // Call the function on resize
  });
</script>
<?php get_footer(); ?>