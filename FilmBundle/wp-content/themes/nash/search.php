<?php
/**
 *
 * Description: Search Results Page Template.
 *
 */

get_header(); ?>

	<div id="main">
			
		<section id="content">
		
			<div class="container">
			
				<div class="sixteen columns">
				
					<section id="post-content" class="ten columns alpha">
					
						<h1><?php _e('Search Results:', 'nash'); ?></h1>
					
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							
						<article <?php post_class("post-excerpt"); ?>>
											
							<h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
							
							<span class="meta-author">By <?php the_author_posts_link(); ?></span>
							
							<span class="meta-category"><?php _e('Posted in', 'nash'); ?> - <?php the_category(' & '); ?> <?php _e('on', 'nash'); ?> <strong><?php the_time('F jS, Y'); ?></strong> <span class="comment-count"><a href="<?php the_permalink(); ?>#comments"><?php $commentscount = get_comments_number(); echo $commentscount; ?></a> <?php _e('Comments', 'nash'); ?></span></span> 
							
							<a href="<?php the_permalink() ?>">
							<?php the_post_thumbnail('archive-post'); ?>
							</a>
							
							<?php the_excerpt(); ?>
							
							<a class="view-article-btn" href="<?php the_permalink() ?>"><?php _e('Read More', 'nash'); ?> &rarr;</a>
											
						</article><!-- end .post-excerpt -->
							
					<?php endwhile; endif; ?>
					
					<?php if (!have_posts()) : ?>
						
						<div id="no-posts-found" class="ten columns alpha">

							<h2 class="post-title"><?php _e( '<span>Oh, that did not go so well!</span>', 'nash' ); ?></h2>
							<p><?php echo __( 'Sorry, but no results were found. Please try the search again.', 'nash' ); ?></p>
						
						</div><!-- end #no-posts-found -->
						
					<?php endif; ?>
					
					<?php if(function_exists('wp_pagenavi')) { ?>
					<?php wp_pagenavi(); ?>   
					<?php } else { ?>      
					  <div class="post-navigation"><p><?php posts_nav_link('&#8734;','&laquo;&laquo; Previous Posts','Older Posts &raquo;&raquo;'); ?></p></div>
					<?php } ?>
						
					</section><!-- end #post-content -->
					
					<?php get_sidebar(); ?>
			
				</div><!-- end .sixteen columns -->
		
			</div><!-- end .container -->
		
		</section><!-- end #content -->
	
	</div><!-- end #main -->
		
<?php get_footer(); ?>