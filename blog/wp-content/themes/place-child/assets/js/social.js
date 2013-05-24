function handleSocialWin(url, title)
{
    var win = window.open(url, title,'width=600,height=350,status=0,toolbar=0');
    var timer = setInterval(function() {
        if(win.closed) {
            clearInterval(timer);
            // alert('closed');
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
        
    $(window).scroll(function (){
        // Outputs current scroll position
        console.log($(window).scrollTop());
    });
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

function onPlayerReady(event) {
  var embedCode = event.target.getVideoEmbedCode();
  event.target.playVideo();
  if (document.getElementById('embed-code')) {
    document.getElementById('embed-code').innerHTML = embedCode;
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
