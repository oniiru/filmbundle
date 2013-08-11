<?php global $theme_url, $pl_data;?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php
	global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'Kangaroo' ), max( $paged, $page ) );
	?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
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
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	
	<?php if($pl_data['custom_favicon']!='') {?>
	<link rel="shortcut icon" href="<?php echo trim($pl_data['custom_favicon']);?>">
	<?php } ?>
	
	<?php wp_head();?>	
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/socialcss/zocial.css">
	<link href='http://fonts.googleapis.com/css?family=Amatic+SC:700' rel='stylesheet' type='text/css'>
	<!-- start Mixpanel --><script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f);b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==
	typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");for(g=0;g<i.length;g++)f(c,i[g]);
	b._i.push([a,e,d])};b.__SV=1.2}})(document,window.mixpanel||[]);
	mixpanel.init("ebcb577c9f9a1c1e95f19b57aab2071e");</script><!-- end Mixpanel -->
</head>
<body <?php body_class(''); ?>>
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
	        	<div class=" widget_title"><a id="closeModal">Close</a></div>
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

	<div id="header">
		<div class="container clearfix">
			<h1 id="logo"><?php if($pl_data['custom_logo']!='') {?><a href="<?php echo home_url();?>" title="<?php bloginfo('name');?>"><img src="<?php echo trim($pl_data['custom_logo']);?>" alt="<?php bloginfo('name');?>" /></a><?php }?></h1>
			
			<?php
			if(function_exists('wp_nav_menu')) {
				wp_nav_menu( 'container_id=top_menu&depth=3&theme_location=navigation&menu_id=mainmenu&menu_class=sf-menu&fallback_cb=menu_default');
				?>
				<?php
			} else {
				menu_default();
			}
			
			function menu_default()
			{
				?>
				<div class="default_nav">Go to: <a href="<?php echo admin_url(); ?>nav-menus.php" target="_blank">Appearance &raquo; Menus</a> to create Navigation</div>
			<?php } ?>
			
			
			<form method="get" id="searchform" action="<?php echo home_url();?>">
			<div class="header_search"><div class="search_zoom search_btn"></div> <input id="s" name="s"   type="text" placeholder="<?php _e('Type & hit enter to search','presslayer');?>" class="search_box" /> </div>	</form>	
		</div>	
		<?php if ( dynamic_sidebar('home_left_1') ) : else : endif; ?>
		
	</div><!-- #header -->
	

<div id="main">
<div class="container clearfix">	