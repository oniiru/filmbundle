<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_work");'));

class stag_section_work extends WP_Widget{
  function stag_section_work(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Showcase your work from Portfolio section.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_work');
    $this->WP_Widget('stag_section_work', __('Homepage: Work Section', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];
    $count = $instance['count'];
    $cat = $instance['cat'];
    $color = $instance['color'];
    $bg = $instance['bg'];
    $link = $instance['link'];
    $id = $instance['id'];

    echo $before_widget;

    if($id === '') $id = 'work';

    ?>

    <!-- BEGIN #work.section-block -->
    <section id="<?php echo $id; ?>" class="work-section section-block" data-bg="<?php echo $bg; ?>" data-color="<?php echo $color; ?>" data-link="<?php echo $link; ?>">

      <div class="inner-section">

        <?php
          if($subtitle != '') echo '<p class="sub-title">'.$subtitle.'</p>';
          echo $before_title . $title . $after_title;

          $args = array(
              'post_type' => 'portfolio',
              'posts_per_page' => $count,
              'skill' => $cat
          );
          $the_query = new WP_Query($args);
        ?>

        <!-- BEGIN #portfolio-slider -->
        <div id="portfolio-slider" class="">
          <ul class="grids">
            <?php
              if($the_query->have_posts()){
                while($the_query->have_posts()): $the_query->the_post();
                ?>
                  <li class="grid-6">
                    <a href="<?php the_permalink(); ?>" data-through="gateway" data-postid="<?php the_ID(); ?>">
                      <div class="portfolio-content">
                        <h3><?php the_title(); ?></h3><i class="icon-open"></i>
                      </div>
                    </a>
                    <?php
                      if(has_post_thumbnail()){
                        echo the_post_thumbnail('portfolio-thumb');
                      }

                    ?>
                  </li>
                <?php
                endwhile;
              }
              wp_reset_postdata();
            ?>
          </ul>
        <!-- END #portfolio-slider -->
        </div>
      </div>

      <!-- END #work.section-block -->
    </section>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['subtitle'] = strip_tags($new_instance['subtitle']);
    $instance['id'] = strip_tags($new_instance['id']);
    $instance['count'] = strip_tags($new_instance['count']);
    $instance['color'] = strip_tags($new_instance['color']);
    $instance['bg'] = strip_tags($new_instance['bg']);
    $instance['link'] = strip_tags($new_instance['link']);
    $instance['cat'] = strip_tags($new_instance['cat']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      /* Deafult options goes here */
      'bg' => '#1F2329',
      'color' => '',
      'link' => '',
      'cat' => '',
      'count' => 6,
      'id' => 'work'
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

    <p>
      <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Section ID:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo @$instance['id']; ?>" />
      <span class="description"><?php _e('Section ID is required if you want to use this section as a navigation. e.g. about, and add a custom link under Menus with link #about.', 'stag') ?></span>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo @$instance['count']; ?>" />
      <span class="description"><?php _e('Number of portfolio items to show.', 'stag'); ?></span>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('Skill:', 'stag'); ?></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'cat' ); ?>" name="<?php echo $this->get_field_name( 'cat' ); ?>">
        <option value="0">All</option>
      <?php
      $c = get_categories('taxonomy=skill&type=portfolio&hide_empty=1');
      foreach($c as $cat){
          ?>
          <option value="<?php echo $cat->slug; ?>" <?php if($instance['cat'] === $cat->slug) echo "selected"; ?>><?php echo $cat->name; ?></option>
          <?php
      }
      ?>
      </select>
      <span class="description"><?php _e('Choose the skill to filter the Portfolio.', 'stag'); ?></span>
    </p>

    <?php include('helper-widget-colors.php'); ?>

    <?php
  }
}

?>