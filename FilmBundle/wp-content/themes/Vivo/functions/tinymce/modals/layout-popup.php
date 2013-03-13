<?php
// this file contains the contents of the popup window
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Insert Quote</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.js"></script>
<script language="javascript" type="text/javascript" src="../../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="../../../wp-includes/js/tinymce/themes/advanced/skins/wp_theme/dialog.css"></style>
<link rel="stylesheet" href="buttons_tinymce.css" />

<script type="text/javascript">
 
var ButtonDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ButtonDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
 
		// Try and remove existing style / blockquote
		//tinyMCEPopup.execCommand('mceRemoveNode', false, null);
 
		// set up variables to contain our input values
		var type = jQuery('#button-dialog select#layout-type').val();
 
		var output = '';
 
		// setup the output of our shortcode
		output = '[' + type + '] ';
			output += ' Insert your content here ';
		output += '[/' + type + ']';
 
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ButtonDialog.init, ButtonDialog);
 
</script>
</head>
<body>
	<div id="button-dialog">
		<form action="/" method="get" accept-charset="utf-8">
			<div>
				<label for="layout-type">Type</label>
				<select name="layout-type" id="layout-type" size="1">
					<option value="one_third" selected="selected">One Third</option>
					<option value="one_third_last">One Third Last</option>
					<option value="two_third">Two Third</option>
					<option value="two_third_last">Two Third Last</option>
					<option value="one_half">One Half</option>
					<option value="one_half_last">One Half Last</option>
					<option value="one_fourth">One Fourth</option>
					<option value="one_fourth_last">One Fourth Last</option>
					<option value="three_fourth">Three Fourth</option>
					<option value="three_fourth_last">Three Fourth Last</option>
					<option value="one_fifth">One Fifth</option>
					<option value="one_fifth_last">One Fifth Last</option>
					<option value="two_fifth">Two Fifth</option>
					<option value="two_fifth_last">Two Fifth Last</option>
					<option value="three_fifth">Three Fifth</option>
					<option value="three_fifth_last">Three Fifth Lasr</option>
					<option value="four_fifth">Four Fifth</option>
					<option value="four_fifth_last">Four Fifth Last</option>
					<option value="one_sixth">One Sixth</option>
					<option value="one_sixth_last">One Sixth Last</option>
					<option value="five_sixth">Five Sixth</option>
					<option value="five_sixth_last">Five Sixth Last</option>
				</select>
			</div>
			<div>	
				<a href="javascript:ButtonDialog.insert(ButtonDialog.local_ed)" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>