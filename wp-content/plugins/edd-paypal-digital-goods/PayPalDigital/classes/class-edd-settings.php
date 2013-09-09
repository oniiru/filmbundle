<?php

/**
*
*/
class EDD_PPDG_Settings
{

	/**
	 * Adds the settings to the Payment Gateways section
	 *
	 * @param array   $settings
	 * @return array
	 */
	public function gateway_settings( $settings )
	{
		$settings[] =  array(
			'id'   => 'paypal_digital_header',
			'name' => '<strong>' . __( 'PayPal Digital Goods', 'edd_ppdg' ) . '</strong>',
			'desc' => __( 'Configure the gateway settings', 'edd_ppdg' ),
			'type' => 'header'
		);

		$settings[] =  array(
			'id'   => 'paypal_digital_username',
			'name' => __( 'API Username', 'edd_ppdg' ),
			'desc' => __( '', 'edd_ppdg' ),
			'type' => 'text',
			'size' => 'regular'
		);

		$settings[] =  array(
			'id'   => 'paypal_digital_password',
			'name' => __( 'API Password', 'edd_ppdg' ),
			'desc' => __( '', 'edd_ppdg' ),
			'type' => 'text',
			'size' => 'regular'
		);

		$settings[] =  array(
			'id'   => 'paypal_digital_signature',
			'name' => __( 'API Signature', 'edd_ppdg' ),
			'desc' => __( '', 'edd_ppdg' ),
			'type' => 'text',
			'size' => 'regular'
		);

		return $settings;
	}

}