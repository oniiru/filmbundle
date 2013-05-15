<?php
//Somewhat awkward way of finding the ID for the posts page
//NOTE: is_home is a little miss-leading
$posts_page = get_option('page_for_posts');
$the_id = '';

if(is_home($posts_page)) {
	$the_id = $posts_page; }
else {
	$the_id = $post->ID; }

//Find out if there is a custom background and if it should be repeated
$custom_bg = get_post_meta($the_id, 'mb_custom_bg_image', true);
$custom_bg_repeat = get_post_meta($the_id, 'mb_custom_bg_repeat', true);

//If there is a custom background
if($custom_bg) {
	$image_url = wp_get_attachment_image_src($custom_bg, 'full'); ?>
	<style>
	body {
		background-image: url(<?php echo $image_url[0]; ?>);
		background-attachment: fixed;

		<?php if($custom_bg_repeat == true) { ?>
			background-repeat: repeat;
		background-position: top left;
		<?php } else { ?>
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		background-position: center center;
		<?php } ?>
	}
	</style>
<?php } else {
//Otherwise get the standard site background options
	$bgShows = get_option('of_bg_shows');
	$bgUploadPat = get_option('of_bg_upload_pat');
	$bgUploadFull = get_option('of_bg_upload_full');
	$bgcolour = get_option('of_bg_colour');
	$bg_pattern = get_option('of_background_pattern');
	?>
	<style>
	body {	
			background-color: <?php echo $bgcolour; ?>;
			
			<?php if($bgShows == "up_image") { ?>
				background-image: url(<?php echo $bgUploadFull; ?>);
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
				background-position: center center;
				background-attachment: fixed;
			<?php } else if($bgShows == "up_pat") { ?>
				background: url(<?php echo $bgUploadPat; ?>) repeat;
			<?php } else if($bgShows == "pattern") { ?>
				background: url(<?php echo get_template_directory_uri(); ?>/styles/images/bg/<?php echo $bg_pattern; ?>.png) repeat;
			<?php } ?>
	}
	</style>

	<?php //If using the full screen BG, add a dark overlay too
	//if(get_option('of_bg_shows') == "up_image") { ?>
		<!-- <div id="bg_dark_overlay"></div>-->
	<?php //} ?>

<?php } ?>