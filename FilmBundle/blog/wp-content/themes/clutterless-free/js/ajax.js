jQuery(document).ready(function($) {
    var $mainContent = $("#content"),
        siteUrl = "http://" + top.location.host.toString(),
        url = '';	
		var fileUrl = document.URL;
		var filename = fileUrl.substring(fileUrl.lastIndexOf('/')+1);		
    $(document).delegate("a[href^='"+siteUrl+"']:not([href*='/wp-admin/']):not([href*='/clutterless/wp-login.php/']):not([href$='/feed/'])", "click", function() {
		if(filename!='wp-login.php?loggedout=true' && filename !='wp-login.php')
		{
			if(this.pathname!='/clutterless/wp-login.php')
			{
				location.hash = this.pathname;
				return false;
			}
		}
    }); 
    $("#search-form").submit(function(e) {
		if(location.hash !='')
		{
			location.hash ='';
		}
        location.hash = '?s=' + $("#search-field").val();
        e.preventDefault();
    }); 
    $(window).bind('hashchange', function(){
        url = window.location.hash.substring(1); 
        if (!url) {
            return;
        } 
        url = url + " #post"; 
        $mainContent.animate({opacity: "0.1"}).html("<img src='http://opldemos.wpengine.com/wp-content/themes/clutterless/img/ajax-loader.gif'/>").load(url, function() {
            $mainContent.animate({opacity: "1"});
        });
    });
    $(window).trigger('hashchange');
});