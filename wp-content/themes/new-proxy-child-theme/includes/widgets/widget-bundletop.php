<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_bundletop");'));
class stag_section_bundletop extends WP_Widget{
  function stag_section_bundletop(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Show info about your site from specific page.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_bundletop');
    $this->WP_Widget('stag_section_bundletop', __('Homepage: Bundletop Section', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = $instance['title'];
    $subtitle = $instance['subtitle'];
    $color = $instance['color'];
    $bg = $instance['bg'];
    $link = $instance['link'];
    $page = $instance['page'];
    $id = $instance['id'];
    $facebook_share_text = $instance['facebook_share_text'];
    $twitter_share_text = $instance['twitter_share_text'];

    echo $before_widget;

    ?>

    <!-- BEGIN #about.section-block -->
    <section id="<?php echo stag_to_slug($id); ?>" class="section-block content-section">

      <div class="inner-section">

        <?php

        $the_page = get_page($page);

            echo '<h1 id="bigone">'.$title.'</h1>';
			if($subtitle != '') echo '<p class="shared-sub-title">'.$subtitle.'</p>';
		
        // echo '<div class="entry-content">'.apply_filters('the_content', $the_page->post_content).'</div>';
   ?>
    <div class="centerthis">
   
	</div>

</div>
  
      <!-- END #about.section-block -->
    </section>
  <div class="topshelf grid-12"></div>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = $new_instance['title'];
    $instance['subtitle'] = $new_instance['subtitle'];
    $instance['color'] = strip_tags($new_instance['color']);
    $instance['bg'] = strip_tags($new_instance['bg']);
    $instance['link'] = strip_tags($new_instance['link']);
    $instance['page'] = strip_tags($new_instance['page']);
    $instance['id'] = strip_tags($new_instance['id']);
    $instance['facebook_share_text'] = strip_tags($new_instance['facebook_share_text']);
    $instance['twitter_share_text'] = strip_tags($new_instance['twitter_share_text']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      /* Deafult options goes here */
      'page' => 0,
      'id' => 'about',
      'color' => '',
      'bg' => '',
      'link' => '',
      'facebook_share_text' => '',
      'twitter_share_text' => '',
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
      <textarea class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo @$instance['subtitle']; ?>" /><?php echo @$instance['subtitle']; ?></textarea>
    </p>


    <p>
      <label for="<?php echo $this->get_field_id('facebook_share_text'); ?>"><?php _e('Facebook Share Text:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'facebook_share_text' ); ?>" name="<?php echo $this->get_field_name( 'facebook_share_text' ); ?>" value="<?php echo @$instance['facebook_share_text']; ?>" />
    </p>


    <p>
      <label for="<?php echo $this->get_field_id('twitter_share_text'); ?>"><?php _e('Twitter Share Text:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'twitter_share_text' ); ?>" name="<?php echo $this->get_field_name( 'twitter_share_text' ); ?>" value="<?php echo @$instance['twitter_share_text']; ?>" />
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