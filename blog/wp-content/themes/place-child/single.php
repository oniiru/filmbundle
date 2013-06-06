<?php get_header();?>
<div id="leftContent">
    <div class="inner">
        <div class="post_item post_single white_box">
            <?php if (have_posts()) : while (have_posts()) : the_post(); 
            $title_top_class = ' post_top_element';
            $video_embed = get_post_meta($post->ID, 'pl_video_embed', true) ;
            if($video_embed!=''){
            $title_top_class = '';
            // echo do_shortcode($video_embed);
            ?>
                <div class="fit post_video_wrapper"><?php echo do_shortcode($video_embed); ?></div>
            <?php 
            } else { 
                $title_top_class = ' post_top_element';
                if ( has_post_thumbnail()){
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'fulls-size');
                $new_image = aq_resize( $image[0], 800, NULL, FALSE, FALSE );
                $title_top_class = '';
                ?>
                <div class="large_thumb">
                    
                        
                        <div class="img_wrapper"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><img src="<?php echo $new_image[0];?>" width="<?php echo $new_image[1];?>" height="<?php echo $new_image[2];?>" alt="<?php the_title_attribute();?>" class="post_top_element thumb" /></a></div>
                </div>
                
                <?php } ?>
                
                <?php get_template_part( 'content', 'audio'); ?>
                
            <?php } // if(video_embed) ;?>  

            <div class="social_share <?php echo $title_top_class ;?>">
                <?php
                    // Setup share urls
                    $facebook_share = "http://www.facebook.com/sharer.php?s=100&amp;p[title]=".urlencode(get_the_title())."&amp;p[summary]=".urlencode(get_the_excerpt())."&amp;p[url]=".get_permalink();
                    $twitter_share = "https://twitter.com/share?url=".get_permalink()."&amp;text=".urlencode("This is awesome - ".get_the_title());
                ?>
                <a class="zocial facebook" href="<?php echo $facebook_share; ?>" onclick="return !handleSocialWin('<?php echo $facebook_share; ?>', 'Facebook');" target="_blank">Share on Facebook</a>

                <a class="zocial twitter" href="<?php echo $twitter_share; ?>" onclick="return !handleSocialWin('<?php echo $twitter_share; ?>', 'Twitter');" target="_blank">Share on Twitter</a>
            </div>
            
            <div class="post_single_inner">
            <h1><?php the_title(); ?></h1>
            
            <div class="post_meta">
                <span class="user"><?php _e('by','presslayer');?> <?php the_author_posts_link(); ?></span> 
                <span class="comment"><?php comments_popup_link(__('No Comments','presslayer'), __('1 Comment','presslayer'), __('% Comments','presslayer'),'post_comment'); ?></span>
                <span class="cats"><?php the_category(', ') ?></span>
            </div>
            <div class="post_entry">
            <?php the_content(); ?>
            <?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
            
            <?php edit_post_link('Edit this entry','<p>','</p>'); ?>
            </div>
            <div style="text-align:center">
                <a class="zocial facebook" href="<?php echo $facebook_share; ?>" onclick="return !handleSocialWin('<?php echo $facebook_share; ?>', 'Facebook');" target="_blank">Share on Facebook</a>

                <a class="zocial twitter" href="<?php echo $twitter_share; ?>" onclick="return !handleSocialWin('<?php echo $twitter_share; ?>', 'Twitter');" target="_blank">Share on Twitter</a>
                
                <a href="http://www.reddit.com/submit" onclick="window.location = 'http://www.reddit.com/submit?url=' + encodeURIComponent(window.location); return false"> <img style="height:36px" src="http://www.reddit.com/static/spreddit14.gif" alt="submit to reddit" border="0" /> </a>
            </div>

            <div class="post_single_bottom_wrapper">    
                <div class="post_tag"><?php the_tags( 'Tags: ', ' ', ''); ?></div>
                <span class="like"><?php printLikes(get_the_ID()); ?></span>
                <span class="time"><?php the_time(get_option('date_format')) ?></span>
                
            </div>
            <div class="clear"></div>
            </div>  
        <?php endwhile; endif; ?>
        </div><!-- post item -->
        <div class="mainsharing2 white_box box_info">
            <div class="socialstuff2">
                <h3>Love it<span>?</span> Keep it coming!</h3>
                    <p>Sign up and we'll send you exclusive articles and interviews.</p>
        
        
            <?php mailchimpSF_signup_form(); ?>
    
            </div>
        </div>
        <?php
        if(get_post_meta($post->ID, 'pl_related', true)=='default' or get_post_meta($post->ID, 'pl_related', true)==''){
            $related = $pl_data['enable_related_posts'];
        }else{
            $related = get_post_meta($post->ID, 'pl_related', true);
        }
        if($related!='no') get_template_part( 'inc/related_posts');
        ?>

        
        <?php comments_template(); ?>
    </div>
</div>
<?php get_sidebar('custom');?>
<?php get_footer();?>