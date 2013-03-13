(function() {
    tinymce.create('tinymce.plugins.videogall', {
        init : function(ed, url) {
            ed.addButton('videogall', {
                title : 'Add Video Gallery',
                image : url+'/videogall-button.png',
                onclick : function() {
                     ed.selection.setContent('[myvideogall:all' + ed.selection.getContent() + ']');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('videogall', tinymce.plugins.videogall);
})();