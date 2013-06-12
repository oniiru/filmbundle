<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<a class="hiddenanchor" id="toregister"></a>
   <a class="hiddenanchor" id="tologin"></a>
   <div id="wrapper">
<div id="login" class="form animate">
	<div class="logintopbar">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/smallerlogo.png" class="smallerlogo">
    <a id="to-register" href="#toregister" class="stag-button small light-blue square to_register">Join</a><p class="alreadymember"> Not a member?</p>
</div>	
<h2 class="loginsubtitle"> Log in to your Account </h2>

	<?php $template->the_errors(); ?>

	<div class="socialloginstuff">
		<?php do_action( 'wordpress_social_login' ); ?> 
		<span>or</span>
 	</div>

	<div class="login loginbox animate" id="theme-my-login<?php $template->the_instance(); ?>">
		
	<form name="loginform" id="loginform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'login' ); ?>" method="post">
		<p>
			<input type="text" placeholder="Email" name="log" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'log' ); ?>" size="20" />
		</p>
		<p>
			<input type="password" placeholder="Password" name="pwd" id="user_pass<?php $template->the_instance(); ?>" class="input" value="" size="20" />
		</p>
		<?php do_action( 'login_form' ); ?>
		<?php $template->the_action_template_message( 'login' ); ?>
	
		<p class="submit">
			<input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php esc_attr_e( 'Log In' ); ?>" />
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'login' ); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="action" value="login" />
		</p>
	</form>
	<?php $template->the_action_links( array( 'login' => false, 'register' =>false ) ); ?>
	
	</div>

</div>

<div id="register" class="animate form">
	<div class="logintopbar">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/smallerlogo.png" class="smallerlogo">
   	 <a id="to-login" href="#tologin" class="stag-button small light-blue square to_register"> Login</a><p class="alreadymember"> Already a member?</p>
		
	</div>
	<p class="registerheader">Create a free account for instant access.</p>
	
	<div class="login loginbox animate" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php do_action( 'wordpress_social_login' ); ?> 
	<p class="orrr"> - OR -</p>
		<form name="registerform" id="registerform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'register' ); ?>" method="post">
			<!--
			<p>
				<input type="text" placeholder="Username" name="user_login" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_login' ); ?>" size="20" />
			</p>
			-->

			<!-- <p>
				
			<input type="text" placeholder="First Name" name="first_name" id="first_name<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'first_name' ); ?>" size="20" tabindex="20" />
			</p> -->
			<p>
				<input placeholder="Email" type="text" name="user_email" id="user_email<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_email' ); ?>" size="20" />
			</p>
		
			<?php do_action( 'register_form' ); ?>
			<p id="reg_passmail<?php $template->the_instance(); ?>"><?php echo apply_filters( 'tml_register_passmail_template_message', __( 'A password will be e-mailed to you.' ) ); ?></p>

			<p class="submit">
				<input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php esc_attr_e( 'Register' ); ?>" />
				<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'register' ); ?>" />
				<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
				<input type="hidden" name="action" value="register" />
			</p>
		</form>
		
	</div>
	<div class="threepoints"> 
	
		<h3 class="notopmargin">Curated Discovery</h3>
		<p>Your favorite filmmakers and organization share films that matter to them.</p>
		
		<h3>Pay What You Want</h3>
		<p>You are in control. Pay what the films are worth to you. </p>
		
		<h3>Support Charity</h3>
		<p>Give some or all of your payment to charity.</p>
		 
</div>		 
	 </div>
		 
 </div>
	
</div>

<script>
if (!('backgroundSize' in document.body.style || 'MozBackgroundSize' in document.body.style)) {
    $(document).ready(function() {
        var background = $('body'), fallbackimage, fallbackpattern, overflowX, overflowY;
         
        background.prepend('<img src="img/background-image.jpg" id="fallbackimage">');
        background.prepend('<div id="fallbackpattern"></div>');
         
        fallbackimage = $('#fallbackimage');
        fallbackpattern = $('#fallbackpattern');
         
        $(window).on("load resize", centerImage);
         
        function centerImage() {        
            overflowX = (fallbackpattern.width() - fallbackimage.width()) / 2;
            overflowY = (fallbackpattern.height() - fallbackimage.height()) / 2;                    
            fallbackimage.css('margin-left', overflowX+'px');
            fallbackimage.css('margin-top', overflowY+'px');
        }
         
    });
}
</script>