<?php
// this file contains the contents of the popup window
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Insert Toggle</title>
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
		var type = jQuery('#button-dialog select#cbox-type').val();
		var title = jQuery('#button-dialog input#cbox-title').val();  
		var text = jQuery('#button-dialog textarea#cbox-text').val();  
 
		var output = '';
 
		// setup the output of our shortcode
		output = '[textbox ';
			output += 'style="' + type + '" ';
			output += 'title="' + title + '"';
 
		// check to see if the TEXT field is blank
		if(text) {	
			output += ']'+ text + '[/textbox]&nbsp;';
		}
		// if it is blank, use the selected text, if present
		else {
			output += ']'+ButtonDialog.local_ed.selection.getContent() + '[/textbox]&nbsp;';
		}
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
				<label for="cbox-type">Type</label>
				<select name="cbox-type" id="cbox-type" size="1">
					<option value="light" selected="selected">Light</option>
					<option value="dark">Dark</option>
				</select>
			</div>
			<div>
				<label for="cbox-title">Title</label>
				<input type="text" name="cbox-title" value="" id="cbox-title" />
			</div>
			<div>
				<label for="cbox-text">Box Content</label>
				<textarea name="cbox-text" value="" id="cbox-text"></textarea>
			</div>
			<div>	
				<a href="javascript:ButtonDialog.insert(ButtonDialog.local_ed)" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>