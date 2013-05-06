<?php
/*
Template Name: Blog Template
*/

 get_header(); ?>
 <div id="content">

     <?php
               // Blog post query
     $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
     query_posts( array( 'post_type' => 'post', 'paged'=>$paged, 'showposts'=>0) );
     if (have_posts()) : while ( have_posts() ) : the_post(); ?>
     <div <?php post_class(); ?>>
       <a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><h3><?php the_title();?></h3></a>
<p class="pubdate"></p>
       <div class="row">
         <div class="span2"><?php // Checking for a post thumbnail
         if ( has_post_thumbnail() ) ?>
         <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
           <?php the_post_thumbnail();?></a>
         </div><!-- /.span2 -->
         <div class="span6">
          <?php the_excerpt();?>
        </div><!-- /.span6 -->
      </div><!-- /.row -->
      <hr />
    </div><!-- /.post_class -->
  <?php endwhile; endif; ?>
         
	  </div>
<?php get_footer(); ?>