jQuery(document).ready(function($) {

    // Amount buttons
    // -------------------------------------------------------------------------
    $('.customshow').hide();
    $('.pwyw-amount button').click(function() {

        updateSliders($(this).val());

        if ($(this).attr('id') == 'custom_price') {
            $('.customshow').fadeIn('fast');
        } else {
            $('.customshow').fadeOut('fast');
        }
    });

    // Only allow numbers in the custom price field
    $('.pwyw-checkout .custompricefield').keypress(function(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
    });

    // Update the value in the custom price button, and sliders
    $('.pwyw-checkout .custompricefield').change(function() {
        var new_amount = $(this).val();
        $('.pwyw-amount button#custom_price').val(new_amount);
        updateSliders(new_amount);
    });


    // Sliders
    // -------------------------------------------------------------------------

    function updateSliders(new_amount)
    {
        // Convert to a number, as linkedsliders gets problem otherwise
        new_amount = Math.floor(new_amount);

        $('div.linked3').linkedSliders('destroy');

        var input_class = 'percent';
        $('.'+input_class).each(function(){
            // Recalc the values
            var id = $(this).attr('id').match(/(.+)_inp/)[1];
            var slider = $('#slider_'+id);

            // Old values percentage of old amount
            var old_value = $(this).val();
            var percentage = old_value / bundle_checkout_amount;

            // New value based on new amount and the percentage
            var new_value = percentage * new_amount;
            slider.attr('value', new_value);
        });

        bundle_checkout_amount = new_amount;

        setSliderHandlers('linked3', 'percent', new_amount);
    }


    function setSliderHandlers(slider_class, input_class, max_val)
    {
        var default_val = 0;
        $('.'+input_class).val(0);

        $("."+slider_class ).slider(
            { animate: false },
            { min: 0 },
            { max: max_val },
            {change: function(event, ui) {
                var id = $(this).attr('id').match(/slider_(.+)/)[1];
                $('#'+id+'_inp').val($(this).slider('value'));
            }},
            {slide: function(event, ui) {
                var id = $(this).attr('id').match(/slider_(.+)/)[1];
                $('#'+id+'_inp').val($(this).slider('value'));
            }
        });

        $('.'+input_class).each(function(){
            var id = $(this).attr('id').match(/(.+)_inp/)[1];
            var slider = $('#slider_'+id);

            if(slider.attr('value') != ''){
                $(this).val(slider.attr('value'));
                slider.slider("value",slider.attr('value'));
            }else{
                $(this).val(default_val);
            }

            $(this).change(function(){
                slider.slider("value" , $(this).val());
            })
        });

        $('div.'+slider_class).linkedSliders({
            total: max_val,      // The total for all the linked sliders
            policy: 'next'   // Adjustment policy: 'next', 'prev', 'first', 'last', 'all'
        });

    }

    setSliderHandlers('linked3', 'percent', 100);
    setSliderHandlers('sub_charities','charities_percent', 100);
    setSliderHandlers('sub_filmmakers','filmmakers_percent', 100);

    // Set initial amount
    var new_amount = $('.pwyw-amount button').first().val();
    new_amount = Math.floor(new_amount);
    updateSliders(new_amount);

    // Handle the dive deeper buttons
    $('.dive-deeper').click(function() {
        var id = $(this).data('id');
        $(id).toggle('slow');
    });
    $('.dive-deeper').tooltip({
        placement: 'top',
        html: true
    });

    function updateSliderTotalAmount(slider_class, amount) {
        console.log(amount);

        $('div.'+slider_class).linkedSliders({
            total: 200,
            policy: 'next'
        });
    }
});
