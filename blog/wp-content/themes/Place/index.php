<?php get_header();?>

<div id="leftContent">
	<div class="inner">
		<?php 
		if(is_home() and $pl_data['enable_slider']!='no') get_template_part('inc/slider');?>
		<?php get_template_part('loop-entry','index');?>
	</div>
</div>

<?php get_sidebar();?>
<?php get_footer();?>