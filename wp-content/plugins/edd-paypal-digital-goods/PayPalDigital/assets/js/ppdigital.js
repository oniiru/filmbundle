var allowSubmit = false;

jQuery(document).ready(function(){

	jQuery('#edd_checkout_form_wrap').on('submit', '#edd_purchase_form', function(e) {
		if ( jQuery('input[name=edd-gateway]').val() == 'paypal_digital' ) {

			if ( !allowSubmit ) {
				e.preventDefault();

				var form = jQuery(this);

				jQuery('#edd-purchase-button').val('Processing...');

				jQuery.post(edd_ppdigital.ajaxurl, { action: 'paypal_digital' }, function(data) {
					jQuery('#paypal_digital_holder').remove();

					if ( data !== '1' ) {
						allowSubmit = false;
						jQuery('#edd_purchase_form').after('<div id="paypal_digital_holder">' + data + '</div>');
						jQuery('#paypal-submit')[0].click();
					} else {
						allowSubmit = true;
						form.submit();
					}
				});
			}

		}

	});

});
