<?php
/*
Template Name: Landing Page
*/
get_header('landing'); ?>

<div class="landingcontent-top">
	<div class="landingcontainer">
	<div class="landingcontent-topleft">
		<h1>Choose your own price for bundles of amazing indies.</h1>
		<p>Limited-time bundles of amazing hand-selected independent films. Pay only what they are worth to you, and support charity while you're at it.</p>
	 <div class="chimpform">
	 	<?php mailchimpSF_signup_form(); ?>
	 </div>
	 <script type="text/javascript">
	 jQuery('input[name$="mc_mv_EMAIL"]').attr('placeholder', 'Subscribe to hear about our launch');
	 </script>
	
	</div>
	
	<div class="landingcontent-topright">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/landing.png">
	</div>
	
</div>
	
	
</div>




<div class="landingcontainer landingcontent-bottom">
	<div class="gettothepoint">
			<div class="thepoint pointleft">
				<h4>Discover Amazing Indies</h4>
				<p>Each bundle contains amazing hand-picked films for you to stream. Our curators bring you only the best.</p>
			</div>
			<div class="thepoint pointmiddle">
				<h4>Pay What You Want</h4>
				<p>Bundles have no set prices. You choose what you want to pay, and how to split it between the filmmakers, charities and us! </p>
			
			</div>
			<div class="thepoint pointright">
				<h4>Support Charity</h4>
				<p>We partner with the best arts-driven nonprofits with each bundle, making it easy to give back while watching killer films. </p>
			</div>
		
		</div>
		<a href="http://filmbundle.com/about" class="landingbutton joinbtn learnbtn"> Learn More </a>
	
	
</div>
<?php

get_footer('landing'); ?>