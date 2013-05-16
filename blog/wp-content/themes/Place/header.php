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
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	
	<?php if($pl_data['custom_favicon']!='') {?>
	<link rel="shortcut icon" href="<?php echo trim($pl_data['custom_favicon']);?>">
	<?php } ?>
	
	<?php wp_head();?>	
</head>
<body <?php body_class(''); ?>>
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
	</div><!-- #header -->
	

<div id="main">
<div class="container clearfix">	