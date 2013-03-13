<?php 
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])){
	die('Please do not load this page directly!');
}
	if(post_password_required()){
?>
	<p>This post is password protected.</p>
<?php return; } ?>

<div class="divider"></div>
	<?php if('open' == $post->comment_status) : ?><h3 class="comments"><?php comments_number('Be the first to comment!', 'One Comment', '% Comments'); ?></h3><?php endif; ?>
	<?php if($comments) : ?>
	
	<ol id="comments_section">
		<?php wp_list_comments(array('avatar_size'=>50, 'reply_text'=>'Reply')); ?>
	</ol>
	<div class="pagination"><?php paginate_comments_links(); ?></div>
	<?php
	else ://if no comments so far
	?>
	
	<?php if('open' == $post->comment_status) : ?>
	<?php else : ?>
	<p>Comments currently closed!</p>
		<?php endif; ?>
	<?php endif; ?>
<?php if('open' == $post->comment_status) : ?>

<?php comment_form(); ?>

<?php endif; ?>