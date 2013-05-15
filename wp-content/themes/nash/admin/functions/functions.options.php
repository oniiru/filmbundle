<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
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
	
		$of_options_select = array("one","two","three","four","five"); 
		$of_options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		$of_options_slider_select = array("2","3","4","5","6","7","8","9","10");
		$of_options_latest_work_select = array("3","6","9","12");
		$of_options_quotes_select = array("2","3","4","5","6","7","8","9","10");
		$of_options_services_select = array("3","6","9","12");
		$of_options_meet_team_select = array("3","6","9","12");
		$of_options_latest_news_select = array("3","6","9","12");
		
		//Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"enabled" => array (
				"placebo" => "placebo", //REQUIRED!
				"about_block" => "About",
				"quotes_top_block" => "Quotes (Top)",
				"work_block" => "Latest Work",
				"logos_block" => "Client Logos",
				"services_block" => "Services",
				"tweet_block" => "Latest Tweet",
				"team_block" => "Meet the Team",
				"quotes_bottom_block" => "Quotes (Bottom)",
				"news_block" => "Latest News",
			),
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
			),
		);

		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/assets/img/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/assets/img/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		
		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads = get_option('of_uploads');
		$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();

$of_options[] = array( "name" => __('Home Settings', 'nash'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Homepage Layout Manager', 'nash'),
					"desc" => __('Organize how you want the layout to appear on the homepage.<br /><br />You can choose to enable/disable sections via drag & drop, or re-order their stacking order on the homepage.<br /><br />NB; Once you have re-ordered or disabled, do not forget to adjust your Menu (Navigation) in the same way.', 'nash'),
					"id" => "homepage_blocks",
					"std" => $of_options_homepage_blocks,
					"type" => "sorter");

$of_options[] = array( "name" => __('Header Settings', 'nash'),
					"type" => "heading");

$of_options[] = array( "name" => __('Custom Logo', 'nash'),
					"desc" => __('Upload your own logo to use on the site.', 'nash'),
					"id" => "custom_logo",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => __('Text Logo', 'nash'),
					"desc" => __('If you do not have a logo you can choose to use a plain text logo instead.', 'nash'),
					"id" => "text_logo",
					"std" => false,
					"type" => "checkbox");
					
$of_options[] = array( "name" => __('Introduction', 'nash'),
					"desc" => __('You can add a short introduction to appear in your header (eg; Yes we do some awesome things).<br /><br /><em>*HTML tags are allowed.</em>', 'nash'),
					"id" => "text_introduction",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Background Image', 'nash'),
					"desc" => __('Upload a background image to use in your header.', 'nash'),
					"id" => "upload_header_background",
					"std" => "",
					"type" => "media");
					
$of_options[] = array( "name" => __('About Us Settings', 'nash'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'nash'),
					"desc" => __('Please enter a title for the About Us section. (eg; We are an award winning digital agency. And truly awesome too.)', 'nash'),
					"id" => "text_about_us_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Icon', 'nash'),
					"desc" => __('Please add an icon to appear above your title. (eg; [icon name=icon-trophy])<br/><br />All list of available icons can be found <a href="http://fortawesome.github.com/Font-Awesome/" target="_blank">here</a>.', 'nash'),
					"id" => "icon_about_us",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'nash'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'nash'),
					"id" => "textarea_about_us_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "name" => __('Slider', 'nash'),
					"desc" => __('Please select how many items you would like featured on your slider.', 'nash'),
					"id" => "select_slider",
					"std" => "3",
					"type" => "select",
					"class" => "tiny",
					"options" => $of_options_slider_select);
					
$of_options[] = array( "name" => __('Portfolio Settings', 'nash'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'nash'),
					"desc" => __('Please enter a title for the Portfolio section. (eg; Our work says a lot about us. Passionate about all we do.)', 'nash'),
					"id" => "text_portfolio_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Icon', 'nash'),
					"desc" => __('Please add an icon to appear above your title. (eg; [icon name=icon-pencil])<br/><br />All list of available icons can be found <a href="http://fortawesome.github.com/Font-Awesome/" target="_blank">here</a>.', 'nash'),
					"id" => "icon_portfolio",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'nash'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'nash'),
					"id" => "textarea_portfolio_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "name" => __('Button Title (Single Project)', 'nash'),
					"desc" => __('Please enter a global name for your single project button (eg; Launch Project or Visit Website)', 'nash'),
					"id" => "text_project_button_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Service Settings', 'nash'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'nash'),
					"desc" => __('Please enter a title for the Services section. (eg; We provide a multitude of services. Everything is covered.)', 'nash'),
					"id" => "text_services_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Icon', 'nash'),
					"desc" => __('Please add an icon to appear above your title. (eg; [icon name=icon-cog])<br/><br />All list of available icons can be found <a href="http://fortawesome.github.com/Font-Awesome/" target="_blank">here</a>.', 'nash'),
					"id" => "icon_services",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'nash'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'nash'),
					"id" => "textarea_services_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "desc" => __('Please select how many items you would like to show in the services section.', 'nash'),
					"id" => "select_services",
					"std" => "6",
					"type" => "select",
					"class" => "tiny",
					"options" => $of_options_services_select);
					
$of_options[] = array( "name" => __('Team Settings', 'nash'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'nash'),
					"desc" => __('Please enter a title for the Meet the Team section. (eg; We have a team of truly awesome folk. You will love them.)', 'nash'),
					"id" => "text_team_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Icon', 'nash'),
					"desc" => __('Please add an icon to appear above your title. (eg; [icon name=icon-user])<br/><br />All list of available icons can be found <a href="http://fortawesome.github.com/Font-Awesome/" target="_blank">here</a>.', 'nash'),
					"id" => "icon_team",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'nash'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'nash'),
					"id" => "textarea_team_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "desc" => __('Please select how many items you would like to show in the meet the team section.', 'nash'),
					"id" => "select_team",
					"std" => "3",
					"type" => "select",
					"class" => "tiny",
					"options" => $of_options_meet_team_select);

$of_options[] = array( "name" => __('News Settings', 'nash'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'nash'),
					"desc" => __('Please enter a title for the Latest News section. (eg; Hear what we have to say. It is all good.)', 'nash'),
					"id" => "text_news_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Icon', 'nash'),
					"desc" => __('Please add an icon to appear above your title. (eg; [icon name=icon-book])<br/><br />All list of available icons can be found <a href="http://fortawesome.github.com/Font-Awesome/" target="_blank">here</a>.', 'nash'),
					"id" => "icon_news",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'nash'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'nash'),
					"id" => "textarea_news_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "desc" => __('Please select how many items you would like to show in the latest news section.', 'nash'),
					"id" => "select_news",
					"std" => "3",
					"type" => "select",
					"class" => "tiny",
					"options" => $of_options_latest_news_select);			
					
$of_options[] = array( "name" => __('Contact Settings', 'nash'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Title', 'nash'),
					"desc" => __('Please enter a title for the Contact section. (eg; Contact Us)', 'nash'),
					"id" => "text_contact_us_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Icon', 'nash'),
					"desc" => __('Please add an icon to appear above your title. (eg; [icon name=icon-envelope])<br/><br />All list of available icons can be found <a href="http://fortawesome.github.com/Font-Awesome/" target="_blank">here</a>.', 'nash'),
					"id" => "icon_contact_us",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Overview', 'nash'),
					"desc" => __('You can add a short overview to appear in this section.<br /><br /><em>*HTML tags are allowed.</em>', 'nash'),
					"id" => "textarea_contact_us_overview",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "name" => __('Contact Email', 'nash'),
					"desc" => __('Please enter your company email address (eg; davesmith@guuthemes.com.)', 'nash'),
					"id" => "text_contact_email",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Contact Telephone Number', 'nash'),
					"desc" => __('Please enter your company telephone number (eg; (212) 823-6000.)', 'nash'),
					"id" => "text_contact_telephone",
					"std" => "",
					"type" => "text");				

$of_options[] = array( "name" => __('Contact Address', 'nash'),
					"desc" => __('Please enter your company address (eg; 10 Columbus Circle, New York, NY 10019, United States.)', 'nash'),
					"id" => "text_contact_address",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('General Settings', 'nash'),
                    "type" => "heading");
					
$of_options[] = array( "name" => __('Custom Favicon', 'nash'),
					"desc" => __('Upload a 32px x 32px PNG/GIF image that will represent your website favicon.', 'nash'),
					"id" => "custom_favicon",
					"std" => "",
					"mod" => "min",
					"type" => "upload");
					
$of_options[] = array( "name" => __('Footer Text', 'nash'),
					"desc" => __('Please enter the text to appear at the bottom of your Footer (eg; All rights reserved. Designed by GuuThemes.)', 'nash'),
					"id" => "textarea_footer_text",
					"std" => "",
					"type" => "textarea");
                
$of_options[] = array( "name" => __('Google Analytics Tracking Code', 'nash'),
					"desc" => __('Paste your Google Analytics tracking code here (Remember you need to paste all the Javascript code, not just your ID). This will be added into the footer template of your theme.<br /><br />Do not have Google Analytics? Unsure what to paste in this box? Visit this <a href="http://www.google.com/analytics">link</a> to find out more.', 'nash'),
					"id" => "google_analytics",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "name" => __('Client Logos Title', 'nash'),
					"desc" => __('Please enter a title for the Client Logos section. (eg; Folks we have worked with)', 'nash'),
					"id" => "text_client_logos_title",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Client Logo One', 'nash'),
					"desc" => __('Upload client logos to appear in the client logo section. Choose an image around 100px wide to achieve the best layout.', 'nash'),
					"id" => "client_logo_one",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => __('Client Logo Two', 'nash'),
					"id" => "client_logo_two",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => __('Client Logo Three', 'nash'),
					"id" => "client_logo_three",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => __('Client Logo Four', 'nash'),
					"id" => "client_logo_four",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => __('Client Logo Five', 'nash'),
					"id" => "client_logo_five",
					"std" => "",
					"mod" => "min",
					"type" => "media");
					
$of_options[] = array( "name" => __('Twitter Username', 'nash'),
					"desc" => __('Enter your Twitter Username <br />(ie; guuthemes). This enables you to show your latest tweet in the theme', 'nash'),
					"id" => "text_twitter_username",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Twitter', 'nash'),
					"desc" => __('Enter your Twitter Profile URL <br />(ie; http://twitter.com/guuthemes)', 'nash'),
					"id" => "text_twitter_profile",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => __('Facebook', 'nash'),
					"desc" => __('Enter your Facebook Profile URL <br />(ie; http://facebook.com/guuthemes)', 'nash'),
					"id" => "text_facebook_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Dribbble', 'nash'),
					"desc" => __('Enter your Dribbble Profile URL <br />(ie; http://dribbble.com/guuthemes)', 'nash'),
					"id" => "text_dribbble_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Forrst', 'nash'),
					"desc" => __('Enter your Forrst Profile URL <br />(ie; http://forrst.com/people/guuthemes)', 'nash'),
					"id" => "text_forrst_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Vimeo', 'nash'),
					"desc" => __('Enter your Vimeo Profile URL <br />(ie; http://vimeo.com/guuthemes)', 'nash'),
					"id" => "text_vimeo_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('YouTube', 'nash'),
					"desc" => __('Enter your YouTube Profile URL <br />(ie; http://youtube.com/user/guuthemes)', 'nash'),
					"id" => "text_youtube_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Flickr', 'nash'),
					"desc" => __('Enter your Flickr Profile URL <br />(ie; http://flickr.com/people/guuthemes)', 'nash'),
					"id" => "text_flickr_profile",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => __('Linkedin', 'nash'),
					"desc" => __('Enter your Linkedin Profile URL <br />(ie; http://linkedin.com/in/guuthemes)', 'nash'),
					"id" => "text_linkedin_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Pinterest', 'nash'),
					"desc" => __('Enter your Pinterest Profile URL <br />(ie; http://pinterest.com/guuthemes)', 'nash'),
					"id" => "text_pinterest_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Google +', 'nash'),
					"desc" => __('Enter your Google + Profile URL <br />(ie; http://plus.google.com/1030594445)', 'nash'),
					"id" => "text_googleplus_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Tumblr', 'nash'),
					"desc" => __('Enter your Tumblr Profile URL <br />(ie; http://guuthemes.tumblr.com)', 'nash'),
					"id" => "text_tumblr_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Soundcloud', 'nash'),
					"desc" => __('Enter your Soundcloud Profile URL <br />(ie; https://soundcloud.com/guuthemes)', 'nash'),
					"id" => "text_soundcloud_profile",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => __('Last FM', 'nash'),
					"desc" => __('Enter your Last FM Profile URL <br />(ie; http://last.fm/user/guuthemes)', 'nash'),
					"id" => "text_lastfm_profile",
					"std" => "",
					"type" => "text");   
					
$of_options[] = array( "name" => __('Styling Options', 'nash'),
					"type" => "heading");                                                    

$of_options[] = array( "name" => __('Text Logo Styling', 'nash'),
					"desc" => __('Specify the text logo font properties (if you chose this option on the previous page).', 'nash'),
					"id" => "logo_font",
					"std" => array('size' => '39px','face' => 'pacifico','style' => 'normal','color' => '#333333'),
					"type" => "typography");
					
$of_options[] = array( "name" => __('Body Font Styling', 'nash'),
					"desc" => __('Specify the body font properties.', 'nash'),
					"id" => "body_font",
					"std" => array('size' => '14px','face' => 'cabin','style' => 'normal','color' => '#333333'),
					"type" => "typography");
					
$of_options[] = array( "name" => __('Headings Styling', 'nash'),
					"desc" => __('Specify the h1, h2, h3, h4, h5 font properties.', 'nash'),
					"id" => "headings_font",
					"std" => array('face' => 'oswald','style' => 'normal','color' => '#333333'),
					"type" => "typography");

$of_options[] = array( "name" =>  __('Accent Color', 'nash'),
					"desc" => __('Pick an accent color for the theme. (This will affect Header Navigation, Portfolio Filter, Quotes, Blockquotes, Pricing Tables, Tabs, Portfolio Navigation & Social Icons).', 'nash'),
					"id" => "accent_color",
					"std" => "#e47c14",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Button Color', 'nash'),
					"desc" => __('Pick an accent color for the buttons.', 'nash'),
					"id" => "accent_color_button",
					"std" => "#e47c14",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Body Link Color', 'nash'),
					"desc" => __('Pick an accent color for the main body links.', 'nash'),
					"id" => "body_link_color",
					"std" => "#e47c14",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Footer Link Color', 'nash'),
					"desc" => __('Pick an accent color for the footer text links.', 'nash'),
					"id" => "footer_link_color",
					"std" => "#e47c14",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Service Icons Color', 'nash'),
					"desc" => __('Pick an accent color for the service icons.', 'nash'),
					"id" => "accent_color_service_icons",
					"std" => "#e47c14",
					"type" => "color");
					
$of_options[] = array( "name" =>  __('Team Member Social Icons Color', 'nash'),
					"desc" => __('Pick an accent color for the team member social icons.', 'nash'),
					"id" => "accent_color_team_icons",
					"std" => "#e47c14",
					"type" => "color");
					
$of_options[] = array( "name" => __('Custom CSS', 'nash'),
                    "desc" => __('Quickly add some CSS to your theme by adding it to this block.', 'nash'),
                    "id" => "custom_css",
                    "std" => "",
                    "type" => "textarea");
                    
$of_options[] = array( "name" => __('Background Settings', 'nash'),
					"type" => "heading");  
                    
$of_options[] = array( "name" => __('Quotes (Top) Background Image', 'nash'),
					"desc" => __('Upload a background image to use in your (top) quotes section.', 'nash'),
					"id" => "upload_quotes_top_background",
					"std" => "",
					"type" => "media");
					
$of_options[] = array( "name" => __('Logos Background Image', 'nash'),
					"desc" => __('Upload a background image to use in your logo section.', 'nash'),
					"id" => "upload_logos_background",
					"std" => "",
					"type" => "media");
					
$of_options[] = array( "name" => __('Latest Tweet Background Image', 'nash'),
					"desc" => __('Upload a background image to use in your latest tweet section.', 'nash'),
					"id" => "upload_latest_tweet_background",
					"std" => "",
					"type" => "media");
					
$of_options[] = array( "name" => __('Quotes (Bottom) Background Image', 'nash'),
					"desc" => __('Upload a background image to use in your (bottom) quotes section.', 'nash'),
					"id" => "upload_quotes_bottom_background",
					"std" => "",
					"type" => "media");

// Backup Options
$of_options[] = array( "name" => __('Backup Options', 'nash'),
					"type" => "heading");
					
$of_options[] = array( "name" => __('Backup and Restore Options', 'nash'),
                    "id" => "of_backup",
                    "std" => "",
                    "type" => "backup",
					"desc" => __('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'nash'),
					);
					
$of_options[] = array( "name" => __('Transfer Theme Options Data', 'nash'),
                    "id" => "of_transfer",
                    "std" => "",
                    "type" => "transfer",
					"desc" => __('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".
						', 'nash'),
					);
					
	}
}
?>