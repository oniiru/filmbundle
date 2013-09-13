jQuery(document).ready(function($) {

    // Handle the submissions
    // -------------------------------------------------------------------------
    var allowSubmit = false;
    $('.tipping-form').submit(function(e) {
        if ( !allowSubmit ) {
            e.preventDefault();

            // Collect relevant data
            var form = $(this);
            var formId = $(this).attr('id');
            var amount = $('#'+formId+' [name=tipAmount]').val();
            var download_id = $('[name=download_id]').val();

            // Don't submit empty amounts
            if (!amount) {
                $('#'+formId+' [name=tipAmount]').focus();
                return;
            }

            // Update the button
            $('#'+formId+' [name=giveTip]').html('Processing...');
            $('#'+formId+' [name=giveTip]').prop('disabled', true);

            // Initiate ajax call
            $.post(
                edd_ppdigital.ajaxurl,
                {
                    action: 'pwyw_ppdg',
                    download_id: download_id,
                    total_amount: amount
                },
                function(data) {
                    if (data !== '1') {
                        allowSubmit = false;
                        $('#paypal_digital_holder').remove();
                        $('#'+formId).after(
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
    });


    // Handle live input validation
    // -------------------------------------------------------------------------
    $('[name=tipAmount]').keypress(function(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode < 48 || charCode > 57) {
            return false;
        }
    });

});
