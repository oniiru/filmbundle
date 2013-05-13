<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_service_box");'));

class stag_service_box extends WP_Widget{
  function stag_service_box(){
    $widget_ops = array('classname' => '', 'description' => __('Service box, use it under Services Widgets Sidebar.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_service_box');
    $this->WP_Widget('stag_service_box', __('Services: Service Box', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $description = $instance['description'];
    $icon = $instance['icon'];
    @$customicon = $instance['customicon'];

    echo $before_widget;

    ?>

    <div class="grid-4">

      <figure class="<?php if($customicon != '') echo 'no-bg'; ?>">

        <?php if($customicon  != ''){
          echo '<div class="custom-icon"><img src="'.$customicon.'" alt=""></div>';
        }else{
          echo '<div class="inner-bg '.stag_to_slug($icon).'"></div>';
        } ?>

      </figure>

      <?php
        echo $before_title . $title . $after_title;
        if($description != '') echo '<div class="service-description">'.$description.'</div>';
      ?>
    </div>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['description'] = strip_tags($new_instance['description']);
    $instance['icon'] = strip_tags($new_instance['icon']);
    $instance['customicon'] = strip_tags($new_instance['customicon']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      /* Deafult options goes here */
      'title' => 'This is a Title!',
      'icon' => 'screen',
      'customicon' => ''
    );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo @$instance['title']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:', 'stag'); ?></label>
      <textarea rows="6" class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo @$instance['description']; ?></textarea>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('customicon'); ?>"><?php _e('Custom Icon URL:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'customicon' ); ?>" name="<?php echo $this->get_field_name( 'customicon' ); ?>" value="<?php echo @$instance['customicon']; ?>" />
      <span class="description"><?php _e('Enter the custom icon URL if you want to use your own icon or choose one below.', 'stag'); ?></span>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('icon'); ?>"><?php _e('Icon:', 'stag'); ?></label>
      <select name="<?php echo $this->get_field_name( 'icon' ); ?>" id="<?php echo $this->get_field_name( 'icon' ); ?>" class="widefat">
        <option value="user-interface" <?php if ( 'user-interface' == $instance['icon'] ) echo 'selected="selected"'; ?>>User Interface</option>
        <option value="mobile" <?php if ( 'mobile' == $instance['icon'] ) echo 'selected="selected"'; ?>>Mobile</option>
        <option value="user-experience" <?php if ( 'user-experience' == $instance['icon'] ) echo 'selected="selected"'; ?>>User Experience</option>
        <option value="branding" <?php if ( 'branding' == $instance['icon'] ) echo 'selected="selected"'; ?>>Branding</option>
      </select>
    </p>

    <?php
  }
}

?>