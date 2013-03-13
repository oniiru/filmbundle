<?php if(get_option('of_widget_off') == 'false') { ?>
<div id="widget_area">
	<div id="widget_area_inner" class="clearfix">
	<a class="showhide" id="closed" href="#">></a>
		<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Hidden Widget' ) ) ?>
		<p class="footer_text"><?php echo get_option('of_foot_text')?></p>
	</div><!-- end #widget_area_inner -->	
</div><!-- end #top-area -->
<?php } ?>
<?php wp_footer() ?>
</body>
</html>