<?php
// this file contains the contents of the popup window
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Insert Button</title>
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
		var url = jQuery('#button-dialog input#button-url').val();
		var text = jQuery('#button-dialog input#button-text').val();
		var size = jQuery('#button-dialog select#button-size').val();
		var style = jQuery('#button-dialog select#button-style').val();		 
		var shape = jQuery('#button-dialog select#button-shape').val();	 
 
		var output = '';
 
		// setup the output of our shortcode
		output = '[button ';
			output += 'size="' + size + '" ';
			output += 'shape="' + shape + '" ';
			output += 'style="' + style + '"';
 
			// only insert if the url field is not blank
			if(url)
				output += ' link="' + url + '"';
		// check to see if the TEXT field is blank
		if(text) {	
			output += ']'+ text + '[/button]&nbsp;';
		}
		// if it is blank, use the selected text, if present
		else {
			output += ']'+ButtonDialog.local_ed.selection.getContent() + '[/button]&nbsp;';
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
				<label for="button-url">Button URL</label>
				<input type="text" name="button-url" value="" id="button-url" />
			</div>
			<div>
				<label for="button-text">Button Text</label>
				<input type="text" name="button-text" value="" id="button-text" />
			</div>
			<div>
				<label for="button-size">Size</label>
				<select name="button-size" id="button-size" size="1">
					<option value="small" selected="selected">Small</option>
					<option value="large">Large</option>
				</select>
			</div>
			<div>
				<label for="button-shape">Shape</label>
				<select name="button-shape" id="button-shape" size="1">
					<option value="round">Round</option>
					<option value="square" selected="selected">Square</option>
				</select>
			</div>
			<div>
				<label for="button-style">Color</label>
				<select name="button-style" id="button-style" size="1">
					<option value="red" selected="selected">Red</option>
					<option value="green"=>Green</option>
					<option value="orange">Orange</option>
					<option value="blue">Blue</option>
					<option value="lightblue">Light Blue</option>
					<option value="purple">Purple</option>
					<option value="black">Black</option>
					<option value="white">White</option>
					<option value="pink">Pink</option>
				</select>
			</div>
			<div>	
				<a href="javascript:ButtonDialog.insert(ButtonDialog.local_ed)" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>