function handleSocialWin()
{
    var win = window.open('http://www.google.com', 'google','width=800,height=600,status=0,toolbar=0');
    var timer = setInterval(function() {
        if(win.closed) {
            clearInterval(timer);
            // alert('closed');
            $('.socialModalWrap').show();
        }
    }, 1000);
}


(function($) {
    //Hide modal box
    $('#closeModal').click(
        function() {$('.socialModalWrap').hide();}
    );
        
    $(window).scroll(function () {
        // Outputs current scroll position
        console.log($(window).scrollTop());
    });
})(jQuery);
