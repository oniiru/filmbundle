jQuery(document).ready(function($) {

    /** PubNub Setup */
    var pubnub_subscribe_key = 'sub-c-ef114922-f1ea-11e2-b383-02ee2ddab7fe';
    var pubnub_channel       = 'filmbundle';

    /** Hold the easing method to use for animations */
    var easing = 'easeInOutSine';


    // Hide elements that can be revealed later
    // -------------------------------------------------------------------------
    $('.customshow').hide();
    $('[id^=dive-]').hide();


    // PubNub handling
    // -------------------------------------------------------------------------
    var pubnub = $.PUBNUB.init({
        subscribe_key : pubnub_subscribe_key
    });

    pubnub.subscribe({
        channel : pubnub_channel,
        message : function(m){
            /** Update Global Variables */
            avg_price = parseFloat(m.averagePrice);
            min_amount = parseFloat(m.minAmount);

            /** Update the stats section */
            $('#pwyw-total-sales').text(m.totalSales);
            $('#pwyw-average-price').text(
                '$'+parseFloat(m.averagePrice).toFixed(2)
            );
            $('#pwyw-total-payments').text(
                '$'+parseFloat(m.totalPayments).toFixed(2)
            );

            /** Update top contributors */
            // Prepare
            var contributors = new Array();
            for (var key in m.contributors) {
                var item = "<li>{n} <span class='pull-right'>${a}</span></li>";
                var name = m.contributors[key].name;
                var amount = parseFloat(m.contributors[key].amount).toFixed(2);
                item = item.replace('{n}', name);
                item = item.replace('{a}', amount);
                contributors.push(item);
            }

            // Populate
            $('.pwyw-contributor-section ol').empty();
            for (var i = 0; i < 5; i++) {
                $('.pwyw-contributor-section ol.contributor-left').append(
                    contributors[i]
                );
            }
            for (var i = 5; i < 10; i++) {
                $('.pwyw-contributor-section ol.contributor-right').append(
                    contributors[i]
                );
            }

            // Update form fields
            $('[name="average_price"]').val(parseFloat(m.averagePrice).toFixed(2));
        }
    });


    // Amount buttons
    // -------------------------------------------------------------------------
    $('.pwyw-amount button').click(function() {

        total_amount = $(this).val();

        if ($(this).attr('id') == 'custom_price') {
            $('.customshow').fadeIn('fast');
        } else {
            $('.customshow').fadeOut('fast');
        }

        updateSliders();
        handleAlerts(total_amount);
        setEddProduct(total_amount);
        $('[name="total_amount"]').val(total_amount);
		$('#slidersandcheckout').slideDown(1000);
	    $('#slidersandcheckout').css('display','inline-block');

        $('html, body').animate({
            scrollTop: $('#amountbuttons').offset().top - 90
        }, 'slow', easing);


	});

    // Update the value in the custom price button, and sliders
    $('.pwyw-checkout .custompricefield').change(function() {
        total_amount = parseFloat($(this).val()).toFixed(2);
        $('.pwyw-amount button#custom_price').val(total_amount);
        $('.pwyw-checkout .custompricefield').val(total_amount);
        updateSliders();
        handleAlerts(total_amount);
        setEddProduct(total_amount);
        $('[name="total_amount"]').val(total_amount);

    });

    // EDD Product
    // -------------------------------------------------------------------------

    /**
     * Set the EDD product to use, based on current price and average.
     */
    function setEddProduct(amount)
    {
        var average = parseFloat(avg_price);
        var price = parseFloat(amount)

        if (price > average) {
            $('[name="download_id"]').val(edd_above_average);
        } else {
            $('[name="download_id"]').val(edd_below_average);
        }
    }


    // Sliders
    // -------------------------------------------------------------------------
    function updateSliders()
    {
        $('.percent').change();
        $('.charities_percent').change();
        $('.filmmakers_percent').change();
    }

    function setSliderHandlers(slider_class, input_class, amount_class)
    {
        var default_val = 0;
        $('.'+input_class).val(0);

        $("."+slider_class ).slider(
            { animate: false },
            { min: 0 },
            { max: 100 },
            { step: 0.001 },
            {change: function(event, ui) {
                var id = $(this).attr('id').match(/slider_(.+)/)[1];

                // Get correct total amount depending on slider level
                var total = total_amount;
                if ($(this).hasClass('sub_charities')) {
                    total = $('#charities_amount').val();
                }
                if ($(this).hasClass('sub_filmmakers')) {
                    total = $('#filmmakers_amount').val();
                }

                // Get/Calc the values to use
                var percentage = $(this).slider('value');
                var amount = (percentage / 100) * total;
                amount = parseFloat(Math.round(amount * 100) / 100).toFixed(2);

                // Update input fields
                $('#'+id+'_inp').val(percentage);
                $('#'+id+'_amount').val(amount);

                // Refresh subsliders if needed
                if (id == 'filmmakers') {
                    $('.filmmakers_percent').change();
                }
                if (id == 'charities') {
                    $('.charities_percent').change();
                }
            }},
            {slide: function(event, ui) {
                var id = $(this).attr('id').match(/slider_(.+)/)[1];

                // Get correct total amount depending on slider level
                var total = total_amount;
                if ($(this).hasClass('sub_charities')) {
                    total = $('#charities_amount').val();
                }
                if ($(this).hasClass('sub_filmmakers')) {
                    total = $('#filmmakers_amount').val();
                }

                // Get/Calc the values to use
                var percentage = $(this).slider('value');
                var amount = (percentage / 100) * total;
                amount = parseFloat(Math.round(amount * 100) / 100).toFixed(2);

                // Update input fields
                $('#'+id+'_inp').val(percentage);
                $('#'+id+'_amount').val(amount);

                // Refresh subsliders if needed
                if (id == 'filmmakers') {
                    $('.filmmakers_percent').change();
                }
                if (id == 'charities') {
                    $('.charities_percent').change();
                }
            }}
        );

        // Handle manual changes in the percentage field
        $('.'+input_class).each(function() {
            var id = $(this).attr('id').match(/(.+)_inp/)[1];
            var slider = $('#slider_'+id);

            if(slider.attr('value') != ''){
                $(this).val(slider.attr('value'));
                slider.slider("value",slider.attr('value'));
            }else{
                $(this).val(default_val);
            }
            $(this).change(function() {
                slider.slider("value" , $(this).val());

            })
        });

        // Handle manual changes in the amount field
        $('.'+amount_class).each(function() {
            var id = $(this).attr('id').match(/(.+)_amount/)[1];
            var slider = $('#slider_'+id);

            $(this).change(function() {
                var amount = parseFloat($(this).val()).toFixed(2);
                $(this).val(amount);

                // Get correct total amount depending on slider level
                var total = total_amount;
                if ($(this).hasClass('charities_amount')) {
                    total = $('#charities_amount').val();
                }
                if ($(this).hasClass('filmmakers_amount')) {
                    total = $('#filmmakers_amount').val();
                }

                var percentage = (amount / total) * 100;
                slider.slider('value' ,percentage);
            })
        });

        $('div.'+slider_class).linkedSliders({
            total: 100,     // The total for all the linked sliders
            policy: 'next'  // Adjustment policy: 'next', 'prev', 'first', 'last', 'all'
        });

    }

    // Set initial amount
    var total_amount = 0;

    setSliderHandlers('linked3', 'percent', 'amount');
    setSliderHandlers('sub_charities', 'charities_percent', 'charities_amount');
    setSliderHandlers('sub_filmmakers', 'filmmakers_percent', 'filmmakers_amount');
    setEddProduct(total_amount);

    // Handle the dive deeper buttons
    $('.dive-deeper').click(function() {
        var id = $(this).data('id');
        $(id).toggle('slow');
    });
    $('.dive-deeper').tooltip({
        placement: 'top',
        html: true
    });

    // Remove slider handles from the tab index
    $('.pwyw-checkout-slider a.ui-slider-handle').attr('tabindex', '-1');

    // Set initial average price
    $('[name="average_price"]').val(parseFloat(avg_price).toFixed(2));


    // Keyboard handling
    // -------------------------------------------------------------------------

    /**
     * Prevent enter/return key to submit the form.
     */
    $(window).keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    /**
     * Allow only numbers and dot in the numeric fields.
     */
    $('.pwyw-checkout .numeric-only').keypress(function(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 46 || charCode > 57)) {
            return false;
        }
    });


    // Validate on Submit
    // -------------------------------------------------------------------------

    /**
     * Validate form before accepting a submit
     */
    $('#bundle-checkout-form').submit(function() {
        var amount = $('[name="total_amount"]').val();

        // Check so we don't have 0 amount
        if (parseFloat(amount) == 0) {
            handleAlerts(amount);
            $('html, body').animate({
                scrollTop: $('.pwyw-checkout').offset().top - 80
            }, 'slow', easing, function() {
                $('.custompricefield').focus();
            });
            return false;
        }

        return validateCreateAccount();

    });


    function validateCreateAccount()
    {
        // See if we have create account fields.
        if ($('[name="email"]').length > 0) {
            // We have, so make sure they are not empty
            var email = $('[name="email"]').val();
            var password = $('[name="password"]').val();

            if (email=='' || password=='' || !isEmail(email)) {
                $('html, body').animate({
                    scrollTop: $('#pwyw-create-account').offset().top - 80
                }, 'slow', easing, function() {
                    if (email=='' || !isEmail(email)) {
                        $('[name="email"]').focus();
                    } else {
                        $('[name="password"]').focus();
                    }
                });
                return false;
            }
        }
        return true;
    }



    // PayPal Digital Good Handling
    // -------------------------------------------------------------------------
    var allowSubmit = false;
    $('#bundle-checkout-form').submit(function(e) {
        if ($('input[name=edd-gateway]:checked').val() == 'paypal_digital') {

            if ( !allowSubmit ) {
                if (!validateCreateAccount()) {
                    return false;
                }

                // Check so we didn't have a 0 amount
                var amount = $('[name="total_amount"]').val();
                if (parseFloat(amount) == 0) {
                    return false;
                }

                e.preventDefault();

                var form = jQuery(this);

                $('[name=bundle_checkout]').html('Processing...');
                $('[name=bundle_checkout]').prop('disabled', true);

                $.post(
                    edd_ppdigital.ajaxurl,
                    {
                        action: 'pwyw_ppdg',
                        download_id: $('[name="download_id"]').val(),
                        total_amount: $('[name="total_amount"]').val()
                    },
                    function(data) {
                        if ( data !== '1' ) {
                            allowSubmit = false;
                            $('#paypal_digital_holder').remove();
                            $('#bundle-checkout-form').after(
                                '<div id="paypal_digital_holder">'+data+'</div>'
                            );
                            $('#paypal-submit')[0].click();
                        } else {
                            allowSubmit = true;
                            form.submit();
                        }
                    }
                );
            }
        }
    });


    // Alerts
    // -------------------------------------------------------------------------
    function handleAlerts(amount)
    {
        // Check if no amount all has been selected
        if (amount == 0 && $('.pwyw-amount button.active').val() == undefined) {
            $('.leaderboardinput:visible').hide();
            $('.lowpaymentwarning:visible').hide();
            $('.nozero:visible').hide();

            $('.no-amount:hidden').fadeIn('slow');
            return;
        }

        // Prepare variables
        avg_price = parseFloat(avg_price);
        min_amount = parseFloat(min_amount);
        amount = parseFloat(amount);

        var top_count = 10;
        if(typeof(bundle.top)!='undefined'){
            top_count = bundle.top.length;
        }

        if ((top_count==10&&amount>min_amount)||(top_count<10&&amount>=0.01)) {

            $('.leaderboardinput:hidden').fadeIn('slow');
            if(amount>avg_price){
               $('.lowpaymentwarning:visible').hide();
            }

            $('.nozero:visible').hide();
            $('.alertboxes .no-amount').hide();
        }

        if ((amount <= avg_price) && (amount > 0)) {
            difference = number_format(avg_price - amount + 0.01,2);
            $('#difference').html(difference);
            $('.lowpaymentwarning:hidden').fadeIn('slow');
            if((top_count==10&&amount<=min_amount)){
                $('.leaderboardinput:visible').hide();
            }

            $('.nozero:visible').hide()
            $('.alertboxes .no-amount').hide();
        }

        /** More than average, but not enough to reach the top 10, then no alerts to be shown */
        if (amount > avg_price && amount <= min_amount) {
            $('.leaderboardinput:visible').hide();
            $('.lowpaymentwarning:visible').hide();
            $('.alertboxes .no-amount').hide();
            $('.nozero:hidden').hide();
        }

        /** Handle 0 Amounts */
        if(amount < 0.01) {
            $('.leaderboardinput:visible').hide();
            $('.lowpaymentwarning:visible').hide();
            $('.alertboxes .no-amount').hide();
            $('.nozero:hidden').fadeIn('slow');
        }
    }

    /**
     * Form submit alert. Scroll to alert box, if form submission fails.
     */
    if ($('#pwyw-checkout-error').length > 0) {
        $('html, body').animate({
            scrollTop: $('.pwyw-checkout').offset().top - 80
        }, 'slow', easing);
    }


    // -------------------------------------------------------------------------
    // HELPERS
    // -------------------------------------------------------------------------

    /*
     * Checks if an email address is valid.
     *
     * @param string email
     * @return boolean
     */
    function isEmail(email)
    {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    // Format a number with grouped thousands
    //
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     bugfix by: Michael White (http://crestidg.com)
    function number_format(number, decimals, dec_point, thousands_sep)
    {
        var i, j, kw, kd, km;

        // input sanitation & defaults
        if( isNaN(decimals = Math.abs(decimals)) ){
            decimals = 2;
        }
        if( dec_point == undefined ){
            dec_point = ".";
        }
        if( thousands_sep == undefined ){
            thousands_sep = ".";
        }

        i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

        if( (j = i.length) > 3 ){
            j = j % 3;
        } else{
            j = 0;
        }

        km = (j ? i.substr(0, j) + thousands_sep : "");
        kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
        //kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
        kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");

        return km + kw + kd;
    }
});
