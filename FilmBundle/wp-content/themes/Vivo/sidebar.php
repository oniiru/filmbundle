<div class="sidebar">
	<div class="user_content">
		<ul>
			<?php /*lets widgetize up in here */
				if(!function_exists('dynamic_sidebar') || !dynamic_sidebar()) :
			?>
			
			<li class="sidebar_block clearfix">
				<div class="feat_title_container"><h3 class="feat_title">Pages</h3></div>
				<ul>
					<?php wp_list_pages('title_li='); ?>
				</ul>
			</li>
			
			<li class="sidebar_block clearfix">
				<div class="feat_title_container"><h3 class="feat_title">Archives</h3></div>
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>
			
			<li class="sidebar_block clearfix">
				<div class="feat_title_container"><h3 class="feat_title">Categories</h3></div>
				<ul>
					<?php wp_list_categories('title_li='); ?>
				</ul>
			</li>
			
			<?php get_search_form(); ?>
			
			<ul>
				<li><?php wp_loginout(); ?></li>
			</ul>
			
			<?php endif; ?>
		</ul>
	</div>
</div><!-- end #sidebar -->