<?php
/**
Template Name: Slide Template
*/

get_header('slide'); ?>

<div class="homepage-sections">
    <?php dynamic_sidebar( 'slide-bundle' ); ?>
</div>

<?php get_footer('slide'); ?>