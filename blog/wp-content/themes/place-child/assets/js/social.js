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
