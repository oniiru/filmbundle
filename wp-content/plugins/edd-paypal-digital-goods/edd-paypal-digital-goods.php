<?php

/**
 * Plugin Name:         Easy Digital Downloads - PayPal Digital Goods
 * Plugin URI:          http://shop.mgates.me/?p=295
 * Description:         Use PayPal Digital Goods to accept payments on your shop!
 * Author:              Matt Gates
 * Author URI:          http://mgates.me
 *
 * Version:             1.1.5
 * Requires at least:   3.2.1
 * Tested up to:        3.5.1
 *
 * Text Domain:         edd_ppdg
 * Domain Path:         /PayPalDigital/languages/
 *
 * @category            Payment Method
 * @copyright           Copyright © 2012 Matt Gates.
 * @author              Matt Gates
 * @package             Easy Digital Downloads
 */


/**
 * Required functions
 */
if ( ! class_exists( 'MGates_Plugin_Updater' ) ) require_once 'PayPalDigital/classes/mg-includes/mg-functions.php';
if ( is_admin() ) new MGates_Plugin_Updater( __FILE__, '842cb593fac5e36f624e48816a4ac370' );

class EDD_PayPal_Digital_Goods
{

	/**
	 * Absolute path to our plugin directory
	 *
	 * @var string
	 *
	 * @access public
	 * @static
	 */
	public static $plugin_dir;


	/**
	 * Initial hooks
	 */
	function __construct()
	{
		self::$plugin_dir = trailingslashit( dirname( __FILE__ ) ) . 'PayPalDigital/';

		$this->load_core();
		$this->load_hooks();
		$this->setup_config();
	}

	public function load_core()
	{
		require_once self::$plugin_dir . 'classes/class-edd-settings.php';
		require_once self::$plugin_dir . 'classes/class-edd-validate.php';
		require_once self::$plugin_dir . 'classes/class-edd-paypal-ipn.php';
	}


	/**
	 * Simple hooks to setup with EDD
	 */
	public function load_hooks()
	{
		global $edd_options;

		if ( !EDD_PPDG_Validate::is_valid() ) return;

		add_filter( 'edd_payment_gateways' , array( $this, 'register_gateway' ) );
		add_filter( 'edd_settings_gateways', array( 'EDD_PPDG_Settings', 'gateway_settings' ) );
		add_action( 'edd_paypal_digital_cc_form', array( $this, 'paypal_digital_cc_form' ) );

		if ( !empty( $edd_options['paypal_digital_username'] ) ) {
			add_action( 'init'                      , array( 'EDD_PPDG_PayPal_IPN', 'check_paypal_return' ) );
			add_action( 'wp_enqueue_scripts'        , array( $this, 'load_scripts' ) );
			add_action( 'edd_gateway_paypal_digital', array( $this, 'process_payment' ) );

			add_action('wp_ajax_paypal_digital'       , array( $this, 'show_paypal_button' ) );
			add_action('wp_ajax_nopriv_paypal_digital', array( $this, 'show_paypal_button' ) );
		}
	}

	public function load_scripts()
	{
		wp_enqueue_script( 'jquery-ppdigital', plugin_dir_url( self::$plugin_dir . 'assets/js/ppdigital.js' ) . 'ppdigital.js', array('jquery') );
		wp_localize_script( 'jquery-ppdigital', 'edd_ppdigital', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}


	/**
	 * Initial configuration for PayPal API
	 *
	 * @return unknown
	 */
	public function setup_config()
	{
		global $edd_options;

		if ( empty( $edd_options['paypal_digital_username'] ) && !$this->is_checkout_paypal_digital() ) return false;

		require_once self::$plugin_dir . 'classes/api/paypal-digital-goods.class.php';

		try {
			PayPal_Digital_Goods_Configuration::username( $edd_options['paypal_digital_username'] );
			PayPal_Digital_Goods_Configuration::password( $edd_options['paypal_digital_password'] );
			PayPal_Digital_Goods_Configuration::signature( $edd_options['paypal_digital_signature'] );

			PayPal_Digital_Goods_Configuration::currency( $edd_options['currency'] );
			PayPal_Digital_Goods_Configuration::notify_url( 'null' );
			PayPal_Digital_Goods_Configuration::return_url( add_query_arg( array( 'paypal_digital' => 'paid' ), edd_get_checkout_uri() ) );
			PayPal_Digital_Goods_Configuration::cancel_url( add_query_arg( array( 'paypal_digital' => 'cancel' ), edd_get_checkout_uri() ) );

			// Set PayPal to live if test mode is not turned on
			if ( !edd_is_test_mode() ) PayPal_Digital_Goods_Configuration::environment( 'live' );
		}
		 catch (Exception $e) {
			edd_set_error('edd_ppdg_error', $e->getMessage());
		}
	}


	/**
	 * Output the HTML button and scripts
	 *
	 * @param string  $html
	 * @return string
	 */
	public function show_paypal_button()
	{

		if ( !edd_get_errors() ) {
			$purchase_details = $this->create_purchase_details();

			$html = $this->print_paypal_button( $purchase_details );
			echo $html;
		}

		exit;
	}


	/**
	 * Purchase details of the cart in PayPal array format
	 *
	 * @return array
	 */
	public function create_purchase_details()
	{
		// Setup the order details
		$purchase_details = $this->get_totals();
		$purchase_details['items'] = $this->get_items();

		return $purchase_details;
	}


	/**
	 * Helper function for seeing if the customer
	 * is checking out with PayPal Digital Goods
	 *
	 * @return bool
	 */
	public function is_checkout_paypal_digital()
	{
		global $edd_options;

		$is_ppdigital = false;

		// Switching payment methods to Digital Downloads
		if ( !empty( $_GET['payment-mode'] ) && $_GET['payment-mode'] == 'paypal_digital' ) {
			$is_ppdigital = true;

		// Digital Downloads is the only payment method available
		} elseif ( sizeof( $edd_options['gateways'] ) === 1 && !empty( $edd_options['gateways']['paypal_digital'] ) ) {
			$is_ppdigital = true;
		}

		return $is_ppdigital;
	}


	/**
	 * Totals in cart formatted for PayPal
	 *
	 * @return array
	 */
	public function get_totals()
	{
		$total = edd_get_cart_total();

		$purchase_details = array(
			'name'        => get_bloginfo('name'),
			'description' => get_bloginfo('description'),
			'amount'      => $total,
		);

		return $purchase_details;
	}


	/**
	 * Items in cart formatted for PayPal
	 *
	 * @return array
	 */
	public function get_items()
	{
		$purchase_details = array();
		$cart = edd_get_cart_content_details();

		if ( edd_cart_has_discounts() ) {
			$purchase_details[] = array(
				'item_name'        => __('Order: Discounts', 'edd_ppdg'),
				'item_description' => __('Total discounts for this order.', 'edd_ppdg'),
				'item_amount'      => edd_get_cart_discounted_amount() * -1,
				'item_quantity'    => 1,
				'item_number'      => 'discount',
			);
		}

		$tax = edd_get_cart_tax();
		if ( !empty( $tax ) ) {
			$purchase_details[] = array(
				'item_name'        => __('Order: Tax', 'edd_ppdg'),
				'item_description' => __('Total taxes for this order.', 'edd_ppdg'),
				'item_amount'      => $tax,
				'item_quantity'    => 1,
				'item_number'      => 'tax',
			);
		}

		foreach ( $cart as $key => $item ) {
			$purchase_details[] = array(
				'item_name'        => html_entity_decode( $item['name'], ENT_COMPAT, 'UTF-8' ),
				// 'item_description' => '',
				'item_amount'      => $item['price'],
				'item_quantity'    => $item['quantity'],
				'item_number'      => $item['id'],
			);
		}

		return $purchase_details;
	}


	/**
	 * Output the HTML & JS button for PayPal
	 *
	 * @param array   $purchase_details
	 * @return string
	 */
	public function print_paypal_button( $purchase_details )
	{
		$paypal_purchase = $this->create_purchase( $purchase_details );
		if ( !$paypal_purchase ) return false;

		$html = false;

		// Stop here if the order total is 0
		if ( empty( $purchase_details['amount'] ) ) {
			echo '1';
			return false;
		}

		try {
			$html = $paypal_purchase->get_buy_button();
			$html .= $paypal_purchase->get_script();
		} catch (Exception $e) {
			edd_set_error('edd_ppdg_error', $e->getMessage());
			edd_print_errors();
		}


		return $html;
	}


	/**
	 * Use the API to create a PayPal_Purchase object
	 *
	 * @param array   $purchase_details
	 * @return object
	 */
	public function create_purchase( $purchase_details )
	{
		$paypal_purchase = false;

		require_once self::$plugin_dir . 'classes/api/paypal-purchase.class.php';

		try {
			$paypal_purchase = new PayPal_Purchase( $purchase_details );
		} catch (Exception $e) {
			edd_set_error('edd_ppdg_error', $e->getMessage());
		}

		return $paypal_purchase;
	}

	/**
	 * Process the payment
	 *
	 * @param array   $purchase_data
	 */
	public function process_payment( $purchase_data )
	{
		global $edd_options;

		$fail = false;

		// Check for any stored errors
		$errors = edd_get_errors();
		if ( $errors ) $fail = true;

		$payment = array(
			'price'        => $purchase_data['price'],
			'date'         => $purchase_data['date'],
			'user_email'   => $purchase_data['user_email'],
			'purchase_key' => $purchase_data['purchase_key'],
			'currency'     => $edd_options['currency'],
			'downloads'    => $purchase_data['downloads'],
			'cart_details' => $purchase_data['cart_details'],
			'user_info'    => $purchase_data['user_info'],
			'status'       => 'pending'
		);

		// Record the pending payment
		$payment_id = edd_insert_payment( $payment );

		if ( $_POST['paypal_digital'] == 'cancel' ) {
			$fail = true;
		}

		if ( !$fail ) {

			// Process the payment
			$purchase_details = $this->create_purchase_details();
			$paypal_purchase = $this->create_purchase( $purchase_details );

			if ( !$paypal_purchase ) {
				$fail = true;
			} else {

				try {
					$response = $paypal_purchase->process_payment();
				} catch (Exception $e) {
					edd_set_error('edd_ppdg_error', $e->getMessage());
				}

				// Payment confirmed
				if ( $response['PAYMENTINFO_0_ACK'] == 'Success' ) {

					// Once a transaction is successful, set the purchase to complete
					edd_update_payment_status( $payment_id, 'complete' );

					// Save the PayPal transaction ID to this EDD order
					edd_insert_payment_note( $payment_id, sprintf( __( 'PayPal Transaction ID: %s', 'edd' ) , $response['PAYMENTINFO_0_TRANSACTIONID'] ) );

					// Empty the cart
					edd_empty_cart();

					// Go to the success page
					edd_send_to_success_page();

				// Something went wrong :|
				} else {

					$fail = true;

				}

			}

		}

		// If errors are present, send the user back to the purchase page so they can be corrected
		if ( $fail ) {
			edd_update_payment_status( $payment_id, 'failed' );
			edd_send_back_to_checkout( '?payment-mode=' . $purchase_data['post_data']['edd-gateway'] );
		}

	}


	/**
	 * Register the gateway with EDD
	 *
	 * @param array   $gateways
	 * @return array
	 */
	public function register_gateway( $gateways )
	{
		$gateways['paypal_digital'] = array(
			'admin_label'    => 'PayPal Digital Goods',
			'checkout_label' => __( 'PayPal', 'edd_ppdg' ),
		);

		return $gateways;
	}


	/**
	 * Remove the default credit card form added by EDD
	 */
	public function paypal_digital_cc_form() {}

}


// Call our plugin on init
add_action( 'init', 'edd_load_paypal_digital_goods', 1 );


/**
 * Init
 */
function edd_load_paypal_digital_goods()
{
	new EDD_PayPal_Digital_Goods;
}
