<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class='hfeed'>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <p class="pubdate"></p>

        <h2 class="entry-title"><?php the_title(); ?></h2>

        <div class="entry-content clearfix">
            <?php the_content(); ?>
        </div>
    </article>
</div>
<?php endwhile; ?>

<?php endif; ?>

<?php get_footer() ?>