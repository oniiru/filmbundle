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


		
	 
	


 <?php 
 $extrasmeta = $extras_mb->the_meta(); 
 
 if($extrasmeta['extra-feature'] != '') { ?>
	 <div class="undervidstripe">
		 <h2>Special Features </h2>
	 </div>
	 <div class="theextras">

	 <div class = 'iosSlider'>

	 	<div class = 'slider'>
	
 
	 <?php
 foreach ($extrasmeta['extra-feature'] as $extrasindiv)
 { 
	 $extraembed = $extrasindiv['extra_embed']; 
	 $extratitle = $extrasindiv['extra_title']; 
	 $extrabg = $extrasindiv['backgroundimage']; 
	 $extraruntime = $extrasindiv['run_time']; 
	 ?>
	
	<div class = 'item'>
		 <a class="extrapopup" href="<?php echo $extraembed ; ?>">
	 <div style="<?php if($extrabg == '') { echo 'background-image:green'; } else {echo 'background-image:url('.$extrabg.')';}; ?>" class="anextra">
		 <div class="iteminfo">
			 <p><?php echo $extratitle ;?> <span><?php echo $extraruntime ;?> </span></p>
		 </div>
	 </div>
 </a>
 </div>
	 <?php
 }?> 
	</div>
	
</div><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/nav-arrow-right.png" class="next">

<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/nav-arrow-left.png" class="prev unselectable">
</div>

 	<?php
}
 ?>
 <div class="undervidstripe">
  <h2>What do you think? </h2>
 </div>
 <div class="thecomments">
 <?php echo do_shortcode('[fbcomments count="off" width="900px"]'); ?>
 </div>
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
  
	jQuery(document).ready(function() {
		
		jQuery('.iosSlider').iosSlider({
			snapToChildren: true,
			desktopClickDrag: true,
			keyboardControls: false,
			onSliderLoaded: slideComplete,
			onSlideComplete: slideComplete,
			navNextSelector: jQuery('.next'),
		    navPrevSelector: jQuery('.prev'),
		});
		
	});
	
	
	
	function slideComplete(args) {
		
		jQuery('.next, .prev').removeClass('unselectable');

	    if(args.currentSlideNumber == 1) {
	
	        jQuery('.prev').addClass('unselectable');
	
	    } else if(args.currentSliderOffset == args.data.sliderMax) {
	
	        jQuery('.next').addClass('unselectable');	
	    }
	if(jQuery('.anextra').length < 5) {
			 jQuery('.next, .prev').addClass('unselectable');	
			}
	}
         jQuery(document).ready(function() {
           jQuery('.extrapopup').magnificPopup({
             disableOn: 700,
             type: 'iframe',
             mainClass: 'mfp-fade',
             removalDelay: 160,
             preloader: false,

             fixedContentPos: false
           });
         });
</script>
<?php get_footer(); ?>