<?php

class EDD_PPDG_PayPal_IPN extends EDD_PayPal_Digital_Goods {

	/**
	 * Javascript for jQuery BlockUI when processing an order
	 */
	public function load_block_ui()
	{
		wp_register_script( 'jquery-blockui', plugin_dir_url( parent::$plugin_dir . 'assets/js/jquery-blockui/jquery.blockUI.min.js' ) . 'jquery.blockUI.min.js', 'jquery' );
		wp_print_scripts( 'jquery' );
		wp_print_scripts( 'jquery-blockui' );

		?><script>
		jQuery(function() {
			jQuery('body', window.parent.document).block({
					message: "<?php _e( "We are now processing your order. Please wait.", 'edd_ppdg' ); ?>",
					overlayCSS:
					{
						background: "#fff",
						opacity:    0.6
					},
					css: {
				        padding:         20,
				        textAlign:       "center",
				        color:           "#555",
				        border:          "3px solid #aaa",
				        backgroundColor: "#fff",
				        cursor:          "wait",
				        lineHeight:      "32px"
				    }
				});
			jQuery('#PPDGFrame > div.mask', window.parent.document).remove();
		});
		</script><?php
	}


	// hi
	/**
	 * Some hacky stuff to get rid of that iFrame PayPal introduces
	 *
	 * Submits the top form after it appends the GET variables from PayPal
	 *
	 * @return string
	 */
	public function check_paypal_return()
	{
		// Cancel payment
		if ( isset( $_GET['paypal_digital'] ) && $_GET['paypal_digital'] == 'cancel' ) {
			EDD_PPDG_PayPal_IPN::load_block_ui();

			?><script>
			jQuery(function() {
				var form = top.document.forms["edd_purchase_form"];
				var input = jQuery('<input type="hidden" name="paypal_digital">').val('<?php echo $_GET["paypal_digital"]; ?>');

				jQuery(form).append(input);
				jQuery(form).submit();
			})
			</script><?php

			exit;
		}

		// Returning from PayPal
		if ( isset( $_GET['PayerID'] ) && ( isset( $_GET['paypal_digital'] ) && $_GET['paypal_digital'] == 'paid' ) ) {
			EDD_PPDG_PayPal_IPN::load_block_ui();

			?><script>
			jQuery(function() {
				var form           = top.document.forms["edd_purchase_form"];
				var paypal_digital = jQuery('<input type="hidden" name="paypal_digital">').val('<?php echo $_GET["paypal_digital"]; ?>');
				var payerid        = jQuery('<input type="hidden" name="PayerID">').val('<?php echo $_GET["PayerID"]; ?>');
				var token          = jQuery('<input type="hidden" name="token">').val('<?php echo $_GET["token"]; ?>');

				jQuery(form).append(paypal_digital);
				jQuery(form).append(payerid);
				jQuery(form).append(token);
				jQuery(form).submit();
			})
			</script><?php

			exit;
		}

	}

}