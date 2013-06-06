<?php if ( post_password_required() ) : ?>
<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'presslayer' ); ?></p>
<?php
	return;
endif;
?>

<?php // You can start editing here -- including this comment! ?>
<?php if ( have_comments() ) : ?>
<div id="comments">
	hi
	
</div>	
<?php endif; ?>
<div id="respond">
	
<?php echo do_shortcode('[fbcomments width="700" count="on" num="5" countmsg="comments!"]'); ?>

</div>