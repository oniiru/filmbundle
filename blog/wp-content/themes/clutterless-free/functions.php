<?php

// Clutterless Free functions.php index:

// 00. Defining
// 01. AJAX Loading Archive Posts
// 02. Set number of archive & search results
// 03. Exclude pages from search results
// 04. Enable sidebar
// 05. Theme Options
// 06. Enqueue Scripts and Styles
// 07. Your custom code
// 08. Theme Version Update Notifications

// -------------------------------------------------------------
// 00. Defining
// -------------------------------------------------------------

// Theme Version
define( 'CLUTTERLESS_THEME_VERSION' , '1.1' );

// Content Width
global $content_width;
if ( ! isset( $content_width ) ) $content_width = 600;

// -------------------------------------------------------------
// 02. Set number of archive & search results
// -------------------------------------------------------------

add_filter('pre_get_posts', 'clutterless_change_wp_search_size'); // Hook our custom function onto the request filter
function clutterless_change_wp_search_size($query) {
	if ( $query->is_search ) // Make sure it is a search page
	    $query->query_vars['posts_per_page'] = 100; // Change 100 to the number of posts you would like to show
	return $query; // Return our modified query variables
}

add_filter('pre_get_posts', 'clutterless_change_wp_archive_size'); // Hook our custom function onto the request filter
function clutterless_change_wp_archive_size($query) {
	if ( $query->is_archive ) // Make sure it is a search page
	    $query->query_vars['posts_per_page'] = 100; // Change 100 to the number of posts you would like to show
	return $query; // Return our modified query variables
}

// -------------------------------------------------------------
// 03. Exclude pages from search results
// -------------------------------------------------------------

add_filter('pre_get_posts','clutterless_mySearchFilter');
function clutterless_mySearchFilter($query) {
	 if ($query->is_search) {
	    $query->set('post_type', 'post');
	 }
	 return $query;
}

 // -------------------------------------------------------------
 // 04. Enable Widgets
 // -------------------------------------------------------------

add_action('widgets_init', 'clutterless_register_sidebars');
function clutterless_register_sidebars(){
	register_sidebar(array(
		'name' => 'Sidebar',
		'before_widget' => '<div class="sidebar-widget">',
		'after_widget' => '</div>',
		'before_title' => '<span class="sidebar-widget-title">',
		'after_title' => '</span>',
	));
}
 
 // -------------------------------------------------------------
 // 05. Theme Options
 // -------------------------------------------------------------

 add_action('admin_menu', 'clutterless_options_menu');
 function clutterless_options_menu() {
 	add_theme_page("Clutterless Options", "Options", 'edit_themes', basename(__FILE__), 'clutterless_options_page');
 }

function clutterless_options_page()
{
	if (@$_POST['update_themeoptions'] == 'true' ) {clutterless_themeoptions_update(); }
	?>
	<div class="wrap">
	  
	    <h2>Clutterless Free Theme Options</h2>
	    <?php
	    if (@$_POST['action'] == 'save') {
	    ?>
	    <div style="border-radius: 2px; height: 20px; width: 360px; background-color: #d8fcc4; text-align:center; padding:5px;">
	    Yay! Theme options updated.
	    </div>
	    <?php } ?>
	
	    <form method="POST" action="">
	        <input type="hidden" name="update_themeoptions" value="true" />
	
	        <p>Simply fill out as much as you can below, hit 'Update Options' at the bottom and you are winning!</p>
	        <p style="background: #fffed3; border: #feecab 1px dotted; padding: 20px; margin: 0 0 30px 0; color: #333;">
          <strong>Why not upgrade?</strong> The premium version of this theme is only $9 and includes:<br /><br />
          - Friendly Support<br />
          - Retina Optimization<br />
          - Theme Customizer style options<br />
          - Responsive Design that fits perfect on mobile<br />
          - Seamless Upgrade from Free version, no need to redo widgets, settings or options<br /><br />          
          Upgrade: 
          <a href="http://onepagelove.com/themes/clutterless" target="_blank" title="See Clutterless Premium Details">Clutterless Premium Theme Page</a> | 
          <a href="http://onepagelove.fetchapp.com/sell/ghooliel" target="_blank" title="Purchase Clutterless Premium">Direct PayPal Link</a> 
          </p>
	        
	        
	        <p><strong>Problems?</strong> Visit our <a href="http://onepagelove.com/themes/clutterless-documentation" target="_blank" title="See Clutterless Free Documentation">documentation online</a>.</p>
	        <br />
	
	        <h3>Image/Logo</h3>
	        <p><i>Full URL, recommended 48px x 48px</i></p>
	        <p><input type="text" name="logo" id="logo" size="40" value="<?php echo get_option('clutterless_logo'); ?>" /></p>
	        <br />
	
	        <h3>Favicon</h3>
	        <p><i>Full URL, recommended 32px x 32px</i></p>
	        <p><input type="text" name="favicon" id="favicon" size="40" value="<?php echo get_option('clutterless_favicon'); ?>" /></p>
	        <br />
	
	        <h3>About/Bio</h3>
	        <p><i>Why not keep it short 'n sweet...</i></p>
			<p><textarea name="bio" id="bio" cols="40" rows="5" value="<?php echo get_option('clutterless_bio'); ?>" /><?php echo get_option('clutterless_bio'); ?></textarea></p>
			<br />	
	
	        <h3>Statistics</h3>
	        <p><i>Tip: Simply paste in the full code given</i></p>
			<p><textarea name="analytics" id="analytics" cols="40" rows="5" value="<?php echo get_option('clutterless_analytics'); ?>" /><?php echo get_option('clutterless_analytics'); ?></textarea></p>
			<br />
	
	    <input type="hidden" name="action" value="save" />
	    <p><input type="submit" name="search" value="Update Options" class="button" /></p>
	  </form>
	
	 </div> <!-- #wrap -->
	
	 <?php
} 

function clutterless_themeoptions_update(){
	update_option('clutterless_logo', $_POST['logo']);
	update_option('clutterless_favicon', $_POST['favicon']);
	update_option('clutterless_bio', $_POST['bio']);
	update_option('clutterless_analytics', $_POST['analytics']);
}
 

// -------------------------------------------------------------
// 06. Enqueue Scripts and Styles
// -------------------------------------------------------------

add_action('wp_enqueue_scripts', 'clutterless_enqueue_scripts');
function clutterless_enqueue_scripts(){
	// Clutterless Stylesheet	
	wp_enqueue_style( 'clutterless', get_stylesheet_uri(), array(), CLUTTERLESS_THEME_VERSION );
	$fontscss = get_stylesheet_directory_uri() . '/fonts/fonts.css';
	

	// Clutterless Google Fonts
	wp_enqueue_style('google-webfonts-nc', 'http://fonts.googleapis.com/css?family=News+Cycle:400');
	wp_enqueue_style('google-webfonts-mw', 'http://fonts.googleapis.com/css?family=Merriweather:700');
	wp_enqueue_style('google-webfonts-os', 'http://fonts.googleapis.com/css?family=Open+Sans');
	wp_enqueue_style('fontsalright', $fontscss);
	
	
	// Clutterless Scripts
	$url = get_stylesheet_directory_uri() . '/js/';
	
	
	// Add your scripts below
	
	// Add your scriptsabove
}


// Favicon
add_action('wp_head', 'clutterless_favicon');
function clutterless_favicon(){
	$favicon = get_option('clutterless_favicon');
	if ($favicon != '') {
        ?><link rel="shortcut icon" href="<?php echo $favicon; ?>" /><?php
	}
}


// -------------------------------------------------------------
// 07. Your Custom Code
// -------------------------------------------------------------

/* Add you code below this line */




/* End your code above this line */

// -------------------------------------------------------------
// 08. Theme Version Update Notifications
// -------------------------------------------------------------

require_once('wp-updates-theme.php');
new WPUpdatesThemeUpdater( 'http://wp-updates.com/api/1/theme', 223, basename(get_template_directory()) );

add_theme_support( 'post-thumbnails' ); 
register_nav_menus( array(
	'header' => 'simple header nav',
	'leftthing' => 'Leftthing Nav',
	'slideout' => 'slideout nav'
) );

class FilmBundleBlog_ThemeFunctions
	{
	    const VERSION = '1.0';
	    private static $instance = false;

	    public static function getInstance()
	    {
	        if (!self::$instance) {
	            self::$instance = new self();
	        }
	        return self::$instance;
	    }

	    private function __construct()
	    {
	        add_action('wp_enqueue_scripts', array(&$this, 'scripts'));
	        add_shortcode('vimeo', array(&$this,'shortcodeVimeo'));
	        add_shortcode('youtube', array(&$this,'shortcodeYouTube'));
	    }

	    public function scripts()
	    {
	        wp_enqueue_script(
	            'filmbundle-social',
	            get_stylesheet_directory_uri().'/js/social.js',
	            array('jquery'), 
	            self::VERSION,
	            true
	        );
	    }

	    // -------------------------------------------------------------------------
	    // Shortcodes
	    // -------------------------------------------------------------------------
	    public function shortcodeVimeo($atts)
	    {
	        extract(
	            shortcode_atts(
	                array(
	                    'id' => '',
	                ),
	                $atts
	            )
	        );
	        $embed = "<iframe src=\"http://player.vimeo.com/video/{$id}?";
	        $embed .= "api=1&";
	        $embed .= "title=0&byline=0&portrait=0\" width=\"500\" height=\"281\"";
	        $embed .= "frameborder=\"0\"";
	        $embed .= "webkitAllowFullScreen mozallowfullscreen allowFullScreen>";
	        $embed .= "</iframe>";
	        return $embed;
	    }

	    public function shortcodeYouTube($atts)
	    {
	        extract(
	            shortcode_atts(
	                array(
	                    'id' => '',
	                ),
	                $atts
	            )
	        );

	        $embed = "
	            <div id=\"player_{$id}\" class=\"fit post_video_wrapper\"></div>
	            <script>
	                // Hides the player, until responsiveness is activated.
	                jQuery('#player_{$id}').hide();

	                // Setup a variable to keep track of initialization, to avoid
	                // infinite responsive loops
	                if (typeof yt_player_ready === 'undefined') {
	                    var yt_player_ready = [];
	                }
	                yt_player_ready['{$id}'] = false;

	                // Load the IFrame Player API code asynchronously.
	                var tag = document.createElement('script');

	                tag.src = \"https://www.youtube.com/iframe_api\";
	                var firstScriptTag = document.getElementsByTagName('script')[0];
	                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

	                // Create the iframe after the API code is downloaded.
	                var player_{$id};
	                function onYouTubeIframeAPIReady() {
	                    player_{$id} = new YT.Player('player_{$id}', {
	                        height: '315',
	                        width: '500',
	                        videoId: '{$id}',
	                        events: {
	                            'onReady': onYTPlayerReady,
	                            'onStateChange': onYTPlayerStateChange
	                        }
	                    });
	                }
	            </script>
	        ";
	        return $embed;
	    }
	}

	$fb_theme = FilmBundleBlog_ThemeFunctions::getInstance();

	include_once 'metaboxes/setup.php';

	include_once 'metaboxes/select-spec.php';

	/* eof */
	add_filter( 'pre_user_description', 'wp_filter_post_kses' );