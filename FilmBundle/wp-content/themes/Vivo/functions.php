<?php
//---------------------------------------------//
//					Call in functions		   //
//---------------------------------------------//
//Add custom post types
include("functions/custom-post-types/custom-post-type-portfolio.php");

//Add meta boxes
include("functions/meta-boxes/meta-box-portfolio.php");
include("functions/meta-boxes/meta-box-portfolio-cats.php");
include("functions/meta-boxes/meta-box-blog.php");
include("functions/meta-boxes/meta-box-page.php");

// Add shortcodes
include("functions/shortcodes/shortcodes-layout.php");
include("functions/shortcodes/shortcodes-styles.php");

// Add custom widgets
include("functions/widgets/widget-twitter.php");
include("functions/widgets/widget-flickr.php");
include("functions/widgets/widget-social.php");
include("functions/widgets/widget-video.php");

//Add custom TinyMCE buttons
include("functions/tinymce/shortcode-tinymce.php");

//--------------------------------------//
//	   		Options Framework     		//
//--------------------------------------//
/* Set the file path based on whether the Options Framework is in a parent theme or child theme */

if ( get_stylesheet_directory() == get_template_directory() ) {
	define('OF_FILEPATH', get_template_directory());
	define('OF_DIRECTORY', get_template_directory_uri());
} else {
	define('OF_FILEPATH', get_template_directory());
	define('OF_DIRECTORY', get_template_directory_uri());
}

/* These files build out the options interface.  Likely won't need to edit these. */

require_once (OF_FILEPATH . '/admin/admin-functions.php');		// Custom functions and plugins
require_once (OF_FILEPATH . '/admin/admin-interface.php');		// Admin Interfaces (options,framework, seo)

/* These files build out the theme specific options and associated functions. */

require_once (OF_FILEPATH . '/admin/theme-options.php'); 		// Options panel settings and custom settings
require_once (OF_FILEPATH . '/admin/theme-functions.php'); 	// Theme actions based on options settings

//---------------------------//
//	   Image sizes		     //
//---------------------------//
//Register thumbs
add_theme_support( 'post-thumbnails' );

// Custom thumbnail size
add_image_size('blog_index', 300, '', false); //blog index page and work items
add_image_size('blog_single', 670, '', false); //blog single page
add_image_size('gallery_index', 300, 200, true); //blog gallery on index page
 
//---------------------------//
//	   Post Formats		     //
//---------------------------//
 add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio' ) );


//---------------------------//
//	   Change login logo     //
//---------------------------//
if(get_option('of_login_logo')) { //If there is a cutom logo specified, use it
	function md_custom_login_logo() {
	  echo '<style type="text/css">
			  h1 a { background-image: url('.get_option('of_login_logo').') !important; }
			</style>';
	}
} else {
	function md_custom_login_logo() { //else use default custom logo
	  echo '<style type="text/css">
			  h1 a { background-image: url('.get_template_directory_uri().'/styles/images/general/admin_logo.png) !important; }
			</style>';
	}
}
function md_change_login_url() { //change the link of the logo
	echo home_url();
}

function md_change_login_title() { //change the title of the logo
	echo get_option('blogname');
}

add_action('login_head', 'md_custom_login_logo');
add_filter('login_headerurl', 'md_change_login_url');
add_filter('login_headertitle', 'md_change_login_title');

//---------------------------//
//	   Google Analytics      //
//---------------------------//
if (get_option('of_google_analytics') != "") {
	add_action('wp_footer', 'add_googleanalytics');
	function add_googleanalytics() {
	get_option('of_google_analytics');
	}
}

//---------------------------//
// Make theme WP3 Menu ready //
//---------------------------//
add_action('init', 'register_menus');

function register_menus() {
	register_nav_menus(
		array(
		'primary-menu' => __('Primary Menu')
		)
	);
}

//---------------------------//
//  Make theme widget ready  //
//---------------------------//
if(function_exists('register_sidebar')){	
	register_sidebar(array(
		'name' => 'Hidden Widget',
		'before_widget'=>'<div class="sidebar_block clearfix">',
		'after_widget'=>'</div><div class="divider"></div>',
		'before_title'=>'<h4>',
		'after_title'=>'</h4>',
	));
}

//-------------------------------//
//	        Enqueue CSS          //
//-------------------------------//

function enqueue_css() {
	wp_enqueue_style('glegoo_font', 'http://fonts.googleapis.com/css?family=Glegoo');
	wp_enqueue_style('rokkitt_font', 'http://fonts.googleapis.com/css?family=Rokkitt');
	wp_enqueue_style('selected_font', 'http://fonts.googleapis.com/css?family=' . get_option('of_font') . '');
	wp_enqueue_style('default_styles_css', get_template_directory_uri() .'/styles/default-styles.css');
	wp_enqueue_style('responsiveness', get_template_directory_uri() .'/styles/responsiveness.css');
	wp_enqueue_style('flexslider_css', get_template_directory_uri() .'/styles/flexslider.css');

	//Load custom CSS if provided
	if (get_option('of_custom_css') != "") {
		wp_enqueue_style('custom_css', get_template_directory_uri() .'/styles/custom-css.php');
	}

	//Load any alt colour skin
	$alt_style = get_option('of_alt_style');
	if ($alt_style != 'default') { //if a stylesheet other than default is selected in theme options, load it
		wp_enqueue_style('alt_style_css', get_template_directory_uri() .'/styles/colours/alt-' . get_option('of_alt_style') . '.php');
	}

}
add_action('wp_print_styles', 'enqueue_css');

//-------------------------------//
//	        Register JS          //
//-------------------------------//

function register_js() {
	if (!is_admin()) {
		wp_deregister_script('jquery');
		//Register Scripts
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
		wp_register_script('gmaps', 'http://maps.google.com/maps/api/js?sensor=false');
		wp_register_script('scripts', get_template_directory_uri() . '/js/scripts.js', 'jquery');
		wp_register_script('superfish', get_template_directory_uri() . '/js/superfish.js', 'superfish');
		wp_register_script('prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', 'jquery');
		wp_register_script('validate', get_template_directory_uri() . '/js/jquery.validate.min.js', 'jquery');
		wp_register_script('verif', get_template_directory_uri() . '/js/verif.js', 'jquery');
		wp_register_script('easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', 'jquery');
		wp_register_script('jplayer', get_template_directory_uri() . '/js/jquery.jplayer.min.js', 'jquery');
		wp_register_script('tabs', get_template_directory_uri() . '/js/jquery.idTabs.min.js', 'jquery');
		wp_register_script('flexSlider', get_template_directory_uri() . '/js/jquery.flexslider.js', 'flexSlider');
		wp_register_script('isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', 'isotope');
		//Enqueue Scripts
		wp_enqueue_script('jquery');
		wp_enqueue_script('gmaps');
		wp_enqueue_script('scripts');
		wp_enqueue_script('superfish');
		wp_enqueue_script('prettyphoto');
		wp_enqueue_script('validate');
		wp_enqueue_script('verif');
		wp_enqueue_script('easing');
		wp_enqueue_script('jplayer');
		wp_enqueue_script('tabs');
		wp_enqueue_script('flexSlider');
		wp_enqueue_script('isotope');
	}
	if (is_admin()) {
		wp_enqueue_script('admin-scripts', get_template_directory_uri().'/js/admin-scripts.js');
		wp_enqueue_script('jquery-ui-sortable');
	}
}
add_action('init', 'register_js');

//Set max content width
if ( ! isset( $content_width ) ) $content_width = 620;

//-------------------------------//
//    Change excerpt length      //
//-------------------------------//
add_filter('excerpt_length', 'my_excerpt_length');

function my_excerpt_length($length) {
	return 23; 
}

add_filter('excerpt_more', 'new_excerpt_more');  

function new_excerpt_more($text){ 
	return '...';  
}

//used to grab the posts screenshot
function portfolio_thumbnail_url($pid){
	$image_id = get_post_thumbnail_id($pid);
	$image_url = wp_get_attachment_image_src($image_id,'full');
	return  $image_url[0];
}

//The following removes auto inserting of P tags in shortcodes//
function my_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

add_filter('the_content', 'my_formatter', 99);


//----------------------------------//
//    		Paged function     		//
//----------------------------------//
function number_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {

         echo "<div class='pagination clearfix'>";
         echo "<p>Go to page...</p>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}

/*****
	Time ago function
	http://www.jasonbobich.com/wordpress/a-better-way-to-add-time-ago-to-your-wordpress-theme/
*****/

function mb_time_ago() {
 
	global $post;
 
	$date = get_post_time('G', true, $post);
 
	// Array of time period chunks
	$chunks = array(
		array( 60 * 60 * 24 * 365 , __( 'year', 'mb' ), __( 'years', 'mb' ) ),
		array( 60 * 60 * 24 * 30 , __( 'month', 'mb' ), __( 'months', 'mb' ) ),
		array( 60 * 60 * 24 * 7, __( 'week', 'mb' ), __( 'weeks', 'mb' ) ),
		array( 60 * 60 * 24 , __( 'day', 'mb' ), __( 'days', 'mb' ) ),
		array( 60 * 60 , __( 'hour', 'mb' ), __( 'hours', 'mb' ) ),
		array( 60 , __( 'minute', 'mb' ), __( 'minutes', 'mb' ) ),
		array( 1, __( 'second', 'mb' ), __( 'seconds', 'mb' ) )
	);
 
	if ( !is_numeric( $date ) ) {
		$time_chunks = explode( ':', str_replace( ' ', ':', $date ) );
		$date_chunks = explode( '-', str_replace( ' ', '-', $date ) );
		$date = gmmktime( (int)$time_chunks[1], (int)$time_chunks[2], (int)$time_chunks[3], (int)$date_chunks[1], (int)$date_chunks[2], (int)$date_chunks[0] );
	}
 
	$current_time = current_time( 'mysql', $gmt = 0 );
	$newer_date = strtotime( $current_time );
 
	// Difference in seconds
	$since = $newer_date - $date;
 
	// Something went wrong with date calculation and we ended up with a negative date.
	if ( 0 > $since )
		return __( 'sometime', 'mb' );
 
	/**
	 * We only want to output one chunks of time here, eg:
	 * x years
	 * xx months
	 * so there's only one bit of calculation below:
	 */
 
	//Step one: the first chunk
	for ( $i = 0, $j = count($chunks); $i < $j; $i++) {
		$seconds = $chunks[$i][0];
 
		// Finding the biggest chunk (if the chunk fits, break)
		if ( ( $count = floor($since / $seconds) ) != 0 )
			break;
	}
 
	// Set output var
	$output = ( 1 == $count ) ? '1 '. $chunks[$i][1] : $count . ' ' . $chunks[$i][2];
 
 
	if ( !(int)trim($output) ){
		$output = '0 ' . __( 'seconds', 'mb' );
	}
 
	$output .= __(' ago', 'mb');
 
	return $output;
}
 
/*****
	Filter our mb_time_ago() function into WP's the_time() function
*****/
add_filter('the_time', 'mb_time_ago');

/*****
	Other theme support
*****/
add_theme_support( 'automatic-feed-links' );

/*****
	Post liking
*****/
add_action('wp_ajax_nopriv_post-like', 'post_like');
add_action('wp_ajax_post-like', 'post_like');

wp_enqueue_script('like_post', get_template_directory_uri().'/js/post-like.js', array('jquery'), '1.0', true );
wp_localize_script('like_post', 'ajax_var', array(
	'url' => admin_url('admin-ajax.php'),
	'nonce' => wp_create_nonce('ajax-nonce')
));

function post_like()
{
	// Check for nonce security
	$nonce = $_POST['nonce'];
 
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Busted!');
	
	if(isset($_POST['post_like']))
	{
		// Retrieve user IP address
		$ip = $_SERVER['REMOTE_ADDR'];
		$post_id = $_POST['post_id'];
		
		// Get voters'IPs for the current post
		$meta_IP = get_post_meta($post_id, "voted_IP");
		$voted_IP = $meta_IP[0];

		if(!is_array($voted_IP))
			$voted_IP = array();
		
		// Get votes count for the current post
		$meta_count = get_post_meta($post_id, "votes_count", true);

		// Use has already voted ?
		if(!hasAlreadyVoted($post_id))
		{
			$voted_IP[$ip] = time();

			// Save IP and increase votes count
			update_post_meta($post_id, "voted_IP", $voted_IP);
			update_post_meta($post_id, "votes_count", ++$meta_count);
			
			// Display count (ie jQuery return value)
			echo $meta_count;
		}
		else
			echo "already";
	}
	exit;
}

$timebeforerevote = get_option('of_like_time'); // in mins

function hasAlreadyVoted($post_id)
{
	global $timebeforerevote;

	// Retrieve post votes IPs
	$meta_IP = get_post_meta($post_id, "voted_IP");
	$voted_IP = $meta_IP[0];
	
	if(!is_array($voted_IP))
		$voted_IP = array();
		
	// Retrieve current user IP
	$ip = $_SERVER['REMOTE_ADDR'];
	
	// If user has already voted
	if(in_array($ip, array_keys($voted_IP)))
	{
		$time = $voted_IP[$ip];
		$now = time();
		
		// Compare between current time and vote time
		if(round(($now - $time) / 60) > $timebeforerevote)
			return false;
			
		return true;
	}
	
	return false;
}

function getPostLikeLink($post_id)
{
	if(get_option('of_post_liking') == 'false') {
		$themename = "vivo";

		$vote_count = get_post_meta($post_id, "votes_count", true);

		$output = '<span class="post-like">';
		if(hasAlreadyVoted($post_id))
			$output .= ' <span title="'.__('I like this article', $themename).'" class="like alreadyvoted"></span>
			<span class="count alreadyvoted_text">'.$vote_count.'</span></span>';
		else
			$output .= '<a href="#" data-post_id="'.$post_id.'">
						<span  title="'.__('I like this article', $themename).'"class="qtip like"></span>
						<span class="count">'.$vote_count.'</span></span>
						</a>';
		
		return $output;
	}
}
/***** End *****/
?>
<?php 
if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'countDown',
		'id'   => 'countdowndiv',
		'description'   => 'This is where the countdown goes.',
		'before_widget' => '<div id="countdown" class="widget-countdown">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));

}
	if (function_exists('register_sidebar')) {

		register_sidebar(array(
			'name' => 'Login',
			'id'   => 'Loginthing',
			'description'   => 'Login Dropdown',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>'
		));
}
?>