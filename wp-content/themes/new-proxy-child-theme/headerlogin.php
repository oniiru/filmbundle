<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <title>FilmBundle - Login </title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

  <link rel="dns-prefetch" href="//fonts.googleapis.com">
  <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

  <?php stag_meta_head(); ?>

  <?php wp_head(); ?>

  <?php stag_head(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/socialcss/zocial.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/modernizr.custom.82475.js'></script>

<script>
  if(Modernizr.cssanimations) {
  } else {
    (function($) {
      $(document).ready(function() {
        $("a#to-login").attr('href', '/login/');
        $("a#to-register").attr('href', '/register/');
      });
    })(jQuery);
  }
</script>

<style>
html, body {
	height:100%;
}
</style>
</head>

<!-- BEGIN body -->
<body cite="Hudson Gardner, http://www.flickr.com/photos/hlg/6782185502/sizes/l/in/photostream/" id="loginbody" <?php body_class(); ?>>
  <?php stag_body_start(); ?>


  <?php stag_header_before(); ?>

  <!-- BEGIN #header -->
  <header id="header" role="banner">

    <?php stag_header_start(); ?>

      <!-- BEGIN .header-inner -->
      <div class="header-inner clearfix">

        <!-- BEGIN #logo -->
        <div id="logo">
          <?php

          if( stag_get_option('general_text_logo') == 'on' ){ ?>
            <a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a>
          <?php } elseif( stag_get_option('general_custom_logo') ) { ?>
            <a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>"><img src="<?php echo stag_get_option('general_custom_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
          <?php } else{ ?>
            <a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php bloginfo( 'name' ); ?>"></a>
          <?php }

          ?>
          <!-- END #logo -->
        </div>
<h1 class="logintitle">Choose your own price for bundles of amazing indies.</h1>       

        <!-- END .header-inner -->
      </div>

    <?php stag_header_end(); ?>
	<link href='http://fonts.googleapis.com/css?family=Amatic+SC:700' rel='stylesheet' type='text/css'>

    <!-- END .header -->
  </header>

  <?php stag_header_after(); ?>

  <!-- BEGIN #container -->
  <div id="container">
  <?php stag_content_start(); ?>