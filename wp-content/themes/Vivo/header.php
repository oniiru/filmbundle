<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta content="IE=EmulateIE7" http-equiv="X-UA-Compatible">
	<title><?php bloginfo('name'); ?><?php wp_title('::'); ?></title>
 	<meta name="description" content="">
	<!-- Import Styles -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php if(is_singular()){ wp_enqueue_script('comment-reply');} ?>
	<!--End WP generated header-->
	<!--[if IE]>
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/styles/ie8.css">
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<!--WP generated header-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php include 'includes/get_background.php'; ?>

	<div id="container">
	    <div id="main_sidebar" class="clearfix <?php echo get_option('of_nav_style'); ?>">
	        <div id="logo">
	          <a href="<?php echo home_url(); ?>">
	          	<!-- If a logo is specified in the options, use it -->
				<?php if (get_option('of_logo') != "") { ?>
					<img src="<?php echo get_option('of_logo'); ?>" alt="<?php bloginfo('name'); ?>">
				<!-- Otherwise just show the sites name -->
				<?php } else { ?>
					<h1><?php bloginfo( 'name' ); ?></h1>
				<?php } ?>
	          </a>
	        </div>

	        <div id="side_contact">
				<?php if(get_option('of_email') != "") { ?><p><?php echo get_option('of_email'); ?></p><?php } ?>
				<?php if(get_option('of_phone') != "") { ?><p><?php echo get_option('of_phone'); ?></p><?php } ?>
		        <?php if(get_option('of_address') != "") { ?><p><?php echo get_option('of_address'); ?></p><?php } ?>
			</div>

			<div id="primary_nav_container" class="clearfix">
				<div id="primary_nav" class="clearfix">
					<!-- If a custom menu has been created, use it -->
					<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
						<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'sf-menu' ) ); ?>
					<!-- Otherwise use all the sites pages as the nav -->
					<?php } else { ?>
						<ul class="sf-menu">
							<?php wp_list_pages('title_li='); ?>
						</ul>
					<?php } ?>
				</div><!-- end #primary_nav -->
				<div id="responsive_menu_container">
					<select class="responsive_menu">
						<option>Navigate to...</option>
					</select>
				</div>
			</div><!-- end #primary_nav_container -->