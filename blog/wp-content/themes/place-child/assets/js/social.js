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
    //Hide modal box
    $('#closeModal').click(
        function() {
		    // $('.socialModalWrap').fadeTo('slow', 0);
        	$('.socialModalWrap').hide();
        }
    );
        
    $(window).scroll(function () {
        // Outputs current scroll position
        console.log($(window).scrollTop());
    });
})(jQuery);

function showSocialModal()
{
    $('.socialModalWrap').show();
    $('.socialModalOverlay').hide();
    $('.socialModalBox').hide();
    $('.socialModalOverlay').fadeIn('slow');
    $('.socialModalBox').fadeIn('slow');
}
