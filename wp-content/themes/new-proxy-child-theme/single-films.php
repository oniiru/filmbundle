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
			<?php global $user_ID; 
			$abovebelow = array (
			"below" => $videometa['belowavg'],
			"above" => $videometa['aboveavg'],
			);
				if(((edd_has_user_purchased( $user_ID, $abovebelow )) && ($videometa['abvaccessonly'] == '')) || ((edd_has_user_purchased( $user_ID, $videometa['aboveavg'] )) && ($videometa['abvaccessonly'] == 'above')))  {
				?>
				<div class="playbutton filmtrigger"><span>&#xf01d;</span></div>
				
	<div style="padding-bottom:<?php echo $videometa['aspect']?>; background-image: url('<?php echo $videometa['fullimage']?>')"id="video_container">	
	</div>
	<?php
	} else {
	 ?>
<div class="playbutton trailertrigger"><span>&#xf01d;</span><h3>Trailer</h3></div>
 <div style="padding-bottom:<?php echo $videometa['aspect']?>; background-image: url('<?php echo $videometa['trailerimage']?>')" id="video_container"></div>
	 
	 
	 <?php }?>
</div>
<h1 class="filmtitl"><?php echo $videometa['title']; ?> </h1>

<div class="filminfo">
	<div class="tabbable tabs-left">
	              <ul class="nav nav-tabs">
	                <li class="active"><a href="#lA" data-toggle="tab">Info</a></li>
	                <li><a href="#lB" data-toggle="tab">FilmMaker</a></li>
	                <li><a href="#lC" data-toggle="tab">Credits</a></li>
	              </ul>
	              <div class="tab-content">
	                <div class="tab-pane active" id="lA">
						<?php echo $videometa['synopsis']; ?>
						<span><?php echo $videometa['runtime'].' Min.  &nbsp;• &nbsp; Genre(s): '.$videometa['genres'].' &nbsp;• &nbsp;Rated: '.$videometa['rating'] ?></spam>
	                </div>
	                <div class="tab-pane" id="lB">
	        			<img src="<?php echo $videometa['filmmakerimg'] ?>">
						<div class="fromfilmmaker"><?php echo $videometa['note'] ?>
							<span class="makername">- <?php echo $videometa['filmmakername']?></span>
						</div>
						<div class="filmmakerconnect">
							<?php if ($videometa['filmmakertwit'] != '') { ?>
							<a href="https://twitter.com/<?php echo $videometa['filmmakertwit'] ?>" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @FilmBundle</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
							<?php }
							if ($videometa['filmmakerface'] != '') {
							?>
<div class="fb-follow" data-href="https://www.facebook.com/<?php echo $videometa['filmmakerface'] ?>" data-width="75" data-layout="button_count" data-show-faces="true"></div>	<?php }?>					
						</div>	
						
						
	                </div>
	                <div class="tab-pane" id="lC">
					   <?php foreach ($videometa['credits'] as $credit)
					    { 
					   	 $creditname = $credit['creditname']; 
					   	 $creditjob = $credit['creditjob']; 
					   	
					   	 ?>
						 <div class="acredit">
							 <p><?php echo $creditname; ?></p>
							 <span><?php echo $creditjob; ?></span>
						 </div>
						 <?php }?>
	                </div>
	              </div>
	            </div> <!-- /tabbable -->
	
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
	 if(edd_has_user_purchased( $user_ID, $videometa['aboveavg'] )) {
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
 } } else {
	 foreach ($extrasmeta['extra-feature'] as $extrasindiv)
	 { 
		 $extraembed = $extrasindiv['extra_embed']; 
		 $extratitle = $extrasindiv['extra_title']; 
		 $extrabg = $extrasindiv['backgroundimage']; 
		 $extraruntime = $extrasindiv['run_time']; 
		 ?>
	
		<div class = 'item'>
   		 <a class="lockpopup" href="#small-dialog">
			
		 <div style="<?php if($extrabg == '') { echo 'background-image:green'; } else {echo 'background-image:url('.$extrabg.')';}; ?>" class="anextra">
			 <div class="lockeditem">
				 <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/lock.png">
			 <div class="iteminfo">
				 <p><?php echo $extratitle ;?> <span><?php echo $extraruntime ;?> </span></p>
			 </div>
		 </div>
		 </div>
	 </a>
	 </div>
	 
	 <div id="small-dialog" class="white-popup mfp-hide">
	        <h3 style="margin-bottom:10px">This content is locked.</h3>
	        <p>These special features are only available to folks who have paid more than average at the time of checkout. If you missed out, our next version of FilmBundle will include the ability to earn special features by sharing with friends. Stay tuned!</p>
	      </div>
 
<?php }; }?> 
	</div>
	
</div><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/nav-arrow-right.png" class="next">

<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/nav-arrow-left.png" class="prev unselectable">
</div>

 	<?php
}
 ?>
 <div class="thecomments">
	 <img class="whatthink" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/lovebundle.png">
	 
 <?php echo do_shortcode('[fbcomments count="off" width="900px"]'); ?>
 </div>
</div>

<script type="text/javascript">
 
  
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
             type: 'iframe',
             mainClass: 'mfp-fade',
             removalDelay: 160,
             preloader: false,
             fixedContentPos: false
           });
		   jQuery('.lockpopup').magnificPopup({
		     type:'inline',
		     midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
		   });
         });
		 jQuery('.filmtrigger').click(function(e) {
			  jQuery(this).remove();
		     e.preventDefault();
		   jQuery('#video_container').html('<iframe src="http://player.vimeo.com/video/<?php echo $videometa['fullembed'];?>?title=1&amp;byline=1&amp;portrait=1&amp;autoplay=true" frameborder="0"></iframe>');
		 });
		 jQuery('.trailertrigger').click(function(e) {
			  jQuery(this).remove();
		     e.preventDefault();
		   jQuery('#video_container').html('<iframe src="http://player.vimeo.com/video/<?php echo $videometa['trailerembed']?>?title=1&amp;byline=1&amp;portrait=1&amp;autoplay=true"  frameborder="0"></iframe>');
		 });

		 
</script>
<?php get_footer(); ?>