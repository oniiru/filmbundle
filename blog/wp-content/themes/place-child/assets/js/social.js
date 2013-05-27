/* Change this value to decide how far to scroll before sliding out the box */
var socialSlideVerticalThreshold = 750;

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
function onYTPlayerReady(event) {
    var iframes = document.getElementsByTagName('iframe');
   
    for (var i = 0; i < iframes.length; i++) {
        var iframe = iframes[i];
        var players = /www.youtube.com|player.vimeo.com/;
        if(iframe.src.search(players) !== -1) {
            var videoRatio = (iframe.height / iframe.width) * 100;
            var id = iframe.id.replace('player_', '');
            if (yt_player_ready[id] == true) {
                return;
            }

            iframe.style.position = 'absolute';
            iframe.style.top = '0';
            iframe.style.left = '0';
            iframe.width = '100%';
            iframe.height = '100%';
            
            var div = document.createElement('div');
            div.className = 'video-wrap';
            div.style.width = '100%';
            div.style.position = 'relative';
            div.style.paddingTop = videoRatio + '%';
            
            var parentNode = iframe.parentNode;
            parentNode.insertBefore(div, iframe);
            div.appendChild(iframe);
            yt_player_ready[id] = true;

            // Show the player
            jQuery('#'+iframe.id).show();
        }
    }
}

function onYTPlayerStateChange(event) {
    if (event.data == YT.PlayerState.ENDED) {
        showSocialModal();
    }
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
