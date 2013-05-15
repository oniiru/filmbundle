<?php
/**
 *
 * Default Page Header
 *
 * @package WP-Bootstrap
 * @subpackage Default_Theme
 * @since WP-Bootstrap 0.1
 *
 * Last Revised: April 11, 2012
 */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
   <title><?php
  /*
   * Print the <title> tag based on what is being viewed.
   */
  global $page, $paged;
  wp_title( '|', true, 'right' );

  // Add the blog name.
  bloginfo( 'name' );

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    echo " | $site_description";

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 )
    echo ' | ' . sprintf( __( 'Page %s', 'bootstrapwp' ), max( $paged, $page ) );

  ?></title>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, target-densitydpi=medium-dpi">

    <link rel="profile" href="http://gmpg.org/xfn/11" />


    <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

  <!-- Le fav and touch icons -->
   <!-- <link rel="shortcut icon" href="<?php bloginfo( 'template_url' );?>/ico/favicon.ico"> -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php bloginfo( 'template_url' );?>/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo( 'template_url' );?>/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php bloginfo( 'template_url' );?>/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php bloginfo( 'template_url' );?>/ico/apple-touch-icon-57-precomposed.png">
	<link href='http://fonts.googleapis.com/css?family=Sonsie+One' rel='stylesheet' type='text/css'>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> 
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
 	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/jquery.jqplot.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/jqplot.donutRenderer.js'></script> 
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/bundle.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/jquery.linkedsliders.js'></script>
	<link rel='stylesheet' type='text/css' href='<?php bloginfo('stylesheet_directory'); ?>/js/chunkfive.otf'>


	

  <!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
    <?php wp_head(); ?>
            	<link rel='stylesheet' id='style-css'  href='<?php bloginfo('stylesheet_directory'); ?>/style.css' type='text/css' media='screen' />
               	<link rel='stylesheet' id='style-css'  href='<?php bloginfo('stylesheet_directory'); ?>/jquery.jqplot.css' type='text/css' media='screen' />  </head>
	 <body <?php body_class(); ?>  data-spy="scroll" data-target=".subnav" data-offset="50">
		
		<div class="navbar">
			<div class="navbar-inner">
				<div class="bodyouter">
				<div class="container">
						<?php if (!is_user_logged_in()) {

					?>
						
						<form action="http://filmbundle.us6.list-manage.com/subscribe/post?u=752f5f41f587ae5e48edfa699&amp;id=bcd472b80e" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="form-search" target="_blank" novalidate>
						Hear about upcoming packs:
						<input type="email" name="EMAIL" placeholder="email address" class="emailformsearch input-medium search-query">
						<input type="submit" name="subscribe"  id="mc-embedded-subscribe" value="Subscribe" class="btn btn-info">
						
					
					</form>
				    <div class="btn-group">
					
				<a class="btn btn-info logbtn dropdown-toggle" data-toggle="dropdown" href="#"> Login</a>	
				<ul class="dropdown-menu">
					<li>
						<?php dynamic_sidebar('Loginthing') ?>
					</li>
				</ul>
			</div>

					<?php }

						else {
 ?> <div class="headerleftlogo"><h3><a href="<?php echo esc_url( home_url( '/' ) ); ?>">FilmBundle</a></h3></div>
 <div class="btn-group">
 	
						<a class="btn btn-info logbtn dropdown-toggle" data-toggle="dropdown" href="#"> Account </a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>membership-account/">Account</a>
								
							</li>
							<li>
								<a href="<?php echo wp_logout_url(); ?>">Logout</a>
							</li>
						</ul>
					</div>
										<a class="btn btn-info" href="<?php echo esc_url( home_url( '/' ) ); ?>watch/" type="button">Watch!</a>

					<?php
					}
					?>
	
					<a class="btn btn-info" href="<?php echo esc_url( home_url( '/' ) ); ?>blog/" type="button">Blog</a>

				</div>
			</div>
		</div>
        </div>
      </div>	
      </div>
    </div>
    <!-- End Header -->
      <div id="content-wrapper">
      	<div class="bodyouter">
        <div class="container">
              <!-- Begin Template Content -->