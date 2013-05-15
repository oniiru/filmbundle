(function() {
	tinymce.create('tinymce.plugins.buttonLists', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mcelists', function() {
				ed.windowManager.open({
					file : url + '/modals/lists-popup.php', // file that contains HTML for our modal window
					width : 220 + parseInt(ed.getLang('button.delta_width', 0)), // size of our window
					height : 240 + parseInt(ed.getLang('button.delta_height', 0)), // size of our window
					inline : 1
				}, {
					plugin_url : url
				});
			});
 
			// Register buttons
			ed.addButton('md_lists', {title : 'Insert List', cmd : 'mcelists', image: url + '/icons/lists.png' });
		},
 
		getInfo : function() {
			return {
				longname : 'Insert Lists',
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
	tinymce.PluginManager.add('md_lists', tinymce.plugins.buttonLists);
 
})();