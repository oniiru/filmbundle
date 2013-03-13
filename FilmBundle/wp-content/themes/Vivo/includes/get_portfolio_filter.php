<ul id="filters">
	<li><a href="#" data-filter="*">Show All</a></li>
	<?php 
		// Get portfolio terms
		$taxonomy = 'project-type';
		$categories = get_terms($taxonomy);
								
	   // List the portfolio terms
	   foreach($categories as $category) {
			echo '<li><a href="#" data-filter=".filter_block, .'.str_replace('-', '', $category->slug).'">'.$category->name.'</a></li>'; 
		}
	?>
</ul>