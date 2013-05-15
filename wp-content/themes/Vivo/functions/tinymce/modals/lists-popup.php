<?php
// this file contains the contents of the popup window
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Insert Tabs</title>
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
		var icon = jQuery('#button-dialog select#button-icon').val();
		var items = jQuery('#button-dialog input#button-items').val(); 
 
		// convert items to an integer
		var intItems = parseInt(items);
 
		var output = '';
 
		// setup the output of our shortcode
		output = '[list ';
			output += 'icon="' + icon + '"';
		output += ']<br\/>';
 
		//output all list items
		for(var i=1; i<=intItems; i++) {
			output += '[li]ENTER CONTENT[/li]<br\/>';
		}
 
		// output ending
		output += '[/list]<br\/>';
		
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
				<label for="button-icon">Icon Type</label>
				<select name="button-icon" id="button-icon" size="1">
					<option value="add" selected="selected">Add</option>
					<option value="black"=>Black</option>
					<option value="blue">Blue</option>
					<option value="cross">Cross</option>
					<option value="delete">Delete</option>
					<option value="go">Go</option>
					<option value="green">Green</option>
					<option value="orange">Orange</option>
					<option value="pink">Pink</option>
					<option value="purple">Purple</option>
					<option value="red">Red</option>
					<option value="star">Star</option>
					<option value="tick">Tick</option>
					<option value="yellow">Yellow</option>
				</select>
			</div>
			<div>
				<label for="button-items">How many items?</label>
				<input type="text" name="button-items" value="" id="button-items" />
			</div>
			<div>	
				<a href="javascript:ButtonDialog.insert(ButtonDialog.local_ed)" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>