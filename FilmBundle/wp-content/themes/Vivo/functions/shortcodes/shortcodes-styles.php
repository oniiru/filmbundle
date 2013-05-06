<?php
//space shortcode
function md_space( $atts, $content = null ) {
   return '<div class="space"></div>';
}
add_shortcode('space', 'md_space');

//separator shortcode
function md_separator( $atts, $content = null ) {
   return '<div class="divider"></div>';
}
add_shortcode('sep1', 'md_separator');

//embed vimeo shortcode
function md_vimeo( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"vid" => ''
	), $atts));
   return '<div class="video_container"><iframe src="http://player.vimeo.com/video/'.$vid.'?title=1&byline=0&portrait=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
}
add_shortcode('vimeo', 'md_vimeo');

//embed youtube shortcode
function md_youtube( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"vid" => ''
	), $atts));
   return '<div class="video_container"><iframe src="http://youtube.com/embed/'.$vid.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
}
add_shortcode('youtube', 'md_youtube');

//title shortcode
function md_title( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"title" => ''
	), $atts));
   return '<div class="feat_title_container"><h3 class="feat_title home">'.$title.'</h3></div>';
}
add_shortcode('title', 'md_title');

//header icon
function md_icon_header($atts, $content = null) {
	extract(shortcode_atts(array(
		"icon" => ''
	), $atts));
	return '<h3 class="icon '.$icon.'">'.$content.'</h3>';
}
add_shortcode("icon", "md_icon_header");

//message boxes - coloured
function md_box($atts, $content = null) {
	extract(shortcode_atts(array(
		"type" => ''
	), $atts));
	return '<div class="message '.$type.'">'.$content.'</div>';
}
add_shortcode("box", "md_box");

//message boxes - plain
function md_box_plain($atts, $content = null) {
	extract(shortcode_atts(array(
		"style" => 'light',
		"title" => 'No title'
	), $atts));
	return '<div class="box '.$style.'"><div class="box-title">'.$title.'</div><div class="box-body">'.$content.'</div></div>';
}
add_shortcode("textbox", "md_box_plain");

//lists
function md_icon_lists($atts, $content = null) {
	extract(shortcode_atts(array(
		"icon" => ''
	), $atts));
	return '<ul class="icon_list '.$icon.'">'.do_shortcode($content).'</ul>';
}
add_shortcode("list", "md_icon_lists");

	//lists
	function md_icon_lists_item($atts, $content = null) {
		return '<li>'.$content.'</li>';
	}
	add_shortcode("li", "md_icon_lists_item");	

//quote
function md_quote_left( $atts, $content = null ) {
	return '<div class="quote left">'.$content.'</div>';
}
add_shortcode("quote_left", "md_quote_left");

function md_quote_right( $atts, $content = null ) {
	return '<div class="quote right">'.$content.'</div>';
}
add_shortcode("quote_right", "md_quote_right");

//code
function md_code( $atts, $content = null ) {
	return '<div class="code">'.$content.'</div>';
}
add_shortcode("code", "md_code");

//buttons
function md_buttons( $atts, $content = null ) {
    extract(shortcode_atts(array(
    'link'	=> '#',
    'shape'	=> '',
    'style'	=> '',
    'size'	=> '',
    ), $atts));


	$out = '<a class="button '.$shape . ' ' . $size . ' ' . $style. '" href="' .$link. '"><span>' .do_shortcode($content). '</span></a>';

    return $out;
}
add_shortcode('button', 'md_buttons');

//togglers
function md_toggler($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => ''
	), $atts));
	return '<div class="toggler"><h4 class="trigger"><a href="#">'.$title.'</a></h4><div class="toggle_container"><div class="toggle_block">'.$content.'</div></div></div>';
}
add_shortcode("toggle", "md_toggler");

//tabs
add_shortcode( 'tabgroup', 'md_tab_group' );
function md_tab_group( $atts, $content ){

extract(shortcode_atts(array(
'id' => ''
), $atts));

$GLOBALS['tab_count'] = 0;

do_shortcode( $content );

if( is_array( $GLOBALS['tabs'] ) ){
$uid = '';
foreach( $GLOBALS['tabs'] as $tab ){
$uid = $uid + 1;
$tabs[] = '<li><a class="" href="#tabs'.$id.$uid.'">'.$tab['title'].'</a></li>';
$panes[] = '<div id="tabs'.$id.$uid.'">'.$tab['content'].'</div>';
}
$return = '<div id="'.$id.'" class="tabs"><ul class="idTabs clearfix">'.implode( "\n", $tabs ).'</ul>'."\n".implode( "\n", $panes )."\n".'</div>';
}
return $return;
}

add_shortcode( 'tab', 'md_tab' );
function md_tab( $atts, $content ){
extract(shortcode_atts(array(
'title' => 'Tab %d'
), $atts));

$x = $GLOBALS['tab_count'];
$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' =>  $content );

$GLOBALS['tab_count']++;
} ?>