<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_services");'));

class stag_section_services extends WP_Widget{
  function stag_section_services(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Displays a section on homepage to show your services. Use under Homepage Widgets.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_services');
    $this->WP_Widget('stag_section_services', __('Homepage: Services Section', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];
    $color = $instance['color'];
    $bg = $instance['bg'];
    $link = $instance['link'];

    echo $before_widget;

    ?>

    <!-- BEGIN #services.section-block -->
    <section id="services" class="section-block" data-bg="<?php echo $bg; ?>" data-color="<?php echo $color; ?>" data-link="<?php echo $link; ?>">

      <div class="inner-section">

        <?php
          if($subtitle != '') echo '<p class="sub-title">'.$subtitle.'</p>';
          echo $before_title . $title . $after_title;
        ?>

        <div class="grids">
          <?php dynamic_sidebar( 'sidebar-services' ); ?>
        </div>

      </div>

      <!-- END #services.section-block -->
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

    return $instance;
  }

  function form($instance){
    $defaults = array(
      /* Deafult options goes here */
      'title' => 'This is a Title!',
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
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo @$instance['subtitle']; ?>" />
    </p>

    <?php include('helper-widget-colors.php'); ?>

    <?php
  }
}

?>