(function($) {
	
	
	// Background color
	$('#custom_bg_color').miniColors({
		change: function(hex, rgba) {
			$('body').css('background-color', hex);
		}
	});
	
	// Background pattern
	$( "#custom_bg_image img" ).each(function( index ) {
		var pattern =  $(this).data('img');									  
		$(this).css('background-image',  'url(' + template + '/images/bg/'+ pattern +'.png)');  
	});
	
	$('#custom_bg_image img').click(function(e) {
		var pattern =  $(this).data('img');	
		e.preventDefault();
		$('body').css('background-image', 'url(' + template + '/images/bg/' + pattern + '.png)');
		$(this).parent().find('img').removeClass('selected');
		$(this).addClass('selected');
		
	});
	
	// Reset
	$('#reset_style').click(function(e) {
		setTimeout('location.reload(true);', 0);
	});
	
	// Control panel
	$('#panel_control').click(function(){
		if ( $(this).hasClass('control-open') ) {
			$('#pl_control_panel').animate( { left: 0 }, {easing: 'easeOutCirc'}, 300);
			$(this).removeClass('control-open');
			$(this).addClass('control-close');
		} else {
			$('#pl_control_panel').animate( { left: -301 },{easing: 'easeOutCirc'}, 300 );
			$(this).removeClass('control-close');
			$(this).addClass('control-open');
		}
		return false;
	});	

})(jQuery);	