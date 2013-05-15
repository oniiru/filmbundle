(function() {
    tinymce.create('tinymce.plugins.buttonSep', {
        init : function(ed, url) {
            ed.addButton('md_sep', {
                title : 'Insert Separator',
                image : url + '/icons/sep.png',
                onclick : function() {
                    ed.execCommand('mceInsertContent', false, '[sep1]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Brett's YouTube Shortcode",
                author : 'Brett Terpstra',
                authorurl : 'http://brettterpstra.com/',
                infourl : 'http://brettterpstra.com/',
                version : tinymce.majorVersion + "." + tinymce.minorVersion
            };
        }
    });
    tinymce.PluginManager.add('md_sep', tinymce.plugins.buttonSep);
})();