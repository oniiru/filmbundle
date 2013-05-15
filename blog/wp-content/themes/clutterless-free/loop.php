<div class="post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <div class="post-date">

    <a href="<?php the_permalink(); ?>"><?php echo the_time('j F Y') ?></a>

  </div><!-- .post-date -->

  <div class="post-title">

   <a href="<?php the_permalink(); ?>"> <h2><?php the_title(); ?></h2> </a>

  </div><!-- .post-title -->

  <div class="post-content">

      <?php the_content();?>

  </div><!-- .post-content -->

</div><!-- /.post -->