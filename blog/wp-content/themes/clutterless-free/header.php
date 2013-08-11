<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('name'); ?></title>
	
	<!-- Meta -->
	<meta charset = "UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<?php
	// Add meta tag for Facebook's open graph if we have a featured image
	// available
	if (is_singular()) {
		if (has_post_thumbnail()) {
			$thumbId = get_post_thumbnail_id($post->ID);
			$thumbObj = get_post($thumbId);
			echo "<meta property='og:image' content='{$thumbObj->guid}' />\n";
		}
	}
	?>
	<!-- RSS Feed -->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	
	<!-- Pingbacks -->
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
<?php wp_head(); ?>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
<link href='http://fonts.googleapis.com/css?family=Amatic+SC:700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/socialcss/zocial.css">
	

<script>
jQuery(function() {
  
 jQuery('.littlelogo').click(
  function () {
	  if (jQuery('#sidebar').css("display") == "none") {
		  jQuery('.littlelogo').hide();
   jQuery('#sidebar').stop().animate({width: 'show'}, { duration: 200, queue: false });
   jQuery('.leftthing').stop().animate({'left':'280px'},{ duration: 200, queue: false });
   jQuery('#content').stop().animate({'marginLeft':'364px'},{ duration: 200, queue: false });
   
   if (jQuery(window).width() <= 950){	
	   jQuery('#content').stop().animate({'width':'750px', 'marginLeft':'280px'},{ duration: 200, queue: false });
	   
   	}	
	
   jQuery('.clearthing').stop().animate({width: 'show'}, 0);
   
 
 
} else {
    jQuery('#sidebar').stop().animate({width: 'hide'}, { duration: 200, queue: false });
    jQuery('.leftthing').stop().animate({'left':'0px'},{ duration: 200, queue: false });
    jQuery('#content').stop().animate({'width':'100%', 'marginLeft':'0px'},{ duration: 200, queue: false });
	jQuery('.clearthing').stop().animate({width: 'hide'}, 0);
}; 
 
 });
  
 jQuery('.clearthing').click(function() {
  jQuery('.littlelogo').fadeIn(1500);
	 
     jQuery('#sidebar').stop().animate({width: 'hide'}, { duration: 200, queue: false });
     jQuery('.leftthing').stop().animate({'left':'0px'},{ duration: 200, queue: false });
     jQuery('#content').stop().animate({'width':'100%', 'marginLeft':'0px'},{ duration: 200, queue: false });
 	jQuery('.clearthing').stop().animate({width: 'hide'}, 0);
 
 });

 
});

</script>
<!-- start Mixpanel --><script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f);b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==
typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");for(g=0;g<i.length;g++)f(c,i[g]);
b._i.push([a,e,d])};b.__SV=1.2}})(document,window.mixpanel||[]);
mixpanel.init("ebcb577c9f9a1c1e95f19b57aab2071e");</script><!-- end Mixpanel -->
</head>
<body <?php body_class(); ?>>
	<!-- Start: The modal dialog for additional social features -->
	<?php if (is_singular()): ?>
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
	        	<div class=" widget_title"><a id="closeModal">X</a></div>
	        	<div class="socialModalContent">
		        	<div class="socialModalContentInner">
		        		<div id="socialModalFromShare">
			        		<span class="socialModalThanks">Thanks for Sharing!</span>
			        		<span class="socialModalTell">Why don't you give us a like to get updates and exclusive content.</span>
							<div class="fb-like" data-href="https://www.facebook.com/filmbundle" data-layout="button_count" data-show-faces="false"></div>
		        		</div>
		        		<div id="socialModalFromVideo">
			        		<span class="socialModalThanks">Like the video?</span>
			        		<span class="socialModalTell">Like us on FaceBook for more just like it!</span>
							<div class="fb-like" data-href="https://www.facebook.com/filmbundle" data-layout="button_count" data-show-faces="false"></div>
		        		</div>
					</div>
					<span class="socialModalDisable">Already like us? <a id="disableModal">Don't show this again</a></span>
	        	</div>
	        </div>
	    </div>
	</div>
	<div class="socialSlideWrap">
        <div class="socialSlideBox">
        	<div class="widget_title"><a id="disableSocialSlide">Don't show again</a> | <a id="closeSocialSlide">Close</a></div>
        	<span class="socialSlideText">Like us on Facebook?</span>
			<div class="fb-like" data-href="https://www.facebook.com/filmbundle" data-send="false" data-width="200" data-show-faces="false"></div>
        </div>
	</div>

	<?php endif; ?>
	<!-- End: The modal dialog for additional social features -->
	
	
  <?php get_sidebar(); ?>

  <div id="content">

