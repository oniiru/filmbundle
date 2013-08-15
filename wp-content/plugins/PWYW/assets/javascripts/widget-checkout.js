jQuery(document).ready(function($) {

    /** PubNub Setup */
    var pubnub_subscribe_key = 'sub-c-ef114922-f1ea-11e2-b383-02ee2ddab7fe';
    var pubnub_channel       = 'filmbundle';


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
            // console.log(m);

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
        }
    });


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

        handleAlerts(new_amount);
        setEddProduct(new_amount);
    });

    // Only allow numbers in the custom price field
    $('.pwyw-checkout .custompricefield').keypress(function(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 46 || charCode > 57)) {
            return false;
        }
    });

    // Update the value in the custom price button, and sliders
    $('.pwyw-checkout .custompricefield').change(function() {
        var new_amount = $(this).val();
        $('.pwyw-amount button#custom_price').val(new_amount);
        updateSliders('linked3', 'percent', new_amount, bundle_checkout_amount);
        handleAlerts(new_amount);
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
    setEddProduct(new_amount);

    // Handle the dive deeper buttons
    $('.dive-deeper').click(function() {
        var id = $(this).data('id');
        $(id).toggle('slow');
    });
    $('.dive-deeper').tooltip({
        placement: 'top',
        html: true
    });


    // Alerts
    // -------------------------------------------------------------------------
    function handleAlerts(amount)
    {
        if(amount == null){
            amount = parseFloat($('.custompricefield').val());
        }

        // Prepare variables
        avg_price = parseFloat(avg_price);
        min_amount = parseFloat(min_amount);

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
        }

        if((amount < avg_price)&& (amount > 0.00)){
            difference = number_format(avg_price - amount + 0.01,2);
            $('#difference').html(difference);
            $('.lowpaymentwarning:hidden').fadeIn('slow');
            if((top_count==10&&amount<=min_amount)){
                $('.leaderboardinput:visible').hide();
            }
            $('.nozero:visible').hide()
        }

        if(amount < 0.01) {
            $('.leaderboardinput:visible').hide();
            $('.lowpaymentwarning:visible').hide();
            $('.nozero:hidden').fadeIn('slow');
        }
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
