<?php
/*
	Meta boxes for Portfolio post type
*/

// Add the actual Meta Box
function add_portfolio_meta_box() {
    add_meta_box(
		'portfolio_meta_box', // $id - for CSS styling
		'Project Options', // $title - displayed in handle of box
		'show_portfolio_meta_box', // $callback - function used to define output inside box
		'portfolio_post_type', // $page - where to display meta box
		'normal', // $context - where box will show up on page
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_portfolio_meta_box');

// Field Array
$prefix = 'mb_';
$portfolio_meta_fields = array(
	array(
		'label'=> 'Project Link',
		'desc'	=> 'Add a link to the live project (Leave blank to disable).',
		'id'	=> $prefix.'text',
		'type'	=> 'text'
	),
	array(
		'label'=> 'Embed Video',
		'desc'	=> 'The video embed code, remove the height and width attributes to make the video responsive.</br><strong>Adding a video here will override the gallery images below.</strong>',
		'id'	=> $prefix.'video',
		'type'	=> 'textarea'
	),
	array(
		'label'=> 'Project images </br><strong>Recommended size: 670px width or wider by any height</strong>',
		'name'	=> 'Image',
		'desc'	=> 'Upload an image to be shown on the single page carousel.',
		'id'	=> $prefix.'image_port1',
		'type'	=> 'image'
	),
	array(
		'name'	=> 'Image',
		'desc'	=> 'Upload an image to be shown on the single page carousel.',
		'id'	=> $prefix.'image_port2',
		'type'	=> 'image'
	),
	array(
		'name'	=> 'Image',
		'desc'	=> 'Upload an image to be shown on the single page carousel.',
		'id'	=> $prefix.'image_port3',
		'type'	=> 'image'
	),
	array(
		'name'	=> 'Image',
		'desc'	=> 'Upload an image to be shown on the single page carousel.',
		'id'	=> $prefix.'image_port4',
		'type'	=> 'image'
	),
	array(
		'name'	=> 'Image',
		'desc'	=> 'Upload an image to be shown on the single page carousel.',
		'id'	=> $prefix.'image_port5',
		'type'	=> 'image'
	),
);

// The Callback
function show_portfolio_meta_box() {
global $portfolio_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($portfolio_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					// case items will go here
					// text
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// textarea
					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
							<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox
					case 'checkbox':
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
							<label for="'.$field['id'].'">'.$field['desc'].'</label>';
					break;
					// select
					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// radio
					case 'radio':
						foreach ( $field['options'] as $option ) {
							echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
					break;
					// checkbox_group
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' />
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break; 
					// tax_select
					case 'tax_select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
						$terms = get_terms($field['id'], 'get=all');
						$selected = wp_get_object_terms($post->ID, $field['id']);
						foreach ($terms as $term) {
							if (!empty($selected) && !strcmp($term->slug, $selected[0]->slug))
								echo '<option value="'.$term->slug.'" selected="selected">'.$term->name.'</option>';
							else
								echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
						}
						$taxonomy = get_taxonomy($field['id']);
						echo '</select><br /><span class="description"><a href="'.get_bloginfo('home').'/wp-admin/edit-tags.php?taxonomy='.$field['id'].'">Manage '.$taxonomy->label.'</a></span>';
					break;
					// post_list
					case 'post_list':
					$items = get_posts( array (
						'post_type'	=> $field['post_type'],
						'posts_per_page' => -1
					));
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
							foreach($items as $item) {
								echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_type.': '.$item->post_title.'</option>';
							} // end foreach
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// image
					case 'image':
						$image = get_template_directory_uri().'/admin/images/no_image.png';
						echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
						if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium');	$image = $image[0]; }
						echo	'<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
									<img src="'.$image.'" class="custom_preview_image" alt="" /><br />
										<input class="custom_upload_image_button button" type="button" value="Choose Image" />
										<small> <a href="#" class="custom_clear_image_button">Remove Image</a></small>
										<br clear="all" /><span class="description">'.$field['desc'].'';
					break;
					// repeatable
					case 'repeatable':
						echo '<a class="repeatable-add button" href="#">+</a>
								<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
						$i = 0;
						if ($meta) {
							foreach($meta as $row) {
								echo '<li><span class="sort hndle">|||</span>
											<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="'.$row.'" size="30" />
											<a class="repeatable-remove button" href="#">-</a></li>';
								$i++;
							}
						} else {
							echo '<li><span class="sort hndle">|||</span>
										<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="" size="30" />
										<a class="repeatable-remove button" href="#">-</a></li>';
						}
						echo '</ul>
							<span class="description">'.$field['desc'].'</span>';
					break;
					// repeatable
					/*case 'repeatable':
						echo '<a class="repeatable-add-image button" href="#">+</a>
								<ul id="'.$field['id'].'-repeatable" class="custom_repeatable-image">';
						$i = 0;
						if ($meta) {
							foreach($meta as $row) {
								$image = wp_get_attachment_image_src($meta, 'medium');	$image = $image[0];
								echo '<li><span class="sort hndle">|||</span>
									<input name="'.$field['id'].'['.$i.']" type="hidden" class="custom_upload_image" value="'.$meta.'" />
									<img src="'.$image.'" class="custom_preview_image" alt="" /><br />
									<input class="custom_upload_image_button button" type="button" value="Choose Image" />
									<small> <a href="#" class="custom_clear_image_button">Remove Image</a></small>
									<br clear="all" />
									<a class="repeatable-remove-image button" href="#">-</a></li>';
								$i++;
							}
						} else {
							echo '<li><span class="sort hndle">|||</span>
								<input name="'.$field['id'].'['.$i.']" type="hidden" class="custom_upload_image" value="" />
								<img src="" class="custom_preview_image" alt="" /><br />
								<input class="custom_upload_image_button button" type="button" value="Choose Image" />
								<small> <a href="#" class="custom_clear_image_button">Remove Image</a></small>
								<br clear="all" />
								<a class="repeatable-remove-image button" href="#">-</a></li>';
						}
						echo '</ul>
							<span class="description">'.$field['desc'].'</span>';
					break;*/
				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}


// Save the Data
function save_portfolio_meta($post_id) {
    global $portfolio_meta_fields;

	// verify nonce
	if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}

	// loop through fields and save the data
	foreach ($portfolio_meta_fields as $field) {
		if($field['type'] == 'tax_select') continue;
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach

	// save taxonomies
	$post = get_post($post_id);
	$category = $_POST['category'];
	wp_set_object_terms( $post_id, $category, 'category' );
}
add_action('save_post', 'save_portfolio_meta');  
?>