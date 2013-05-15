/* VideoGall Specific JavaScript */
jQuery(document).ready(function() {
    //Animating paging
    jQuery('.videogall-nav-item').click(function() {
        var currentNavId = jQuery('.current-video-page').attr("id");
        var clickedNavId = jQuery(this).attr("id");
        if(clickedNavId != currentNavId) {
            var showPageId = clickedNavId.replace('nav-item','page');
            jQuery('.videogall-page').hide();
            jQuery('#' + showPageId).fadeIn(500);
            jQuery('.videogall-nav-item').removeClass('current-video-page');
            jQuery(this).addClass('current-video-page');
        }
    });
    
    jQuery('.videogall-thumb').hover(function() {
        var currThumb = jQuery(this).attr('id');
        jQuery('.videogall-thumb[id!="' + currThumb +'"]').stop().animate({opacity: 0.3}, 800);
    }, function() {
        jQuery('.videogall-thumb').stop().animate({opacity: 1.0}, 800);
    });
});