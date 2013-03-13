<?php
/*
Template Name: Portfolio: Masonry no descriptions
*/
?>
 
<?php get_header(); ?>
</div><!-- end #main_sidebar -->

<div id="layout_spaced" class="clearfix">

    <?php if( empty( $post->post_content) ) {
    // Don't show content box
    }
    else { // Else add content before work ?>
        <div id="content_fluid_container">
            <div id="content_fluid" class="clearfix">
                <div class="inner">
                    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                        <?php if (get_option('of_titles_off') == "false") { ?>
                            <h1 class="page_title"><?php the_title(); ?></h1>
                            <div class="divider"></div>
                        <?php } ?>
                            <?php the_content(); ?>
                            <?php wp_link_pages(array('before' => '<p><strong>'. 'Pages:' .'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                        <?php edit_post_link('Edit this page...', '<strong>', '</strong>'); ?>
                    <?php endwhile; endif; ?>
                </div>
            </div><!-- end #content -->
        </div>      
    <?php } ?>

    <?php include 'includes/get_portfolio_category.php'; ?>

    <div id="loader"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/misc/loader.gif"></div>
	<div id="work_container" class="no_desc clearfix">
        <?php //Find out whether to show filter list or not
        if($selectedCat == 'all') { ?>
            <div class="work_item filter_block">
                <?php include 'includes/get_portfolio_filter.php'; ?>
            </div>
        <?php } ?>
		<?php if (have_posts()) : while (have_posts()) : the_post();
            // Variables to store each of our possible taxonomy lists
            // This one checks for an project-type classification
            $tax_list = get_the_term_list( $post->ID, 'project-type', '', ' <span> &middot; </span> ', '' );
                    
            // Add project-type list if this post was so tagged
            if ( '' != $tax_list ) {
                $taxo_text .= "$tax_list<br />\n";
            }
        ?>
			<div class="work_item <?php $categories = get_the_terms( $post->id, 'project-type' ); $count = count($categories); $i=1; foreach($categories as $category) {        echo str_replace('-', '', $category->slug); if ($i<$count) echo ' '; $i++;} ?>" class="post-<?php the_ID(); ?> <?php $categories = get_the_category(); foreach($categories as $category) {        echo str_replace('-', '', $category->slug).' '; } ?> project " data-id="post-<?php the_ID(); ?>">
				<div class="work_thumb">
                    <a href="<?php print portfolio_thumbnail_url($post->ID) ?>" rel="prettyPhoto" title="See preview of <?php the_title(); ?>">
                        <?php the_post_thumbnail('blog_index'); ?>
                            <a class="overlay_zoom" href="<?php print portfolio_thumbnail_url($post->ID) ?>" rel="prettyPhoto" title="See preview of <?php the_title(); ?>"></a>
                            <a class="overlay_link" href="<?php the_permalink(); ?>" title="Go to <?php the_title(); ?>"></a>
                        <div class="work_item_overlay"></div>
                    </a>
                </div><!-- end .work_thumb -->
			</div><!-- end #work_item -->
		<?php endwhile; endif; wp_reset_query(); ?>
	</div><!-- end #work_container -->

</div><!-- end #content -->
</div><!-- end #container -->

<?php include 'includes/get_masonrified.php'; ?>

<?php get_footer(); ?>