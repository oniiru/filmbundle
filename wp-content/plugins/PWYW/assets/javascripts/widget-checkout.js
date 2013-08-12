jQuery(document).ready(function($) {

    // Hide elements that can be revealed later
    $('.customshow').hide();
    $('[id^=dive-]').hide();

    // Amount buttons
    // -------------------------------------------------------------------------
    $('.pwyw-amount button').click(function() {

        var new_amount = $(this).val();
        updateSliders('linked3', 'percent', new_amount, bundle_checkout_amount);

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
        updateSliders('linked3', 'percent', new_amount, bundle_checkout_amount);
    });


    // Sliders
    // -------------------------------------------------------------------------
    var init_sliders = true;
    function updateSliders(slider_class, input_class, new_amount, old_amount)
    {
        // Convert to a number, as linkedsliders gets problem otherwise
        new_amount = Math.floor(new_amount);

        // Get rid of the current sliders, so we can calc new options
        $('div.'+slider_class).linkedSliders('destroy');

        $('.'+input_class).each(function(){
            // Recalc the values
            var id = $(this).attr('id').match(/(.+)_inp/)[1];
            var slider = $('#slider_'+id);

            // Old values percentage of old amount
            var old_value = $(this).val();
            var percentage = old_value / old_amount;

            // New value based on new amount and the percentage
            var new_value = percentage * new_amount;
            slider.attr('value', new_value);

            // Update eventual subsliders
            if (init_sliders) {
                old_value = 100;
                init_sliders = false;
            }
            if ($(this).attr('id') == 'filmmakers_inp') {
                updateSliders(
                    'sub_filmmakers',
                    'filmmakers_percent',
                    new_value,
                    old_value
                );
            }
            if ($(this).attr('id') == 'charities_inp') {
                updateSliders(
                    'sub_charities',
                    'charities_percent',
                    new_value,
                    old_value
                );
            }
        });

        // If it's the main sliders, updated the checkout amount
        if (slider_class == 'linked3') {
            bundle_checkout_amount = new_amount;
        }

        // Recreate the sliders with the new settings
        setSliderHandlers(slider_class, input_class, new_amount);
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

                var old_value = $('#'+id+'_inp').val();
                var new_value = $(this).slider('value');
                if (id == 'filmmakers') {
                    updateSliders(
                        'sub_filmmakers',
                        'filmmakers_percent',
                        new_value,
                        old_value
                    );
                }
                if (id == 'charities') {
                    updateSliders(
                        'sub_charities',
                        'charities_percent',
                        new_value,
                        old_value
                    );
                }
            }},
            {slide: function(event, ui) {
                var id = $(this).attr('id').match(/slider_(.+)/)[1];
                $('#'+id+'_inp').val($(this).slider('value'));

                var old_value = $('#'+id+'_inp').val();
                var new_value = $(this).slider('value');
                if (id == 'filmmakers') {
                    updateSliders(
                        'sub_filmmakers',
                        'filmmakers_percent',
                        new_value,
                        old_value
                    );
                }
                if (id == 'charities') {
                    updateSliders(
                        'sub_charities',
                        'charities_percent',
                        new_value,
                        old_value
                    );
                }
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
            total: max_val,  // The total for all the linked sliders
            policy: 'next'   // Adjustment policy: 'next', 'prev', 'first', 'last', 'all'
        });

    }

    // Set initial amount
    var new_amount = $('.pwyw-amount button').first().val();
    new_amount = Math.floor(new_amount);
    updateSliders('linked3', 'percent', new_amount, bundle_checkout_amount);

    // Handle the dive deeper buttons
    $('.dive-deeper').click(function() {
        var id = $(this).data('id');
        $(id).toggle('slow');
    });
    $('.dive-deeper').tooltip({
        placement: 'top',
        html: true
    });
});
