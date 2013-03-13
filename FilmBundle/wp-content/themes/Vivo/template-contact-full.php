<?php
/*
Template Name: Contact Full Screen
*/
?>

<?php
$nameError = '';
$emailError = '';
$commentError = '';
if(isset($_POST['submitted'])) {
	if(trim($_POST['contactName']) === '') {
		$nameError = 'Please enter your name.';
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}

	if(trim($_POST['email']) === '')  {
		$emailError = 'Please enter your email address.';
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	if(trim($_POST['comments']) === '') {
		$commentError = 'Please enter a message.';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}

	if(!isset($hasError)) {
		$emailTo = get_option('of_email');
		if (!isset($emailTo) || ($emailTo == '') ){
			$emailTo = get_option('admin_email');
		}
		$subject = 'Message from '.$name;
		$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
		$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}

} ?>

<?php get_header(); ?>
</div><!-- end #main_sidebar -->

<!-- Display map -->
<?php if(get_option('of_maps_location') != "") { ?>
	<div class="contact_full">
		<?php include 'includes/get_map.php'; ?>
	</div>
<?php } ?>

	<div class="contact_open"><a href="#">Open</a></div>
	<div class="contact_open_responsive"><a href="#">Open</a></div>

	<div id="content" class="fixed_page contact_full clearfix">
		<div class="contact_close"><a href="#">&larr;</a></div>
		<div class="contact_close_responsive"><a href="#">&larr;</a></div>

		<?php if (get_option('of_titles_off') == "false") { ?>
			<h1 class="page_title"><?php the_title(); ?></h1>
			<div class="divider"></div>
		<?php } ?>

		<!-- Display form -->
		<div id="contact-form" class="clearfix">
			<!-- Standard page content -->
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			<?php endif; ?>

			<?php if(isset($emailSent) && $emailSent == true) { ?>
				<div class="message success nospace">
					<h2>Thanks</h2>
					<p>Your email was sent successfully, we'll get back to you as soon as possible.</p>
				</div>
			</div>
			<?php } else { ?>
				<?php if(isset($hasError) || isset($captchaError)) { ?>
					<p class="error">Sorry, an error occured.<p>
			<?php } ?>
		
			
				<form action="<?php the_permalink(); ?>" id="contactForm" method="post">
					<ul>
						<li>
							<?php if($nameError != '') { ?>
								<span class="error"><?php echo $nameError;?></span>
							<?php } ?>
							<label for="contactName">Name<div class="contact-arrow"></div></label>
							<input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required requiredField" />
						</li>
						<li>
							<?php if($emailError != '') { ?>
								<span class="error"><?php echo $emailError; ?></span>
							<?php } ?>
							<label for="email">Email<div class="contact-arrow"></div></label>
							<input type="email" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required requiredField email" />
						</li>
						<li>
							<?php if($commentError != '') { ?>
								<span class="error"><?php echo $commentError;?></span>
							<?php } ?>
							<label class="message-area" for="commentsText">Message<div class="contact-message-arrow"></div></label>
							<textarea name="comments" id="commentsText" class="required requiredField"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
						</li>
						<li>
							<button type="submit" class="button">Send</button>
						</li>
					</ul>
					<input type="hidden" name="submitted" id="submitted" value="true" />
				</form>
			</div><!--end #contact-form-->
			<?php } ?>
			<div class="divider responsive"></div>
			<div id="contact_sidebar">
				<div id="contact_info">
					<div class="feat_title_container">
						<h3 class="feat_title">Other info</h3>
					</div>
					<?php if(get_option('of_address') != "") { ?><p class="contact-icon address"><?php echo get_option('of_address'); ?></p><?php } ?>
					<?php if(get_option('of_phone') != "") { ?><p class="contact-icon phone"><?php echo get_option('of_phone'); ?></p><?php } ?>
					<?php if(get_option('of_email') != "") { ?><p class="contact-icon email"><?php echo get_option('of_email'); ?></p><?php } ?>
				</div><!-- end .contact_info -->
				<div class="divider"></div>
				<div id="contact_social_links">
					<div class="feat_title_container">
						<h3 class="feat_title">Social Media</h3>
					</div>
					<ul id="social" class="contact">
			          <?php if(get_option('of_sm_facebook') != "") { ?><li><a href="http://facebook.com/<?php echo get_option('of_sm_facebook'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/facebook_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_vimeo') != "") { ?><li><a href="http://vimeo.com/<?php echo get_option('of_sm_vimeo'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/vimeo_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_twitter') != "") { ?><li><a href="http://twitter.com/<?php echo get_option('of_sm_twitter'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/twitter_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_tumblr') != "") { ?><li><a href="http://<?php echo get_option('of_sm_tumblr'); ?>.tumblr.com/"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/tumblr_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_linkedin') != "") { ?><li><a href="<?php echo get_option('of_sm_linkedin'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/linkedin_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_flickr') != "") { ?><li><a href="http://www.flickr.com/photos/<?php echo get_option('of_sm_flickr'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/flickr_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_dribbble') != "") { ?><li><a href="http://www.dribbble.com/<?php echo get_option('of_sm_dribbble'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/dribbble_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_rss') != "") { ?><li><a href="<?php echo get_option('of_sm_rss'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/rss_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_forrst') != "") { ?><li><a href="http://forrst.com/people/<?php echo get_option('of_sm_forrst'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/forrst_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_devart') != "") { ?><li><a href="http://<?php echo get_option('of_sm_devart'); ?>.deviantart.com"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/deviantart_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_google') != "") { ?><li><a href="http://plus.google.com/<?php echo get_option('of_sm_google'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/google_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_lastfm') != "") { ?><li><a href="http://last.fm/user/<?php echo get_option('of_sm_lastfm'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/lastfm_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_myspace') != "") { ?><li><a href="http://www.myspace.com/<?php echo get_option('of_sm_myspace'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/myspace_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_pinterest') != "") { ?><li><a href="http://pinterest.com/<?php echo get_option('of_sm_pinterest'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/pinterest_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_skype') != "") { ?><li><a href="callto://<?php echo get_option('of_sm_skype'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/skype_hover.png" /></a></li><?php } ?>
			          <?php if(get_option('of_sm_youtube') != "") { ?><li><a href="<?php echo get_option('of_sm_youtube'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/styles/images/icons/social/youtube_hover.png" /></a></li><?php } ?>
			        </ul>
				</div><!-- end .contact_social_links -->
			</div><!-- end #contact_sidebar -->
	
</div><!-- end #content -->		
</div><!-- end #wrapper -->
<?php get_footer(); ?>