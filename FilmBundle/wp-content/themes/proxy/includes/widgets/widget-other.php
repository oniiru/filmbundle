<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_others");'));

class stag_section_others extends WP_Widget{
  function stag_section_others(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Displays a section on homepage to display widgets used under Other Widets Sidebar.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_others');
    $this->WP_Widget('stag_section_others', __('Homepage: Other Widgets Section', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    // $title = apply_filters('widget_title', $instance['title'] );
    $color = $instance['color'];
    $bg = $instance['bg'];
    $link = $instance['link'];

    echo $before_widget;

    ?>

    <!-- BEGIN #other.section-block -->
    <section id="other" class="section-block" data-bg="<?php echo $bg; ?>" data-color="<?php echo $color; ?>" data-link="<?php echo $link; ?>">
      <div class="inner-section">
        <div class="grids">
          <?php dynamic_sidebar( 'sidebar-other' ); ?>
        </div>
      </div>
      <!-- END #other.section-block -->
    </section>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    $instance['color'] = strip_tags($new_instance['color']);
    $instance['bg'] = strip_tags($new_instance['bg']);
    $instance['link'] = strip_tags($new_instance['link']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      'color' => '',
      'bg' => '',
      'link' => '',
      /* Deafult options goes here */
    );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <?php include('helper-widget-colors.php'); ?>

    <?php
  }
}

?>