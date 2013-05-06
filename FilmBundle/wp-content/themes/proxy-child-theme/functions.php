<?php
/* Set Max Content Width */
if ( ! isset( $content_width ) ) $content_width = 1170;

global $is_retina;
(isset($_COOKIE['retina']) && $_COOKIE['retina'] > 1) ? $is_retina = true : $is_retina = false;

/* Theme Setup */
if(!function_exists('stag_theme_setup')){
  function stag_theme_setup(){
    load_theme_textdomain('stag', get_template_directory().'/languages');

    $locale = get_locale();
    $locale_file = get_template_directory()."/languages/$locale.php";
    if(is_readable($locale_file)){
      require_once($locale_file);
    }

    add_editor_style('framework/css/editor-style.css');

    if(function_exists('add_theme_support')){
      add_theme_support( 'post-thumbnails' );
      set_post_thumbnail_size( 170, 160 ); // Normal post thumbnails
    }

    if(function_exists('add_image_size')){
      add_image_size( 'portfolio-thumb', 600, 400, true ); // Recent Posts thumbnail (homepage)
      add_image_size( 'team-thumb', 270, 390, true ); // Team Members thumbnail (homepage)
      // add_image_size( 'blog-thumb', 170, 160, false ); // Blog thumbnail (homepage)
    }
  }
}
add_action('after_setup_theme', 'stag_theme_setup');

add_theme_support( 'automatic-feed-links' );

/* Register Sidebar */
if(!function_exists('stag_sidebar_init')){
  function stag_sidebar_init(){

    register_sidebar(array(
      'name' => __('Other Widgets', 'stag'),
      'id' => 'sidebar-other',
      'before_widget' => '<div id="%1$s" class="widget grid-4 %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h3 class="widget-title">',
      'after_title' => '</h3>',
      'description' => __('All widgets excluding Homepage and Services widgets should be included in this sidebar.', 'stag')
    ));

    register_sidebar(array(
      'name' => __('Homepage Widgets', 'stag'),
      'id' => 'sidebar-homepage',
      'before_widget' => '',
      'after_widget' => '',
      'before_title' => '<h2 class="main-title">',
      'after_title' => '</h2>',
      'description' => __('Only include widgets whose name starts with Homepage:', 'stag')
    ));

    register_sidebar(array(
      'name' => __('Services Widgets', 'stag'),
      'id' => 'sidebar-services',
      'before_widget' => '',
      'after_widget' => '',
      'before_title' => '<h3 class="service-title">',
      'after_title' => '</h3>',
    ));

  }
}
add_action('widgets_init', 'stag_sidebar_init');

/* WordPress Title Filter */
if ( !function_exists( 'stag_wp_title' ) ) {
  function stag_wp_title($title) {
    if( !stag_check_third_party_seo() ){
      if( is_front_page() ){
        if(get_bloginfo('description') == ''){
          return get_bloginfo('name');
        }else{
          return get_bloginfo('name') .' | '. get_bloginfo('description');
        }
      } else {
        return trim($title) .' | '. get_bloginfo('name');
      }
    }
    return $title;
  }
}
add_filter('wp_title', 'stag_wp_title');

/* Register Menu */
function register_menu() {
  register_nav_menu('primary-menu', __('Primary Menu', 'stag'));
}
add_action('init', 'register_menu');

/* Register and load scripts */
function stag_enqueue_scripts(){
  if(!is_admin()){
    global $is_IE;
    wp_enqueue_script('jquery');
    wp_enqueue_script('script', get_template_directory_uri().'/assets/js/jquery.custom.js', array('jquery', 'superfish', 'supersubs', 'flexslider'), '', true);

    // Dropdown for Superfish
    wp_enqueue_script('superfish', get_template_directory_uri().'/assets/js/superfish.js', array('jquery'), '', true);
    wp_enqueue_script('supersubs', get_template_directory_uri().'/assets/js/supersubs.js', array('jquery'), '', true);

    // Theme Scripts
    wp_enqueue_script('viewport', get_template_directory_uri().'/assets/js/jquery.viewport.js', array('jquery'), '', true);
    wp_enqueue_script('retinajs', get_template_directory_uri().'/assets/js/retina.js', '', '', true);
    wp_enqueue_script('fitvids', get_template_directory_uri().'/assets/js/jquery.fitvids.js', array('jquery', 'script'), '1.0.1', true);
    wp_enqueue_script('prettify', get_template_directory_uri().'/assets/js/prettify.js', array('jquery', 'script'), '', true);

    // Flexslider
    wp_enqueue_script('flexslider', get_template_directory_uri().'/assets/js/jquery.flexslider-min.js', array('jquery'), '', true);
    wp_enqueue_style('flexslider', get_template_directory_uri().'/assets/css/flexslider.css');

    wp_enqueue_style('style', get_stylesheet_directory_uri().'/style.css');
    wp_enqueue_style('fonts', get_template_directory_uri().'/assets/fonts/fonts.css');
    wp_enqueue_style('user-style', get_template_directory_uri().'/assets/css/user-styles.php');

    if( is_singular() ) wp_enqueue_script( 'comment-reply' ); // loads the javascript required for threaded comments

    // IE Scripts
    if($is_IE){
      wp_enqueue_script('html5shiv', '//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js');
      wp_enqueue_script('selectivizr', '//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js');
      wp_enqueue_script('css3-mediaqueries', 'http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js');
    }

    // IE CSS
    if (strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 8")){
      wp_enqueue_style('ie8', get_template_directory_uri().'/assets/css/ie.css');
    }
  }
}
add_action('wp_enqueue_scripts', 'stag_enqueue_scripts');

function stag_menu_footer_scripts(){
  if(!is_home()){
    ?>
    <script type="text/javascript">
      jQuery(document).ready(function(jQuery){
        jQuery('#navigation a').each(function(){
          var re = /^#/g,
              that = jQuery(this),
              url = '<?php echo home_url(); ?>',
              attr = jQuery(this).attr('href');
          if(re.test(attr) === true){
            that.attr('href', url+"/"+attr);
          }
        });
      });
    </script>
    <?php
  }

  ?>
  <script>

  jQuery(document).ready(function(jQuery){
    jQuery('[data-bg]').each(function(){
      jQuery(this).css('background-color', jQuery(this).data('bg'));
      jQuery(".portfolio-content h3",this).css('background-color', jQuery(this).data('bg'));
    });
    jQuery('[data-color]').each(function(){
      jQuery(this).css('color', jQuery(this).data('color'));
      jQuery("h1,h2,h3,h4,h5,h6,.pubdate", this).css('color', jQuery(this).data('color'));
    });
    jQuery('[data-link]').each(function(){
      jQuery("a", this).css('color', jQuery(this).data('link'));
    });
  });

  </script>
  <?php
}
add_action('wp_footer', 'stag_menu_footer_scripts');


/* Custom text length */
function stag_trim_text($text, $cut, $suffix = '...') {
  if ($cut < strlen($text)) {
    return substr($text, '0', $cut) . $suffix;
  } else {
    return substr($text, '0', $cut);
  }
}

/* Pagination */
function pagination(){
  global $wp_query;
    $total_pages = $wp_query->max_num_pages;
    if($total_pages > 1){
      if ($total_pages > 1){
        $current_page = max(1, get_query_var('paged'));
        $return = paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_next' => false
          ));
        echo "<div class='pages'>{$return}</div>";
        }
  }else{
    return false;
  }
}


/* Comments */
function stag_comments($comment, $args, $depth) {

    $isByAuthor = false;

    if($comment->comment_author_email == get_the_author_meta('email')) {
        $isByAuthor = true;
    }

    $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>" class="the-comment">

     <div class="comment-body clearfix">
        <?php
          global $is_retina;
          if($is_retina){
            echo get_avatar($comment,$size='150');
          }else{
            echo get_avatar($comment,$size='100');
          }
        ?>

        <div class="inner-body">
            <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            <h3 class="comment-author"><?php echo get_comment_author_link(); ?></h3>
            <p class="comment-date"><?php echo get_comment_date("U"); ?></p>
            <?php if ($comment->comment_approved == '0') : ?>
               <em class="moderation"><?php _e('Your comment is awaiting moderation.', 'stag') ?></em>
            <?php endif; ?>
          <div class="comment-text">
            <?php comment_text() ?>
          </div>
        </div>
      </div>

     </div>

<?php
}

function stag_list_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment; ?>
<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }


// A little math stuff
function is_multiple($number, $multiple){
  return ($number % $multiple) == 0;
}

if(!function_exists('custom_excerpt_length')){
  function custom_excerpt_length( $length ) {
    return stag_get_option('general_post_excerpt_length');
  }
  add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
}

if(!function_exists('new_excerpt_more')){
  function new_excerpt_more($more) {
    global $post;
    return ' <a class="read-more" data-through="gateway" data-postid="'.$post->ID.'" href="'. get_permalink($post->ID) . '">'.stag_get_option('general_post_excerpt_text').'</a>';
  }
  add_filter('excerpt_more', 'new_excerpt_more');
}

function stag_social_class($value){
  $class = explode('_', $value);
  return end($class);
}

function stag_date($arg, $data = null){
  $return = date($arg, strtotime($data));
  return $return;
}

add_action('comment_post', 'ajaxify_comments',20, 2);
function ajaxify_comments($comment_ID, $comment_status){
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    //If AJAX Request Then
    switch($comment_status){
      case '0':

        //notify moderator of unapproved comment
        wp_notify_moderator($comment_ID);
        case '1': //Approved comment
        echo "success";
        $commentdata=&get_comment($comment_ID, ARRAY_A);
        $post=&get_post($commentdata['comment_post_ID']);
        wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
        break;

      default:
      echo "error";
    }
    exit;
  }
}

add_filter( 'get_comment_date', 'get_the_relative_time' );
function get_the_relative_time($time = null){
    if(is_null($time)) $time = get_the_time("U");

    $time_diff = date("U") - $time; // difference in second

    $second = 1;
    $minute = 60;
    $hour = 60*60;
    $day = 60*60*24;
    $week = 60*60*24*7;
    $month = 60*60*24*7*30;
    $year = 60*60*24*7*30*365;

    if ($time_diff <= 120) {
        $output = "now";
    } elseif ($time_diff > $second && $time_diff < $minute) {
        $output = round($time_diff/$second)." second";
    } elseif ($time_diff >= $minute && $time_diff < $hour) {
        $output = round($time_diff/$minute)." minute";
    } elseif ($time_diff >= $hour && $time_diff < $day) {
        $output = round($time_diff/$hour)." hour";
    } elseif ($time_diff >= $day && $time_diff < $week) {
        $output = round($time_diff/$day)." day";
    } elseif ($time_diff >= $week && $time_diff < $month) {
        $output = round($time_diff/$week)." week";
    } elseif ($time_diff >= $month && $time_diff < $year) {
        $output = round($time_diff/$month)." month";
    } elseif ($time_diff >= $year && $time_diff < $year*10) {
        $output = round($time_diff/$year)." year";
    } else{ $output = " more than a decade ago"; }

    if ($output <> "now") {
      $output = (substr($output,0,2)<>"1 ") ? $output."s" : $output;
      $output .= " ago";
    }

    return $output;
}

/* Include the StagFramework */
$tmpDir = get_stylesheet_directory();
require_once($tmpDir.'/framework/_init.php');
require_once($tmpDir.'/includes/_init.php');
require_once($tmpDir.'/includes/theme-customizer.php');
