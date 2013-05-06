<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class='hfeed'>

    <?php if(get_post_meta(get_the_ID(), '_stag_cover_video', true) != ''): ?>
        <iframe id="player_1" src="http://player.vimeo.com/video/<?php echo get_post_meta(get_the_ID(), '_stag_cover_video', true); ?>?api=1&amp;player_id=player_1" width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
    <?php elseif(get_post_meta(get_the_ID(), '_stag_cover_image', true) != ''): ?>
        <figure class="entry-image">
            <img src="<?php echo get_post_meta(get_the_ID(), '_stag_cover_image', true); ?>" alt="<?php the_title(); ?>">
        </figure>
    <?php endif; ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <p class="pubdate">
            <?php the_time('F d Y'); ?>
        </p>

        <h2 class="entry-title"><?php the_title(); ?></h2>

        <div class="entry-content clearfix">
            <?php the_content(); ?>
        </div>

    </article>

</div>

<?php endwhile; ?>

<?php comments_template('', true); ?>

<?php endif; ?>

<?php get_footer() ?>