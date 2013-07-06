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
    });

    /**
     * Handle the logic for previous and next buttons
     */
    $('.pwyw-previous').click(function() {
        var key = getCurrentFilmKey();
        key--;
        // Loop array if beginning reached
        if (key < 0) {
            key = pwyw_films.length - 1;
        }
        selected_film = pwyw_films[key];
        update();
    });
    $('.pwyw-next').click(function() {
        var key = getCurrentFilmKey();
        key++;
        // Loop array if end reached
        if (key >= pwyw_films.length) {
            key = 0;
        }
        selected_film = pwyw_films[key];
        update();
    });

    /**
     * Handle the logic for the film tabs.
     */
    $('.pwyw-tabs .tab').click(function() {
        var tab = $(this).data(tab);

        $('[class^=pwyw-tab-]').hide();
        $('.pwyw-tab-'+tab.tab).show();
    });

    /**
     * Update the information section with the current selected film object
     */
    function update()
    {
        // reset tabs
        $('[class^=pwyw-tab-]').hide();
        $('.pwyw-tab-overview').show();

        // Set title
        $('.pwyw-tabs h3').html(selected_film.title);

        // Populate the overview tab
        for (var prop in selected_film) {
            if(selected_film.hasOwnProperty(prop)){
                $('.pwyw-tab-overview .'+prop).html(selected_film[prop]);
            }
        }

        // Populate the reviews tab
        $(".pwyw-tab-reviews").empty();
        var reviews = selected_film.reviews;
        for (var key in reviews) {
            var review = parseTemplate(reviews[key], review_template);
            $('.pwyw-tab-reviews').append(review);
        }
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

    /**
     * Get the key of the currently selected film in the film array
     *
     * @returns integer
     */
    function getCurrentFilmKey()
    {
        var id = selected_film.id;
        for (var key in pwyw_films) {
            if(pwyw_films.hasOwnProperty(key)){
                if (pwyw_films[key].id == id) {
                    return key;
                }
            }
        }
        return false;
    }

    /**
     * Parse a template to replace holders with data from the supplied object
     *
     * @returns string
     */
    function parseTemplate(dataObj, template)
    {
        for (var prop in dataObj) {
            template = template.replace('{'+prop+'}', dataObj[prop]);
        }
        return template
    }

    // -------------------------------------------------------------------------
    // Templates
    // -------------------------------------------------------------------------
    var review_template = "\
    <div class='pwyw-review'> \
        <div class='review'>{review}</div> \
        <div class='author'>{author}</div> \
        <div class='publication'>{publication}</div> \
        <div class='link'>{link}</div> \
    </div> \
    ";
});
