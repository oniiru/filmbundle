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
		 <?php
		 global $wpdb;
		 $linkedbundle = $videometa['thisbundle'];
		 $bundles = $wpdb->get_results("SELECT * FROM wp_pwyw_bundles WHERE id = $linkedbundle;", ARRAY_A);
		 $activebundle = $bundles['0']['activated'];
		 if($activebundle == '1') {
		 ?>
				 <div class="buybundle">

					 <h3> Get this film as part of our <?php echo $bundles['0']['title'] ?> Bundle before time runs out!  </h3>
					 <div class="buttoncount">
					 <a href="http://filmbundle.com" class="button"> Take a look </a>

						 <div class='pwyw-countdown'>    <div class='remaining'>Time Remaining</div>

    <?php
        $atts = array(
            't'           => $bundles['0']['end_time'],
            'days'        => 'd',
            'hours'       => 'h',
            'minutes'     => 'm',
            'seconds'     => 's',
            'omitweeks'   => 'true',
			'omitseconds'   => 'true',
            'style'       => 'pwyw',
            'jsplacement' => 'inline'
        );
        echo tminuscountdown($atts);
    ?>
</div>
</div>
</div>
<?php };?>


			<?php global $user_ID;
			$abovebelow = array (
			"below" => $videometa['belowavg'],
			"above" => $videometa['aboveavg'],
			);
				if(((edd_has_user_purchased( $user_ID, $abovebelow )) && ($videometa['abvaccessonly'] == '')) || ((edd_has_user_purchased( $user_ID, $videometa['aboveavg'] )) && ($videometa['abvaccessonly'] == 'above')))  {
				?>
				 <?php if($videometa['tipster'] == 'yes') {
					 $tiptime = ($videometa['tiphr'] * 3600) + ($videometa['tipmin'] * 60) + ($videometa['tipsec']);
					 ?>



					 <div class="tipshare">
                        <?php
                        // -----------------------------------------------------------------------------
                        // START: Tip the Filmmaker
                        // -----------------------------------------------------------------------------
                        ?>
                        <div class="tiptime">
                            <div class="tiptimetext">
                                <h3>Amazing huh? Feel like giving the filmmaker a tip?</h3>
                                <p>100% goes to the makers of this film. Any amount would sure be appreciated. :-)</p>
                            </div>
                            <form id='tipshare-form' class='tipping-form' method='post' action=''>
                                <p class="flatinputprepend">$</p>
                                <input type="text" name="tipAmount" class="flatinput">
                                <input type="hidden" name="download_id" value="<?php echo $videometa['tipprod']; ?>" />
                                <input type="hidden" name="tipCheckout" value="1" />
                                <input type="hidden" name="edd-gateway" value="paypal_digital" />
                                <button name='giveTip' type='submit' value='checkout' class='tipbutton'>Tip away!</button>
                            </form>
                        </div>
                        <?php
                        // -----------------------------------------------------------------------------
                        // END: Tip the Filmmaker
                        // -----------------------------------------------------------------------------
                        ?>
						 <p class="soctext">or help out by letting your friends know!</p>
	  	               <div class="social_share <?php echo $title_top_class ;?>">
					       <?php
					           if (is_user_logged_in()) {
					               // Get relevant info for current user
					               $user = wp_get_current_user();
					               $email = $user->user_email;

					               // Retrieve the user from the subscriber DB
					               global $wpdb;
					               $tablename = $wpdb->prefix . SEED_CSP3_TABLENAME;
					               $sql = "SELECT * FROM $tablename WHERE email = %s;";
					               $safe_sql = $wpdb->prepare($sql, $email);
					               $result = $wpdb->get_row($safe_sql);

					               if ($result) {
					                   // Calc referrer url
					                   $ref = $result->id+1000;
					   				$urlnoslash = rtrim(get_permalink(),'/');
					                   $referrer_url = $urlnoslash . '?ref='.base_convert($ref, 10, 36);
					               };
					   			$sharingiscaring = $referrer_url;

					   		}
					   		else {
					   			$sharingiscaring = get_permalink();

					   		}
					           // Setup share urls
					           $facebook_share = "http://www.facebook.com/sharer.php?s=100&amp;p[title]=".urlencode($videometa['facetitle'])."&amp;p[summary]=".urlencode($videometa['facemsg'])."&amp;p[images][0]=".$videometa['faceimg']."&amp;p[url]=".$sharingiscaring;
					           $twitter_share = "https://twitter.com/share?url=".$sharingiscaring."&amp;text=".urlencode($videometa['twitmsg'].' - '.$sharingiscaring);

					       ?>

	  	                   <a class="zocial facebook" href="<?php echo $facebook_share; ?>" onclick="return !handleSocialWin('<?php echo $facebook_share; ?>', 'Facebook');" target="_blank">Share on Facebook</a>

	  	                   <a class="zocial twitter" href="<?php echo $twitter_share; ?>" onclick="return !handleSocialWin('<?php echo $twitter_share; ?>', 'Twitter');" target="_blank">Share on Twitter</a>
	  	               </div>
					 </div>
					 <?php } ?>
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
<div class="filmtitl">
	<h1><?php echo $videometa['title']; ?> </h1>

<div class="social_share socialsmaller<?php echo $title_top_class ;?>">
    <?php
        if (is_user_logged_in()) {
            // Get relevant info for current user
            $user = wp_get_current_user();
            $email = $user->user_email;

            // Retrieve the user from the subscriber DB
            global $wpdb;
            $tablename = $wpdb->prefix . SEED_CSP3_TABLENAME;
            $sql = "SELECT * FROM $tablename WHERE email = %s;";
            $safe_sql = $wpdb->prepare($sql, $email);
            $result = $wpdb->get_row($safe_sql);

            if ($result) {
                // Calc referrer url
                $ref = $result->id+1000;
				$urlnoslash = rtrim(get_permalink(),'/');
                $referrer_url = $urlnoslash . '?ref='.base_convert($ref, 10, 36);
            };
			$sharingiscaring = $referrer_url;

		}
		else {
			$sharingiscaring = get_permalink();

		}
        // Setup share urls
        $facebook_share = "http://www.facebook.com/sharer.php?s=100&amp;p[title]=".urlencode($videometa['facetitle'])."&amp;p[summary]=".urlencode($videometa['facemsg'])."&amp;p[images][0]=".$videometa['faceimg']."&amp;p[url]=".$sharingiscaring;
        $twitter_share = "https://twitter.com/share?url=".$sharingiscaring."&amp;text=".urlencode($videometa['twitmsg'].' - '.$sharingiscaring);
    ?>
    <a class="zocial facebook" href="<?php echo $facebook_share; ?>" onclick="return !handleSocialWin('<?php echo $facebook_share; ?>', 'Facebook');" target="_blank">Share</a>

    <a class="zocial twitter" href="<?php echo $twitter_share; ?>" onclick="return !handleSocialWin('<?php echo $twitter_share; ?>', 'Twitter');" target="_blank">Tweet</a>
</div>

</div>
<?php
global $wpdb;
$linkedbundle = $videometa['thisbundle'];
$bundles = $wpdb->get_results("SELECT * FROM wp_pwyw_bundles WHERE id = $linkedbundle;", ARRAY_A);
$activebundle = $bundles['0']['activated'];
$abovebelow = array (
"below" => $videometa['belowavg'],
"above" => $videometa['aboveavg'],
);

if(((edd_has_user_purchased( $user_ID, $abovebelow )) && ($videometa['abvaccessonly'] == '')) || ((edd_has_user_purchased( $user_ID, $videometa['aboveavg'] )) && ($videometa['abvaccessonly'] == 'above')))  {}
else {
if($activebundle == 1) {
?>
<div class="thepitch">
	<h4>Watch this film now as part of our <?php echo $bundles['0']['title'] ?> Bundle!</h4>
	<p><?php echo $videometa['pitchsub']?></p>
	<div class="buttoncount">

	<a href="http://filmbundle.com" class="button"> Check it out </a>
	<div class="fixr">
    <div class='pwyw-countdown'>
        <div class='remaining'>Time Remaining</div>
        <?php
            $atts = array(
                't'           => $bundles['0']['end_time'],
                'days'        => 'd',
                'hours'       => 'h',
                'minutes'     => 'm',
                'seconds'     => 's',
                'omitweeks'   => 'true',
				'omitseconds'   => 'true',
                'style'       => 'pwyw',
                'jsplacement' => 'inline'
            );
            echo tminuscountdown($atts);
        ?>
    </div></div>
</div>
</div>


<?php }

elseif($activebundle == 0) { ?>

	<div class="thepitch mailchimp">
		<h4>The <?php echo $bundles['0']['title'] ?>  Bundle is now over. </h4>
		<p>Enter your email below to be the first to hear about upcoming bundles.</p>
	 <div class="chimpform">
	 	<?php mailchimpSF_signup_form(); ?>
	 </div>
	</div>


<?php }

}?>
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
						<span><?php echo $videometa['runtime'].' Min.  &nbsp;• &nbsp; Genre(s): '.$videometa['genres'].' &nbsp;• &nbsp;Rated: '.$videometa['rating'] ?></span>
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

</div>
<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slider-right-arrow.png" class="next">
<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slider-left-arrow.png" class="prev unselectable">

</div>

 	<?php
}
 ?>

<?php
// -----------------------------------------------------------------------------
// START: Tip the Filmmaker
// -----------------------------------------------------------------------------
if (($videometa['tipster'] == 'yes') && (((edd_has_user_purchased( $user_ID, $abovebelow )) && ($videometa['abvaccessonly'] == '')) || ((edd_has_user_purchased( $user_ID, $videometa['aboveavg'] )) && ($videometa['abvaccessonly'] == 'above')))
) {
?>
    <div class="tipster">
        <div class="tipstertext">
            <h3>Like what you see? Tip the Filmmaker!</h3>
            <p>(All tips received go straight to the filmmaker.)</p>
        </div>
        <form id='tipster-form' class='tipping-form' method='post' action=''>
            <p class="flatinputprepend">$</p>
            <input type="text" name="tipAmount" class="flatinput">
            <input type="hidden" name="download_id" value="<?php echo $videometa['tipprod']; ?>" />
            <input type="hidden" name="tipCheckout" value="1" />
            <input type="hidden" name="edd-gateway" value="paypal_digital" />
            <button name='giveTip' type='submit' value='checkout' class='tipbutton'>Tip away!</button>
        </form>
    </div>
<?php
}
// -----------------------------------------------------------------------------
// END: Tip the Filmmaker
// -----------------------------------------------------------------------------
?>

<div class="thecomments">
	 <img class="whatthink" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/lovebundle.png">

	 <?php disqus_embed('filmbundle'); ?>

 </div>
</div>

<script type="text/javascript">


	jQuery(document).ready(function() {

		jQuery('.iosSlider').iosSlider({
			snapToChildren: true,
			desktopClickDrag: true,
			keyboardControls: false,
			onSliderLoaded: slideComplete2,
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


	function slideComplete2(args) {

		jQuery('.next, .prev').removeClass('unselectable');

	    if(args.currentSlideNumber == 1) {

	        jQuery('.prev').addClass('unselectable');

	    } else if(args.currentSliderOffset == args.data.sliderMax) {

	        jQuery('.next').addClass('unselectable');
	    }
	if(jQuery('.anextra').length < 5) {
			 jQuery('.next, .prev').addClass('unselectable');
			}
			jQuery('.item').show();

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
		   jQuery('#video_container').html('<iframe id="full" src="http://player.vimeo.com/video/<?php echo $videometa['fullembed'];?>?title=1&amp;byline=1&amp;portrait=1&amp;api=1&amp;player_id=full&amp;autoplay=true" frameborder="0"></iframe>');
		<?php if(($videometa['tipster'] == 'yes') && (((edd_has_user_purchased( $user_ID, $abovebelow )) && ($videometa['abvaccessonly'] == '')) || ((edd_has_user_purchased( $user_ID, $videometa['aboveavg'] )) && ($videometa['abvaccessonly'] == 'above')))){ ?>
		   //vimeo tip stuff


		   var iframe = jQuery('#full')[0],
		       player = $f(iframe),
		       status = jQuery('.status');

		   // When the player is ready, add listeners for pause, finish, and playProgress
		   player.addEvent('ready', function() {

			   player.addEvent('playProgress', function(data) {
					if(data.seconds >= <?php echo $tiptime ?>) {

						if(!jQuery('.tipshare').is(":visible")) {
						jQuery('.tipshare').slideDown();

						}
					}

					else if(data.seconds < <?php echo $tiptime ?>) {
					if(jQuery('.tipshare').is(":visible")) {
						jQuery('.tipshare').slideUp();

					}

							}

			   });
		   });

		 //end vimeo tip stuff
		 <?php } ?>
		 });


		 jQuery('.trailertrigger').click(function(e) {
			  jQuery(this).remove();
		     e.preventDefault();
		   jQuery('#video_container').html('<iframe id="trailer" src="http://player.vimeo.com/video/<?php echo $videometa['trailerembed']?>?title=1&amp;byline=1&amp;api=1&amp;portrait=1&amp;player_id=trailer&amp;autoplay=true"  frameborder="0"></iframe>');

   		<?php if(!edd_has_user_purchased( $user_ID, $abovebelow)) { ?>
   		   //vimeo tip stuff


   		   var iframe = jQuery('#trailer')[0],
   		       player = $f(iframe),
   		       status = jQuery('.status');

   		   // When the player is ready, add listeners for pause, finish, and playProgress
   		   player.addEvent('ready', function() {

   			   player.addEvent('pause', function(data) {

   						if(!jQuery('.buybundle').is(":visible")) {
   						jQuery('.buybundle').slideDown();

   						}
   					});
	    			   player.addEvent('finish', function(data) {

	    						if(!jQuery('.buybundle').is(":visible")) {
	    						jQuery('.buybundle').slideDown();

	    						}
	    					});
	 	    			   player.addEvent('play', function(data) {

	 	    						if(jQuery('.buybundle').is(":visible")) {
	 	    						jQuery('.buybundle').slideUp();

	 	    						}
	 	    					});

   		   });

   		 //end vimeo tip stuff
   		 <?php } ?>


		 });



</script>
<?php get_footer(); ?>