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

 <div class = 'iosSlider iosSlider-<?php echo $bundleid?>'>

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

   
<div class = 'item item-<?php echo $bundleid?>'>
	<a href="<?php echo $film['linkedpage'] ?>">
 <div class="anextra">
	 <div class="iteminfo">
		 <img style="height:50px" src="<?php echo $film['image'] ?>">
		 <p><?php echo $film['rating'] ?></p>
		 <p><?php echo $film['logline'] ?></p>
		 
	 </div>
 </div>
</a>
 
</div>
<?php }
else { ?>
	<div class = 'item item-<?php echo $bundleid?>'>
		<div class="lockeditem">
		 <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/lock.png">
			
	 <div class="anextra">
		 <div class="iteminfo">
			 <img style="height:50px" src="<?php echo $film['image'] ?>">
			 <p><?php echo $film['rating'] ?></p>
			 <p><?php echo $film['logline'] ?></p>
		 
		 </div>
	 </div>
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