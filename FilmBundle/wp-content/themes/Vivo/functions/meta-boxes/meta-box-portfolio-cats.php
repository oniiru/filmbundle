<?php
/*
	This file contains the base code to create meta boxes
	Copy the code from here and ensure you change:
	-- function names with 'custom' in (ie. add_custom_meta_box, save_custom_meta)
	-- custom_meta_fields
	-- show_custom_meta_box
	-- Basically anything with the word custom in
*/

// Add the actual Meta Box
function add_port_cats_meta_box() {
    add_meta_box(
		'port_cats_meta_box', // $id - for CSS styling
		'Project types to show (Portfolio)', // $title - displayed in handle of box
		'show_port_cats_meta_box', // $callback - function used to define output inside box
		'page', // $page - where to display meta box
		'side', // $context - where box will show up on page
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_port_cats_meta_box');

// Field Array
$prefix = 'mb_';
$port_cats_meta_fields = array(
	array(
		'label'=> 'Project type',
		'desc'	=> 'Select what project types to show if using one of the portfolio templates.',
		'id'	=> $prefix.'select',
		'type'	=> 'select',
		'options' => array (
			'all' => array (
				'label' => 'All',
				'value'	=> 'all'
			)
		)
	)
);

// The Callback
function show_port_cats_meta_box() {
global $port_cats_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($port_cats_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
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

						// Get portfolio terms
						$taxonomy = 'project-type';
						$categories = get_terms($taxonomy);
												
					   // List the portfolio terms
					   foreach($categories as $category) {
					   		$label = $category->name;
					   		$value = str_replace('-', '', $category->slug);
					   		//Setting value as 'label' here instead of 'value' as need the text exactly as is...
					   		//...so can query the category text in portfolio template pages
					   		echo '<option', $meta == $label ? ' selected="selected"' : '', ' value="'.$label.'">'.$label.'</option>';
						}

						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}


// Save the Data
function save_port_cats_meta($post_id) {
    global $port_cats_meta_fields;

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
	foreach ($port_cats_meta_fields as $field) {
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
add_action('save_post', 'save_port_cats_meta');  
?>