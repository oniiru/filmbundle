<?php
	// registers the buttons for use
	function md_register_buttons($buttons) {
		// inserts a separator between existing buttons and our new one
		// "md_button" is the ID of our button
		array_push($buttons, "md_button");
		/*NEW*/array_push($buttons, "md_toggle");
		/*NEW*/array_push($buttons, "md_tabs");
		/*NEW*/array_push($buttons, "md_lists");
		/*NEW*/array_push($buttons, "md_mboxes");
		/*NEW*/array_push($buttons, "md_cboxes");
		/*NEW*/array_push($buttons, "md_quotes");
		/*NEW*/array_push($buttons, "md_layout");
		/*NEW*/array_push($buttons, "md_header");
		/*NEW*/array_push($buttons, "md_sep");
		/*NEW*/array_push($buttons, "md_vimeo");
		/*NEW*/array_push($buttons, "md_youtube");
		return $buttons;
	}
	 
	// filters the tinyMCE buttons and adds our custom buttons
	function md_shortcode_buttons() {
		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	 
		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
			// filter the tinyMCE buttons and add our own
			add_filter("mce_external_plugins", "add_button_tinymce_plugin");
			add_filter('mce_buttons_3', 'md_register_buttons');
		}
	}
	// init process for button control
	add_action('init', 'md_shortcode_buttons');
	 
	// add the button to the tinyMCE bar
	function add_button_tinymce_plugin($plugin_array) {
		$plugin_array['md_button'] = get_template_directory_uri() . '/functions/tinymce/shortcode-buttons.js';
		/*NEW*/$plugin_array['md_toggle'] = get_template_directory_uri() . '/functions/tinymce/shortcode-toggle.js';
		/*NEW*/$plugin_array['md_tabs'] = get_template_directory_uri() . '/functions/tinymce/shortcode-tabs.js';
		/*NEW*/$plugin_array['md_lists'] = get_template_directory_uri() . '/functions/tinymce/shortcode-lists.js';
		/*NEW*/$plugin_array['md_mboxes'] = get_template_directory_uri() . '/functions/tinymce/shortcode-mboxes.js';
		/*NEW*/$plugin_array['md_cboxes'] = get_template_directory_uri() . '/functions/tinymce/shortcode-cboxes.js';
		/*NEW*/$plugin_array['md_quotes'] = get_template_directory_uri() . '/functions/tinymce/shortcode-quotes.js';
		/*NEW*/$plugin_array['md_layout'] = get_template_directory_uri() . '/functions/tinymce/shortcode-layout.js';
		/*NEW*/$plugin_array['md_header'] = get_template_directory_uri() . '/functions/tinymce/shortcode-header.js';
		/*NEW*/$plugin_array['md_sep'] = get_template_directory_uri() . '/functions/tinymce/shortcode-sep.js';
		/*NEW*/$plugin_array['md_vimeo'] = get_template_directory_uri() . '/functions/tinymce/shortcode-vimeo.js';
		/*NEW*/$plugin_array['md_youtube'] = get_template_directory_uri() . '/functions/tinymce/shortcode-youtube.js';
		return $plugin_array;
	}
?>