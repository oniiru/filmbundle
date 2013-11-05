<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_fb");'));

class stag_section_fb extends WP_Widget{
  function stag_section_fb(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Show info about your site from specific page.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_fb');
    $this->WP_Widget('stag_section_fb', __('Facebook Widget', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    echo $before_widget;

    ?>

    <!-- BEGIN #about.section-block -->
    <section id="facebookwidget" class="section-block content-section">

      <div class="inner-section">
		  <h2>What do you think of the bundle?</h2>
		  <?php disqus_embed('filmbundle'); ?>

		  
      </div>

      <!-- END #about.section-block -->
    </section>

    <?php
    echo $after_widget;
}
}

?>