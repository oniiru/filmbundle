<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_slidetoptop");'));

class stag_section_slidetoptop extends WP_Widget{
  function stag_section_slidetoptop(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Show info about your site from specific page.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_slidetoptop');
    $this->WP_Widget('stag_section_slidetoptop', __('Slides: Slidetoptop Section', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];
    $color = $instance['color'];
    $bg = $instance['bg'];
    $link = $instance['link'];
    $page = $instance['page'];
    $id = $instance['id'];

    echo $before_widget;
 $the_page = get_page($page);
 $image = wp_get_attachment_url( get_post_thumbnail_id($page) );
    ?>

    <!-- BEGIN #about.section-block -->
    <section id="<?php echo stag_to_slug($id); ?>"  class="section-block content-section midsect slidetoptop" style="background-image:url('<?php echo $image; ?>')" data-link="<?php echo $link; ?>">
		<div class="overlay">
		<script>
		jQuery( document ).ready(function() {
			jQuery('.carousel').carousel({
			  interval: 3000,
			  pause: "false"
			})
		  
			
			
				
				})
		</script>
		<div class="inner-carousel">
			
			<div class='flat-computer'>
				<div id="myCarousel" class="carousel slide">
				
  			  <!-- Carousel items -->
  			  <div class="carousel-inner carouselcomp">
  			    <div class="active item"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/discover.png">
					 </div>
  			    <div class="item"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/pwyw.png"></div>
  			    <div class="item"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/helpcharity.png"></div>
  			  </div>
			  
			</div>
		</div>
		
		<div class="carousel-text">
			<div id="myCarousel2" class="carousel slide">
			
		  <!-- Carousel items -->
		  <div class="carousel-inner">
		    <div class="active item">
				<h1>Discover Killer films</h1>
				 </div>
		    <div class="item">
				<h1>Pay What you Want</h1>
			</div>
		    <div class="item">
				<h1>Support Charity</h1>			
			</div>
		  </div>
		  
		</div>
		<p class="undercarousel">
		
			Limited-time bundles of amazing hand-selected independent films. Pay only what they are worth to you, and support charity while you're at it.
		</p>
		<p class="carousel-btn"> Learn More <span> &#9660;</span></p>
	</div>
		</div>
		
		<!-- <div class="scrolldown">
		
			<h4>See what we're about </h4>
		</div>
	</div>
	 -->
	<script>
	jQuery(document).ready(function (){
	            jQuery("p.carousel-btn").click(function (){
	                //$(this).animate(function(){
	                    jQuery('html, body').animate({
	                        scrollTop: jQuery("section:nth-of-type(2)").offset().top
	                    }, 1000);
	                //});
	            });
				
	        });
			

	 
	</script>
	
    </section>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['subtitle'] = strip_tags($new_instance['subtitle']);
    $instance['color'] = strip_tags($new_instance['color']);
    $instance['bg'] = strip_tags($new_instance['bg']);
    $instance['link'] = strip_tags($new_instance['link']);
    $instance['page'] = strip_tags($new_instance['page']);
    $instance['id'] = strip_tags($new_instance['id']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      /* Deafult options goes here */
      'page' => 0,
      'id' => 'slidetoptop',
      'color' => '',
      'bg' => '',
      'link' => '',
    );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo @$instance['title']; ?>" />
      <span class="description">Leave blank to use default page title.</span>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo @$instance['subtitle']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Select Page:', 'stag'); ?></label>

      <select id="<?php echo $this->get_field_id( 'page' ); ?>" name="<?php echo $this->get_field_name( 'page' ); ?>" class="widefat">
      <?php

        $args = array(
          'sort_order' => 'ASC',
          'sort_column' => 'post_title',
          );
        $pages = get_pages($args);

        foreach($pages as $paged){ ?>
          <option value="<?php echo $paged->ID; ?>" <?php if($instance['page'] == $paged->ID) echo "selected"; ?>><?php echo $paged->post_title; ?></option>
        <?php }

       ?>
     </select>
     <span class="description">This page will be used to display content.</span>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Section ID:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo @$instance['id']; ?>" />
      <span class="description"><?php _e('Section ID is required if you want to use this section as a navigation. e.g. about, and add a custom link under Menus with link #about.', 'stag') ?></span>
    </p>

    <?php include('helper-widget-colors.php'); ?>

    <?php
  }
}

?>