<?php
/*
Template Name: Filmmaker Template
*/
 get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class='hfeed'>
	<div style="background-image:url('<?php echo get_stylesheet_directory_uri(); ?>/assets/img/topbannerbg.jpg')" class="topbanner"> 
		<div class="topbanner-inner">
		<h1>FilmBundle creates unique pay-what-you-want promotions 
to get your film in front of a whole new audience.</h1>
<h3>Our bundles are highly curated, but we absolutely DO consider unsolicited submissions.</h3>
	</div>		
	</div>
    <article class="filmmakerclass" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-content clearfix">
            <?php the_content(); ?>
        </div>
    </article>
</div>
<div class="filmmakersbanner">
	<h3> Have Questions?</h3> <a href="mailto:andrew@filmbundle.com" class="btn-large">Give a Shout</a>
</div>
<?php endwhile; ?>

<?php endif; ?>

<?php get_footer() ?>