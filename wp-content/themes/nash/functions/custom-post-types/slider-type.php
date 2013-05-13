<?php

if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 250, 250, true );
}

add_action('init', 'slider_register');  

function slider_register() {
    $labels = array(
        'name' => __('Slider', 'nash'),
        'add_new' => __('Add New', 'nash'),
        'add_new_item' => __('Add New Slider Item', 'nash'),
        'edit_item' => __('Edit Slider Item', 'nash'),
        'new_item' => __('New Slider Item', 'nash'),
        'view_item' => __('View Slider Item', 'nash'),
        'search_items' => __('Search Slider Items', 'nash'),
        'not_found' => __('No items found', 'nash'),
        'not_found_in_trash' => __('No items found in Trash', 'nash'), 
        'parent_item_colon' => '',
        'menu_name' => 'Slider'
        );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'rewrite' => true,
        'exclude_from_search' => true,
        'supports' => array('title','thumbnail')
       );  

    register_post_type( 'slider' , $args );
}

add_action('contextual_help', 'slider_help_text', 10, 3);
function slider_help_text($contextual_help, $screen_id, $screen) {
    if ('slider' == $screen->id) {
        $contextual_help =
        '<h3>' . __('Things to remember when adding a Slider item:', 'nash') . '</h3>' .
        '<ul>' .
        '<li>' . __('Give the item a title. This will aid in reference when viewing the list of slides.', 'nash') . '</li>' .
        '<li>' . __('Attach a Featured Image to use on your Slider.', 'nash') . '</li>' .
        '<li>' . __('Add a link to the slider item. This can be a link to a Portfolio item, or an external link.', 'nash') . '</li>' .
        '</ul>';
    }
    elseif ('edit-slider' == $screen->id) {
        $contextual_help = '<p>' . __('A list of all Slider items appear below. To edit an item, click on the items title.', 'nash') . '</p>';
    }
    return $contextual_help;
}

function slider_image_box() {
 	// Remove the orginal "Set Featured Image" Metabox
	remove_meta_box('postimagediv', 'slider', 'side');
 	// Add it again with another title
	add_meta_box('postimagediv', __('Slide Image', 'nash'), 'post_thumbnail_meta_box', 'slider', 'side', 'low');
}
add_action('do_meta_boxes', 'slider_image_box');

add_filter("manage_edit-slider_columns", "slider_edit_columns");   

function slider_edit_columns($columns){
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Title",
            "slide_link" => "Link",
        );  

        return $columns;
}

add_action("manage_posts_custom_column",  "slider_custom_columns"); 

function slider_custom_columns($column){
        global $post;
        switch ($column)
        {

            case "slide_link":
                $custom = get_post_custom();
                echo $custom["gt_slide_url"][0];
                break;
        }
}

function enable_slider_sort() {
    add_submenu_page('edit.php?post_type=slider', 'Sort Slider', 'Sort Slider Items', 'edit_posts', basename(__FILE__), 'sort_slider');
}
add_action('admin_menu' , 'enable_slider_sort'); 
 
function sort_slider() {
    $sliders = new WP_Query('post_type=slider&posts_per_page=-1&orderby=menu_order&order=ASC');
?>
    <div class="wrap">
    <div id="icon-tools" class="icon32"><br /></div>
    <h2><?php _e('Sort Slider Items', 'nash'); ?> <img src="<?php echo home_url(); ?>/wp-admin/images/loading.gif" id="loading-animation" /></h2>
    <p><?php _e('Click, drag, re-order. Repeat as neccessary. Slide item at the top will appear first on your slider.', 'nash'); ?></p>
    <ul id="post-list">
    <?php while ( $sliders->have_posts() ) : $sliders->the_post(); ?>
        <li id="<?php the_id(); ?>"><?php the_title(); ?></li>          
    <?php endwhile; ?>
    </div>
 
<?php
}

function slider_print_scripts() {
    global $pagenow;
 
    $pages = array('edit.php');
    if (in_array($pagenow, $pages)) {
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('slider-sorter', get_template_directory_uri().'/assets/js/jquery.posttype.sort.js');
    }
}
add_action( 'admin_print_scripts', 'slider_print_scripts' );
 
function slider_print_styles() {
    global $pagenow;
 
    $pages = array('edit.php');
    if (in_array($pagenow, $pages))
        wp_enqueue_style('style', get_template_directory_uri('template_url').'/assets/css/custom-admin.css');
}
add_action( 'admin_print_styles', 'slider_print_styles' );
 
 
function slider_save_order() {
    global $wpdb;
 
    $order = explode(',', $_POST['order']);
    $counter = 0;
 
    foreach ($order as $post_id) {
        $wpdb->update($wpdb->posts, array( 'menu_order' => $counter ), array( 'ID' => $post_id) );
        $counter++;
    }
    die(1);
}
add_action('wp_ajax_post_sort', 'slider_save_order');

?>