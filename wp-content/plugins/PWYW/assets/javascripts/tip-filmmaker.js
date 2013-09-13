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
                return;
            }

            $.post(
                pwyw_ajax.url,
                {
                    action: 'pwyw_tip',
                },
                function(data) {
                    console.log(data);
                }
            );


            // console.log(amount);
            // console.log(download_id);
            // console.log(formId);
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
