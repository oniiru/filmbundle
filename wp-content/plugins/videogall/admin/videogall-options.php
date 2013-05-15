<?php
/**
 * Initialize plugin options
 */
function videogall_init_options() {
    if(false === videogall_get_options()) add_option('videogall_options', videogall_get_default_options());
    register_setting('videogall_options', 'videogall_options', 'videogall_validate_options');
    videogall_update_videos_categories();
}
add_action('admin_init', 'videogall_init_options');

/**
 * Retreive plugin options
 */
function videogall_get_options() {
    return get_option('videogall_options', videogall_get_default_options());
}

/**
 * Return page capability
 */
function videogall_page_capability($capability) {
    return 'edit_theme_options';
}
add_filter('option_page_capability_videogall_options', 'videogall_page_capability');

/**
 * Enqeueing the javascripts & stylesheets
 */
function videogall_enqueue_admin_scripts($hook_suffix) {
    wp_enqueue_script('jquery');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
    wp_enqueue_script('videogall_color_picker', VIDEOGALL_DIR_URL.'admin/js/jscolor.js', false, false);
    wp_enqueue_script('videogall_admin_js', VIDEOGALL_DIR_URL.'admin/js/videogall-options.js', array('jquery'), false);
    wp_enqueue_style('videogall_admin_css', VIDEOGALL_DIR_URL.'admin/videogall-options.css', false, false, 'all');
}

/**
 * Add the plugin options page to the menu
 */
function videogall_activate_options() {
    $videogall_plugin_page = add_options_page('Videogall Settings', 'Videogall Settings', 'manage_options', 'videogall_plugin_options', 'videogall_options_page');
    add_action('admin_print_styles-' . $videogall_plugin_page, 'videogall_enqueue_admin_scripts');
}
add_action('admin_menu', 'videogall_activate_options');

/**
 * List of settings tabs
 */
function videogall_tab_list() {
    $tabs = array(
        'listvideos' => array('value' => 'listvideos', 'label' => __('Your Videos','videogall')),
        'addvideo' => array('value' => 'addvideo', 'label' => __('Add New Video','videogall')),
        'videocategory' => array('value' => 'videocategory', 'label' => __('Video Categories','videogall')),
        'videoadditional' => array('value' => 'videoadditional', 'label' => __('Additional Settings','videogall')),
        'videoinstructions' => array('value' => 'videoinstructions', 'label' => __('Instructions','videogall')),
    );
    return apply_filters('videogall_tab_list', $tabs);
}

/**
 * Dropdown arrays
 */
function videogall_video_size_list() {
    $list = array(
	'480|320' => array('value' => '480|320', 'label' => __('Small','videogall')),
	'640|480' => array('value' => '640|480', 'label' => __('Medium','videogall')),
	'1024|720' => array('value' => '1024|720', 'label' => __('Large','videogall')),
    );
    return apply_filters('videogall_video_size_list', $list);
}

function videogall_thumbnail_size_list() {
    $list = array(
	'100|150' => array('value' => '100|150', 'label' => __('Small','videogall')),
	'120|180' => array('value' => '120|180', 'label' => __('Medium','videogall')),
	'350|320' => array('value' => '350|320', 'label' => __('Large','videogall')),
    );
    return apply_filters('videogall_thumbnail_size_list', $list);
}

/**
 * Setting default option values
 */
function videogall_get_default_options() {
    $videogall_default_options = array(
	'video_size' => '1024|720',
	'thumbnail_size' => '100|150',
	'enable_border' => false,
        'border_color' => 'ffffff',
	'enable_pagination' => false,
	'videos_per_page' => 10,
	'enable_shadowbox_images' => false
    );
    return apply_filters('videogall_get_default_options', $videogall_default_options);
}

/**
 * Updating videos & categories
 */
function videogall_update_videos_categories() {
    $video_list = get_option('videogall_videos');
    $video_categories = get_option('videogall_categories');
    $new_video_list = array();
    $new_category_list = array();
    
    if(isset($_POST['add_category_submit'])) {
	$category = videogall_sanitize_field($_POST['add_new_category']);
	if($category != '') {
	    foreach($video_categories as $exist) {
		if(strtoupper($exist) == strtoupper($category)) {
		    add_settings_error('videogall_options','error',__('Category already exists','videogall'),'error');
		    return;
		}
	    }
	    array_push($video_categories,$category);
	    update_option('videogall_categories',$video_categories);
	    add_settings_error('videogall_options','success',__('Category created succesfully','videogall'),'updated');
	} else {
	    add_settings_error('videogall_options','error',__('Invalid category name provided','videogall'),'error');
	    return;
	}
    }
    
    if(isset($_POST['rename_category_submit'])) {
	$exist_category = videogall_sanitize_field($_POST['rename_category']);
	$new_category = videogall_sanitize_field($_POST['rename_category_txt']);
	if($exist_category != '') {
	    if($new_category != '') {
		foreach($video_categories as $entry) {
		    if(strtoupper($entry) == strtoupper($exist_category)) {
			array_push($new_category_list,$new_category);
		    } else {
			array_push($new_category_list,$entry);
		    }
		}
		update_option('videogall_categories',$new_category_list);
		foreach($video_list as $entry) {
		    if(strtoupper($entry['category']) == strtoupper($exist_category)) {
			$entry['category'] = $new_category;
		    }
		    array_push($new_video_list,$entry);
		}
		update_option('videogall_videos',$new_video_list);
		add_settings_error('videogall_options','notice',__('Category has been renamed','videogall'),'updated');
	    } else {
		add_settings_error('videogall_options','error',__('Invalid category name provided','videogall'),'error');
		return;
	    }
	}
    }
    
    if(isset($_POST['id_list'])) {
	if(isset($_POST['delete_video_submit'])) {
	    foreach($video_list as $entry) {
		if($entry['id'] != $_POST['id_list'])
		    array_push($new_video_list,$entry);
	    }
	    update_option('videogall_videos',$new_video_list);
	    add_settings_error('videogall_options','notice',__('Video deleted succesfully','videogall'),'updated');
	}
	
	if(isset($_POST['edit_done_submit'])) {
	    $edit_id = $_POST['id_list'];
	    $name = videogall_sanitize_field($_POST['edit_name_'.$edit_id]);
	    $url = videogall_sanitize_field($_POST['edit_url_'.$edit_id]);
	    $category = videogall_sanitize_field($_POST['edit_category_'.$edit_id]);
	    $thumbnail = videogall_sanitize_field($_POST['edit_thumbnail_'.$edit_id]);
	    $caption = stripslashes($_POST['edit_caption_'.$edit_id]);
	    $description = stripslashes($_POST['edit_description_'.$edit_id]);
	    $processed = videogall_process_url($url);
	    $url = $processed['url'];
	    if($thumbnail == '') $thumbnail = $processed['thumbnail'];
	    if($name != '' and $url != '') {
		foreach($video_list as $entry) if(strtoupper($entry['name']) == strtoupper($name) and $entry['id'] != $edit_id) {
		    add_settings_error('videogall_options','error',__('Video with name '.$name.' already exists','videogall'),'error');
		    return;
		}
		foreach($video_list as $entry) {
		    if($entry['id'] == $edit_id) {
			$entry['name'] = $name;
			$entry['url'] = $url;
			$entry['category'] = $category;
			$entry['thumbnail'] = $thumbnail;
			$entry['caption'] = $caption;
			$entry['description'] = $description;
		    }
		    array_push($new_video_list,$entry);
		}
		update_option('videogall_videos',$new_video_list);
		add_settings_error('videogall_options','success',__('Video updated succesfully','videogall'),'updated');
	    } else {
		add_settings_error('videogall_options','error',__('Name, URL are required fields','videogall'),'error');
		return;
	    }
	}
    }
    
    if(isset($_POST['add_video_submit'])) {	
	$next_id = intval(get_option('videogall_sequence_id')) + 1;
	$name = videogall_sanitize_field($_POST['add_name']);	
	$url = videogall_sanitize_field($_POST['add_url']);
	$category = videogall_sanitize_field($_POST['add_category']);
	$thumbnail = videogall_sanitize_field($_POST['add_thumbnail']);
	if($thumbnail != '' and !videogall_validate_image_url($thumbnail)) {
	    add_settings_error('videogall_options','error',__('Invalid image URL for thumbnail','videogall'),'error');
	    return;
	}
	$caption = videogall_sanitize_field($_POST['add_caption']);
	$description = videogall_sanitize_textarea($_POST['add_description']);
	if($name != '' and $url != '') {
	    foreach($video_list as $entry) if(strtoupper($entry['name']) == strtoupper($name)) {
		add_settings_error('videogall_options','error',__('Video with name '.$name.' already exists','videogall'),'error');
		return;
	    }
	    $processed = videogall_process_url($url);
	    $url = $processed['url'];
	    if($thumbnail == '') $thumbnail = $processed['thumbnail'];
	    $entry = array('id' => $next_id, 'name' => $name, 'url' => $url, 'thumbnail' => $thumbnail, 'category' => $category, 'caption' => $caption, 'description' => $description);
	    array_push($video_list,$entry);
	    update_option('videogall_videos',$video_list);
	    update_option('videogall_sequence_id',$next_id);
	    add_settings_error('videogall_options','success',__('Video added succesfully','videogall'),'updated');
	} else {
	    add_settings_error('videogall_options','error',__('Name, URL are required fields','videogall'),'error');
	    return;
	}
    }
}

/**
 * Displays the option page
 */
function videogall_options_page() {
    if(isset($_POST['settings-reset'])) {
        delete_option('videogall_options');
        add_settings_error('videogall_options','notice',__('Default settings restored','videogall'),'updated');
    }
    ?>
    <div class="settings-wrap">
        <div class="settings-header">
            <table class="tablayout" style="height:100%;"><tr>
            <td class="left" style="width:50%;">
                <h2 class="settings-title"><?php _e('Videogall Options', 'videogall'); ?></h2>
            </td>
            <td class="right" style="width:50%;">
                <form class="paypalform" target="_blank" action="https://www.paypal.com/cgi-bin/webscr" method="post" style="text-align: right; margin-top: 10px;">
                    <span class="donate-text"><?php _e('Feel free to donate via ','videogall'); ?></span>
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="43VU78ENDDKSU">
                    <input type="image" src="<?php echo VIDEOGALL_DIR_URL; ?>admin/images/paypal_btn.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
            </td>
            </tr></table>
        </div>
        <div class="settings-menu clearfix">
            <?php $count = 1; ?>
            <?php foreach (videogall_tab_list() as $tab) { if($count == 1) $class = " settings-menu-tab-active"; else $class = ""; ?>
            <a href="javascript:void(0)" id="settings-menu-tab-<?php echo $tab['value']; ?>" class="settings-menu-tab<?php echo $class; ?>">
                <img class="settings-menu-tab-icon" src="<?php echo VIDEOGALL_DIR_URL; ?>admin/images/<?php echo $tab['value']; ?>_icon.png"/>
                <?php echo $tab['label']; ?>
            </a>
            <?php $count++; } ?>
        </div>
        <div class="settings-content-container">
            <span id="error-location"><?php settings_errors(); ?></span>
            <form class="settings-form" method="post" id="settings-form" action="options.php">
            <?php
                settings_fields('videogall_options');
                $videogall_options = videogall_get_options();
                $videogall_default_options = videogall_get_default_options();
            ?>
            <div id="settings-content-listvideos" class="settings-content settings-content-active">
                <?php foreach(get_option('videogall_videos') as $entry) { ?>
		    <div class="video-item" id="video-item-<?php echo $entry['id']; ?>">
			<img src="<?php echo $entry['thumbnail'] ?>"/>
			<p style="text-align:center;">
			    <input type="button" class="edit_video_button" name="edit_video_button" id="edit_video_button_<?php echo $entry['id']; ?>" value="<?php _e('Edit','videogall'); ?>"/>
                            <input type="submit" class="delete_video_submit" name="delete_video_submit" id="delete_video_submit_<?php echo $entry['id']; ?>" value="<?php _e('Delete','videogall'); ?>"/>
                        </p>
			<div class="edit-form" id="edit-form-<?php echo $entry['id']; ?>">
                            <table cellpadding="10px">
                                <tr>
                                    <td><label><?php _e('Name: * ','videogall'); ?></label></td>
                                    <td><input type="text" name="edit_name_<?php echo $entry['id']; ?>" id="edit_name_<?php echo $entry['id']; ?>" value="<?php echo $entry['name']; ?>"/></td>
                                </tr>
                                <tr>
                                    <td><label><?php _e('URL: * ','videogall'); ?></label></td>
                                    <td><input type="text" name="edit_url_<?php echo $entry['id']; ?>" id="edit_url_<?php echo $entry['id']; ?>" value="<?php echo $entry['url']; ?>"/></td>
                                </tr>
				<tr>
                                    <td><label><?php _e('Category: ','videogall'); ?></label></td>
                                    <td>
					<select name="edit_category_<?php echo $entry['id']; ?>" id="edit_category_<?php echo $entry['id']; ?>">
					    <option value=""></option>
					    <?php foreach(get_option('videogall_categories') as $cat_entry) { ?>
					    <?php if($cat_entry == $entry['category']) $selected = " selected"; else $selected = ""; ?>
					    <option value="<?php echo $cat_entry; ?>"<?php echo $selected; ?>><?php echo ucwords($cat_entry); ?></option>
					    <?php } ?>
					</select>
				    </td>
                                </tr>
                                <tr>
                                    <td><label><?php _e('Thumbnail: ','videogall'); ?></label></td>
                                    <td>
					<input type="text" name="edit_thumbnail_<?php echo $entry['id']; ?>" id="edit_thumbnail_<?php echo $entry['id']; ?>" value="<?php echo $entry['thumbnail']; ?>"/>
					<input id="edit_thumbnail_<?php echo $entry['id']; ?>_upload" type="button" class="image_upload" value="<?php _e('Upload','videogall'); ?>" />
				    </td>
                                </tr>
                                <tr>
                                    <td><label><?php _e('Caption: ','videogall'); ?></label></td>
                                    <td><input type="text" name="edit_caption_<?php echo $entry['id']; ?>" id="edit_caption_<?php echo $entry['id']; ?>" value="<?php echo $entry['caption']; ?>"/></td>
                                </tr>
                                <tr>
                                    <td><label><?php _e('Description: ','videogall'); ?></label></td>
                                    <td><textarea rows="3" cols="40" name="edit_description_<?php echo $entry['id']; ?>" id="edit_description_<?php echo $entry['id']; ?>"><?php echo $entry['description']; ?></textarea></td>
                                </tr>
                                <tr>                                    
                                    <td></td>
                                    <td style="text-align:right;">
					<input type="submit" class="button-primary edit_done_submit" id="edit_done_submit_<?php echo $entry['id']; ?>" name="edit_done_submit" value="<?php _e('Submit','videogall'); ?>"/>
					<input type="button" class="edit_cancel_submit" id="edit_cancel_submit_<?php echo $entry['id']; ?>" name="edit_cancel_submit" value="<?php _e('Cancel','videogall'); ?>"/>
				    </td>
                                </tr>
                            </table>
                        </div>
		    </div>
		<?php } ?>
            </div>
            <div id="settings-content-addvideo" class="settings-content">
                <table cellpadding="10px">
                    <tr>
                        <td><label><?php _e('Name','videogall'); ?> * :</label></td>
                        <td><input type="text" name="add_name" id="add_name" value=""/></td>
                    </tr>
                    <tr>
                        <td><label><?php _e('URL','videogall'); ?> * :</label></td>
                        <td><input type="text" name="add_url" id="add_url" value=""/></td>
                    </tr>
		    <tr>
                        <td><label><?php _e('Category','videogall'); ?> :</label></td>
                        <td>
			    <select name="add_category" id="add_category">
				<option value=""></option>
				<?php foreach(get_option('videogall_categories') as $entry) { ?>
				<option value="<?php echo $entry; ?>"><?php echo ucwords($entry); ?></option>
				<?php } ?>
			    </select>
			</td>
                    </tr>
                    <tr>
                        <td><label><?php _e('Thumbnail','videogall'); ?>:</label></td>
                        <td>
                            <input type="text" name="add_thumbnail" id="add_thumbnail" value=""/>
                            <input id="add_thumbnail_upload" type="button" class="image_upload" value="<?php _e('Upload Thumbnail','videogall'); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td><label><?php _e('Caption','videogall'); ?>:</label></td>
                        <td><input type="text" name="add_caption" id="add_caption" value=""/></td>
                    </tr>
                    <tr>
                        <td><label><?php _e('Description','videogall'); ?>:</label></td>
                        <td><textarea rows="3" cols="40" name="add_description" id="add_description"></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" class="button-primary" name="add_video_submit" id="add_video_submit" value="<?php _e('Add Video','videogall'); ?>"/>
                            <p><?php _e('* are required fields','videogall'); ?></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="settings-content-videocategory" class="settings-content">
                <p class="lblfield"><label><?php _e('Add new category','videogall'); ?></label></p>
		<p class="frmfield">
		    <input type="text" name="add_new_category" id="add_new_category" value=""/>
		    <input type="submit" class="button-primary" name="add_category_submit" id="add_category_submit" value="<?php _e('Add Category','videogall'); ?>"/>
		</p>
		<p class="lblfield"><label><?php _e('Rename categories','videogall'); ?></label></p>
		<p class="frmfield">
		    <select name="rename_category" id="rename_category">
		    <option value=""></option>
		    <?php foreach(get_option('videogall_categories') as $entry) { ?>
		    <option value="<?php echo $entry; ?>"><?php echo ucwords($entry); ?></option>
		    <?php } ?>
		    </select>
		    <span id="rename-category-section">
		    <input type="text" name="rename_category_txt" id="rename_category_txt" value=""/>
		    <input type="submit" class="button-primary" name="rename_category_submit" id="rename_category_submit" value="<?php _e('Update Category','videogall'); ?>"/>
		    </span>
		</p>
            </div>
            <div id="settings-content-videoadditional" class="settings-content">
		<p class="lblfield"><label><?php _e('Video Size','videogall'); ?></label></p>
                <p class="frmfield">
                    <select name="videogall_options[video_size]">
                        <?php foreach (videogall_video_size_list() as $video_size) { ?>
                            <option value="<?php echo $video_size['value']; ?>" <?php selected($videogall_options['video_size'], $video_size['value']); ?>><?php echo $video_size['label']; ?></option>
                        <?php } ?>
                    </select>
                </p>
		<p class="lblfield"><label><?php _e('Thumbnail Size','videogall'); ?></label></p>
                <p class="frmfield">
                    <select name="videogall_options[thumbnail_size]">
                        <?php foreach (videogall_thumbnail_size_list() as $thumbnail_size) { ?>
                            <option value="<?php echo $thumbnail_size['value']; ?>" <?php selected($videogall_options['thumbnail_size'], $thumbnail_size['value']); ?>><?php echo $thumbnail_size['label']; ?></option>
                        <?php } ?>
                    </select>
                </p>
		<p class="lblfield"><label><?php _e('Enable ShadowBox for images','videogall'); ?></label></p>
                <p class="frmfield">
                    <input type="checkbox" name="videogall_options[enable_shadowbox_images]" value="true" <?php checked(true,$videogall_options['enable_shadowbox_images']); ?> />
                </p>
		<p class="lblfield"><label><?php _e('Enable Border','videogall'); ?></label></p>
                <p class="frmfield">
                    <input type="checkbox" name="videogall_options[enable_border]" value="true" <?php checked(true,$videogall_options['enable_border']); ?> />
                </p>
                <p class="lblfield"><label><?php _e('Border Color','videogall'); ?></label></p>
                <p class="frmfield">
                    <input type="text" name="videogall_options[border_color]" class="color" value="<?php echo esc_attr($videogall_options['border_color']); ?>"/>
                </p>
		<p class="lblfield"><label><?php _e('Enable Pagination','videogall'); ?></label></p>
                <p class="frmfield">
                    <input type="checkbox" name="videogall_options[enable_pagination]" value="true" <?php checked(true,$videogall_options['enable_pagination']); ?> />
                </p>
		<p class="lblfield"><label><?php _e('Number of videos per page','videogall'); ?></label></p>
                <p class="frmfield">
                    <input type="text" name="videogall_options[videos_per_page]" value="<?php echo esc_attr($videogall_options['videos_per_page']); ?>"/>
                </p>
            </div>
            <div id="settings-content-videoinstructions" class="settings-content">
                <h2><?php _e('VideoGall Installation','videogall'); ?></h2>
		<ol>
		    <li>
			<?php _e('Unzip the VideoGall plugin in the plugins folder in wp-content directory i.e "wp-content/plugins"','videogall'); ?>
		    </li>
		    <li>
			<?php _e('Go to your wordpress admin\'s plugins section and activate the VideoGall plugin','videogall'); ?>
		    </li>
		    <li>
			<?php _e('Go to settings --&gt; VideoGall Settings to set your options and add videos. Check out the instructions below on how to fetch the video URL from your desired website','videogall'); ?>
		    </li>
		    <li>
			<?php _e('In a page or a post use the button in the editor to add the vidoeogall shortcode e.g. [myvideogall:all] will display all the videos. To display videos from a certain category, replace "all" with your desired category name','videogall'); ?>
		    </li>
		</ol>
		
		<h2><?php _e('Add Videos','videogall'); ?></h2>
		<ol>
		    <li>
			<?php _e('Go to VideoGall Settings page and you can add videos from the "Add Video" section','videogall'); ?>
		    </li>
		    <li>
			<?php _e('If you want VideoGall to automatically fetch the video thumbnail, then leave the thumbnail field empty while adding the video. If you want to use your own thumbnail image, you can upload or select existing image from your media library using the "Upload" button.','videogall'); ?>
		    </li>
		    <li>
			<?php _e('Always use the URL from the browser address bar from the video website of your choice (e.g. YouTube, Vimeo, etc).','videogall'); ?>
		    </li>
		    <li>
			<?php _e('If you want to add a video from a site which is not supported by VideoGall then use the direct URL of that video.','videogall'); ?>
		    </li>
		</ol>
		
		<h2><?php _e('Supported Sites','videogall'); ?></h2>
		<ol>
		    <li>
			<?php _e('YouTube','videogall'); ?>
		    </li>
		    <li>
			<?php _e('Metacafe','videogall'); ?>
		    </li>
		    <li>
			<?php _e('Dailymotion','videogall'); ?>
		    </li>
		    <li>
			<?php _e('Vimeo','videogall'); ?>
		    </li>
		    <li>
			<?php _e('WordPress','videogall'); ?>
		</li>
		</ol>
            </div>
            <div class="settings-content-container-footer">
                <?php submit_button('Save Settings','primary','settings-submit',false); ?>
            </div>
	    <input type="hidden" name="id_list" id="id_list" value=""/>
            </form>            
        </div>
        <div class="settings-footer">
            <table class="tablayout"><tr>
            <td class="left" style="width:50%;">
                <form class="settings-form" method="post" id="reset-form" onsubmit="return confirmAction()">
                    <input type="submit" name="settings-reset" id="settings-reset" value="<?php _e('Reset Settings','videogall'); ?>" />
                </form>
            </td>
            <td class="right" style="width:50%;">
                <?php _e('Plugin designed and developed by ','videogall'); ?><a href="http://www.nischalmaniar.com"><?php _e('Nischal Maniar','videogall'); ?></a>
            </td>
            </tr></table>
        </div>
    </div>
    <?php
}

/**
 * Validating the options before saving
 */
function videogall_validate_options($input) {
    $output = $defaults = videogall_get_default_options();

    //Validating dropdowns and radio options
    if (isset($input['video_size']) && array_key_exists($input['video_size'], videogall_video_size_list()))
	$output['video_size'] = $input['video_size'];
    if (isset($input['thumbnail_size']) && array_key_exists($input['thumbnail_size'], videogall_thumbnail_size_list()))
	$output['thumbnail_size'] = $input['thumbnail_size'];

    //Validating Color Boxes
    if(videogall_validate_color($input['border_color']))
        $output['border_color'] = $input['border_color'];

    //Validating number fields
    if(videogall_validate_number($input['videos_per_page'],0,99999))
	$output['videos_per_page'] = $input['videos_per_page'];
    
    //Validating all the checkboxes
    $chkboxinputs = array('enable_border','enable_pagination','enable_shadowbox_images');
    foreach($chkboxinputs as $chkbox) {
        if (!isset($input[$chkbox]))
            $input[$chkbox] = null;
        $output[$chkbox] = ($input[$chkbox] == true ? true : false);
    }
    
    return apply_filters('videogall_validate_options', $output, $input, $defaults);
}

/**
 * Processing functions
 */
function videogall_process_url($url) {
    $thumb = '';
    $newurl = '';
    //Getting youtube's thumbnail
    if(preg_match('/youtube/',$url) > 0 or preg_match('/youtu.be/',$url) > 0) {
        if(preg_match('/embed/',$url) > 0) {
            $pos = strpos($url,'?');
            if($pos > 0)
                $url = substr($url,0,$pos);
            $pos = strpos($url,'&');
            if($pos > 0)
                $url = substr($url,0,$pos);
            $url = str_ireplace('http://www.youtube.com/embed/','',$url);
            $url = str_ireplace('http://youtube.com/embed/','',$url);
        } else if(preg_match('/watch/',$url) > 0) {
            $pos = strpos($url,'&');
            if($pos > 0)
                $url = substr($url,0,$pos);
            $url = str_ireplace('http://www.youtube.com/watch?v=','',$url);
            $url = str_ireplace('http://youtube.com/watch?v=','',$url);
        } else {
            $url = str_ireplace('http://www.youtube/','',$url);
            $url = str_ireplace('http://youtube/','',$url);
            $url = str_ireplace('http://youtu.be/','',$url);
        }
        $url = str_ireplace('/','',$url);
        $newurl = 'http://www.youtube.com/embed/'.$url;
        $thumb = 'http://img.youtube.com/vi/'.$url.'/default.jpg';
    }
    elseif(preg_match('/metacafe/',$url) > 0) {
        $url = str_ireplace('http://www.metacafe.com/watch/','',$url);
        $url = str_ireplace('http://metacafe.com/watch/','',$url);
        $url = rtrim($url,'\/');
        if(preg_match('/metacafe\.com\/fplayer/',$url) > 0)
            $newurl = $url;
        else
            $newurl = 'http://www.metacafe.com/fplayer/'.$url.'.swf';
        $pos = strpos($url,'/');
        if($pos > 0)
            $url = substr($url,0,$pos);
        $url = str_ireplace('/','',$url);
        $thumb = 'http://www.metacafe.com/thumb/'.$url.'.jpg';
    }
    elseif(preg_match('/dailymotion/',$url) > 0) {
        $thumb = str_ireplace('video','thumbnail/video',$url);
        $user = str_ireplace('http://www.dailymotion.com/video/','',$url);
        $pos = strpos($user,'_');
        if($pos > 0)
            $user = substr($user,0,$pos);
        if(preg_match('/dailymotion.com\/embed\/video/',$url) > 0)
            $newurl = $url;
        else
            $newurl = 'http://www.dailymotion.com/embed/video/'.$user;
    }
    elseif(preg_match('/vimeo/',$url) > 0) {
        $url = str_ireplace('http://www.vimeo.com/','',$url);
        $url = str_ireplace('http://vimeo.com/','',$url);
        if(preg_match('/player\.vimeo\.com/',$url) > 0)
            $newurl = $url;
        else
            $newurl = 'http://player.vimeo.com/video/'.$url;
        $thumb = getVimeoThumb($url);
    }
    elseif(preg_match('/google/',$url) > 0) {
        $url = str_replace('http://video.google.com/videoplay?docid=','',$url);
        $url = str_replace('http://www.video.google.com/videoplay?docid=','',$url);
        $url = rtrim($url,'\/');
        $newurl = 'http://video.google.com/googleplayer.swf?docid='.$url;
        $thumb = VIDEOGALL_DIR_URL.'images/default.png';
    }
    elseif(videogall_is_wordpress($url)) {
        $newurl = videogall_wordpress_url($url);
        $thumb = VIDEOGALL_DIR_URL.'images/default.png';
    }
    else {
        $newurl = $url;
        $thumb = VIDEOGALL_DIR_URL.'images/default.png';
    }
    return array('url'=>$newurl,'thumbnail'=>$thumb);
}

function getVimeoThumb($url) {
    $apiurl = 'http://vimeo.com/api/v2/video/'.$url.'.php';
    $contents = @file_get_contents($apiurl);
    $array = @unserialize(trim($contents));
    return $array[0][thumbnail_medium];
}

function videogall_wordpress_url($url) {
    global $site_content;
    if(preg_match('/\<embed.*src\=\"(.+)\".*\>.*\<\/embed\>/',$site_content,$matches) > 0) {
        $pos = strpos($matches[1],'"');
        $url = substr($matches[1],0,$pos);
    }
    if(preg_match('/\<iframe.*src\=\"(.+)\".*\>.*\<\/iframe\>/',$site_content,$matches) > 0) {
        $pos = strpos($matches[1],'"');
        $url = substr($matches[1],0,$pos);
    }
    return $url;
}

function videogall_is_wordpress($url) {
    global $site_content;
    videogall_get_site_data($url);
    if(preg_match('/\<meta(.*)content\=\"WordPress/',$site_content) > 0)
        return true;
    else return false;
}

function videogall_get_site_data($url) {
    global $site_content;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,1);
    curl_setopt($ch,CURLOPT_TIMEOUT,5);
    $site_content = curl_exec($ch);
    curl_close($ch);
}

/**
 * Support functions for validation
 */
function videogall_validate_color($color) {
    $exp = "/([A-Za-z0-9])/";
    if(!preg_match($exp,$color))
        return false;
    else
        return true;
}

function videogall_validate_image_url($url) {
    $exp = "/^https?:\/\/(.)*\.(jpg|png|gif|ico)$/i";
    if(!preg_match($exp,$url))
        return false;
    else
        return true;
}

function videogall_validate_image_size($url,$width,$height) {
    $size = getimagesize($url);
    if($size[0] > $width or $size[1] > $height)
        return false;
    else
        return true;
}

function videogall_validate_number($value,$min,$max) {
    if(is_numeric($value)) {
        $value = intval($value);
        if($value < $min or $value > $max)
            return false;
        else
            return true;
    } else return false;
}

function videogall_validate_decimal($value) {
    if(is_numeric($value))
        return true;
    else return false;
}

function videogall_validate_social_user($user) {
    $exp = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*$/";
    if(!preg_match($exp,$user))
        return false;
    else
        return true;
}

function videogall_sanitize_field($input) {
    if(isset($input)) {
	$output = trim(wp_filter_nohtml_kses($input));
	return $output;
    } else return "";
}

function videogall_sanitize_textarea($input) {
    if(isset($input)) {
	$allowed = array('p' => array(),'h1' => array(),'h2' => array(),'h3' => array(),'h4' => array(),'h5' => array(),'h6' => array(),'a' => array('href' => array(),'title' => array()),'br' => array(),'em' => array(),'strong' => array()); 
	$output = wp_kses($input,$allowed);
	return $output;
    } else return "";
}
?>