<?php 
if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'countDown',
		'id'   => 'countdowndiv',
		'description'   => 'This is where the countdown goes.',
		'before_widget' => '<div id="countdown" class="widget-countdown">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));
	
}
	if (function_exists('register_sidebar')) {

		register_sidebar(array(
			'name' => 'Login',
			'id'   => 'Loginthing',
			'description'   => 'Login Dropdown',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>'
		));
}
?>