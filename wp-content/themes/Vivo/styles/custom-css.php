<?php
header("Content-type: text/css");
	//Custom CSS here
	if (get_option('of_custom_css') != "") {
		echo get_option('of_custom_css');
	}
?>