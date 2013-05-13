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
		var uid = jQuery('#button-dialog input#button-uid').val();
		var tabs = jQuery('#button-dialog input#button-tabs').val(); 
 
		// convert tabs to an integer
		var intTabs = parseInt(tabs);
 
		var output = '';
 
		// setup the output of our shortcode
		output = '[tabgroup ';
			output += 'id="' + uid + '"';
		output += ']<br\/>';
 
		//output all tabs
		for(var i=1; i<=intTabs; i++) {
			output += '[tab title="ENTER TITLE"]ENTER CONTENT[/tab]<br\/>';
		}
 
		// output ending
		output += '[/tabgroup]<br\/>';
		
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
				<label for="button-uid">Tabs Unique ID</label>
				<input type="text" name="button-uid" value="" id="button-uid" />
			</div>
			<div>
				<label for="button-tabs">How many tabs?</label>
				<input type="text" name="button-tabs" value="" id="button-tabs" />
			</div>
			<div>	
				<a href="javascript:ButtonDialog.insert(ButtonDialog.local_ed)" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>