<?php
//change icons in dash
add_action('admin_head', 'md_port_icons');
function md_port_icons() {
        global $post_type;
        ?>
        <style>
        <?php if (($_GET['post_type'] == 'portfolio_post_type') || ($post_type == 'portfolio_post_type')) : ?>
        #icon-edit { background:transparent url('<?php echo get_template_directory_uri() .'/styles/images/icons/dash/port-lrg.png';?>') no-repeat 0 3px; }      
        <?php endif; ?>
        #adminmenu #menu-posts-portfolio_post_type div.wp-menu-image{background:transparent url("<?php echo get_template_directory_uri() .'/styles/images/icons/dash/port.png';?>") no-repeat center center;}
        #adminmenu #menu-posts-portfolio_post_type:hover div.wp-menu-image,#adminmenu #menu-posts-portfolio_post_type.wp-has-current-submenu div.wp-menu-image{background:transparent url("<?php echo get_template_directory_uri() .'/styles/images/icons/dash/port-hover.png';?>") no-repeat center center;}   

        </style>
        <?php
}

//Set up the custom post type
add_action('init', 'portfolio_register');  

function portfolio_register() {
    $args = array(
        'label' => __('Portfolio'),
        'singular_label' => __('Project'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => true,
        'supports' => array('title', 'editor', 'thumbnail')
       );  

    register_post_type( 'portfolio_post_type' , $args );
}

//Register a custom taxonomy for the portfolio
register_taxonomy("project-type", array("portfolio_post_type"), array("hierarchical" => true, "label" => "Project Types", "singular_label" => "Project Type", "rewrite" => true));
?>