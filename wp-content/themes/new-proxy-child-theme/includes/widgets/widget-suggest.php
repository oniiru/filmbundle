<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_suggest");'));

class stag_section_suggest extends WP_Widget{
  function stag_section_suggest(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('suggest Section of the Homepage', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_suggest');
    $this->WP_Widget('stag_section_suggest', __('Homepage: suggest Bar', 'stag'), $widget_ops, $control_ops);
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

    ?>

    <!-- BEGIN #suggest.section-block -->
    <section id="<?php echo stag_to_slug($id); ?>" class="section-block content-section" data-bg="<?php echo $bg; ?>" data-color="<?php echo $color; ?>" data-link="<?php echo $link; ?>">

      <div class="inner-section">
      <div id="suggest-section">
      <h2>What would you like to see<span>?</span></h2>
      <!-- <h3>Suggest a...</h3> -->
		  <a href="#myModal" data-toggle="modal" class="btn btn-large btn-success"> Suggest a Curator! </a>
		  <a href="#myModal2" data-toggle="modal" class="btn btn-large btn-success"> Suggest a Film! </a>
      </div>
		  
			
      </div>

	  <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-header">
	      <h3 id="myModalLabel">Suggest a Curator</h3>
	    </div>
	    <div class="modal-body">
			<p> Would you love to see a bundle curated by someone specific? Maybe the Oren Peli supernatural bundle, the Tarantino action bundle, the Sundance Indie Bundle or the Freddie Wong shoot 'em up bundle. Here is your chance to let know!</p>
	     <?php echo do_shortcode( '[gravityform id="5" name="Suggest A Curator" title="false" description="false" ajax="true"]' ) ?> 
	    </div>
	    <div class="modal-footer">
	    </div>
	  </div>
	  
	  <div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
	    <div class="modal-header">
	      <h3 id="myModal2Label">Suggest a Curator</h3>
	    </div>
	    <div class="modal-body">
			<p> See an awesome film? Make an awesome film? We want to hear about it! Killer indies can be tough to uncover, so we need your help. Let us know what you love using the form below. :)</p>
	     <?php echo do_shortcode( '[gravityform id="6" name="Suggest A Film" title="false" description="false" ajax="true"]' ) ?> 
	    </div>
	    <div class="modal-footer">
	    </div>
	  </div>



      <!-- END #suggest.section-block -->
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
      'id' => 'suggest',
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
      <span class="description"><?php _e('Section ID is required if you want to use this section as a navigation. e.g. about, and add a custom link under Menus with link #suggest.', 'stag') ?></span>
    </p>

    <?php include('helper-widget-colors.php'); ?>

    <?php
  }
}

?>