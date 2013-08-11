

var min=0;
var max=100;

jQuery(document).ready(function($) {
    $(".selector").slider(   
        { animate: true },
        { min: min },
        { max: max },
        {change: function(event, ui) {
            $('.filmmakerpercent').val($("#slider_filmmakers").slider("value"));
            $('.charitypercent').val($("#slider_charities").slider("value"));
            $('.bundlepercent').val($("#slider_bundle").slider("value"));
        }},
        {slide: function(event, ui) {
            $('.filmmakerpercent').val($("#slider_filmmakers").slider("value"));
            $('.charitypercent').val($("#slider_charities").slider("value"));
            $('.bundlepercent').val($("#slider_bundle").slider("value"));
        }
    });

    $('.filmmakerpercent').val($("#slider_filmmakers").slider("value"));
    $('.charitypercent').val($("#slider_charities").slider("value"));
    $('.bundlepercent').val($("#slider_bundle").slider("value"));
    
    $(".charitypercent").change(function() {
        $("#slider_charities").slider("value" , $(this).val())
	});

    $(".filmmakerpercent").change(function() {
        $("#slider_filmmakers").slider("value" , $(this).val())
	});

    $(".bundlepercent").change(function() {
        $("#slider_bundle").slider("value" , $(this).val())
	});
    	
    $(function () {
    	$('div.linked3').linkedSliders({ 
            total: 100,  // The total for all the linked sliders 
            policy: 'next' // Adjustment policy: 'next', 'prev', 'first', 'last', 'all' 
        });
    });
});
