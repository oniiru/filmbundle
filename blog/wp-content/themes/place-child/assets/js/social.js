/* Change this value to decide how far to scroll before sliding out the box */
var socialSlideVerticalThreshold = 0;

function handleSocialWin(url, title)
{
    var win = window.open(url, title,'width=600,height=350,status=0,toolbar=0');
    var timer = setInterval(function() {
        if(win.closed) {
            clearInterval(timer);
			showSocialModal();
        }
    }, 1000);
    return win;
}

(function($)
{
    $('#closeModal').click(
        function() {
	    	hideSocialModal();
        }
    );

    $('#disableModal').click(
        function() {
	    	disableSocialModal();
        }
    );

    $('.socialModalOverlay').click(
        function() {
	    	hideSocialModal();
        }
    );

    // -----
    // Slide
    // -----
     
    $(window).scroll(function (){
		var pos = $(window).scrollTop();
        var win_width = $(window).width();
		if (pos > socialSlideVerticalThreshold && win_width > 960) {
			showSocialSlide();
		}
		if (pos < (socialSlideVerticalThreshold+1)) {
			hideSocialSlide();
		}
    });

    $('#closeSocialSlide').click(
        function() {
	    	$('.socialSlideWrap').hide();
        }
    );

    $('#disableSocialSlide').click(
        function() {
	    	disableSocialSlide();
        }
    );
})(jQuery);

function showSocialModal()
{
	if (readCookie('socialModal') == 'disabled') {
		return;
	}

    $('.socialModalWrap').show();
    $('.socialModalOverlay').hide();
    $('.socialModalBox').hide();

    $('.socialModalOverlay').fadeIn('slow');
    $('.socialModalBox').fadeIn('slow');
    $('.socialModalVerticalOffset').animate({ 
        	top: "30%",
        },
        'slow'
    );
}

function hideSocialModal()
{
    $('.socialModalVerticalOffset').animate({ 
        	top: "0%",
        },
        'slow'
    );
    $('.socialModalOverlay').fadeOut('slow');
    $('.socialModalBox').fadeOut('slow', function() {
		$('.socialModalWrap').hide();
    });
}

function disableSocialModal()
{
	createCookie('socialModal', 'disabled', 30);
	hideSocialModal();
}

function showSocialSlide()
{
	if (readCookie('socialSlide') == 'disabled') {
		return;
	}

	$('.socialSlideWrap').stop(true, false);
    $('.socialSlideWrap').animate({ 
        	right: "0px",
        },
        'slow'
    );
}

function hideSocialSlide()
{
	$('.socialSlideWrap').stop(true, false);
    $('.socialSlideWrap').animate({
        	right: "-290px",
        },
        'slow'
    );
}

function disableSocialSlide()
{
	createCookie('socialSlide', 'disabled', 30);
	$('.socialSlideWrap').hide();
}


function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}

// -----------------------------------------------------------------------------
// YouTube API
// https://developers.google.com/youtube/iframe_api_reference
// -----------------------------------------------------------------------------

function onytplayerStateChange(newState) {
   alert("Player's new state: " + newState);
}
function onYouTubePlayerReady(playerId) {
  ytplayer = document.getElementById("post_video_wrapper");
  // note: callback function defined EARLIER
  ytplayer.addEventListener("onStateChange", onytplayerStateChange);
}

// -----------------------------------------------------------------------------
// Vimeo API
// http://developer.vimeo.com/player/js-api
// -----------------------------------------------------------------------------
var f = $('iframe'),
    url = f.attr('src').split('?')[0];

// Listen for messages from the player
if (window.addEventListener){
    window.addEventListener('message', onMessageReceived, false);
}
else {
    window.attachEvent('onmessage', onMessageReceived, false);
}

// Handle messages received from the player
function onMessageReceived(e) {
	if (typeof(e) != 'object') {
		return;
	}
	if (e.origin != 'http://player.vimeo.com') {
		return;
	}
    var data = JSON.parse(e.data);
    
    switch (data.event) {
        case 'ready':
            onReady();
            break;
        case 'finish':
            onFinish();
            break;
    }
}

// Helper function for sending a message to the player
function post(action, value) {
    var data = { method: action };
    
    if (value) {
        data.value = value;
    }
    
    f[0].contentWindow.postMessage(JSON.stringify(data), url);
}

function onReady() {
    post('addEventListener', 'finish');
}

function onFinish() {
	showSocialModal();
}
