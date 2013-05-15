<?php
// this file contains the contents of the popup window
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Insert Header Icon</title>
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
		var type = jQuery('#button-dialog select#header-type').val();
		var title = jQuery('#button-dialog input#header-title').val();  
		var text = jQuery('#button-dialog textarea#header-text').val();  
 
		var output = '';
 
		// setup the output of our shortcode
		output = '[icon ';
			output += 'icon="' + type + '"]';
			output += title + '[/icon]';
 
		// check to see if the TEXT field is blank
		if(text) {	
			output += text;
		}
		// if it is blank, use the selected text, if present
		else {
			output += ButtonDialog.local_ed.selection.getContent();
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
				<label for="header-type">Icon</label>
				<select name="header-type" id="header-type" size="1">
					<option value="alert" selected="selected">Alert</option>
					<option value="basket">Basket</option>
					<option value="bulb">Bulb</option>
					<option value="calendar">Calendar</option>
					<option value="cart">Cart</option>
					<option value="chart">Chart</option>
					<option value="cloud">Cloud</option>
					<option value="cog">Cog</option>
					<option value="create">Create</option>
					<option value="denied">Denied</option>
					<option value="download_cloud">Download Cloud</option>
					<option value="download">Download</option>
					<option value="film_strip">Film Strip</option>
					<option value="flag">Flag</option>
					<option value="globe">Globe</option>
					<option value="help">Help</option>
					<option value="home">Home</option>
					<option value="info">Info</option>
					<option value="link">Link</option>
					<option value="mail">Mail</option>
					<option value="map">Map</option>
					<option value="marker">Marker</option>
					<option value="paperclip">Paperclip</option>
					<option value="paypal">Paypal</option>
					<option value="pricetag">Pricetag</option>
					<option value="robot">Robot</option>
					<option value="search">Search</option>
					<option value="sound">Sound</option>
					<option value="speech">Speech</option>
					<option value="tag">Tag</option>
					<option value="upload_cloud">Upload Cloud</option>
					<option value="upload">Upload</option>
					<option value="user">User</option>
					<option value="users">Users</option>
				</select>
			</div>
			<div>
				<label for="header-title">Title</label>
				<input type="text" name="header-title" value="" id="header-title" />
			</div>
			<div>
				<label for="header-text">Content</label>
				<textarea name="header-text" value="" id="header-text"></textarea>
			</div>
			<div>	
				<a href="javascript:ButtonDialog.insert(ButtonDialog.local_ed)" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>