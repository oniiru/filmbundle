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
<?php 			include_once(SEED_CSP3_PLUGIN_PATH.'/themes/default/functions.php' );
echo seed_cs3_head();
?>


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
		<div style="position:relative;top:-5px;display:inline-block"><a href="https://twitter.com/FilmBundle" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @FilmBundle</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div> </div>
	<div class="navloginstuff"><?php 
if ( dynamic_sidebar('login_header_widget') ) : 
else : 
?>
<?php endif; ?></div>
</nav><!-- end #header-navigation -->

		
		<div class="container">
				
			<div class="row">
			
				<?php if ($data['text_introduction']) { ?>
					<div id="uber-statement">
				<!-- <h1>Our first bundle is almost wrapped!</h1> -->
				<h1 class="bigsubtitle">Get curated bundles of fantastic indie films.<br> Support kickass charities. Pay whatever you want. </h1>
				
				<h5 class="hidethisplease">Our first bundle is almost wrapped! Sign up below and we'll tell you when it's ready.</h5>
				<?php 		
				echo seed_cs3_form();
				?>
				<?php } ?>
			</div>
			
			<script>
			jQuery(document).ready(
				function(){
			if (jQuery( "#csp3-alert" ).is(":visible" ) ) {
			    jQuery( ".hidethisplease" ).hide();
				jQuery('#uber-statement h1').css ("margin-bottom", '10px')
				
			};
			if (jQuery( "#csp3-thankyoumsg" ).is(":visible" ) ) {
			    jQuery( ".hidethisplease" ).hide();
				jQuery('#uber-statement h1').css ("margin-bottom", '10px')
			};
			
		});
			</script>
				<!-- <div class="socialstuff">
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
				</script> -->
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
		
	
	
	</header><!-- end #header-global -->
	
	<div id="main">
		<?php
			$layout = $data['homepage_blocks']['enabled'];
		if ($layout):
		foreach ($layout as $key=>$value) {
			switch($key) {
			case 'about_block':
			?>

		<section id="about">
		
			<div class="container">
	
				<?php if ($data['text_about_us_title']) { ?>
				<div class="icon-holder about">
					<?php echo do_shortcode(stripslashes($data['icon_about_us'])); ?>
				</div>
				
				<h1><?php echo $data['text_about_us_title']; ?></h1>
				<?php } ?>
				
				<p class="overview"><?php echo do_shortcode(stripslashes($data['textarea_about_us_overview'])); ?></p>
				
				<div class="flexslider home-slider">
				  
					<ul class="slides">
				  
					<?php
					global $data;
					
					$args = array('post_type' => 'slider', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => $data['select_slider']);
					$loop = new WP_Query($args);
					while ($loop->have_posts()) : $loop->the_post(); ?>
					
					  <li>
						  <a href="<?php echo get_post_meta($post->ID, 'gt_slide_url', true) ?>">
						  <?php the_post_thumbnail('home-slider-thumb'); ?>
						  </a>
					  </li>
					  
					<?php endwhile; ?>
				  
					</ul><!-- end .slides -->
				
				</div><!-- end #main-slider -->
			
			</div>
		
		</section><!-- end #about -->
		
		<?php
		break;
		case 'quotes_top_block':
		?>
	
		<div id="section-divider-1">
		
			<div class="bg1"></div>
			
			<div class="container">
			
				<div class="text-container">
					
					<section id="latest-quotes">
						<ul id="quotes">
					
							<?php
							global $data;
							
							$args = array('post_type' => 'quotes', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1);
							$loop = new WP_Query($args);
							while ($loop->have_posts()) : $loop->the_post(); ?>
							
								<li>
									<blockquote><?php echo get_post_meta($post->ID, 'gt_quotes_quote', true) ?></blockquote>
									<cite><?php echo get_post_meta($post->ID, 'gt_quotes_author', true) ?></cite>
								</li>
								
							<?php endwhile; ?>
				
						</ul><!-- end #quotes -->
					</section><!-- end #latest-quotes -->
				
				</div><!-- end .text-container -->
			
			</div>
		
		</div><!-- end #section-divider-1 -->
		
		<?php
		break;
		case 'work_block':
		?>
	
		<section id="latest-work">
					
			<div class="container">
			
				<?php if ($data['text_portfolio_title']) { ?>
				<div class="icon-holder work">
					<?php echo do_shortcode(stripslashes($data['icon_portfolio'])); ?>
				</div>
				
				<h1><?php echo $data['text_portfolio_title']; ?></h1>
				<?php } ?>
				
				<p class="overview"><?php echo do_shortcode(stripslashes($data['textarea_portfolio_overview'])); ?></p>
					
				<div id="portfolio-filter">
					
					<ul id="filter">
						<li><a href="#" class="current" data-filter="*"><?php _e('Show all', 'nash'); ?></a></li>
						<?php
						$categories = get_categories(array(
						    'type' => 'post',
						    'taxonomy' => 'project-type'
						));
						foreach ($categories as $category) {
						    $group = $category->slug;
						    echo "<li class='project-type'><a href='#' data-filter='.$group'>" . $category->cat_name . "</a></li>";
						}
						?>
					</ul><!-- end #filter -->
					
				</div><!-- end #portfolio-filter -->
		
				<div id="portfolio-items">
				
				<?php
				query_posts(array(
				    'post_type' => 'portfolio',
				    'orderby' => 'menu_order',
				    'order' => 'ASC',
				    'posts_per_page' => -1
				));
				?>
				
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php 
				    $terms =  get_the_terms( $post->ID, 'project-type' ); 
				    $term_list = '';
				    if( is_array($terms) ) {
				        foreach( $terms as $term ) {
					        $term_list .= urldecode($term->slug);
					        $term_list .= ' ';
					    }
				    }
				?>
					
					<div <?php post_class("$term_list one-third column"); ?> id="post-<?php the_ID(); ?>">
					
						<div class="project-item">
							
							<div class="project-image">
								<?php the_post_thumbnail('portfolio-thumb'); ?>
								<div class="overlay">
									<div class="details">
										<a href="<?php the_permalink() ?>"><i class="icon-circle-arrow-right"></i></a>
									</div>
								</div>
							</div><!-- end .project-image -->
							
							<div class="project-details">
								<h2><?php the_title(); ?></h2>
								<?php the_excerpt(); ?>
							</div><!-- end .project-details -->
	
						</div><!-- end .project-item -->
						
					</div><!-- end .one-third -->
					
				<?php endwhile; endif; ?>
					
				</div><!-- end #portfolio-items -->
				
			</div><!-- end .container -->
	
		</section><!-- end #latest-work -->
		
		<?php
		break;
		case 'logos_block':
		?>
	
		<div id="section-divider-2">
			
			<div class="bg2"></div>
		
			<div class="container">
		
				<div class="text-container">
				
					<div class="logos sixteen columns">
				
						<h2 id="client-logos-title"><?php echo $data['text_client_logos_title']; ?></h2>
					
						<ul id="client-logos">
						<?php if($data["client_logo_one"]) { ?>
							<li><img src="<?php echo $data['client_logo_one']; ?>" alt="" /></li>
						<?php } if($data["client_logo_two"]){ ?>
							<li><img src="<?php echo $data['client_logo_two']; ?>" alt="" /></li>
						<?php } if($data["client_logo_three"]){ ?>
							<li><img src="<?php echo $data['client_logo_three']; ?>" alt="" /></li>
						<?php } if($data["client_logo_four"]){ ?>
							<li><img src="<?php echo $data['client_logo_four']; ?>" alt="" /></li>
						<?php } if($data["client_logo_five"]){ ?>
							<li><img src="<?php echo $data['client_logo_five']; ?>" alt="" /></li>
						<?php } ?>	
						</ul>
				
					</div><!-- end .logos -->
			
				</div><!-- end .text-container -->
		
			</div>
		
		</div><!-- end #section-divider-2 -->
		
		<?php
		break;
		case 'services_block':
		?>
	
		<section id="services">
	
			<div class="container">
			
				<?php if ($data['text_services_title']) { ?>
				
				
				<h1><?php echo $data['text_services_title']; ?></h1>
				<?php } ?>
				
				<p class="overview"><?php echo do_shortcode(stripslashes($data['textarea_services_overview'])); ?></p>
			
				<div id="all-services">
							
					<?php
					global $data;
					
					$args = array('post_type' => 'services', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => $data['select_services']);
					$loop = new WP_Query($args);
					while ($loop->have_posts()) : $loop->the_post(); ?>
				
					<div class="service one-third column">
	
						<?php echo do_shortcode(get_post_meta(get_the_ID(), 'gt_service_icon', $single = true)) ?>
	
						<h2><?php the_title(); ?></h2>
						
						<?php the_content(); ?>
					
					</div><!-- end .service -->
					
					<?php endwhile; ?>
				
				</div><!-- end #all-services -->
				
			</div>
	
		</section><!-- end #services -->
		
		<?php
		break;
		case 'tweet_block':
		?>
	
		<div id="section-divider-3">
		
			<div class="bg3"></div>
		
			<div class="container">
			
				<div class="text-container">
			
					<i class="icon-twitter"></i>
					<div id="latest-tweet"></div>
			
				</div><!-- end .text-container -->
		
			</div>
		
		</div><!-- end #section-divider-3 -->
		
		<?php
		break;
		case 'team_block':
		?>
	
		<section id="meet-the-team">
					
			<div class="container">
			
				<?php if ($data['text_team_title']) { ?>
				
				
				<h1><?php echo $data['text_team_title']; ?></h1>
				<?php } ?>
				<center><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/MYSTERY.png"></center>
				
				<p class="overview"><?php echo do_shortcode(stripslashes($data['textarea_team_overview'])); ?></p>
				<div id="team-members">
			
					<?php
					global $data;
					
					$args = array('post_type' => 'team', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => $data['select_team']);
					$loop = new WP_Query($args);
					while ($loop->have_posts()) : $loop->the_post(); ?>
				
					<div class="team-member one-third column">
					
						<div class="thumbnail">
							<?php the_post_thumbnail('team-member-thumb'); ?>
						</div>
						
						<h2><?php the_title(); ?></h2>
						
						<p><em><?php echo get_post_meta($post->ID, 'gt_member_title', true) ?></em></p>
						
						<?php the_content(); ?>
						
						<div class="social-icons-small">
						<?php if (get_post_meta($post->ID, 'gt_member_twitter', true)) { ?>
							<a href="<?php echo get_post_meta($post->ID, 'gt_member_twitter', true) ?>"><i class="icon-twitter icon-large"></i></a>
						<?php } if (get_post_meta($post->ID, 'gt_member_facebook', true)) { ?>
							<a href="<?php echo get_post_meta($post->ID, 'gt_member_facebook', true) ?>"><i class="icon-facebook icon-large"></i></a>
						<?php } if (get_post_meta($post->ID, 'gt_member_linkedin', true)) { ?>
							<a href="<?php echo get_post_meta($post->ID, 'gt_member_linkedin', true) ?>"><i class="icon-linkedin icon-large"></i></a>
						<?php } if (get_post_meta($post->ID, 'gt_member_pinterest', true)) { ?>
							<a href="<?php echo get_post_meta($post->ID, 'gt_member_pinterest', true) ?>"><i class="icon-pinterest icon-large"></i></a>
						<?php } if (get_post_meta($post->ID, 'gt_member_googleplus', true)) { ?>
							<a href="<?php echo get_post_meta($post->ID, 'gt_member_googleplus', true) ?>"><i class="icon-google-plus icon-large"></i></a>
						<?php } ?>
						</div>	
					
					</div><!-- end .team-member -->
					
					<?php endwhile; ?>
				
				</div><!-- end #team-members -->
				
			</div><!-- end .container -->
				
		</section><!-- end #meet-the-team -->
		
		<?php
		break;
		case 'quotes_bottom_block':
		?>
		
		<div id="section-divider-4">
		
			<div class="bg4"></div>
		
			<div class="container">
			
				<div class="text-container">
			
					<section id="latest-quotes">
						<ul id="quotes">
					
							<?php
							global $data;
							
							$args = array('post_type' => 'quotes', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1);
							$loop = new WP_Query($args);
							while ($loop->have_posts()) : $loop->the_post(); ?>
							
								<li>
									<blockquote><?php echo get_post_meta($post->ID, 'gt_quotes_quote', true) ?></blockquote>
									<cite><?php echo get_post_meta($post->ID, 'gt_quotes_author', true) ?></cite>
								</li>
								
							<?php endwhile; ?>
				
						</ul><!-- end #quotes -->
					</section><!-- end #latest-quotes -->
			
				</div><!-- end .text-container -->
		
			</div>
		
		</div><!-- end #section-divider-4 -->
		
		<?php
		break;
		case 'news_block':
		?>
		
		<section id="latest-news">
		
			<div class="container">
			
				<?php if ($data['text_news_title']) { ?>
				<div class="icon-holder news">
					<?php echo do_shortcode(stripslashes($data['icon_news'])); ?>
				</div>
				
				<h1><?php echo $data['text_news_title']; ?></h1>
				<?php } ?>
				
				<p class="overview"><?php echo do_shortcode(stripslashes($data['textarea_news_overview'])); ?></p>

				<div id="articles">
				
					<?php
					global $data;
											
					$args = array('post_type' => 'post', 'posts_per_page' => $data['select_news']);
					$loop = new WP_Query($args);
					while ($loop->have_posts()) : $loop->the_post(); ?>
				
					<article class="article one-third column">
					
						<div class="thumbnail">
							<?php the_post_thumbnail('latest-news-thumb'); ?>
						</div>
						
						<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
						
						<div class="meta">
							<p><?php _e('Posted in -', 'nash'); ?> <?php the_category(' & '); ?><br />on <?php the_time('F jS, Y'); ?>
							<span><i class="icon-comment"></i> <a href="<?php the_permalink(); ?>#comments"><?php $commentscount = get_comments_number(); echo $commentscount; ?> <?php _e('Comments', 'nash'); ?></a></span>
							</p>
						</div>
						
						<?php the_excerpt(); ?>
						
						<a class="view-article-btn" href="<?php the_permalink() ?>"><?php _e('Read more', 'nash'); ?> &rarr;</a>
					
					</article><!-- end article -->
										
					<?php endwhile; ?>
				
				</div><!-- end #articles -->
			
			</div><!-- end .container -->
	
		</section><!-- end #latest-news -->
		
		<?php break; }
		} endif; ?>
	
	</div><!-- end #main -->
	<footer id="footer-global" role="contentinfo" class="clearfix">
		
		<section id="contact">
		
			<div class="container">
			
				<div class="row">
		
					<div class="sixteen columns">
					
						<?php
						global $data; ?>
					
						<?php if ($data['text_contact_us_title']) { ?>
						<div class="icon-holder contact">
							<?php echo do_shortcode(stripslashes($data['icon_contact_us'])); ?>
						</div>
						
						<h1><?php echo $data['text_contact_us_title']; ?></h1>
						<?php } ?>
						
						<p class="overview"><?php echo do_shortcode(stripslashes($data['textarea_contact_us_overview'])); ?></p>
					
						<address id="contact-details">
						
							<p><a href="mailto:<?php echo $data['text_contact_email']; ?>"><?php echo $data['text_contact_email']; ?></a> // <?php echo $data['text_contact_telephone']; ?><br />
							<?php echo $data['text_contact_address']; ?></p>
						
						</address>
					
					</div>		
					
				</div><!-- end .row -->
			
				<div class="row">
				
					<div class="sixteen columns">
					
						<ul class="social-icons footer">
						
							<?php if ($data["text_twitter_profile"]) { ?>
								<li><a href="<?php echo $data['text_twitter_profile']; ?>" class="twitter-link" title="View Twitter Profile"></a></li>
							<?php } if ($data["text_facebook_profile"]){ ?>
								<li><a href="<?php echo $data['text_facebook_profile']; ?>" class="facebook-link" title="View Facebook Profile"></a></li>
							<?php } if ($data["text_dribbble_profile"]){ ?>
								<li><a href="<?php echo $data['text_dribbble_profile']; ?>" class="dribbble-link" title="View Dribbble Profile"></a></li>
							<?php } if ($data["text_forrst_profile"]){ ?>
								<li><a href="<?php echo $data['text_forrst_profile']; ?>" class="forrst-link" title="View Forrst Profile"></a></li>
							<?php } if ($data["text_vimeo_profile"]){ ?>
								<li><a href="<?php echo $data['text_vimeo_profile']; ?>" class="vimeo-link" title="View Vimeo Profile"></a></li>
							<?php } if ($data["text_youtube_profile"]){ ?>
								<li><a href="<?php echo $data['text_youtube_profile']; ?>" class="youtube-link" title="View YouTube Profile"></a></li>
							<?php } if ($data["text_flickr_profile"]){ ?>
								<li><a href="<?php echo $data['text_flickr_profile']; ?>" class="flickr-link" title="View Flickr Profile"></a></li>
							<?php } if ($data["text_linkedin_profile"]){ ?>
								<li><a href="<?php echo $data['text_linkedin_profile']; ?>" class="linkedin-link" title="View Linkedin Profile"></a></li>
							<?php } if ($data["text_pinterest_profile"]){ ?>
								<li><a href="<?php echo $data['text_pinterest_profile']; ?>" class="pinterest-link" title="View Pinterest Profile"></a></li>
							<?php } if ($data["text_googleplus_profile"]){ ?>
								<li><a href="<?php echo $data['text_googleplus_profile']; ?>" class="googleplus-link" title="View Google + Profile"></a></li>
							<?php } if ($data["text_tumblr_profile"]){ ?>
								<li><a href="<?php echo $data['text_tumblr_profile']; ?>" class="tumblr-link" title="View Tumblr Profile"></a></li>
							<?php } if ($data["text_soundcloud_profile"]){ ?>
								<li><a href="<?php echo $data['text_soundcloud_profile']; ?>" class="soundcloud-link" title="View Soundcloud Profile"></a></li>
							<?php } if ($data["text_lastfm_profile"]){ ?>
								<li><a href="<?php echo $data['text_lastfm_profile']; ?>" class="lastfm-link" title="View Last FM Profile"></a></li>
							<?php } ?>
							
						</ul>
						
					</div>
					
				</div><!-- end .row -->
		
				<div class="row">
		
					<div class="sixteen columns">

			  			<p id="copyright-details">&copy; <?php echo date('Y') ?> <?php echo bloginfo('name'); ?>. <?php global $data; echo $data['textarea_footer_text']; ?></p>
			  		
			  		</div>
			  		
			  	</div><!-- end .row -->	  
		  	
			</div><!-- end .container -->
		
		</section><!-- end #contact -->
		
	</footer><!-- end #footer-global -->
		
<script type="text/javascript">
function scrollTo(target) {
    var myArray = target.split('#');
    var targetPosition = jQuery('#' + myArray[1]).offset().top;
    jQuery('html,body').animate({
        scrollTop: targetPosition
    }, 'slow');
}


jQuery(document).ready(function () {
    jQuery('nav ul#navigation').mobileMenu({
        defaultText: '<?php _e("Navigation", "nash");?>',
        className: 'mobile-menu',
        subMenuDash: '&ndash;'
    });
});
</script>
	<script>
	jQuery(document).ready(
		function(){
			
			
	jQuery('select').change(function(){
if ( document.location.href.indexOf('#headerlogin') > -1 ) {	  	jQuery('.navloginstuff').slideToggle();
	  }
	});
				
});
						
	</script>
	// <script>
	// jQuery(document).ready(
	// 	function(){
	// 		if (jQuery("#csp3-afterform").is('*')) {
	// 			
	// 			jQuery('.socialstuff').hide();
	// 			
	// 		};
	// 		if (jQuery('#csp3-alert').hasClass('alert-info')) {
	// 				jQuery('.socialstuff').hide();
	// 		}
	// 	});
	// 	</script>
	
<?php if ($data['text_twitter_username']) { ?>
<script type="text/javascript">
var twtr_user = "<?php echo $data['text_twitter_username']; ?>"; 
</script>
<?php } ?>
	
<?php echo $data['google_analytics']; ?>
<?php echo seed_cs3_footer()?>
<?php wp_footer(); ?>
		
</body>
	
</html>