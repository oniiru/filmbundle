document.documentElement.className = "js";
/*****
    Start Scripts
*****/
jQuery(document).ready(function($) {

//fade content in when doc ready
$('#content').fadeIn("normal");

/*****
    Create the responsive menu
*****/
    //For each link in the nav
    jQuery('#primary_nav li >a').each(function() {
        //Get the link object
        var a=jQuery(this);
        //Create a new 'option' and append it to the select menu
        var new_option = jQuery('select.responsive_menu').append( new Option(a.text(),a.attr('href')) );
        //Get the closest ul's class
        var ul = a.closest('ul').attr('class');
        //If the class is 'sub-menu'
        if(ul == 'sub-menu')
        {
            jQuery(new_option.text).append("- ");

            //var ulul = a.closest('ul').parent().closest('ul').attr('class');
            //if(ulul == 'sub-menu')
            //{
                //jQuery(a).prepend("- ");
            //}
        }

    });

/*****
    Make the responsive select menu clickable
*****/
    jQuery( ".responsive_menu" ).change(
        function() { 
            window.location = jQuery(this).find("option:selected").val();
        }
    );

/*****
    Superfish
*****/
    $('ul.sf-menu').superfish({ 
            delay:       200,                            // one second delay on mouseout 
            animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
            speed:       'fast',                          // faster animation speed 
            autoArrows:  true,                           // disable generation of arrow mark-up 
            dropShadows: false                            // disable drop shadows 
    });

/*****
    Hidden area
*****/
$(".showhide").click(function(){
    //get current position of the sidebar
    var currentPos = jQuery(this).attr('id');

    if(currentPos == 'closed')
    {
        $('#container').animate({'opacity': '0.4'});
        //change the css to 0px from top
        $('#widget_area').stop().animate({'left': '0'}, 200, 'swing');
        //...and change the buttons id to open
        $('.showhide').attr('id', 'open');
        //Change text of button
        $('.showhide').text('<');
    }
    else if(currentPos == 'open')
    {
        $('#container').animate({'opacity': '1'});
        //change the css top to the height of the container
        $('#widget_area').stop().animate({'left': '-250px'}, 200, 'swing');
        //...and change the buttons id to closed
        $('.showhide').attr('id', 'closed');
        //Change text of button
        $('.showhide').text('>');
    }
});

/*****
    Slide In Overlays on work items
*****/
    $('.work_thumb').hover(
        //on hover
        function() {
            $this = $(this);
             $this.find('.work_item_overlay').stop().animate({opacity:0.5},100, 'jswing');
             $this.find('.overlay_zoom').stop().animate({right:"0px"},200, 'jswing');
             $this.find('.overlay_link').stop().delay(100).animate({right:"0px"},200, 'jswing');
            },
        //On hover out
        function() {
            $this.find('.work_item_overlay').stop().animate({opacity:0},100, 'jswing');
            $this.find('.overlay_zoom').stop().delay(100).animate({right:'-60px'},200, 'jswing');
            $this.find('.overlay_link').stop().animate({right:'-60px'},200, 'jswing');
    });

/*****
    Masonry Blog
*****/
var $container = $('#posts_container');

//Load masonry on posts
$container.imagesLoaded( function(){

    $container.animate({'opacity': '1'});
    $('#loader').fadeOut("fast");

    $container.isotope({
      itemSelector: '.post',
      transformsEnabled: false
    });

});

/*****
    Show/Hide Contact Form
*****/
$('.contact_close').click(function(){
    var form = ('#content');

    //hide the contact form
    jQuery(form).animate({'left': '-1000px'}, 500, 'swing');
    //bring out the open contact form button after a delay
    jQuery('.contact_open').delay(450).animate({'left': '249px'}, 200, 'swing');
    //bring out the open contact form button on smaller displays
    jQuery('.contact_open_responsive').delay(450).animate({'left': '0px'}, 200, 'swing');

});

//Does the same as the non-responsive but hides the main-sidebar also
$('.contact_close_responsive').click(function(){
    var form = ('#content');

    //hide the contact form
    jQuery(form).animate({'left': '-1000px'}, 500, 'swing');
    //bring out the open contact form button after a delay
    jQuery('.contact_open').delay(450).animate({'left': '249px'}, 200, 'swing');
    //bring out the open contact form button on smaller displays
    jQuery('.contact_open_responsive').delay(450).animate({'left': '0px'}, 200, 'swing');

    //for iPhone
    var $headerHeight = $('#main_sidebar').height();
    var $navHeight = $('#primary_nav_container').height();
    var $toHide = $headerHeight - $navHeight;

    $('#main_sidebar').animate({'top': '-'+$toHide+'px'}, 500, 'swing');

});

$('.contact_open').click(function(){
    var form = ('#content');
    //hide the contact open button
    jQuery('.contact_open').animate({'left': '199px'}, 100, 'swing');
    //hide the contact open button on smaller displays
    jQuery('.contact_open_responsive').animate({'left': '-50px'}, 100, 'swing');
    //slide in the contact form
    jQuery(form).delay(250).animate({'left': '0px'}, 200, 'swing');
});

//Does the same as the non-responsive but brings the main-sidebar back in also
$('.contact_open_responsive').click(function(){
    var form = ('#content');
    //hide the contact open button
    jQuery('.contact_open').animate({'left': '199px'}, 100, 'swing');
    //hide the contact open button on smaller displays
    jQuery('.contact_open_responsive').animate({'left': '-50px'}, 100, 'swing');
    //slide in the contact form
    jQuery(form).delay(250).animate({'left': '0px'}, 200, 'swing');

    //for iPhone
    $('#main_sidebar').delay(250).animate({'top': '0px'}, 200, 'swing');
});

/*****
    Togglers
*****/
	//Hide (Collapse) the toggle containers on load
	$(".toggle_container").hide(); 

	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	$("h4.trigger").click(function(){
		$(this).toggleClass("active").next().slideToggle("fast");
		return false; //Prevent the browser jump to the link anchor
	});
 
/*****
    prettyPhoto
*****/
	$("a[rel^='prettyPhoto']").prettyPhoto();

/*****
    Remove jPlayer controls on iOS devices
*****/
    if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) {
        var volume = $('.jp-volume-bar-container');
        volume.remove();
        var mute = $('.jp-mute');
        mute.remove();
    }   

/*****
    End Scripts
*****/
});