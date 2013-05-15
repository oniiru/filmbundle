//To launch media uploader (meta box script)
jQuery(function(jQuery) {

	jQuery('.custom_upload_image_button').click(function() {
		formfield = jQuery(this).siblings('.custom_upload_image');
		preview = jQuery(this).siblings('.custom_preview_image');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			classes = jQuery('img', html).attr('class');
			id = classes.replace(/(.*?)wp-image-/, '');
			formfield.val(id);
			preview.attr('src', imgurl);
			preview.css("max-width", "300px");
			preview.css("height", "auto");
			tb_remove();
		}

		return false;
	});

	jQuery('.custom_clear_image_button').click(function() {
		var defaultImage = jQuery(this).parent().siblings('.custom_default_image').text();
		jQuery(this).parent().siblings('.custom_upload_image').val('');
		jQuery(this).parent().siblings('.custom_preview_image').attr('src', defaultImage);
		jQuery(this).parent().siblings('.custom_preview_image').css("width", "auto");
		return false;
	});

});

//Add/Remove and Sortable (meta box script)
jQuery(document).ready(function() {
	jQuery('.repeatable-add').click(function() {
		field = jQuery(this).closest('td').find('.custom_repeatable li:last').clone(true);
		fieldLocation = jQuery(this).closest('td').find('.custom_repeatable li:last');
		jQuery('input', field).val('').attr('name', function(index, name) {
			return name.replace(/(\d+)/, function(fullMatch, n) {
				return Number(n) + 1;
			});
		})
		field.insertAfter(fieldLocation, jQuery(this).closest('td'))
		return false;
	});

	jQuery('.repeatable-remove').click(function(){
		jQuery(this).parent().remove();
		return false;
	});

	jQuery('.custom_repeatable').sortable({
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		handle: '.sort'
	});

	//Add/remove image
	/*jQuery('.repeatable-add-image').click(function() {
		field = jQuery(this).closest('td').find('.custom_repeatable-image li:last').clone(true);
		fieldLocation = jQuery(this).closest('td').find('.custom_repeatable-image li:last');
		
		field.insertAfter(fieldLocation, jQuery(this).closest('td'))
		return false;
	});

	jQuery('.repeatable-remove-image').click(function(){
		jQuery(this).parent().remove();
		return false;
	});

	jQuery('.custom_repeatable-image').sortable({
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		handle: '.sort'
	});*/
});