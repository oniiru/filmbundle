(function() {
	tinymce.create('tinymce.plugins.buttonMboxes', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mcemboxes', function() {
				ed.windowManager.open({
					file : url + '/modals/mboxes-popup.php', // file that contains HTML for our modal window
					width : 220 + parseInt(ed.getLang('button.delta_width', 0)), // size of our window
					height : 240 + parseInt(ed.getLang('button.delta_height', 0)), // size of our window
					inline : 1
				}, {
					plugin_url : url
				});
			});
 
			// Register buttons
			ed.addButton('md_mboxes', {title : 'Insert Message Box', cmd : 'mcemboxes', image: url + '/icons/mboxes.png' });
		},
 
		getInfo : function() {
			return {
				longname : 'Insert Message Box',
				author : 'Martin Burdon',
				authorurl : 'http://mushindesign.co.uk',
				infourl : 'http://mushindesign.co.uk',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});
 
	// Register plugin
	// first parameter is the button ID and must match ID elsewhere
	// second parameter must match the first parameter of the tinymce.create() function above
	tinymce.PluginManager.add('md_mboxes', tinymce.plugins.buttonMboxes);
 
})();