<?php

$custom_select_mb = new WPAlchemy_MetaBox(array
(
	'id' => 'posts',
	'title' => 'Select Inputs',
	'template' => get_stylesheet_directory() . '/metaboxes/select-meta.php',
	'types' => array('films'), // added only for pages and to custom post type "events"
	
));

/* eof */