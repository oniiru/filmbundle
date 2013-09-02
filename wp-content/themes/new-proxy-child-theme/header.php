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
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/video-js.css" rel="stylesheet">

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/socialcss/zocial.css">
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/modernizr.js'></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/zclip.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.backstretch.min.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.easing-1.3.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.iosslider.min.js'></script>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/video.js"></script>

<script>

  videojs.options.flash.swf = "<?php echo get_stylesheet_directory_uri(); ?>/assets/video-js.swf";
</script>

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
  <!-- Start: The modal dialog for additional social features -->
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
  <div class="socialModalWrap">
      <div class="socialModalOverlay">
          &nbsp;
      </div>
      <div class="socialModalVerticalOffset">
          <div class="socialModalBox">
            <div class="widget_title"><a id="closeModal">Close</a></div>
            <div class="socialModalContent">
              <div class="socialModalContentInner">
                <span class="socialModalThanks">Thanks for Sharing!</span>
                <span class="socialModalTell">Now tell your friends on Facebook that you like Filmbundle!</span>
            <div class="fb-like" data-href="https://www.facebook.com/filmbundle" data-layout="button_count" data-show-faces="false"></div>
          </div>
          <span class="socialModalDisable">Already like us? <a id="disableModal">Don't show this again</a></span>
            </div>
          </div>
      </div>
  </div>
  <!-- End: The modal dialog for additional social features -->
 
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

        <!-- BEGIN #primary-nav -->
  		  <div class="littlesocial">
    		<div class="fb-like" style="margin-right:20px;" data-href="http://facebook.com/filmbundle" data-send="false" data-layout="button_count" data-width="10" data-show-faces="false"></div>
    		<div style="position:relative;display:inline-block"><a href="https://twitter.com/FilmBundle" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @FilmBundle</a>
    		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    	</div>
  </div>
        <nav id="navigation" role="navigation">
          <?php
            if(has_nav_menu('primary-menu')){
              wp_nav_menu(array(
                'theme_location' => 'primary-menu',
                'container' => 'div',
                'container_id' => 'primary-nav',
                'container_class' => 'primary-menu',
                ));
            }
		
          ?>
		 
          <!-- END #primary-nav -->
        </nav>
		
        <!-- END .header-inner -->
      </div>

    <?php stag_header_end(); ?>

    <!-- END .header -->
  </header>

  <?php stag_header_after(); ?>

  <!-- BEGIN #container -->
  <div id="container">
  <?php stag_content_start(); ?>