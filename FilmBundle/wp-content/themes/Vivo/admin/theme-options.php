<?php
add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options(){
	
// VARIABLES
$themename = wp_get_theme(STYLESHEETPATH . '/style.css');
$themename = $themename['Name'];
$shortname = "of";

// Populate OptionsFramework option in array for use in theme
global $of_options;
$of_options = get_option('of_options');

$GLOBALS['template_path'] = OF_DIRECTORY;

//Access the WordPress Categories via an Array
$of_categories = array();  
$of_categories_obj = get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
$categories_tmp = array_unshift($of_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$of_pages = array();
$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($of_pages_obj as $of_page) {
    $of_pages[$of_page->ID] = $of_page->post_name; }
$of_pages_tmp = array_unshift($of_pages, "Select a page:");       

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post"); 

//Testing 
$options_select = array("one","two","three","four","five"); 
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 

//More Options
$uploads_arr = wp_upload_dir();
$all_uploads_path = $uploads_arr['path'];
$all_uploads = get_option('of_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

// Set the Options Array
$options = array();

$options[] = array( "name" => "General Settings",
                    "type" => "heading");
					
$options[] = array( "name" => "Custom Logo",
					"desc" => "Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload");
					
$options[] = array( "name" => "Logo Text Colour",
					"desc" => "Logo text colour if no custom logo specified (default #222222).",
					"id" => $shortname."_logo_text_colour",
					"std" => "#222222",
					"type" => "color");
					
$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload");
					
$options[] = array( "name" => "Widget Area text",
					"desc" => "Enter the text to appear at the bottom of the widget area.",
					"id" => $shortname."_foot_text",
					"std" => "",
					"type" => "textarea");
					
$options[] = array( "name" => "Google Analytics",
					"desc" => "Paste your Google Analytics tracking code here.",
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");
					
$options[] = array( "name" => "Hide widget area?",
					"desc" => "Tick this box to DISABLE the widget area (What slides in from left)",
					"id" => $shortname."_widget_off",
					"std" => "false",
					"type" => "checkbox");
					
$options[] = array( "name" => "Hide page titles?",
					"desc" => "Tick this box to DISABLE page titles",
					"id" => $shortname."_titles_off",
					"std" => "false",
					"type" => "checkbox");
						
						
						
$options[] = array( "name" => "Styling",
					"type" => "heading");
					
$options[] = array( "name" => "Navigation Style",
					"desc" => "Choose the navigation style you'd like to use (Light or Dark).",
					"id" => $shortname."_nav_style",
					"std" => "light",
					"type" => "select",
					"options" => array(
						'light' => 'light',
						'dark' => 'dark'
					));
					
$options[] = array( "name" => "Accent colours",
					"desc" => "Select pre-defined accent colours. <br/><strong>If default is selected, the below accent styles will apply.</strong>",
					"id" => $shortname."_alt_style",
					"std" => "orange",
					"type" => "select",
					"options" => array(
						'' => 'default',
						'black' => 'black',
						'blue' => 'blue',
						'cyan' => 'cyan',
						'green' => 'green',
						'grey' => 'grey',
						'orange' => 'orange',
						'pink' => 'pink',
						'purple' => 'purple',
						'red' => 'red',
						'yellow' => 'yellow'
					));

$options[] = array( "name" => "Accent colour",
					"desc" => "Colour used around the site to accent certain details and for links (default #ff5900). <br/><strong>If a style above is selected, these styles will be overridden.</strong>",
					"id" => $shortname."_link_colour",
					"std" => "#ff5900",
					"type" => "color"); 

$options[] = array( "name" => "Links hover",
					"desc" => "Link hover colour (default #db2100).",
					"id" => $shortname."_linkhov_colour",
					"std" => "#db2100",
					"type" => "color"); 
					
$options[] = array( "name" => "Custom CSS",
					"desc" => "Add some custom CSS to the theme by adding it here.",
					"id" => $shortname."_custom_css",
					"std" => "",
					"type" => "textarea");


					
$options[] = array( "name" => "Fonts",
					"type" => "heading");
					
$options[] = array( "name" => "Font Select",
					"desc" => "Select a font to be used for page titles and the homepage intro.",
					"id" => $shortname."_font",
					"std" => "Open Sans",
					"type" => "select",
					"options" => array(
						'Anonymous Pro' => 'Anonymous Pro',
						'Arvo' => 'Arvo',
						'Capriola' => 'Capriola',
						'Chivo' => 'Chivo',
						'Enriqueta' => 'Enriqueta',
						'Fresca' => 'Fresca',
						'Hammersmith One' => 'Hammersmith One',
						'Karla' => 'Karla',
						'Kreon' => 'Kreon',
						'Lekton' => 'Lekton',
						'Nunito' => 'Nunito',
						'Open Sans' => 'Open Sans',
						'Oswald' => 'Oswald',
						'Quando' => 'Quando',
						'Rokkitt' => 'Rokkitt',
						'Ropa Sans' => 'Ropa Sans'
					));   



$options[] = array(	"name" => "Background",
					"type" => "heading");

$options_bg = array("colour" => "Colour","pattern" => "Pattern","up_pat" => "Uploaded Pattern","up_image" => "Uploaded Image");                                                      

$options[] = array( "name" => "Background shows...",
					"desc" => "Select whether your sites background uses the solid colour, pattern, your uploaded pattern or uploaded image.",
					"id" => $shortname."_bg_shows",
					"std" => "pattern",
					"type" => "select2",
					"options" => $options_bg);  

$options[] = array( "name" => "Background colour",
					"desc" => "Select the colour for the sites background. (Only applies if no pattern is selected below)",
					"id" => $shortname."_bg_colour",
					"std" => "#eaf3f5",
					"type" => "color"); 

$url =  get_stylesheet_directory_uri() . '/admin/images/';					
$options[] = array( "name" => "Background Pattern",
					"desc" => "Select the background pattern to use. Or upload your own below.",
					"id" => $shortname."_background_pattern",
					"std" => "light_1",
					"type" => "images",
					"options" => array(
						'' => $url . 'patterns/none.png',
						'black_twill' => $url . 'patterns/black_twill.png',
						'dark_wood' => $url . 'patterns/dark_wood.png',
						'diagmonds' => $url . 'patterns/diagmonds.png',
						'dirty_old_shirt' => $url . 'patterns/dirty_old_shirt.png',
						'low_contrast_linen' => $url . 'patterns/low_contrast_linen.png',
						'px_by_Gre3g' => $url . 'patterns/px_by_Gre3g.png',
						'tasky_pattern' => $url . 'patterns/tasky_pattern.png',
						'type' => $url . 'patterns/type.png',
						'use_your_illusion' => $url . 'patterns/use_your_illusion.png',
						'light_1' => $url . 'patterns/light_1.png',
						'batthern' => $url . 'patterns/batthern.png',
						'bright_squares' => $url . 'patterns/bright_squares.png',
						'checkered_pattern' => $url . 'patterns/checkered_pattern.png',
						'climpek' => $url . 'patterns/climpek.png',
						'connect' => $url . 'patterns/connect.png',
						'cubes' => $url . 'patterns/cubes.png',
						'diagonal_noise' => $url . 'patterns/diagonal_noise.png',
						'double_lined' => $url . 'patterns/double_lined.png',
						'gplaypattern' => $url . 'patterns/gplaypattern.png',
						'light_wool' => $url . 'patterns/light_wool.png',
						'pinstripe' => $url . 'patterns/pinstripe.png',
						'project_paper' => $url . 'patterns/project_paper.png',
						'small_crosses' => $url . 'patterns/small_crosses.png',
						'subtle_freckles' => $url . 'patterns/subtle_freckles.png',
						'tiny_grid' => $url . 'patterns/tiny_grid.png',
						'vichy' => $url . 'patterns/vichy.png',
						'wavecut' => $url . 'patterns/wavecut.png',
						'white_carbon' => $url . 'patterns/white_carbon.png',
						'white_diamond' => $url . 'patterns/white_diamond.png',
						'whitey' => $url . 'patterns/whitey.png',
						'wood' => $url . 'patterns/wood.png'));
					
$options[] = array( "name" => "Custom Background Pattern",
					"desc" => "Upload a repeatable background pattern. (Will override the above selections)",
					"id" => $shortname."_bg_upload_pat",
					"std" => "",
					"type" => "upload"); 
					
$options[] = array( "name" => "Custom Background Image (Full Screen)",
					"desc" => "Upload a large background image for your site. (Will override the above selections)",
					"id" => $shortname."_bg_upload_full",
					"std" => "",
					"type" => "upload");

					
					
$options[] = array( "name" => "Work",
					"type" => "heading");
					
$options[] = array( "name" => "Portfolio Link",
					"desc" => "Enter the link of your portfolio page, this will enable the back to portfolio button on project pages. To get your portfolio link head to your portfolio page in the admin of WordPress and copy the Permalink below the page title",
					"id" => $shortname."_portfolio_link",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Amount to show",
					"desc" => "Select how many of the latest portfolio items you would like to display on each portfolio page. Select -1 to show all",
					"id" => $shortname."_port_items_to_show",
					"std" => "9",
					"type" => "select",
					"options" => array(
						'-1' => '-1', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10',
						'11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20'	));

$options[] = array( "name" => "Project Link text",
					"desc" => "Change the text of the link to live project (Default: Visit Project &rarr;)",
					"id" => $shortname."_port_proj_link",
					"std" => "Visit Project &rarr;",
					"type" => "text");
					
$options[] = array( "name" => "Project Link unavailable text",
					"desc" => "Change the text when no link to live project is available (Default: Live Link Unavailable)",
					"id" => $shortname."_port_proj_nolink",
					"std" => "Live Link Unavailable",
					"type" => "text");
						


$options[] = array( "name" => "Contact",
					"type" => "heading");
					
$options[] = array( "name" => "Google Maps Location",
					"desc" => "Enter the location, for better results use the <a href=\"http://gmaps-samples.googlecode.com/svn/trunk/geocoder/singlegeocode.html\" target=\"_blank\">Google GeoCode</a> site and copy/paste the latitude/longitude from the speach bubble.<br/><br/>Leave blank to disable.",
					"id" => $shortname."_maps_location",
					"std" => "51.500152,-0.126236",
					"type" => "text");
					
$options[] = array( "name" => "Map Zoom",
					"desc" => "Select the level of zoom<br/><br/>( 0 = the whole world, 21 = most detailed).",
					"id" => $shortname."_maps_zoom",
					"std" => "14",
					"type" => "select",
					"options" => array(
						'0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10',
						'11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21'	));
					
$options[] = array( "name" => "Map Type",
					"desc" => "Select the type of map to use.",
					"id" => $shortname."_maps_type",
					"std" => "Roadmap",
					"type" => "select",
					"options" => array(
						'Roadmap' => 'Roadmap',
						'Satellite' => 'Satellite',
						'Terrain' => 'Terrain',
						'Hybrid' => 'Hybrid'
					));
					
$options[] = array( "name" => "Email address",
					"desc" => "Enter the email address you would like to receive emails to, from your contact page and which will be displayed around the site",
					"id" => $shortname."_email",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Address",
					"desc" => "Enter your address to be displayed around the site",
					"id" => $shortname."_address",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Phone Number",
					"desc" => "Enter your phone number to be displayed around the site",
					"id" => $shortname."_phone",
					"std" => "",
					"type" => "text");
					
					
					
$options[] = array( "name" => "Social Media",
					"type" => "heading");

$options[] = array( "name" => "Facebook",
					"desc" => "Enter the username of the Facebook account to link to",
					"id" => $shortname."_sm_facebook",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Vimeo",
					"desc" => "Enter the username of the Vimeo account to link to",
					"id" => $shortname."_sm_vimeo",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Twitter",
					"desc" => "Enter the username of the Twitter account to link to",
					"id" => $shortname."_sm_twitter",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Tumblr",
					"desc" => "Enter the username of the Tumblr account to link to",
					"id" => $shortname."_sm_tumblr",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "LinkedIn",
					"desc" => "Enter the FULL link of the LinkedIn profile to link to",
					"id" => $shortname."_sm_linkedin",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Flickr",
					"desc" => "Enter the username of the Flickr account to link to",
					"id" => $shortname."_sm_flickr",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Dribbble",
					"desc" => "Enter the username of the Dribbble account to link to",
					"id" => $shortname."_sm_dribbble",
					"std" => "",
					"type" => "text");		

$options[] = array( "name" => "RSS",
					"desc" => "Enter the link of the RSS feed to link to",
					"id" => $shortname."_sm_rss",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "DeviantArt",
					"desc" => "Enter the username of the DeviantArt account to link to",
					"id" => $shortname."_sm_devart",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Forrst",
					"desc" => "Enter the username of the Forrst account to link to",
					"id" => $shortname."_sm_forrst",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Google",
					"desc" => "Enter the username of the Google account to link to",
					"id" => $shortname."_sm_google",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "LastFM",
					"desc" => "Enter the username of the LastFM account to link to",
					"id" => $shortname."_sm_lastfm",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "MySpace",
					"desc" => "Enter the username of the MySpace account to link to",
					"id" => $shortname."_sm_myspace",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Pinterest",
					"desc" => "Enter the username of the Pinterest account to link to",
					"id" => $shortname."_sm_pinterest",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Skype",
					"desc" => "Enter the username of the Skype account to link to",
					"id" => $shortname."_sm_skype",
					"std" => "",
					"type" => "text");		

$options[] = array( "name" => "YouTube",
					"desc" => "Enter the link of the YouTube account to link to",
					"id" => $shortname."_sm_youtube",
					"std" => "",
					"type" => "text");
					
								

$options[] = array( "name" => "Miscellaneous",
					"type" => "heading");
					
$options[] = array( "name" => "Turn off post 'liking'?",
					"desc" => "Tick this box to DISABLE post 'liking'",
					"id" => $shortname."_post_liking",
					"std" => "false",
					"type" => "checkbox");		

$options[] = array( "name" => "Time between 'likes'",
					"desc" => "Enter the time which must pass before users can vote again after placing a vote (in minutes)</br></br><strong>1 hour = 60</br>24 hours = 1440</br>1 week = 10080</br>2 weeks = 20160</strong>",
					"id" => $shortname."_like_time",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Blog Link",
					"desc" => "Enter the link of your blog page, this will enable the back to blog button on single post pages. To get your blog link head to your blog page in the admin of WordPress and copy the Permalink below the page title",
					"id" => $shortname."_blog_link",
					"std" => "20160",
					"type" => "text");
					
$options[] = array( "name" => "Hide author info box?",
					"desc" => "Tick this box to DISABLE the author info box on posts. <br/><strong>Enter info to appear in the author info box by heading to Users > Your Profile.</strong>",
					"id" => $shortname."_auth_info_off",
					"std" => "true",
					"type" => "checkbox");
					
$options[] = array( "name" => "Custom Login Logo",
					"desc" => "Upload a logo to appear on the admin login page, or specify the image address of your online logo. (http://yoursite.com/logo.png). The image must be no larget than 326px x 67px.",
					"id" => $shortname."_login_logo",
					"std" => "",
					"type" => "upload");
					
					
					
/*			
$options[] = array( "name" => "Styling Options",
					"type" => "heading");
				
$options[] = array( "name" => "Custom CSS",
                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
                    "id" => $shortname."_custom_css",
                    "std" => "",
                    "type" => "textarea");
$options[] = array( "name" => "Footer Options",
					"type" => "heading");      

$options[] = array( "name" => "Enable Custom Footer (Left)",
					"desc" => "Activate to add the custom text below to the theme footer.",
					"id" => $shortname."_footer_left",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => "Custom Text (Left)",
					"desc" => "Custom HTML and Text that will appear in the footer of your theme.",
					"id" => $shortname."_footer_left_text",
					"std" => "",
					"type" => "textarea");
						
$options[] = array( "name" => "Enable Custom Footer (Right)",
					"desc" => "Activate to add the custom text below to the theme footer.",
					"id" => $shortname."_footer_right",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => "Custom Text (Right)",
					"desc" => "Custom HTML and Text that will appear in the footer of your theme.",
					"id" => $shortname."_footer_right_text",
					"std" => "",
					"type" => "textarea");
					
					
					
$options[] = array( "name" => "Example Options",
					"type" => "heading"); 	   

$options[] = array( "name" => "Typograpy",
					"desc" => "This is a typographic specific option.",
					"id" => $shortname."_typograpy",
					"std" => array('size' => '16','unit' => 'em','face' => 'verdana','style' => 'bold italic','color' => '#123456'),
					"type" => "typography");  
					
$options[] = array( "name" => "Border",
					"desc" => "This is a border specific option.",
					"id" => $shortname."_border",
					"std" => array('width' => '2','style' => 'dotted','color' => '#444444'),
					"type" => "border");      
					
$options[] = array( "name" => "Colorpicker",
					"desc" => "No color selected.",
					"id" => $shortname."_example_colorpicker",
					"std" => "",
					"type" => "color"); 
					
$options[] = array( "name" => "Colorpicker (default #2098a8)",
					"desc" => "Color selected.",
					"id" => $shortname."_example_colorpicker_2",
					"std" => "#2098a8",
					"type" => "color");          
                    
$options[] = array( "name" => "Upload Basic",
					"desc" => "An image uploader without text input.",
					"id" => $shortname."_uploader",
					"std" => "",
					"type" => "upload_min");     
                                    
$options[] = array( "name" => "Input Text",
					"desc" => "A text input field.",
					"id" => $shortname."_test_text",
					"std" => "Default Value",
					"type" => "text"); 
                                        
$options[] = array( "name" => "Input Checkbox (false)",
					"desc" => "Example checkbox with false selected.",
					"id" => $shortname."_example_checkbox_false",
					"std" => "false",
					"type" => "checkbox");    
                                        
$options[] = array( "name" => "Input Checkbox (true)",
					"desc" => "Example checkbox with true selected.",
					"id" => $shortname."_example_checkbox_true",
					"std" => "true",
					"type" => "checkbox"); 
                                                                               
$options[] = array( "name" => "Input Select Small",
					"desc" => "Small Select Box.",
					"id" => $shortname."_example_select",
					"std" => "three",
					"type" => "select",
					"class" => "mini", //mini, tiny, small
					"options" => $options_select);                                                          

$options[] = array( "name" => "Input Select Wide",
					"desc" => "A wider select box.",
					"id" => $shortname."_example_select_wide",
					"std" => "two",
					"type" => "select2",
					"options" => $options_radio);    

$options[] = array( "name" => "Input Radio (one)",
					"desc" => "Radio select with default of 'one'.",
					"id" => $shortname."_example_radio",
					"std" => "one",
					"type" => "radio",
					"options" => $options_radio);
					
$url =  get_bloginfo('stylesheet_directory') . '/admin/images/';
$options[] = array( "name" => "Image Select",
					"desc" => "Use radio buttons as images.",
					"id" => $shortname."_images",
					"std" => "",
					"type" => "images",
					"options" => array(
						'warning.css' => $url . 'warning.png',
						'accept.css' => $url . 'accept.png',
						'wrench.css' => $url . 'wrench.png'));
                                        
$options[] = array( "name" => "Textarea",
					"desc" => "Textarea description.",
					"id" => $shortname."_example_textarea",
					"std" => "Default Text",
					"type" => "textarea"); 
                                        
$options[] = array( "name" => "Multicheck",
					"desc" => "Multicheck description.",
					"id" => $shortname."_example_multicheck",
					"std" => "two",
					"type" => "multicheck",
					"options" => $options_radio);
                                        
$options[] = array( "name" => "Select a Category",
					"desc" => "A list of all the categories being used on the site.",
					"id" => $shortname."_example_category",
					"std" => "Select a category:",
					"type" => "select",
					"options" => $of_categories);
*/					


update_option('of_template',$options); 					  
update_option('of_themename',$themename);   
update_option('of_shortname',$shortname);

}
}
?>
