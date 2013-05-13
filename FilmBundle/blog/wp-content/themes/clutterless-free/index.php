<?php get_header(); ?>
<div class="socialstuff">
<div class="fb-like" data-href="http://facebook.com/filmbundle" data-send="false" data-layout="button_count" data-width="50" data-show-faces="false"></div>

<?php mailchimpSF_signup_form(); ?>
<div class="twitterbutton">
<a href="https://twitter.com/filmbundle" class="twitter-follow-button" data-show-count="false" data-size="large" data-show-screen-name="false">Follow @filmbundle</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</div>
</div>
         <div id="post">

           <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <?php get_template_part('loop'); ?>

            <?php endwhile; else: ?>

           <p>Sorry, no posts matched your criteria.</p>

           <?php endif; ?>

            <div class="navigation"></div><!-- AJAX navigation -->
            
          </div><!-- #post -->

<?php get_footer(); ?>