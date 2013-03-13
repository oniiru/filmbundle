<?php
/**
 * Default Footer
 *
 * @package WP-Bootstrap
 * @subpackage Default_Theme
 * @since WP-Bootstrap 0.1
 *
 * Last Revised: February 4, 2012
 */
?>
    <!-- End Template Content -->

</div><!--/.container -->
</div><!--/#content-wrapper -->
      <footer>
<div class="container">
      <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; <?php bloginfo('name'); ?> <?php the_time('Y') ?></p>
          <?php
    if ( function_exists('dynamic_sidebar')) dynamic_sidebar("footer-content");
?>
</div> <!-- /container --></div>
       </footer>
<?php wp_footer(); ?>
<script>  
jQuery('.videogall-item').popover({placement:'in top', html:'true', animation:'true'});

</script>  

  </body>
</html>