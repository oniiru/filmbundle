<?php
add_action('add_meta_boxes', 'stag_metabox_portfolio');

function stag_metabox_portfolio(){
  $meta_box = array(
    'id' => 'stag_metabox_portfolio',
    'title' => __('Portfolio Details', 'stag'),
    'description' => __('Enter the details of work.', 'stag'),
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
      array(
        'name' => __('Project Date', 'stag'),
        'desc' => __('Enter the project date e.g. Feb 24, 2013', 'stag'),
        'id' => '_stag_portfolio_date',
        'type' => 'date',
        'std' => ''
        ),
      array(
        'name' => __('Project URL', 'stag'),
        'desc' => __('Enter the project URL.', 'stag'),
        'id' => '_stag_portfolio_url',
        'type' => 'text',
        'std' => ''
        ),

      array(
        'name' => __('Project Image 1', 'stag'),
        'desc' => __('Choose an image, ideal size 1400px x unlimited.', 'stag'),
        'id' => '_stag_portfolio_image_1',
        'type' => 'file',
        'std' => ''
        ),
      array(
        'name' => __('Project Image 2', 'stag'),
        'desc' => __('Choose an image, ideal size 1400px x unlimited.', 'stag'),
        'id' => '_stag_portfolio_image_2',
        'type' => 'file',
        'std' => ''
        ),
      array(
        'name' => __('Project Image 3', 'stag'),
        'desc' => __('Choose an image, ideal size 1400px x unlimited.', 'stag'),
        'id' => '_stag_portfolio_image_3',
        'type' => 'file',
        'std' => ''
        ),
      array(
        'name' => __('Project Image 4', 'stag'),
        'desc' => __('Choose an image, ideal size 1400px x unlimited.', 'stag'),
        'id' => '_stag_portfolio_image_4',
        'type' => 'file',
        'std' => ''
        ),
      array(
        'name' => __('Project Image 5', 'stag'),
        'desc' => __('Choose an image, ideal size 1400px x unlimited.', 'stag'),
        'id' => '_stag_portfolio_image_5',
        'type' => 'file',
        'std' => ''
        ),

      )
    );
    $meta_box['page'] = 'portfolio';
    stag_add_meta_box($meta_box);
}


add_action('add_meta_boxes', 'stag_metabox_portfolio_videos');
function stag_metabox_portfolio_videos(){
  $meta_box = array(
    'id' => 'stag_metabox_portfolio_videos',
    'title' => __('Portfolio Videos', 'stag'),
    'description' => __('Enter the Vimeo Video ID, e.g. for video with a link https://vimeo.com/60835364, enter 60835364', 'stag'),
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
      array(
        'name' => __('Project Video 1', 'stag'),
        'desc' => __('Enter the Vimeo video ID', 'stag'),
        'id' => '_stag_portfolio_video_1',
        'type' => 'text',
        'std' => ''
        ),
      array(
        'name' => __('Project Video 2', 'stag'),
        'desc' => __('Enter the Vimeo video ID', 'stag'),
        'id' => '_stag_portfolio_video_2',
        'type' => 'text',
        'std' => ''
        ),
      array(
        'name' => __('Project Video 3', 'stag'),
        'desc' => __('Enter the Vimeo video ID', 'stag'),
        'id' => '_stag_portfolio_video_3',
        'type' => 'text',
        'std' => ''
        ),
      array(
        'name' => __('Project Video 4', 'stag'),
        'desc' => __('Enter the Vimeo video ID', 'stag'),
        'id' => '_stag_portfolio_video_4',
        'type' => 'text',
        'std' => ''
        ),
      array(
        'name' => __('Project Video 5', 'stag'),
        'desc' => __('Enter the Vimeo video ID', 'stag'),
        'id' => '_stag_portfolio_video_5',
        'type' => 'text',
        'std' => ''
        ),

      )
    );
    $meta_box['page'] = 'portfolio';
    stag_add_meta_box($meta_box);
}