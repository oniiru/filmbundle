<?php get_header();?>
<div class="mainsharing white_box box_info">
	<div class="socialstuff">
		<p>Like, Follow and Subscribe to get the latest great stuff</p>
		
		<div class="fbstuff">
			<p>Facebook</p>
<iframe class="fbthing translucent-modal" src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Ffacebook.com%2Ffilmbundle&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21&amp;appId=194791007338880" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></div>
<div class="chimpform">
	<p>Email</p>
	<?php mailchimpSF_signup_form(); ?>
</div>
	<div class="twitterbutton">
		<p>Twitter</p>
	<a href="https://twitter.com/filmbundle" class="twitter-follow-button translucent-modal" data-show-count="false" data-size="large" data-show-screen-name="false">Follow @filmbundle</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	</div>
	</div>
</div>
<div id="leftContent">
	<div class="inner">
		<?php 
		if(is_home() and $pl_data['enable_slider']!='no') get_template_part('inc/slider');?>
		<?php get_template_part('loop-entry','index');?>
	</div>
</div>

<?php get_sidebar();?>

<?php get_footer();?>	