<?php
/*
Plugin Name: PMPro Stripe Lite
Plugin URI: http://www.paidmembershipspro.com/wp/pmpro-stripe-lite/
Description: Updates the checkout page to use the bare minimum fields for credit card checkout.
Version: .1
Author: Stranger Studios
Author URI: http://www.strangerstudios.com
*/

global $pmpro_stripe_lite;
$pmpro_stripe_lite = true;

/*
	use our checkout template
*/
function pmprosl_pmpro_pages_shortcode_checkout($content)
{
	ob_start();
	include(plugin_dir_path(__FILE__) . "/templates/checkout.php");
	$temp_content = ob_get_contents();
	ob_end_clean();
	return $temp_content;
}
add_filter("pmpro_pages_shortcode_checkout", "pmprosl_pmpro_pages_shortcode_checkout");

/*
	use our confirmation template
*/
function pmprosl_pmpro_pages_shortcode_confirmation($content)
{
	ob_start();
	include(plugin_dir_path(__FILE__) . "/templates/confirmation.php");
	$temp_content = ob_get_contents();
	ob_end_clean();
	return $temp_content;
}
add_filter("pmpro_pages_shortcode_confirmation", "pmprosl_pmpro_pages_shortcode_confirmation");

/*
	use our account template
*/
function pmprosl_pmpro_pages_shortcode_account($content)
{
	ob_start();
	include(plugin_dir_path(__FILE__) . "/templates/account.php");
	$temp_content = ob_get_contents();
	ob_end_clean();
	return $temp_content;
}
add_filter("pmpro_pages_shortcode_account", "pmprosl_pmpro_pages_shortcode_account");

/*
	use our billing template
*/
function pmprosl_pmpro_pages_shortcode_billing($content)
{
	ob_start();
	include(plugin_dir_path(__FILE__) . "/templates/billing.php");
	$temp_content = ob_get_contents();
	ob_end_clean();
	return $temp_content;
}
//add_filter("pmpro_pages_shortcode_billing", "pmprosl_pmpro_pages_shortcode_billing");

/*
	use our invoice template
*/
function pmprosl_pmpro_pages_shortcode_invoice($content)
{
	ob_start();
	include(plugin_dir_path(__FILE__) . "/templates/invoice.php");
	$temp_content = ob_get_contents();
	ob_end_clean();
	return $temp_content;
}
add_filter("pmpro_pages_shortcode_invoice", "pmprosl_pmpro_pages_shortcode_invoice");

/*
	don't require billing address fields
*/
function pmprosl_pmpro_required_billing_fields($fields)
{
	global $gateway;
	
	//ignore if not using stripe
	if($gateway != "stripe")
		return $fields;
	
	//some fields to remove
	$remove = array('bfirstname', 'blastname', 'baddress1', 'bcity', 'bstate', 'bzipcode', 'bphone', 'bcountry', 'CardType');
	
	//if a user is logged in, don't require bemail either
	global $current_user;
	if(!empty($current_user->user_email))
		$remove[] = 'bemail';
	
	//remove the fields
	foreach($remove as $field)
		unset($fields[$field]);
			
	//ship it!
	return $fields;
}
add_filter("pmpro_required_billing_fields", "pmprosl_pmpro_required_billing_fields");