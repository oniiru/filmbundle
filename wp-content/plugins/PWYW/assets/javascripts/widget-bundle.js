jQuery(document).ready(function($) {

    /** Holds the database ID of the currently displayed film */
    var current_film = undefined;


    // -------------------------------------------------------------------------
    // Catch Interaction
    // -------------------------------------------------------------------------

    /**
     * Handle the logic when clicking films on the shelf
     */
    $('.pwyw-bundle-show').click(function() {
        var id = $(this).data('id');

        // if current_film is undefined, we shall open the info section
        // else we shall change film, or close it.
        if (current_film == undefined) {
            $('.pwyw-bundle-info').slideDown('fast');
            slideToFilm(id);
            
            // Scroll document to the film section
            // The extra 80 pixels is to compensate for the top menu bar
            $('html, body').animate({
                scrollTop: $('.pwyw-bundle-info').offset().top - 80
            }, 500);
        } else {
            // if clicked the opened film, lets close the view
            // else load the new film into the view 
            if (current_film == id) {
                $('.pwyw-bundle-info').slideUp('fast', function() {
                    current_film = undefined;
                });
            } else {
                slideToFilm(id);
            }
        }
    });

    /**
     * Handle the logic for previous and next buttons
     */
    $('.pwyw-previous').click(function() {
        var prev = findNextPrev('prev');
        if (prev == undefined) {
            prev = findLast();
        }
        slideToFilm(prev);
    });
    $('.pwyw-next').click(function() {
        var next = findNextPrev('next');
        if (next == undefined) {
            next = findFirst();
        }
        slideToFilm(next);
    });

    /**
     * Handle the logic for the film tabs.
     */
    $('.pwyw-tabs .tab').click(function() {
        // Set selected class for tab buttons
        $('.pwyw-film[data-id='+current_film+'] .pwyw-tabs a')
            .removeClass('selected');
        $(this).addClass('selected');

        // Get selected tab
        var tab = $(this).data(tab);

        // Display selected tab
        $('.pwyw-film[data-id='+current_film+'] [class^=pwyw-tab-]').hide();
        $('.pwyw-film[data-id='+current_film+'] .pwyw-tab-'+tab.tab).show();
    });



    function slideToFilm(id)
    {
        var film = $('.pwyw-film[data-id='+id+']');
        var position  = -film.position().left;

        $('.pwyw-films').animate({left: position}, 'slow', 'swing', function() {
            // Animation complete
            current_film = id;
        });
    }


    // -------------------------------------------------------------------------
    // Helpers 
    // -------------------------------------------------------------------------

    /**
     * Finds the next or previous film in relation to current displayed film.
     *
     * @param direction 'next' or 'prev'
     * @returns integer or undefined
     */
    function findNextPrev(direction)
    {
        // Prepare variables
        var ctr = 0;
        var offset = (direction == 'next') ? 1 : -1;
        var found = undefined;

        // Loop through all films
        $('.pwyw-films').children().each(function () {
            var id = $(this).data('id');
            if (id == current_film) {
                var children = $('.pwyw-films').children();
                var find = children[ctr + offset];
                found = $(find).data('id');
            }
            ctr++;
        });
        return found;
    }

    /**
     * Finds the first film div and returns its database ID.
     *
     * @return integer
     */
    function findFirst()
    {
        return $('.pwyw-film').first().data('id');
    }

    /**
     * Finds the last film div and returns its database ID.
     *
     * @return integer
     */
    function findLast()
    {
        return $('.pwyw-film').last().data('id');
    }
});
