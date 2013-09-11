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
            EDD_PPDG_PayPal_IPN::load_block_ui();

            ?><script>
            jQuery(function() {
                var form = top.document.forms["bundle-checkout-form"];
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
                var form           = top.document.forms["bundle-checkout-form"];
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

