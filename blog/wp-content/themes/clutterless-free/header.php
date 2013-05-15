<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('name'); ?></title>
	
	<!-- Meta -->
	<meta charset = "UTF-8" />
	
	<!-- RSS Feed -->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	
	<!-- Pingbacks -->
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
<?php wp_head(); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>

<script type="text/javascript">
    var stub_showing = false;
 
    function woahbar_show() { 
        if(stub_showing) {
          jQuery('.woahbar-stub').slideUp('fast', function() {
            jQuery('.woahbar').show('bounce', { times:3, distance:15 }, 100); 
            jQuery('body').animate({"marginTop": "2.4em"}, 250);
          }); 
        }
        else {
          jQuery('.woahbar').show('bounce', { times:3, distance:15 }, 100); 
          jQuery('body').animate({"marginTop": "2.4em"}, 250);
        }
    }
 
    function woahbar_hide() { 
        jQuery('.woahbar').slideUp('fast', function() {
          jQuery('.woahbar-stub').show('bounce', { times:3, distance:15 }, 100);  
          stub_showing = true;
        }); 
 
        if( jQuery(window).width() > 1024 ) {
          jQuery('body').animate({"marginTop": "0px"}, 250); // if width greater than 1024 pull up the body
        }
    }
 
    jQuery().ready(function() {
        window.setTimeout(function() {
        woahbar_show();
     }, 1500);
    });
</script>

</head>
<body <?php body_class(); ?>>
	
	
	<!-- <div class="woahbar" style="display:none">
	      <p> Welcome to Jobdeals! Need some help from a local service pro? </p>
	    <a class="close-notify" onclick="woahbar_hide();"><img class="woahbar-up-arrow" src="wp-content/themes/clutterless-free/img/woahbar-up-arrow.png"></a>
	</div>
	<div class="woahbar-stub" style="display:none">
	    <a class="show-notify" onclick="woahbar_show();"><img class="woahbar-down-arrow" src="wp-content/themes/clutterless-free/img/woahbar-down-arrow.png"></a>
	</div> -->
	
  <?php get_sidebar(); ?>

  <div id="content">

