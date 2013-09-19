<?php

function stag_customize_register( $wp_customize ){

    $wp_customize->add_section('accent_control', array(
        'title' => __('Accent Color', 'stag'),
        // 'description' => __('', 'stag'),
        'priority' => 36,
    ));

    $wp_customize->add_setting( 'stag_framework_values[accent_color]' , array(
        'default' => '#1f2329',
        'type' => 'option'
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'stag_framework_values[accent_color]', array(
        'label' => __('Choose accent color', 'stag'),
        'section' => 'accent_control',
        'settings' => 'stag_framework_values[accent_color]',
    )));
}
add_action( 'customize_register', 'stag_customize_register' );

function proxy_customize_css()
{
    ?>
<style type="text/css">
.content-section .sub-title,
#about .sub-title,
#contact .sub-title, #team .sub-title,
a,
.hentry .pubdate,
.stag-toggle .ui-state-active,
.stag-tabs ul.stag-nav .ui-state-active a
{ color:<?php echo stag_get_option('accent_color'); ?>; }

.button,
button,
input[type=submit],
blockquote,
#slideshow .slider-content h3,
#team .member-pic .member-links a,
#portfolio-slider .portfolio-content .icon-open
{ background-color:<?php echo stag_get_option('accent_color'); ?> !important; }

.button:hover,
button:hover,
input[type=submit]:hover
{ background-color:<?php echo stag_get_option('accent_color'); ?> !important; }
}
</style>
    <?php
}
add_action( 'wp_head', 'proxy_customize_css');