<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <title><?php wp_title(''); ?></title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

  <link rel="dns-prefetch" href="//fonts.googleapis.com">
  <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

  <?php stag_meta_head(); ?>

  <?php wp_head(); ?>

  <?php stag_head(); ?>
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/popup.css" rel="stylesheet">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/landing.css" rel="stylesheet">
  

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/socialcss/zocial.css">
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/modernizr.js'></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/zclip.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.backstretch.min.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.easing-1.3.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.iosslider.min.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/popup.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/froogaloop.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/popup.js'></script>
<a href="https://plus.google.com/106976496344175389196" style="display:none" rel="publisher">Google+</a>

<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700' rel='stylesheet' type='text/css'>


<?php if (is_front_page()) { ?>
<style type='text/css'>
html, body {
  height: auto;
}
</style>
<?php } ?>

<script type="text/javascript">
jQuery(document).ready(function($) {
  if(Modernizr.backgroundsize) {
  } else {
    $("#shared").backstretch("/wp-content/themes/new-proxy-child-theme/assets/img/tinyblurred.jpg");
    $("#suggest").backstretch("/wp-content/themes/new-proxy-child-theme/assets/img/ladylooking.jpg");
  };
 
  
 
  </script>
</head>

<!-- BEGIN body -->
<body <?php body_class(); ?>>
	<div class="landingnav">
		<div class="landingcontainer">
		<div class="landinglogo-outer">
			<img class="landinglogo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/hmmm.png">
			<p>Film<span>Bundle</span></p>
		</div>
		<div class="landingbuttons">
			<a href="http://filmbundle.com/blog" class="landingbutton joinbtn"> Blog </a>
			<?php if ( is_user_logged_in() ) {?>
				
<?php echo do_shortcode( '[loginout edit_tag="class=\'landingbutton loginbtnland\'"]' ); ?>				
			
				<?php } else {?> 
			<a href="http://filmbundle.com/login" class="landingbutton loginbtnland"> Login </a>
			<?php } ?>
			
		</div>
	</div>
	</div>
		
  <?php stag_content_start(); ?>