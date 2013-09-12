var postboxes;

(function($) {
    postboxes = {
        add_postbox_toggles : function(page, args) {
            var self = this;

            self.init(page, args);

            $('.postbox h3, .postbox .handlediv').bind('click.postboxes', function() {
                var p = $(this).parent('.postbox'), id = p.attr('id');

                p.toggleClass('closed');

                if (p.hasClass('closed')) {
                    $('#'+id+'_postboxstate').val('closed');
                } else {
                    $('#'+id+'_postboxstate').val('open');
                }

                if ( id ) {
                    if ( !p.hasClass('closed') && $.isFunction(postboxes.pbshow) )
                        self.pbshow(id);
                    else if ( p.hasClass('closed') && $.isFunction(postboxes.pbhide) )
                        self.pbhide(id);
                }
            });
        },

        init : function(page, args) {
            var isMobile = $(document.body).hasClass('mobile');

            $.extend( this, args || {} );
            $('#wpbody-content').css('overflow','hidden');
            $('.meta-box-sortables').sortable({
                placeholder: 'sortable-placeholder',
                connectWith: '.meta-box-sortables',
                items: '.postbox',
                handle: '.hndle',
                cursor: 'move',
                delay: ( isMobile ? 200 : 0 ),
                distance: 2,
                tolerance: 'pointer',
                forcePlaceholderSize: true,
                helper: 'clone',
                opacity: 0.65,
                stop: function(e,ui) {
                    var sortIDs = $('.meta-box-sortables').sortable('toArray');
                    var sort = 0;
                    _.each(sortIDs, function(id) {
                        $('#'+id+'_sort').val(sort);
                        sort++;
                    });
                },
            });
        },

        /* Callbacks */
        pbshow : false,

        pbhide : false
    };

}(jQuery));

jQuery(document).ready( function($) {
    postboxes.add_postbox_toggles(pagenow);
});
