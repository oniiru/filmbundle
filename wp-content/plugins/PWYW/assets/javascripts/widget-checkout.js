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

        total_amount = $(this).val();

        if ($(this).attr('id') == 'custom_price') {
            $('.customshow').fadeIn('fast');
        } else {
            $('.customshow').fadeOut('fast');
        }

        updateSliders();
        handleAlerts(total_amount);
        setEddProduct(total_amount);
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
        total_amount = $(this).val();
        $('.pwyw-amount button#custom_price').val(total_amount);
        handleAlerts(total_amount);
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
                amount = Math.round(amount * 100) / 100;

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
                amount = Math.round(amount * 100) / 100;

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
                var amount = $(this).val();
                var percentage = (amount / total_amount) * 100;

                slider.slider('value' ,percentage);
            })
        });

        $('div.'+slider_class).linkedSliders({
            total: 100,     // The total for all the linked sliders
            policy: 'next'  // Adjustment policy: 'next', 'prev', 'first', 'last', 'all'
        });

    }

    // Set initial amount
    var total_amount = $('.pwyw-amount button').first().val();
    total_amount = Math.floor(total_amount);

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
