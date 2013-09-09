<div id="sidebar" style="display:none">
  
      
        
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
				                <div id="search">
          
				                  	  <form id="search-form"  action="<?php print get_site_url(); ?>/" method="get">
				                  			<input placeholder="search..." type="text" id="search-field" name="s" value="<?php  if (is_search()) {esc_attr_e($s);} ?>" onFocus="this.value=''" />
				          		        </form>
          
				                </div><!-- #search -->
        
				                <div class="clear"></div>
								
                        <div class="logo-name"><h2><a href="<?php print get_home_url(); ?>">Home</a></h2></div><!-- .logo-name -->
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

                
                
           


                <div class="clear"></div>

        </div><!-- sidebar-inner -->
  
</div><!-- sidebar -->