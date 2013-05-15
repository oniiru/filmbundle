<?php

add_action('add_meta_boxes', 'stag_metabox_slider');

function stag_metabox_slider(){
  $meta_box = array(
    'id' => 'stag_metabox_slider',
    'title' => __('Slider Settings', 'stag'),
    'description' => __('Customize the slider settings.', 'stag'),
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
      array(
        'name' => __('Sub Title', 'stag'),
        'desc' => __('Enter the sub title for slider (optional).', 'stag'),
        'id' => '_stag_slide_subtitle',
        'type' => 'text',
        'std' => ''
        ),
      array(
        'name' => __('Slide URL', 'stag'),
        'desc' => __('Enter the URL for slide (optional).', 'stag'),
        'id' => '_stag_slide_url',
        'type' => 'text',
        'std' => ''
        ),
      array(
        'name' => __('Slide Image', 'stag'),
        'desc' => __('Upload the slider image', 'stag'),
        'id' => '_stag_slide_image',
        'type' => 'file',
        'std' => ''
        ),
      array(
        'name' => __('Slide Video (Vimeo)', 'stag'),
        'desc' => __('Enter the Vimeo Video ID, e.g. for video with a link \'https://vimeo.com/60835364\', enter 60835364. <br><br> If choosing a video, slider image will not be displayed.', 'stag'),
        'id' => '_stag_slide_video',
        'type' => 'text',
        'std' => ''
        ),
      )
    );
    $meta_box['page'] = 'slides';
    stag_add_meta_box($meta_box);
}


function stag_slider_template($count = 5){
    $args = array(
        'post_type' => 'slides',
        'posts_per_pages' => $count,
    );

    $the_query = new WP_Query($args);

    if($the_query->have_posts()){
        $vid = '';
        $hasVid = false;
        ?>

        <div id="slideshow" class="clearfix">
            <div id="main-slider" class="flexslider">
                <ul class="slides">
                    <?php while($the_query->have_posts()): $the_query->the_post(); ?>
                    <?php $vid = get_post_meta(get_the_ID(), '_stag_slide_video', true); if($vid != '') $hasVid = true;  ?>
                    <li>
                        <?php if($vid === ''): ?>
                        <div class="slider-content">
                            <div class="slider-content-inner">

                                <?php if(get_the_title() != ''): ?>
                                    <h2><?php echo get_the_title(); ?></h2>
                                <?php endif; ?>

                                <div class="clear"></div>
                                <?php
                                if(get_post_meta(get_the_ID(), '_stag_slide_subtitle', true) != '' && get_post_meta(get_the_ID(), '_stag_slide_url', true) != ''){
                                    echo '<h3><a href="'.get_post_meta(get_the_ID(), '_stag_slide_url', true).'">'. get_post_meta(get_the_ID(), '_stag_slide_subtitle', true) .'</a></h3>';
                                }elseif(get_post_meta(get_the_ID(), '_stag_slide_subtitle', true) != ""){
                                    echo '<h3>' . get_post_meta(get_the_ID(), '_stag_slide_subtitle', true) . '</h3>';
                                }
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>

                        <?php

                        if($vid != ''){ ?>
                            <iframe id="player_1" src="http://player.vimeo.com/video/<?php echo $vid; ?>?api=1&amp;player_id=player_1" width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                        <?php
                        }elseif(get_post_meta(get_the_ID(), '_stag_slide_image', true) != ''){
                            echo '<img src="'. get_post_meta(get_the_ID(), '_stag_slide_image', true) .'" alt="">';
                        }
                         ?>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <?php if($hasVid) echo '<script src="'.get_template_directory_uri().'/assets/js/froogaloop.js"></script>'; ?>
        </div>

        <script>
        jQuery(window).load(function(){

            <?php if($hasVid){ ?>
            // Vimeo API nonsense
            var player = document.getElementById('player_1');
            $f(player).addEvent('ready', ready);

            function addEvent(element, eventName, callback) {
                if (element.addEventListener) {
                  element.addEventListener(eventName, callback, false)
                } else {
                  element.attachEvent(eventName, callback, false);
                }
            }

            function ready(player_id) {
                var froogaloop = $f(player_id);
                froogaloop.addEvent('play', function(data) {
                    $('#main-slider').flexslider("pause");
                });
                froogaloop.addEvent('pause', function(data) {
                    $('#main-slider').flexslider("play");
                });
            }
            <?php } ?>

            jQuery('#main-slider').fitVids().flexslider({
                directionNav: false,
                controlNav: true,
                animation: "fade",
                smoothHeight: true,
                video: true,
            });
        });

        </script>

        <?php
        wp_reset_postdata();
    }
}

function stag_slider_shortcode(){
    ob_start();
    stag_slider_template();
    $slider = ob_get_clean();
    return $slider;
}
add_shortcode( 'stag_slider', 'stag_slider_shortcode' );