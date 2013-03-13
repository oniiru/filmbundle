<?php
/*
Plugin Name: VideoGall
Plugin URI: http://dezineappz.com/videogall
Description: Automatically generate a beautiful video gallery by adding videos from different websites
Version: 2.5.1
Author: DezineAppz
Author URI: http://www.dezineappz.com
*/

/*  Copyright 2009

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Fix to avoid memory leak error
 */
ini_set("memory_limit","50M");

/**
 * Defining constants
 */
define('VIDEOGALL_DIR_URL',plugin_dir_url(__FILE__));
define('VIDEOGALL_DIR_PATH',plugin_dir_path(__FILE__));

/**
 * Creating options for storing videos, categories and auto generated ID
 */
add_option('videogall_videos',array());
add_option('videogall_categories',array());
if(trim(get_option('videogall_sequence_id')) == '') add_option('videogall_sequence_id',0);

/**
 * Calling the options page
 */
require(VIDEOGALL_DIR_PATH.'admin/videogall-options.php');
$videogall_options = videogall_get_options();

/**
 * Migrate existing videos from DB to options
 */
require(VIDEOGALL_DIR_PATH.'inc/videogall-migrate.php');
videogall_migrate();

/**
 * Total video count
 */
$total_videos = videogall_count();

/**
 * Enqueue necessary javascripts & stylesheets
 */
function videogall_enqueue_scripts() {
    wp_register_style('videogall-shadowbox-style', VIDEOGALL_DIR_URL.'inc/shadowbox/shadowbox.css',false,false,'all');
    wp_enqueue_style('videogall-shadowbox-style');
    wp_register_style('videogall-default-style', VIDEOGALL_DIR_URL.'videogall.css','videogall-shadowbox-style',false,'all');
    wp_enqueue_style('videogall-default-style');
    wp_enqueue_script('jquery');    
    wp_register_script('videogall-shadowbox-js', VIDEOGALL_DIR_URL.'inc/shadowbox/shadowbox.js','jquery');
    wp_enqueue_script('videogall-shadowbox-js');
    wp_register_script('videogall-js', VIDEOGALL_DIR_URL.'js/videogall.js','jquery');
    wp_enqueue_script('videogall-js');
}
add_action('wp_enqueue_scripts', 'videogall_enqueue_scripts');

/**
 * Adding script & style code to head
 */
function videogall_init() {
    global $videogall_options;
    echo '<script type="text/javascript">'."\n";
    echo "\t".'Shadowbox.init();'."\n";
    echo '</script>'."\n";
}
add_action('wp_head','videogall_init');

/**
 * Creating video gallery
 */
function videogall_gallery($filter = '', $number_of_videos = '', $iswidget = false) {
    global $videogall_options, $total_videos;
    $video_list = get_option('videogall_videos');
    $video_size_option = explode("|",$videogall_options['video_size']);
    $thumbnail_size_option = explode("|",$videogall_options['thumbnail_size']);
    $video_width = $video_size_option[0];
    $video_height = $video_size_option[1];
    $thumbnail_width = $thumbnail_size_option[0];
    $thumbnail_height = $thumbnail_size_option[1];
    $videos_per_page = $videogall_options['videos_per_page'];
    $total_videos = videogall_count();
    if($videogall_options['enable_border'])
        $borderstyle = ' padding: 3px; background-color: #'.$videogall_options['border_color'].'; border: 1px #'.videogall_color_darken($videogall_options['border_color'],50).' solid;';
        else $borderstyle = '';
    $output = '';
    $count = 1;
    $page_num = 1;
    if($iswidget) $widget_class = ' videogall-widget-item'; else $widget_class = '';
    if($videogall_options['enable_pagination'] and $videos_per_page < $total_videos and !$iswidget)
        $output .= '<div class="videogall-page" id="videogall-page-1"> <!-- Start of first page -->'."\n";
    
    foreach($video_list as $entry) {            
        $rel = 'shadowbox';
        if($filter != '') $rel .= '['.strtolower($filter).']';
        elseif($entry['category'] != '') $rel .= '['.$entry['category'].']';
        $rel .= ';width='.$video_width.';height='.$video_height;
        if($filter != '' and strtoupper($filter) != strtoupper($entry['category'])) continue;
        $output .= '<div ref="popover" data-content="'.$entry['description'].'" data-original-title="'.$entry['caption'].'" class="videogall-item'.$widget_class.'" id="videogall-item-'.$entry['id'].'" style="width:'.$thumbnail_width.'px;">'."\n";
        $output .= "\t".'<a rel="'.$rel.'" class="videogall-'.$entry['category'].'" href="'.$entry['url'].'">
                        <img id="videogall-thumb-'.$entry['id'].'" class="videogall-thumb" src="'.$entry['thumbnail'].'" style="'.$borderstyle.'"/></a>'."\n";
         
        $output .= '</div>'."\n\n";
        
        if($videogall_options['enable_pagination'] and $videos_per_page < $total_videos and $count % $videos_per_page == 0 and $count < $total_videos and !$iswidget) {            $output .= '</div> <!-- End of page -->'."\n";            
            $page_num++;
            $output .= '<div class="videogall-page" id="videogall-page-'.$page_num.'"> <!-- Start of new page -->'."\n";
        }
        if($iswidget and $number_of_videos > 0 and $count >= $number_of_videos)
            break;
        $count++;        
    }
    
    if($videogall_options['enable_pagination'] and $videos_per_page < $total_videos and !$iswidget)
        $output .= '</div> <!-- End of last page-->'."\n";
    if($videogall_options['enable_pagination'] and $videos_per_page < $total_videos and !$iswidget) {
        $output .= '<div class="videogall-navigation clearfix"><span class="video-page-title">'.__('Pages: ','videogall').'</span>'."\n";
        for($i = 1; $i <= $page_num; $i++) {
            if($i == 1) $current = ' current-video-page'; else $current = '';
            $output .= "\t".'<a href="javascript:void(0)" id="videogall-nav-item-'.$i.'" class="videogall-nav-item'.$current.'">'.$i.'</a>'."\n";
        }
        $output .= '</div>'."\n";
    }    
    return $output;
}

/**
 * Displaying video gallery on Posts/Pages
 */
function videogall_output($content) {
    preg_match_all('/\[myvideogall:(.*)\]/',$content,$matches);
    for($i = 0; $i < count($matches[0]); $i++) {
        $shortcodestr = explode(":",$matches[0][$i]);
        $category = str_replace(']','',$shortcodestr[1]);
        if($category == 'all') $filter = ''; else $filter = $category;
        $content = str_ireplace("[myvideogall:$category]", videogall_gallery($filter), $content);
    }
    return $content;
}
add_filter('the_content','videogall_output');

/**
 * Adding Shadowbox Rel attribute to Images
 */
function videogall_add_image_shadowbox ($content) {
    $pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
    $replacement = '<a$1href=$2$3.$4$5 rel="shadowbox"$6>$7</a>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}
if($videogall_options['enable_shadowbox_images']) {
    add_filter('the_content','videogall_add_image_shadowbox');
}

/**
 * Count total videos
 */
function videogall_count() {
    $video_list = get_option('videogall_videos');
    return count($video_list);
}

/**
 * Function to return darker color shade
 */
function videogall_color_darken($color, $dif=80){
    $color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return '000000'; }
    $rgb = '';
    for ($x=0;$x<3;$x++){
        $c = hexdec(substr($color,(2*$x),2)) - $dif;
        $c = ($c < 0) ? 0 : dechex($c);
        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
    }
    return $rgb;
}

/**
 * Shortcode functions
 */
function videogall_add_shortcode() {
    if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
        add_filter('mce_external_plugins', 'videogall_add_shortcode_plugin');
        add_filter('mce_buttons', 'videogall_register_shortcode');
    }
}

function videogall_register_shortcode($buttons) {
    array_push($buttons,"videogall");
    return $buttons;
}

function videogall_add_shortcode_plugin($plugin_array) {
    $plugin_array['videogall'] = VIDEOGALL_DIR_URL.'js/videogall-shortcodes.js';
    return $plugin_array;
}

add_action('init','videogall_add_shortcode');

/**
 * Activating the widget
 */
function videogall_activate_widget() {
    require(VIDEOGALL_DIR_PATH.'videogall-widget.php');
}
add_action('widgets_init','videogall_activate_widget');

/* Making Plugin Translation Ready */
load_theme_textdomain('videogall', VIDEOGALL_DIR_PATH.'languages' );
?>