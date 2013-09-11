<?php
/*
Template Name: Bundles Template
*/

get_header(); 

global $wpdb;
$bundles = $wpdb->get_results("SELECT * FROM wp_pwyw_bundles", ARRAY_A);

foreach ($bundles as $bundle)
{ 
	global $user_ID;
 $activebundle = $bundle['activated'];
 $bundletitle = $bundle['title'];
 $bundledesc = $bundle['description'];
 $bundleid = $bundle['id'];
	 $bundleabove = $bundle['aboveaverage'];
	 $bundlebelow = $bundle['belowaverage'];
	$bundleabovebelow = array (
	"below" => $bundlebelow,
	"above" => $bundleabove,
	);
	 if(edd_has_user_purchased( $user_ID, $bundleabovebelow )) {
?>


 <script type="text/javascript">
 
  
 	jQuery(document).ready(function() {
		
 		jQuery('.iosSlider-<?php echo $bundleid?>').iosSlider({
 			snapToChildren: true,
 			desktopClickDrag: true,
 			keyboardControls: false,
 			onSliderLoaded: slideComplete<?php echo $bundleid?>,
 			onSlideComplete: slideComplete<?php echo $bundleid?>,
 			navNextSelector: jQuery('.next-<?php echo $bundleid?>'),
 		    navPrevSelector: jQuery('.prev-<?php echo $bundleid?>'),
 		});
 	});
 	function slideComplete<?php echo $bundleid?>(args) {
 		 jQuery('.next-<?php echo $bundleid?>, .prev-<?php echo $bundleid?>').removeClass('unselectable');

 	    if(args.currentSlideNumber == 1) {
	
 	        jQuery('.prev-<?php echo $bundleid?>').addClass('unselectable');
	
 	    } else if(args.currentSliderOffset == args.data.sliderMax) {
	
 	         jQuery('.next-<?php echo $bundleid?>').addClass('unselectable');	
 	    }
 	if(jQuery('.item-<?php echo $bundleid ?>').length < 5) {
 			jQuery('.next-<?php echo $bundleid?>, .prev-<?php echo $bundleid?>').addClass('unselectable');	
 			}
 	}
 </script>

 <div class="undervidstripe">
	 <h2><?php echo $bundletitle ?></h2>
 </div>
 <div class="bundleslider">

 <div class = 'iosSliderfilm iosSlider-<?php echo $bundleid?>'>

 	<div class = 'slider'>
		
		<?php 
		$films = $wpdb->get_results("SELECT * FROM wp_pwyw_films WHERE bundle_id = $bundleid;", ARRAY_A);
		foreach ($films as $film) {
			if ($film['rating'] == 'above') {
					$aorb = $bundleabove;

			}
			else if ($film['rating'] == 'below') {
				$aorb = $bundleabovebelow;
				
				
			}
	
   	 if(edd_has_user_purchased( $user_ID, $aorb )) {
   ?>

   
<div class = 'filmitem item-<?php echo $bundleid?>'>
	<?php if ($film['linkedpage'] != '') {?>
	<a href="<?php echo $film['linkedpage'] ?>">
		<?php }?>
  <div class="anextrafilm" style="<?php if($film['image'] == '') { echo 'background-image:green'; } else {echo 'background-image:url('.$film['image'].')';}; ?>">		  </div>
<div class="iteminfo">
		 <p><?php echo $film['rating'] ?></p>
		 <p><?php echo $film['logline'] ?></p>
<?php if ($film['linkedpage'] != '') {?>
</a>
<?php }?>
</div>
</div>
<?php }
else { ?>
	<div class = 'filmitem item-<?php echo $bundleid?>'>
	 <div class="anextrafilm" style="<?php if($film['image'] == '') { echo 'background-image:green'; } else {echo 'background-image:url('.$film['image'].')';}; ?>">
 		<div class="lockeditemfilm">
 		 <img class="lock" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/lock.png">
	 </div>
 </div>
		 <div class="iteminfo">
			 <p><?php echo $film['rating'] ?></p>
			 <p><?php echo $film['logline'] ?></p>
		 
		 
 </div>
	</div>
	
	
	<?php } }?>

</div> <!-- end slider -->
</div> <!-- end iosSlider -->
<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/nav-arrow-right.png" class="next next-<?php echo $bundleid?>">
<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/nav-arrow-left.png" class="prev prev-<?php echo $bundleid?> unselectable">
</div>

<?php } } ?>

<?php get_footer(); ?>