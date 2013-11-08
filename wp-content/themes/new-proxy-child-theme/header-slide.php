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
 
  // Cache selectors
  var lastId,
      topMenu = $("#slide-nav, #slide-nav2"),
      topMenuHeight = topMenu.outerHeight()+0,
      // All list items
      menuItems = topMenu.find("a"),
      // Anchors corresponding to menu items
      scrollItems = menuItems.map(function(){
        var item = $($(this).attr("href"));
        if (item.length) { return item; }
      });

  // Bind click handler to menu items
  // so we can get a fancy scroll animation
  menuItems.click(function(e){
    var href = $(this).attr("href"),
        offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight+1;
    $('html, body').stop().animate({ 
        scrollTop: offsetTop
    }, 300);
    e.preventDefault();
  });

  // Bind to scroll
  $(window).scroll(function(){
      if($(window).scrollTop() + $(window).height() == $(document).height()) {
          $('#slide-nav ul li').removeClass('active');
          $('#slide-nav ul li:last').addClass('active');
      }
	
 	 else {
		 if ($('#slide-nav ul li:last').hasClass('active')) {
		 	$('#slide-nav ul li:last').removeClass('active');
			$('#slide-nav ul li:nth-last-child(2)').addClass('active');
		 }
		 else{

     // Get container scroll position
     var fromTop = $(this).scrollTop()+topMenuHeight;
   
     // Get id of current scroll item
     var cur = scrollItems.map(function(){
       if ($(this).offset().top < fromTop)
         return this;
     });
     // Get the id of the current element
     cur = cur[cur.length-1];
     var id = cur && cur.length ? cur[0].id : "";
   
     if (lastId !== id) {
         lastId = id;
         // Set/remove active class
         menuItems
           .parent().removeClass("active")
           .end().filter("[href=#"+id+"]").parent().addClass("active");
     } }     }  
   
  });
  
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
	<div id="slidenav-outer">
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
<?php     if(has_nav_menu('slide-menu')){
          wp_nav_menu(array(
            'theme_location' => 'slide-menu',
            'container' => 'div',
            'container_id' => 'slide-nav',
            'container_class' => 'slide-menu',
            ));
        } ?>
	</div>
	
	<div id="slidenav-outer2">
		<img class="homelogo littlelogo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/hmmm.png">
		
		<?php     if(has_nav_menu('slide-menu')){
		          wp_nav_menu(array(
		            'theme_location' => 'slide-menu',
		            'container' => 'div',
		            'container_id' => 'slide-nav2',
		            'container_class' => 'slide-menu',
		            ));
		        } ?>
	</div>
	<script>

	jQuery(window).bind('scroll', function(){
		var viewportWidth  = jQuery(window).width();
		elementOffset = jQuery('section:nth-of-type(2)').offset().top;
	if(jQuery(this).scrollTop() >= elementOffset) {
		if(viewportWidth > 1100) {
	jQuery("#slidenav-outer").fadeIn(450);
	jQuery("#slidenav-outer2").fadeOut(450);
	
}
else {
	jQuery("#slidenav-outer2").fadeIn(450);
}
	jQuery("#contactfooter").fadeIn(450);
	
	}
	if(jQuery(this).scrollTop() < elementOffset) {
	jQuery("#slidenav-outer").fadeOut(450);
	jQuery("#slidenav-outer2").fadeOut(450);
	
	jQuery("#contactfooter").fadeOut(450);
	
	}
	});
	
	

	</script>
	
	
  <!-- BEGIN #container -->
  <div id="container">
	  <div id="contactfooter">
		<p>  Need more information? Drop us a line!</p> <span> <a href="mailto:andrew@filmbundle.com">Email</a> &nbsp;| &nbsp;Phone: 408.656.3604
	  </div>
  <?php stag_content_start(); ?>