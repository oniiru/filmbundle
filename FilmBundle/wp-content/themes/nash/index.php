<?php
/**
 *
 * Description: Main Homepage template.
 *
 */

get_header(); ?>

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
	
						<?php echo do_shortcode(get_post_meta($post->ID, 'gt_service_icon', $single = true)) ?>
	
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
				<div class="icon-holder team">
					<?php echo do_shortcode(stripslashes($data['icon_team'])); ?>
				</div>
				
				<h1><?php echo $data['text_team_title']; ?></h1>
				<?php } ?>
				
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
						
						<i class="icon-star"></i>
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

<?php get_footer(); ?>