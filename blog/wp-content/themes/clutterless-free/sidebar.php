<div id="sidebar">
  
        <div id="sidebar-name">
          <span class="sidebar-name-wrap"><?php bloginfo('name'); ?></span>
        </div><!-- #sidebar-name -->
        
        
        <div id="sidebar-inner">
   
                <div id="sidebar-logo">

                      <div class="logo">

                        <div class="logo-image">
                          <?php
                    			$logo = get_option('clutterless_logo');
                    			if ($logo != '') {
                    			?>
                                <a href="<?php print get_home_url(); ?>" title="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>"><img src="<?php echo $logo; ?>" alt="<?php bloginfo('name'); ?>" width="48" height="48"/></a>
                    			<?php
                    			} else {?>            			
                    			<?php }?>
                    			</div><!-- .logo-image -->
                        <div class="logo-name"><h1><a href="<?php print get_home_url(); ?>"><?php bloginfo('name'); ?></a></h1></div><!-- .logo-name -->
                        <div class="tagline"><?php bloginfo('description'); ?></div><!-- .tagline -->
                        <div class="clear"></div>

                      </div><!-- #logo -->
        
                </div><!-- #sidebar-logo -->

                <div id="sidebar-bio">
          
                        <?php
                  			$bio = get_option('clutterless_bio');
                  			if ($bio != '') {
                  			?>
                              <p><?php echo $bio; ?></p>
                  			<?php
                  			} else {?>            			
                  			<?php }?>

                </div><!-- /#sidebar-bio -->
                
                <div class="clear"></div>
        
                <div id="sidebar-widgets">
          
                   <?php dynamic_sidebar() ?>
          
                </div><!-- #sidebar-widgets -->
                
                <div class="clear"></div>

                <div id="search">
          
                  	  <form id="search-form"  action="<?php print get_site_url(); ?>/" method="get">
                  			<input type="text" id="search-field" name="s" value="<?php  if (is_search()) {esc_attr_e($s);} else {echo ('Search');} ?>" onFocus="this.value=''" />
          			        <input type="submit" id="search-button" value="" />
          		        </form>
          
                </div><!-- #search -->
        
                <div class="clear"></div>
                
                <div id="sidebar-credit">
                  <p><a href="http://onepagelove.com/themes/clutterless" target="_blank">Clutterless WordPress Theme</a> <span class="by">by</span> <a href="http://onepagelove.com" target="_blank">One Page Love</a></p>
                </div><!-- #sidebar-credit -->


                <div class="clear"></div>

        </div><!-- sidebar-inner -->
  
</div><!-- sidebar -->