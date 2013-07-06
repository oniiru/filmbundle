jQuery(document).ready(function($) {

    /** Holds the object of the currently selected film */
    var selected_film = undefined;

    // -------------------------------------------------------------------------
    // Catch Interaction
    // -------------------------------------------------------------------------

    /**
     * Handle the logic when clicking films on the shelf
     */
    $('.pwyw-bundle-show').click(function() {
        var id = $(this).data('id');

        // if selected_film is undefined, we shall open the info section
        // else we shall change film, or close it.
        if (selected_film == undefined) {
            selected_film = getFilmById(id);
            update();
            $('.pwyw-bundle-info').slideDown('fast');
        } else {
            // if clicked the opened film, lets close the view
            // else load the new film into the view 
            if (selected_film.id == id) {
                $('.pwyw-bundle-info').slideUp('fast', function() {
                    selected_film = undefined;
                });
            } else {
                selected_film = getFilmById(id);
                update();
            }
        }
        // console.log(selected_film.id);
        // if ($('.pwyw-bundle-info').is(':visible'))
    });

    /**
     * Handle the logic for previous and next buttons
     */
    $('.pwyw-previous').click(function() {
        console.log('previous');
    });
    $('.pwyw-next').click(function() {
        console.log('next');
    });

    /**
     * Update the information section with the current selected film object
     */
    function update()
    {
        $('.pwyw-tabs h3').html(selected_film.title);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Lookup a film in the film object array.
     *
     * @returns object
     */
    function getFilmById(id)
    {
        for (var key in pwyw_films) {
            if(pwyw_films.hasOwnProperty(key)){
                if (pwyw_films[key].id == id) {
                    return pwyw_films[key];
                }
            }
        }
        return false;
    }

});
