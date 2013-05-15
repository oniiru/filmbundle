	<footer id="footer-global" role="contentinfo" class="clearfix">
		
		<section id="contact">
		
			<div class="container">
			
				<div class="row">
		
					<div class="sixteen columns">
					
						<?php
						global $data; ?>
					
						<?php if ($data['text_contact_us_title']) { ?>
						<div class="icon-holder contact">
							<?php echo do_shortcode(stripslashes($data['icon_contact_us'])); ?>
						</div>
						
						<h1><?php echo $data['text_contact_us_title']; ?></h1>
						<?php } ?>
						
						<p class="overview"><?php echo do_shortcode(stripslashes($data['textarea_contact_us_overview'])); ?></p>
					
						<address id="contact-details">
						
							<p><a href="mailto:<?php echo $data['text_contact_email']; ?>"><?php echo $data['text_contact_email']; ?></a> // <?php echo $data['text_contact_telephone']; ?><br />
							<?php echo $data['text_contact_address']; ?></p>
						
						</address>
					
					</div>		
					
				</div><!-- end .row -->
			
				<div class="row">
				
					<div class="sixteen columns">
					
						<ul class="social-icons footer">
						
							<?php if ($data["text_twitter_profile"]) { ?>
								<li><a href="<?php echo $data['text_twitter_profile']; ?>" class="twitter-link" title="View Twitter Profile"></a></li>
							<?php } if ($data["text_facebook_profile"]){ ?>
								<li><a href="<?php echo $data['text_facebook_profile']; ?>" class="facebook-link" title="View Facebook Profile"></a></li>
							<?php } if ($data["text_dribbble_profile"]){ ?>
								<li><a href="<?php echo $data['text_dribbble_profile']; ?>" class="dribbble-link" title="View Dribbble Profile"></a></li>
							<?php } if ($data["text_forrst_profile"]){ ?>
								<li><a href="<?php echo $data['text_forrst_profile']; ?>" class="forrst-link" title="View Forrst Profile"></a></li>
							<?php } if ($data["text_vimeo_profile"]){ ?>
								<li><a href="<?php echo $data['text_vimeo_profile']; ?>" class="vimeo-link" title="View Vimeo Profile"></a></li>
							<?php } if ($data["text_youtube_profile"]){ ?>
								<li><a href="<?php echo $data['text_youtube_profile']; ?>" class="youtube-link" title="View YouTube Profile"></a></li>
							<?php } if ($data["text_flickr_profile"]){ ?>
								<li><a href="<?php echo $data['text_flickr_profile']; ?>" class="flickr-link" title="View Flickr Profile"></a></li>
							<?php } if ($data["text_linkedin_profile"]){ ?>
								<li><a href="<?php echo $data['text_linkedin_profile']; ?>" class="linkedin-link" title="View Linkedin Profile"></a></li>
							<?php } if ($data["text_pinterest_profile"]){ ?>
								<li><a href="<?php echo $data['text_pinterest_profile']; ?>" class="pinterest-link" title="View Pinterest Profile"></a></li>
							<?php } if ($data["text_googleplus_profile"]){ ?>
								<li><a href="<?php echo $data['text_googleplus_profile']; ?>" class="googleplus-link" title="View Google + Profile"></a></li>
							<?php } if ($data["text_tumblr_profile"]){ ?>
								<li><a href="<?php echo $data['text_tumblr_profile']; ?>" class="tumblr-link" title="View Tumblr Profile"></a></li>
							<?php } if ($data["text_soundcloud_profile"]){ ?>
								<li><a href="<?php echo $data['text_soundcloud_profile']; ?>" class="soundcloud-link" title="View Soundcloud Profile"></a></li>
							<?php } if ($data["text_lastfm_profile"]){ ?>
								<li><a href="<?php echo $data['text_lastfm_profile']; ?>" class="lastfm-link" title="View Last FM Profile"></a></li>
							<?php } ?>
							
						</ul>
						
					</div>
					
				</div><!-- end .row -->
		
				<div class="row">
		
					<div class="sixteen columns">

			  			<p id="copyright-details">&copy; <?php echo date('Y') ?> <?php echo bloginfo('name'); ?>. <?php global $data; echo $data['textarea_footer_text']; ?></p>
			  		
			  		</div>
			  		
			  	</div><!-- end .row -->	  
		  	
			</div><!-- end .container -->
		
		</section><!-- end #contact -->
		
	</footer><!-- end #footer-global -->
		
<script type="text/javascript">
function scrollTo(target) {
    var myArray = target.split('#');
    var targetPosition = jQuery('#' + myArray[1]).offset().top;
    jQuery('html,body').animate({
        scrollTop: targetPosition
    }, 'slow');
}
jQuery(document).ready(function () {
    jQuery('nav ul#navigation').mobileMenu({
        defaultText: '<?php _e("Navigation", "nash");?>',
        className: 'mobile-menu',
        subMenuDash: '&ndash;'
    });
});
</script>
	<script>
	jQuery(document).ready(
		function(){
			
	jQuery('select').change(function(){
if ( document.location.href.indexOf('#headerlogin') > -1 ) {	  	jQuery('.navloginstuff').slideToggle();
	  }
	});
				
});
						
	</script>
	<script>
	jQuery(document).ready(
		function(){
			if (jQuery("#csp3-afterform").is('*')) {
				
				jQuery('.socialstuff').hide();
				
			};
			if (jQuery('#csp3-alert').hasClass('alert-info')) {
					jQuery('.socialstuff').hide();
			}
		});
		</script>
	
<?php if ($data['text_twitter_username']) { ?>
<script type="text/javascript">
var twtr_user = "<?php echo $data['text_twitter_username']; ?>"; 
</script>
<?php } ?>
	
<?php echo $data['google_analytics']; ?>
	
<?php wp_footer(); ?>
		
</body>
	
</html>