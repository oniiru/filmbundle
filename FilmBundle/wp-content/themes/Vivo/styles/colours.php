<?php 
header("Content-type: text/css");

if(file_exists('../../../../wp-load.php')) :
	include '../../../../wp-load.php';
else:
	include '../../../../../wp-load.php';
endif; 

ob_flush(); 
?>


<?php
$font = get_option('of_font');
//Get the colours and options from the Theme Options
$link = get_option('of_link_colour');
$linkhov = get_option('of_linkhov_colour');
$logotextcolour = get_option('of_logo_text_colour');
$logomargin = get_option('of_logo_margin');
$tagmargin = get_option('of_tag_margin');
?>

::selection { background: <?php echo $link; ?>;}

h1, h2, .work_item h3, .format-status .status p {
	font-family: <?php echo $font; ?>, sans-serif;
}

#contact_info_header { margin-top: <?php echo $tagmargin; ?>px;}

a { color: <?php echo $link; ?>; }
a:hover { color: <?php echo $linkhov; ?>; }
#main_sidebar.dark #primary_nav ul li a:hover { background: <?php echo $link; ?>;}
#main_sidebar.dark #primary_nav li.current_page_item > a { background: <?php echo $link; ?>;}
#main_sidebar.light #primary_nav ul li a:hover { background: <?php echo $link; ?>;}
#main_sidebar.light #primary_nav li.current_page_item > a { background: <?php echo $link; ?>;}
#logo h1 { color: <?php echo $logotextcolour; ?>; }
.slider_next, .slider_prev { background: <?php echo $link; ?>;}
.slider_next:hover, .slider_prev:hover { background: <?php echo $linkhov; ?>;}
#filters li:hover { background: <?php echo $link; ?>;}
.overlay_link:hover, .overlay_link:hover { background: <?php echo $link; ?> url(images/icons/overlay_link.png) no-repeat center center; }
.overlay_zoom:hover, .overlay_zoom:hover { background: <?php echo $link; ?> url(images/icons/overlay_zoom.png) no-repeat center center; }
.short_divider { background: <?php echo $link; ?>; }
.feat_work_cat span { color: <?php echo $link; ?>; }
ul.filter-list li:hover { background: <?php echo $link; ?>; }
#nextPortItem:hover, #prevPortItem:hover { background: <?php echo $link; ?>; }
.port_next:hover, .port_prev:hover { background: <?php echo $link; ?>; }
#contact-form input[type=text]:focus, #contact-form input[type=email]:focus, #contact-form textarea:focus, .searchbox input:focus { border-color: <?php echo $link; ?>; }
.contact_close { border-right:60px solid <?php echo $link; ?>; }
.contact_close_responsive { border-right:60px solid <?php echo $link; ?>; }
.contact_open { background: <?php echo $link; ?>; }
.contact_open_responsive { background: <?php echo $link; ?>; }

.flex-direction-nav a { background: <?php echo $link; ?> ;}
ul.portfolio_tags li { background: <?php echo $link; ?>; }
#backToPort:hover {	background: <?php echo $link; ?> url(images/icons/general/grid.png) no-repeat 50% 10px; }

p a, ul li a, a.post-edit-link { color: <?php echo $link; ?>; }
.post-meta a { color: <?php echo $link; ?>; }
.post-meta a:hover { color: <?php echo $linkhov; ?>; }
.comment-author a { color: <?php echo $link; ?>; }
.comment-author a:hover { color: <?php echo $linkhov; ?>; }
a.comment-reply-link { color: <?php echo $link; ?>; }
a.comment-reply-link:hover { color: <?php echo $linkhov; ?>; }
#author-bio a { color: <?php echo $link; ?>; }
#author-bio a:hover { color: <?php echo $linkhov; ?>; }
#commentform input:focus, #commentform textarea:focus { border: 1px solid <?php echo $link; ?>; }

#twitter-tweets ul li a { color: <?php echo $link; ?>;}
#twitter-tweets ul li a:hover { color: <?php echo $linkhov; ?>;}

a.showhide { background: <?php echo $link; ?>;}

<?php ob_end_flush(); ?>