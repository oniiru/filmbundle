<?php
/*
Template Name: Bundles Template
*/

get_header();
?>

<script type="text/javascript">
	jQuery(document).ready(function() {

		jQuery('.iosSliderwide').iosSlider({
			snapToChildren: true,
			desktopClickDrag: true,
			keyboardControls: true,
			navNextSelector: jQuery('.thenext'),
			navPrevSelector: jQuery('.theprev'),
			navSlideSelector: jQuery('.selectors .item'),
			onSlideChange: slideChange,
			autoSlide: true,
			autoSlideTimer: 5000,
			infiniteSlider: true,
			onSliderLoaded: slideShow
		});

	});

	function slideChange(args) {

		jQuery('.selectors .item').removeClass('selected');
		jQuery('.selectors .item:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');

	}
	function slideShow(args) {
		jQuery('.item').show();
	}
</script>


<div class = 'iosSliderwide'>

	<div class = 'slider'>

		<div style="background:black; height:100%" class = 'item'>
			<h1> Slide 1</h1>
		</div>
		<div style="background:blue; height:100%" class = 'item'>
			<h1> Slide 2</h1>
		</div>
		<div style="background:green; height:100%" class = 'item'>
			<h1> Slide 3</h1>
		</div>

	</div>

	<div class = 'prevContainer'>
		<img style="opacity:.6" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slider-left-arrow.png" class="theprev">

	</div>

	<div class = 'nextContainer'>
		<img style="opacity:.6" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slider-right-arrow.png" class="thenext">
	</div>

	<div class = 'selectorsBlock'>

		<div class = 'selectors'>
			<div class = 'item first selected'></div>
			<div class = 'item'></div>
			<div class = 'item'></div>
		</div>

	</div>

</div>
<div class="yourbundles">
 <h2>your bundles</h2>
</div>

<?php

global $wpdb;
global $user_ID;
if(edd_get_users_purchases( $user_id ) == false) {
	?>
		<div class="nopurchases">
			<h2>Bummer! You haven't purchased any bundles yet. Head to <a href="http://filmbundle.com"> Filmbundle.com </a> to check out our current bundle. If you think you've reached this message in error, please <a href="mailto:andrew@filmbundle.com">contact us. </a></h2>

		</div>

		<?php
}

$bundles = $wpdb->get_results("SELECT * FROM wp_pwyw_bundles", ARRAY_A);

foreach ($bundles as $bundle)
{

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
 			onSliderLoaded: slideComplete2<?php echo $bundleid?>,
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

 	function slideComplete2<?php echo $bundleid?>(args) {
 		 jQuery('.next-<?php echo $bundleid?>, .prev-<?php echo $bundleid?>').removeClass('unselectable');

 	    if(args.currentSlideNumber == 1) {

 	        jQuery('.prev-<?php echo $bundleid?>').addClass('unselectable');

 	    } else if(args.currentSliderOffset == args.data.sliderMax) {

 	         jQuery('.next-<?php echo $bundleid?>').addClass('unselectable');
 	    }
 	if(jQuery('.item-<?php echo $bundleid ?>').length < 5) {
 			jQuery('.next-<?php echo $bundleid?>, .prev-<?php echo $bundleid?>').addClass('unselectable');
 			}
			jQuery('.filmitem').show();
 	}


 </script>










 <div class="bundletitle">
	 <h2><?php echo $bundletitle ?> Bundle</h2>
 </div>
 <div class="bundleslider">

 <div class = 'iosSliderfilm iosSlider-<?php echo $bundleid?>'>

 	<div class = 'slider'>

		<?php
		$films = $wpdb->get_results("SELECT * FROM wp_pwyw_films WHERE bundle_id = $bundleid ORDER BY sort;", ARRAY_A);
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
	<a class="showinfo" href="<?php echo $film['linkedpage'] ?>">
		<?php }?>
  <div class="anextrafilm" style="<?php if($film['image'] == '') { echo 'background-image:green'; } else {echo 'background-image:url('.$film['image'].')';}; ?>">
	<div class="filminformation">
		<h3><?php echo $film['title']?></h3>
		<p><?php echo $film['logline']?></p>
		<p style="margin-top:20px" class="rungen">Directed by: <?php echo $film['director']?></p>
		<p class="rungen">Written by: <?php echo $film['writers']?></p>
		<p class="rungen">Starring: <?php echo $film['stars']?></p>

		<p class="rungen">Runtime: <?php echo $film['runtime']?></p>
		<p class="rungen">Genre(s): <?php echo $film['genre']?></p>
 </div>
  	  </div>
<?php if ($film['linkedpage'] != '') {?>
</a>
<?php }?>
</div>
<?php }
 }?>

</div> <!-- end slider -->
</div> <!-- end iosSlider -->
<div class="nextprev">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slider-right-arrow.png" class="next next-<?php echo $bundleid?>">
</div><div class="nextprev">
<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slider-left-arrow.png" class="prev prev-<?php echo $bundleid?> unselectable">
</div>
</div>

<?php } } ?>

<script>
  jQuery(".anextrafilm").mouseenter(function() {
    jQuery(this).children('.filminformation').fadeIn(200);
  }).mouseleave(function() {
    jQuery(this).children('.filminformation').fadeOut(200);
  });

</script>

<?php get_footer(); ?>