      <?php stag_content_end(); ?>
      <!-- END #container -->
    </div>

    <?php stag_footer_before(); ?>

      <!-- BEGIN .footer -->
      <footer class="footer" role="contentinfo">
        <?php stag_footer_start(); ?>

        <div class="inner-section">

            <div class="grids">
              <div class="grid-6 rawr">
                <ul class="social-links">
                  <?php

                    if(stag_get_option('social_url_facebook') != '' ){
                      echo '<li><a href="//facebook.com/'.stag_get_option('social_url_facebook').'" title="'.get_bloginfo('title').' on facebook" class="'.stag_social_class('social_url_facebook').'"></a></li>';
                    }

                    if(stag_get_option('social_url_twitter') != '' ){
                      echo '<li><a href="//twitter.com/'.stag_get_option('social_url_twitter').'" title="'.get_bloginfo('title').' on twitter" class="'.stag_social_class('social_url_twitter').'"></a></li>';
                    }

                    if(stag_get_option('social_url_dribbble') != '' ){
                      echo '<li><a href="//dribbble.com/'.stag_get_option('social_url_dribbble').'" title="'.get_bloginfo('title').' on dribbble" class="'.stag_social_class('social_url_dribbble').'"></a></li>';
                    }

                    if(stag_get_option('social_url_forrst') != '' ){
                      echo '<li><a href="//forrst.com/'.stag_get_option('social_url_forrst').'" title="'.get_bloginfo('title').' on forrst" class="'.stag_social_class('social_url_forrst').'"></a></li>';
                    }

                    if(stag_get_option('social_url_feed') != '' ){
                      echo '<li><a href="'.stag_get_option('social_url_feed').'" title="'.get_bloginfo('title').'\'s feed" class="'.stag_social_class('social_url_feed').'"></a></li>';
                    }

                  ?>
                </ul>
              </div>
              <div class="grid-6 copyright copyrightfooter">
                <?php if(stag_get_option('homepage_footer_info') != '') echo '<span>'.stripslashes(stag_get_option('homepage_footer_info')).'</span>'; ?>
              </div>
            </div>

        </div>

        <?php stag_footer_end(); ?>
        <!-- END .footer -->
      </footer>

      <?php if(is_home()): ?>
      <div id="gateway-wrapper">
        <div id="gateway" data-gateway-path="<?php echo get_template_directory_uri(); ?>/includes/gateway.php"></div>
      </div>
    <?php endif; ?>

    <?php stag_footer_after(); ?>

  <?php wp_footer(); ?>
  <?php stag_body_end(); ?>
  </body>
</html>