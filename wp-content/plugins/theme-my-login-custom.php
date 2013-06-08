<?php 
// function tml_registration_errors( $errors ) {
// 	if ( empty( $_POST['first_name'] ) )
// 		$errors->add( 'empty_first_name', '<strong>ERROR</strong>: Please enter your first name.' );
// 	return $errors;
// }
// add_filter( 'registration_errors', 'tml_registration_errors' );
// 
// function tml_user_register( $user_id ) {
// 	if ( !empty( $_POST['first_name'] ) )
// 		update_user_meta( $user_id, 'first_name', $_POST['first_name'] );
// }
// add_action( 'user_register', 'tml_user_register' ); 
// 
 function tml_redirect_url( $url, $action ) {
 	if ( 'register' == $action )
		$url = 'http://filmbundle.com';
	return $url;
 }
 add_filter( 'tml_redirect_url', 'tml_redirect_url', 10, 2 );
 
 function tml_new_user_registered( $user_id ) {
 	wp_set_auth_cookie( $user_id );
 }
 add_action( 'tml_new_user_registered', 'tml_new_user_registered' );


?>