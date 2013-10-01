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

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/socialcss/zocial.css">
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/modernizr.js'></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/zclip.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.backstretch.min.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.easing-1.3.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.iosslider.min.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/popup.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/froogaloop.js'></script>
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

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
  }
});
</script>

<style type='text/css'>
/** Target Firefox */
@-moz-document url-prefix() {
    input {
      -moz-box-sizing: content-box;
      padding: 5px 10px 5px 10px !important;
    }
    ::-moz-placeholder {
      font-style: italic;
    }
    .gform_wrapper input[type="text"] {
      padding: 5px 10px 5px 10px !important;
    }

}
</style>
</head>

<!-- BEGIN body -->
<body <?php body_class(); ?>>
	<div id="slidenav-outer">
		<a href="<?php echo site_url(); ?>">
    <img class="homelogo littlelogo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/whitehmmm.png">
</a>
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
<?php     if(has_nav_menu('slide-menu')){
          wp_nav_menu(array(
            'theme_location' => 'slide-menu',
            'container' => 'div',
            'container_id' => 'slide-nav',
            'container_class' => 'slide-menu',
            ));
        } ?>
	</div>
  <!-- BEGIN #container -->
  <div id="container">
  <?php stag_content_start(); ?>