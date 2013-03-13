<?php
//Find out what user has selected for portfolio category
//Get value of category drop down
$cats = get_post_custom($post->ID);
//Get the text, this is the 'value' in the project types array
$selectedCat = $cats['mb_select'][0];

//Begin Portfolio items
$amounttoshow = get_option('of_port_items_to_show');

if($selectedCat != 'all') { //If user has selected a specific category to show...
		query_posts('post_type=portfolio_post_type&project-type=' . $selectedCat . '&posts_per_page=' . $amounttoshow );
	} else { //...else display as normal
		query_posts('post_type=portfolio_post_type&posts_per_page=' . $amounttoshow );
	}
?>