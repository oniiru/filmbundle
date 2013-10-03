jQuery(document).ready(function($) {

    /** Holds the database ID of the currently displayed film */
    var current_film = undefined;

    /** Holds the database ID of the currently displayed charity */
    var current_charity = undefined;

    /** Hold the easing method to use for animations */
    var easing = 'easeInOutSine';

    /** PubNub Setup */
    var pubnub_subscribe_key = 'sub-c-ef114922-f1ea-11e2-b383-02ee2ddab7fe';
    var pubnub_channel       = 'filmbundle';


    // -------------------------------------------------------------------------
    // PubNub handling
    // -------------------------------------------------------------------------
    var pubnub = $.PUBNUB.init({
        subscribe_key : pubnub_subscribe_key
    });

    pubnub.subscribe({
        channel : pubnub_channel,
        message : function(m){
            // console.log(m);

            /** Update the average price numbers */
            var average = parseFloat(m.averagePrice).toFixed(2);
            $('.pwyw-bundle .pwyw-average-amount').text('$'+average);
        }
    });


    // -------------------------------------------------------------------------
    // Purchase button: Catch Clicks
    // -------------------------------------------------------------------------
    $('#pwyw-purchase-button').click(function() {
        $('html, body').animate({
            scrollTop: $('.stats-footer').offset().top - 79
        }, 'slow', easing);
    });


    // -------------------------------------------------------------------------
    // FILM: Catch Interaction
    // -------------------------------------------------------------------------

    /**
     * Handle the logic when clicking films on the shelf
     */
    $('.pwyw-bundle-show').click(function() {
        var id = $(this).data('id');

        // If the charity section is opened, let's start by closing it.
        if (current_charity != undefined) {
            closeSection('charity');
        }

        // if current_film is undefined, we shall open the info section
        // else we shall change film, or close it.
        if (current_film == undefined) {
            $('.pwyw-bundle-info').slideDown('slow', easing);
            goTo(id, '.pwyw-films', '.pwyw-film');
            
            // Scroll document to the film section
            // The extra 80 pixels is to compensate for the top menu bar
            $('html, body').animate({
                scrollTop: $('.pwyw-bundle-info').offset().top - 80
            }, 'slow', easing);
        } else {
            // if clicked the opened film, lets close the view
            // else load the new film into the view 
            if (current_film == id) {
                closeSection('film');
            } else {
                slideTo(id, '.pwyw-films', '.pwyw-film');
	            $('html, body').animate({
	                scrollTop: $('.pwyw-bundle-info').offset().top - 80
	            }, 'slow', easing);
            }
        }
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


    // -------------------------------------------------------------------------
    // CHARITIES: Catch Interaction
    // -------------------------------------------------------------------------

    /**
     * Handle the logic when clicking films on the shelf
     */
    $('.pwyw-charity-show').click(function() {
        var id = $(this).data('id');

        // If the film section is opened, let's start by closing it.
        if (current_film != undefined) {
            closeSection('film');
        }

        // if current_charity is undefined, we shall open the info section
        // else we shall change film, or close it.
        if (current_charity == undefined) {
            $('.pwyw-charity-info').slideDown('slow', easing);
            goTo(id, '.pwyw-charities', '.pwyw-charity');
            
            // Scroll document to the film section
            // The extra 80 pixels is to compensate for the top menu bar
            if ($('.pwyw-bundle-info').css('display') == 'none') {
                var targetDiv = '.pwyw-charity-info';
            } else {
                var targetDiv = '.pwyw-bundle-info';
            }

            $('html, body').animate({
                scrollTop: $(targetDiv).offset().top - 80
            }, 'slow', easing);
        } else {
            // if clicked the opened film, lets close the view
            // else load the new film into the view 
            if (current_charity == id) {
                closeSection('charity');
            } else {
                slideTo(id, '.pwyw-charities', '.pwyw-charity');
	            $('html, body').animate({
	                scrollTop: $('.pwyw-charity-info').offset().top - 80
	            }, 'slow', easing);
            }
        }
    });


    // -------------------------------------------------------------------------
    // Sliding 
    // -------------------------------------------------------------------------

    /**
     * Animates the position to scroll to the selected film/charity.
     *
     * @param id
     * @param container
     * @param single
     * @return void
     */
    function slideTo(id, container, single)
    {
        var div = $(single+'[data-id='+id+']');
        var position  = -div.position().left;

        $(container).animate({left: position}, 'slow', easing, function() {
            // Animation complete
            setHolderVal(container, id);
        });
    }

    /**
     * Changes the film position to immediately go to the selected film.
     */
    function goTo(id, container, single)
    {
        var film = $(single+'[data-id='+id+']');
        var position  = -film.position().left;

        $(container).css({left: position});
        setHolderVal(container, id);
    }

    /**
     * Slides up and closes the film section.
     *
     * @param section
     * @return void
     */
    function closeSection(section)
    {
        if (section == 'film') {
            $('.pwyw-bundle-info').slideUp('slow', easing, function() {
                current_film = undefined;
            });
        }
        if (section == 'charity') {
            $('.pwyw-charity-info').slideUp('slow', easing, function() {
                current_charity = undefined;
            });
        }
    }


    // -------------------------------------------------------------------------
    // Navigation 
    // -------------------------------------------------------------------------

    /**
     * Handle the logic for previous and next buttons
     */
    $('.pwyw-previous').click(function() {
        var container = $(this).parent().data('container');
        var single = $(this).parent().data('single');

        var prev = findNextPrev('prev', container);
        if (prev == undefined) {
            prev = findLast(single);
        }
        slideTo(prev, container, single);
    });
    $('.pwyw-next').click(function() {
        var container = $(this).parent().data('container');
        var single = $(this).parent().data('single');

        var next = findNextPrev('next', container);
        if (next == undefined) {
            next = findFirst(single);
        }
        slideTo(next, container, single);
    });

    /**
     * Finds the next or previous film in relation to current displayed film.
     *
     * @param direction 'next' or 'prev'
     * @param container containing div for all slide elements
     * @return integer or undefined
     */
    function findNextPrev(direction, container)
    {
        // Prepare variables
        var ctr = 0;
        var offset = (direction == 'next') ? 1 : -1;
        var found = undefined;

        // Loop through sliding elements
        $(container).children().each(function () {
            var id = $(this).data('id');
            if (id == getHolderVal(container)) {
                var children = $(container).children();
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
     * @param string single
     * @return integer
     */
    function findFirst(single)
    {
        return $(single).first().data('id');
    }

    /**
     * Finds the last film div and returns its database ID.
     *
     * @param string div
     * @return integer
     */
    function findLast(single)
    {
        return $(single).last().data('id');
    }


    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Get current DB id for a container
     *
     * @param container
     * @return int
     */
    function getHolderVal(container)
    {
        if (container == '.pwyw-films') {
            return current_film;
        }
        if (container == '.pwyw-charities') {
            return current_charity;
        }
    }

    /**
     * Set current DB id for a container
     *
     * @param container
     * @param val
     * @return void
     */
    function setHolderVal(container, val)
    {
        if (container == '.pwyw-films') {
            current_film = val;
        }
        if (container == '.pwyw-charities') {
            current_charity = val;
        }
    }
});
