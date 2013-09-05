<?php

class EDD_PPDG_Validate
{

	public static function is_valid()
	{
		// Check if valid version is activated
		if ( version_compare( EDD_VERSION, '1.4.2', '<' ) ) {
			add_action( 'admin_notices', array( 'EDD_PPDG_Validate', 'invalid_edd_version' ) );
			return false;
		}

		if ( ! EDD_PPDG_Validate::is_valid_currency() ) {
			add_action( 'admin_notices', array( 'EDD_PPDG_Validate', 'invalid_edd_currency' ) );
			return false;
		}

		return true;
	}


	public function is_valid_currency() {
		global $edd_options;

		return in_array( $edd_options['currency'], array( 'AUD', 'BRL', 'CAD', 'MXN', 'NZD', 'HKD', 'SGD', 'USD', 'EUR', 'JPY', 'TRY', 'NOK', 'CZK', 'DKK', 'HUF', 'ILS', 'MYR', 'PHP', 'PLN', 'SEK', 'CHF', 'TWD', 'THB', 'GBP', 'RMB' ));
	}



	/**
	 * Invalid EDD version, requires v1.4 or above
	 */
	public function invalid_edd_version()
	{
		echo '
			<div class="error">
				<p>' . __( '<b>PayPal Digital Goods has been disabled.</b> This plugin requires Easy Digital Downloads v1.4.2 or above.', 'edd_ppdg' ) . '</p>
			</div>
		';
	}

	/**
	 * PayPal supported currency is required
	 */
	public function invalid_edd_currency()
	{
		echo '
			<div class="error">
				<p>' . __( '<b>PayPal Digital Goods has been disabled.</b> PayPal does not support your store currency.', 'edd_ppdg' ) . '</p>
			</div>
		';
	}

}