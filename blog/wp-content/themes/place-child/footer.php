<?php global $theme_url, $pl_data ;?>
</div>
</div><!-- #main -->
<div id="footer">
		<div class="container clearfix">
			<div class="ft_left">&copy; <?php echo date('Y'); ?>  <a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a> | <?php bloginfo('description'); ?></div>
			<div class="ft_right"><?php echo stripslashes($pl_data['footer_text']); ?></div>
			<div class="clear"></div>
		</div>
	</div>
	<!-- #footer -->
	<?php if($pl_data['switcher']=='yes') include ('_switcher/index.php');?>  
	<div id="toTop"><a href="#"><?php _e('TOP','presslayer');?></a></div>	
	<?php echo stripslashes($pl_data['google_analytics']); ?>
	<?php wp_footer();?>	
	
	
	<!-- MixPanel Start -->
	<script type="text/javascript">
	// mixpanel.track('Viewed <?php single_post_title(); ?>');
	// mixpanel.track_links('.mainsharing #mc_signup_submit', 'Mailing List Sign Up', {
	//     'Location': 'Upper',
	//     'Page': '<?php the_title(); ?>'
	// });
	// mixpanel.track_links('.mainsharing2 #mc_signup_submit', 'Mailing List Sign Up', {
	//     'Location': 'lower',
	//     'Page': '<?php the_title(); ?>'
	// });
	// mixpanel.track_links('.mainsharing .twitter-follow-futton', 'Twitter Follow');
	// 
	
	
	
	</script>
	<!-- MixPanel End -->
</body>
</html>