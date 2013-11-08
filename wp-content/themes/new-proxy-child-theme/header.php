<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <title><?php wp_title(''); ?></title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

  <link rel="dns-prefetch" href="//fonts.googleapis.com">
  <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

  <?php stag_meta_head(); ?>

  <?php wp_head(); ?>

  <?php stag_head(); ?>
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/popup.css" rel="stylesheet">

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/socialcss/zocial.css">
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/modernizr.js'></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/zclip.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.backstretch.min.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.easing-1.3.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.iosslider.min.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/popup.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/js/froogaloop.js'></script>
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
<a href="https://plus.google.com/106976496344175389196" style="display:none" rel="publisher">Google+</a>

<?php if (is_front_page()) { ?>
<style type='text/css'>
html, body {
  height: auto;
}
</style>
<?php } ?>

<script type="text/javascript">
jQuery(document).ready(function($) {
  if(Modernizr.backgroundsize) {
  } else {
    $("#shared").backstretch("/wp-content/themes/new-proxy-child-theme/assets/img/tinyblurred.jpg");
    $("#suggest").backstretch("/wp-content/themes/new-proxy-child-theme/assets/img/ladylooking.jpg");
  }
});
</script>

<style type='text/css'>
/** Target Firefox */
@-moz-document url-prefix() {
    input {
      -moz-box-sizing: content-box;
      padding: 5px 10px 5px 10px !important;
    }
    ::-moz-placeholder {
      font-style: italic;
    }
    .gform_wrapper input[type="text"] {
      padding: 5px 10px 5px 10px !important;
    }

}
</style>
</head>

<!-- BEGIN body -->
<body <?php body_class(); ?>>
  <!-- Start: The modal dialog for additional social features -->
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
  <div class="socialModalWrap">
      <div class="socialModalOverlay">
          &nbsp;
      </div>
      <div class="socialModalVerticalOffset">
          <div class="socialModalBox">
            <div class="widget_title"><a id="closeModal">X</a></div>
            <div class="socialModalContent">
              <div class="socialModalContentInner">
                <span class="socialModalThanks">Thanks for Sharing!</span>
                <span class="socialModalTell">Don't forget to like us on Facebook to get updates on bundles and exclusive content!</span>
            <div class="fb-like" data-href="https://www.facebook.com/filmbundle" data-layout="button_count" data-show-faces="false"></div>
          </div>
          <span class="socialModalDisable">Already like us? <a id="disableModal">Don't show this again</a></span>
            </div>
          </div>
      </div>
  </div>
  <!-- End: The modal dialog for additional social features -->

<?php stag_body_start(); ?>
<?php stag_header_before(); ?>
<header id="header" role="banner">

    <?php stag_header_start(); ?>

      <!-- BEGIN .header-inner -->
      <div class="header-inner clearfix">

        <!-- BEGIN #logo -->
		<a href="<?php echo site_url(); ?>">
    <img class="homelogo littlelogo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/whitehmmm.png">
</a>
        <div id="logo">
          <?php

          if( stag_get_option('general_text_logo') == 'on' ){ ?>
            <a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a>
          <?php } elseif( stag_get_option('general_custom_logo') ) { ?>
            <a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>"><img src="<?php echo stag_get_option('general_custom_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
          <?php } else{ ?>
            <a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php bloginfo( 'name' ); ?>"></a>
          <?php }

          ?>
          <!-- END #logo -->
        </div>

        <!-- BEGIN #primary-nav -->
		<div class="littlelogin">
			<?php if (!is_user_logged_in()) { ?>
			<a href="<?php bloginfo( 'url' ); ?>/login"><i style="font-size:1.3em; display:none;vertical-align:middle"class="icon-user"></i></a><h3><?php echo do_shortcode( '[login]' ); ?></h3>
			<?php } else  {?>
				
				<i style="font-size:1.3em; vertical-align:middle;display:none" class="icon-cog"></i><h3> Account </h3>
				<ul>
					<li class="hiddenli">
					<a href="<?php bloginfo( 'url' ); ?>/blog">Blog</a>
					</li>
					<li>
					<a href="<?php bloginfo( 'url' ); ?>/profile">Profile</a>
					</li>
					<li>
					<a href="http://filmbundle.zendesk.com">Support</a>
					</li>
					<li>
						<?php echo do_shortcode( '[logout]' ); ?>
					</li>
				</ul>
				
				<?php } ?>
		</div>
        <div class="littlesocial">
			<i style="font-size:1.3em; display:none;vertical-align:middle"class="icon-twitter"></i> <h3> Follow Us </h3>
			<ul>
				<li class="faceli">
        <div class="fb-like" style="margin-right:20px;" data-href="http://facebook.com/filmbundle" data-send="false" data-layout="button_count" data-width="10" data-show-faces="false"></div>
	</li>
	<li class="twitli">
        <div style="position:relative;display:inline-block"><a href="https://twitter.com/FilmBundle" class="twitter-follow-button" data-show-count="true" data-show-screen-name="false">Follow @FilmBundle</a>
          <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          </div>
	  </li>
	  <li class='tubeli'>
		  <script src="https://apis.google.com/js/plusone.js"></script>

		  <div class="g-ytsubscribe" data-channel="filmbundle" data-layout="default"></div>
	  </li>
  </ul>
        </div>
        <?php
		 if (is_user_logged_in()) { ?>
		<div class="littlesocial hiddenthing">
			<a href="<?php echo site_url(); ?>/watch"><i style="font-size:1.3em; display:none;vertical-align:middle"class="icon-film"></i></a> 
		</div>
		<?php } ?>
		
        <nav id="navigation" role="navigation">
            <?php
			 if (is_user_logged_in()) {
              if(has_nav_menu('loggedin-menu')){
                wp_nav_menu(array(
                  'theme_location' => 'loggedin-menu',
                  'container' => 'div',
                  'container_id' => 'primary-nav',
                  'container_class' => 'primary-menu',
                  ));
              }
		  }
		  else {
              if(has_nav_menu('loggedout-menu')){
                wp_nav_menu(array(
                  'theme_location' => 'loggedout-menu',
                  'container' => 'div',
                  'container_id' => 'primary-nav',
                  'container_class' => 'primary-menu',
                  ));
              }
			
			
		  }
            ?>
          
		   <?php 
		   $thebundle = $wpdb->get_results("SELECT * FROM wp_pwyw_bundles WHERE activated = '1'", ARRAY_A);
		
		 
		   class shareCount {
		   private $url,$timeout;
		   function __construct($url,$timeout=10) {
		   $this->url=rawurlencode($url);
		   $this->timeout=$timeout;
		   }
		   function get_tweets() { 
		   $json_string = $this->file_get_contents_curl('http://urls.api.twitter.com/1/urls/count.json?url=' . $this->url);
		   $json = json_decode($json_string, true);
		   return isset($json['count'])?intval($json['count']):0;
		   }

		   function get_fb() {
		   $json_string = $this->file_get_contents_curl('http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls='.$this->url);
		   $json = json_decode($json_string, true);
		   return isset($json[0]['total_count'])?intval($json[0]['total_count']):0;
		   }

		   private function file_get_contents_curl($url){
		   $ch=curl_init();
		   curl_setopt($ch, CURLOPT_URL, $url);
		   curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		   curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		   curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
		   $cont = curl_exec($ch);
		   if(curl_error($ch))
		   {
		   die(curl_error($ch));
		   }
		   return $cont;
		   }
		   }
		   $obj=new shareCount("http://www.humblebundle.com");  //Use your website or URL
		   $twittershares = $obj->get_tweets(); //to get tweets
		   $facebookshares = $obj->get_fb(); //to get facebook total count (likes+shares+comments)
		   $twitterstart = $thebundle[0]['twitterstart'];
		   $facestart = $thebundle[0]['facestart'];
		   $currenttwitter = ($twittershares - $twitterstart);
		   $currentface = ($facebookshares - $facestart);	
		   $facegoal = 	$thebundle[0]['facegoal'];
		   $twittergoal = $thebundle[0]['twittergoal'];
		   if($twittergoal != 0) {
		   $goalratiotwit = (($currenttwitter / $twittergoal) * 100);
	   }
	   else {$goalratiotwit = 1;}
	   if($goalratioface != 0) {
		   $goalratioface = (($currentface / $facegoal) * 100);
	   }
	   else {$goalratioface = 1;}
		   $twittergoal = $thebundle[0]['twittergoal'];
           $pwyw = Pwyw::getInstance();
           $pwyw_data = $pwyw->pwyw_get_bundle_info();
           $payment = $pwyw_data['payment_info'];
           $totalSales = isset($payment->total_sales) ?
                         $payment->total_sales : '0';
           $averagePrice = isset($payment->avg_price) ? 
                           number_format($payment->avg_price, 0) : '0.00';
           $totalPayments = isset($payment->total_payments) ?
                            number_format($payment->total_payments, 0) : '0.00';
		 ?>
          <!-- END #primary-nav -->
        </nav>

        <!-- END .header-inner -->
      </div>

    <?php stag_header_end(); ?>

</header>
<?php
    if (is_user_logged_in()) {
        // Get relevant info for current user
        $user = wp_get_current_user();
        $email = $user->user_email;

        // Retrieve the user from the subscriber DB
        global $wpdb;
        $tablename = $wpdb->prefix . SEED_CSP3_TABLENAME;
        $sql = "SELECT * FROM $tablename WHERE email = %s;";
        $safe_sql = $wpdb->prepare($sql, $email);
        $result = $wpdb->get_row($safe_sql);

        if ($result) {
            // Calc referrer url
            $ref = $result->id+1000;
			$urlnoslash = rtrim(home_url(),'/');
            $referrer_url = $urlnoslash . '?ref='.base_convert($ref, 10, 36);
        };
		$sharingiscaringheader = $referrer_url;

	}
	else {
		$sharingiscaringheader = home_url();

	}
    // Setup share urls
    $facebookheader_share = "http://www.facebook.com/sharer.php?s=100&amp;p[title]=".urlencode($thebundle[0]['facetitle'])."&amp;p[summary]=".urlencode($thebundle[0]['facedescription'])."&amp;p[images][0]=".$thebundle[0]['face_image']."&amp;p[url]=".$sharingiscaringheader;
    $twitterheader_share = "https://twitter.com/share?url=".$sharingiscaringeheader."&amp;text=".urlencode($thebundle[0]['twittermessage'].' - '.$sharingiscaringheader);
	
	if(stag_get_option('disable_social_header') == 'on'){
?>

<div id="slidingheader">
	<div class="skinnytop">
		<div class="slidingheader-inner">	
			<a href="<?php echo site_url(); ?>"><p class="logotext">Film<span>Bundle</span></p></a>
            <?php
			 if (is_user_logged_in()) {
              if(has_nav_menu('loggedinslider-menu')){
                wp_nav_menu(array(
                  'theme_location' => 'loggedinslider-menu',
                  'container' => 'div',
                  'container_id' => 'sliding-nav',
                  'container_class' => 'sliding-menu',
                  ));
              }
		  }
		  else {
              if(has_nav_menu('loggedoutslider-menu')){
                wp_nav_menu(array(
                  'theme_location' => 'loggedoutslider-menu',
                  'container' => 'div',
                  'container_id' => 'sliding-nav',
                  'container_class' => 'sliding-menu',
                  ));
              }
			
			
		  }
            ?>
		
		</div>
	</div>
	<div class="fatbottom">
		<div class="slidingheader-inner">	
			<div class="sharingwidget facebookshare">
	<a class="zocial facebook" href="<?php echo $facebookheader_share; ?>" onclick="return !handleSocialWin('<?php echo $facebookheader_share; ?>', 'Facebook');" target="_blank">Share</a>
	<div class="socialprogtext">
		<p><?php echo $currentface;?> Shares <span> Goal: <?php echo $facegoal;?></span></p>
		<div class="shareprogress">
		  <div class="bar" style="width: <?php echo $goalratioface; ?>%"></div>
		</div>
	</div>
	</div>
	<div class="sharingwidget  twittershare">
		<a class="zocial twitter" href="<?php echo $twitterheader_share; ?>" onclick="return !handleSocialWin('<?php echo $twitterheader_share; ?>', 'Twitter');" target="_blank">Tweet</a>
		<div class="socialprogtext">
		<p><?php echo $currenttwitter;?> Shares <span> Goal: <?php echo $twittergoal;?></span></p>
		<div class="shareprogress">
  <div class="bar" style="width: <?php echo $goalratiotwit; ?>%;"></div>
</div>
</div>
</div>
<div class="bundletotals">
	<a href="<?php home_url(); ?>"><h3>The <?php echo $thebundle[0]['title'];?> Bundle</h3></a>
	<h2><?php echo $totalSales;?> Sold</h2>
	<h2>$<?php echo $totalPayments;?> Raised</h2>
	<h2 class="thecountdown"> <div class="inlineblock"><?php
            $atts = array(
                't'           => $thebundle['0']['end_time'],
                'days'        => 'd',
                'hours'       => 'h',
                'minutes'     => 'm',
                'seconds'     => 's',
                'omitweeks'   => 'true',
                'style'       => 'pwyw',
                'jsplacement' => 'inline'
            );
            echo tminuscountdown($atts);
        ?> </div> remaining</h2>
</div>

	</div>
</div>
</div>
<?php }; ?>
<script>

jQuery(window).bind('scroll', function(){
	if(jQuery(window).width() > 600) {
if(jQuery(this).scrollTop() >= 60) {
jQuery("#slidingheader").fadeIn(450);
}
if(jQuery(this).scrollTop() < 60) {
jQuery("#slidingheader").fadeOut(450);
}
} 
});

</script>
<?php stag_header_after(); ?>

  <!-- BEGIN #container -->
  <div id="container">
  <?php stag_content_start(); ?>