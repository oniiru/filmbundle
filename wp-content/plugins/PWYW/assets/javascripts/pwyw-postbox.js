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
                    if ( $(this).find('#dashboard_browser_nag').is(':visible') && 'dashboard_browser_nag' != this.firstChild.id ) {
                        $(this).sortable('cancel');
                        return;
                    }

                    postboxes.save_order(page);
                },
                receive: function(e,ui) {
                    if ( 'dashboard_browser_nag' == ui.item[0].id )
                        $(ui.sender).sortable('cancel');

                    postboxes._mark_area();
                }
            });

            if ( isMobile ) {
                $(document.body).bind('orientationchange.postboxes', function(){ postboxes._pb_change(); });
                this._pb_change();
            }

            this._mark_area();
        },

        save_order : function(page) {
        //     var postVars, page_columns = $('.columns-prefs input:checked').val() || 0;

        //     postVars = {
        //         action: 'meta-box-order',
        //         _ajax_nonce: $('#meta-box-order-nonce').val(),
        //         page_columns: page_columns,
        //         page: page
        //     }
        //     $('.meta-box-sortables').each( function() {
        //         postVars["order[" + this.id.split('-')[0] + "]"] = $(this).sortable( 'toArray' ).join(',');
        //     } );
        //     $.post( ajaxurl, postVars );
        },

        _mark_area : function() {
            // var visible = $('div.postbox:visible').length, side = $('#post-body #side-sortables');

            // $('#dashboard-widgets .meta-box-sortables:visible').each(function(n, el){
            //     var t = $(this);

            //     if ( visible == 1 || t.children('.postbox:visible').length )
            //         t.removeClass('empty-container');
            //     else
            //         t.addClass('empty-container');
            // });

            // if ( side.length ) {
            //     if ( side.children('.postbox:visible').length )
            //         side.removeClass('empty-container');
            //     else if ( $('#postbox-container-1').css('width') == '280px' )
            //         side.addClass('empty-container');
            // }
        },

        // _pb_edit : function(n) {
        //     var el = $('.metabox-holder').get(0);
        //     el.className = el.className.replace(/columns-\d+/, 'columns-' + n);
        // },

        // _pb_change : function() {
        //     var check = $( 'label.columns-prefs-1 input[type="radio"]' );

        //     switch ( window.orientation ) {
        //         case 90:
        //         case -90:
        //             if ( !check.length || !check.is(':checked') )
        //                 this._pb_edit(2);
        //             break;
        //         case 0:
        //         case 180:
        //             if ( $('#poststuff').length ) {
        //                 this._pb_edit(1);
        //             } else {
        //                 if ( !check.length || !check.is(':checked') )
        //                     this._pb_edit(2);
        //             }
        //             break;
        //     }
        // },

        /* Callbacks */
        pbshow : false,

        pbhide : false
    };

}(jQuery));

jQuery(document).ready( function($) {
    postboxes.add_postbox_toggles(pagenow);
});
