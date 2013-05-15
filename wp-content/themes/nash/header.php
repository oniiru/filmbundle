<!DOCTYPE html>
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="ie8"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>

	<title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>

	<!-- Main Stylesheets
  	================================================== -->
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/dynamic-css/options.css">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/socialcss/zocial.css">
	
	
	
	<!-- Meta
	================================================== -->
	
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS2 Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!-- Favicons
	================================================== -->
	
	<link rel="shortcut icon" href="<?php global $data; echo $data['custom_favicon']; ?>">
	<link rel="apple-touch-icon" href="<?php get_template_directory_uri(); ?>assets/img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php get_template_directory_uri(); ?>assets/img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php get_template_directory_uri(); ?>assets/img/apple-touch-icon-114x114.png">
	
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?> >
	
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=414759715269292";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	<div class="header-background-image"></div>

	<header id="header-global" role="banner">
	
		<div class="logo-icons container">
		
			<div class="row">
			
				<div class="header-logo six columns">

					<?php if ($data['text_logo']) { ?>
						<div id="logo-default"><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></div>
					<?php } elseif ($data['custom_logo']) { ?>
						<div id="logo"><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo $data['custom_logo']; ?>" alt="Header Logo" /></a></div>
					<?php } ?>
				  	
				</div><!-- end .header-logo -->
			
				
			</div><!-- end .row -->
			
		</div><!-- end .logo-icons container -->
			
		<nav id="header-navigation" class="sixteen columns" role="navigation">
		
		<?php if (!is_user_logged_in()) { ?>
			
			<?php
			$header_menu_args = array(
			    'menu' => 'Header',
			    'theme_location' => 'Front',
			    'container' => false,
			    'menu_id' => 'navigation'
			);
			
			wp_nav_menu($header_menu_args);
			?>
			
		<?php } else { ?>
		
			<?php
			$header_menu_args = array(
			    'menu' => 'Header',
			    'theme_location' => 'Inner',
			    'container' => false,
			    'menu_id' => 'navigation'
			);
		
		wp_nav_menu($header_menu_args);
		?>
		
		<?php } ?>
		<div class="socialnavthingy">
		<div class="fb-like" style="top:-9px;margin-right:10px;" data-href="http://filmbundle.com" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
		<div style="position:relative;top:-4px;display:inline-block"><a href="https://twitter.com/FilmBundle" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @FilmBundle</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div></div>
	<div class="navloginstuff"><?php 
if ( dynamic_sidebar('login_header_widget') ) : 
else : 
?>
<?php endif; ?></div>
</nav><!-- end #header-navigation -->

		<?php if (is_front_page()) { ?>
		
		<div class="container">
				
			<div class="row">
			
				<?php if ($data['text_introduction']) { ?>
					<div id="uber-statement">
				<h1><?php echo $data['text_introduction']; ?></h1>
			</div>
				<?php } ?>
				
				<div class="socialstuff">
					<h3 class="fadeplease">Follow us: </h3>
				<a href="http://facebook.com/filmbundle"><img class="fadeplease fadeplease2" src="<?php echo get_stylesheet_directory_uri(); ?>/img/Facebook.png"></a>
				<a href="http://twitter.com/filmbundle"><img class="fadeplease fadeplease2 twitterbird" src="<?php echo get_stylesheet_directory_uri(); ?>/img/twitter.png"></a>
				</div>
				
				<script>
				jQuery(document).ready(function(){
					setTimeout(function(){
				jQuery('.fadeplease').fadeTo(2000, 1);
				jQuery('.fadeplease').fadeTo(2000, 0.5);
				jQuery('.fadeplease').fadeTo(2000, 1);
				jQuery('.fadeplease').fadeTo(2000, 0.5);
				},3000);
				jQuery('.fadeplease2').mouseover(
					function () {
						jQuery(this).fadeTo ("fast", 1);
					}).mouseout (function () {
						
						jQuery(this).fadeTo ("fast", .7);
					});
			});
				</script>
				<script>
				jQuery(document).ready(
					function(){
						jQuery('a[href$="#headerlogin"]').click(function(){
							jQuery('.navloginstuff').slideToggle('slow');
							
						});
			
			jQuery(function() {
			    if ( document.location.href.indexOf('?action=login') > -1 ) {
			        jQuery('.navloginstuff').show();
			    }
			});
			
			jQuery(function() {
			    if ( document.location.href.indexOf('?action=lost') > -1 ) {
			        jQuery('.navloginstuff').show();
			    }
			});
			
			});
				</script>
				
			</div>
		
		</div><!-- end .container -->
		
		<?php } else { ?>
		<?php } ?>
	
	</header><!-- end #header-global -->
	