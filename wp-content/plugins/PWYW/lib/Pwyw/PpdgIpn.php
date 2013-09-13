<?php

/**
 * Extend the class provided by PapPal Digital Goods Gateway plugin, to override
 * the return method, so we can inject the Pwyw Bundle ID tag instead.
 */
class Pwyw_PpdgIpn extends EDD_PPDG_PayPal_Ipn
{
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
            wp_print_scripts( 'jquery' );

            ?><script>
                jQuery(function() {
                    var blocker = top.document.getElementById("PPDGFrame");

                    // Checkout button
                    var button = top.document.getElementsByName('bundle_checkout')[0];
                    jQuery(button).html('Checkout');
                    jQuery(button).prop('disabled', false);

                    // Tip button
                    var button = top.document.getElementsByName('giveTip');
                    jQuery(button[0]).html('Checkout');
                    jQuery(button[0]).prop('disabled', false);
                    jQuery(button[1]).html('Checkout');
                    jQuery(button[1]).prop('disabled', false);

                    jQuery(blocker).remove();
                });
            </script><?php

            exit;
        }

        // Returning from PayPal
        if ( isset( $_GET['PayerID'] ) && ( isset( $_GET['paypal_digital'] ) && $_GET['paypal_digital'] == 'paid' ) ) {
            EDD_PPDG_PayPal_IPN::load_block_ui();

            ?><script>
            jQuery(function() {
                var form = top.document.forms["bundle-checkout-form"];
                // If it wasn't the bundle checkout, let's see which tip form it might be
                if (!form) {
                    // First we try the sharing form
                    form = top.document.forms["tipshare-form"];
                    var button = jQuery(form).find('[name=giveTip]');
                    if (button.html() != 'Processing...') {
                        // It wasn't the first tip form, so let's assume it's the second
                        form = top.document.forms["tipster-form"];
                    }
                }
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

