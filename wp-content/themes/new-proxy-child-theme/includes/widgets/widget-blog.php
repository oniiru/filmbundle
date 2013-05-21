<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_section_blog");'));

class stag_section_blog extends WP_Widget{
  function stag_section_blog(){
    $widget_ops = array('classname' => 'section-block', 'description' => __('Displays your recent blog post.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_section_blog');
    $this->WP_Widget('stag_section_blog', __('Homepage: Blog Section', 'stag'), $widget_ops, $control_ops);
  }



  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['subtitle'] = strip_tags($new_instance['subtitle']);
    $instance['color'] = strip_tags($new_instance['color']);
    $instance['bg'] = strip_tags($new_instance['bg']);
    $instance['link'] = strip_tags($new_instance['link']);

    $instance['db_user'] = strip_tags($new_instance['db_user']);
    $instance['db_password'] = strip_tags($new_instance['db_password']);
    $instance['db_name'] = strip_tags($new_instance['db_name']);
    $instance['db_host'] = strip_tags($new_instance['db_host']);

    return $instance;
  }


    /**
     * Form to edit widget settings.
     */
    public function form($instance)
    {
        $defaults = array(
          'bg' => '#1F2329',
          'color' => '',
          'link' => '',
          /* Deafult options goes here */
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

        <?php include('helper-widget-colors.php'); ?>

        <!-- Setup database connection -->
        <p>
            <label for="<?php echo $this->get_field_id('db_user'); ?>">DB User:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('db_user'); ?>" name="<?php echo $this->get_field_name('db_user'); ?>" value="<?php echo @$instance['db_user']; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('db_password'); ?>">DB Password:</label>
            <input type="password" class="widefat" id="<?php echo $this->get_field_id('db_password'); ?>" name="<?php echo $this->get_field_name('db_password'); ?>" value="<?php echo @$instance['db_password']; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('db_name'); ?>">DB Name:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('db_name'); ?>" name="<?php echo $this->get_field_name('db_name'); ?>" value="<?php echo @$instance['db_name']; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('db_host'); ?>">DB Host:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('db_host'); ?>" name="<?php echo $this->get_field_name('db_host'); ?>" value="<?php echo @$instance['db_host']; ?>" />
        </p>
        <?php
    }

    /**
     * Output the widget to the frontend.
     */
    public function widget($args, $instance)
    {
        extract($args);
        // VARS FROM WIDGET SETTINGS
        $title = apply_filters('widget_title', $instance['title'] );
        $subtitle = $instance['subtitle'];
        $color = $instance['color'];
        $bg = $instance['bg'];
        $link = $instance['link'];
        echo $before_widget;
        ?>

        <!-- BEGIN #blog.section-block -->
        <section id="blog" class="section-block" data-bg="<?php echo $bg; ?>" data-color="<?php echo $color; ?>" data-link="<?php echo $link; ?>">
            <div class="inner-section">
                <?php
                if($subtitle != '') echo '<p class="sub-title">'.$subtitle.'</p>';
                echo $before_title.$title.$after_title;
                $s = get_option( 'sticky_posts' );
                $d_c= '';

                $wpdb_ext = new wpdb($instance['db_user'], $instance['db_password'], $instance['db_name'], $instance['db_host']);

                ?>
                <div class="grids">

            <div class="grid-6 featured-post">
              <?php

              if(count($s) != 0){
                $d_c = 'sticky';
                query_posts(array(
                  'p' => array_pop($s),
                  'posts_per_page' => 1,
                  'orderby' => 'date'
                ));
              }else{
                query_posts(array(
                  'posts_per_page' => 1,
                  'orderby' => 'date'
                ));
              }

              if(have_posts()){
                while(have_posts()): the_post();
                ?>
                <div <?php post_class($d_c); ?>>
                  <p class="pubdate"><?php the_time('F d Y'); ?></p>
                  <h2><a data-through="gateway" data-postid="<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                  <div class="entry-content">
                    <?php if(has_post_thumbnail()): ?>
                    <a data-through="gateway" data-postid="<?php the_ID(); ?>" href="<?php the_permalink(); ?>">
                      <?php the_post_thumbnail(); ?>
                    </a>
                    <?php endif; ?>
                    <?php the_excerpt(); ?>
                  </div>
                </div>
                <?php
                endwhile;
              }
              wp_reset_query();
              ?>
            </div><!-- /featured-post -->

                    <!-- Implementing external posts -->
                    <div class="grid-6 all-posts">
                        <div id="blog-post-slider" class="flexslider">
                            <ul class="slides">
                                <?php
                                $query = "SELECT ID, post_title, post_date, post_name FROM wp_posts
                                          WHERE post_status = 'publish'
                                          AND post_type = 'post'
                                          ORDER BY post_date DESC 
                                          LIMIT 1, 999";
                                $posts = $wpdb_ext->get_results($query, OBJECT);
                                $start = 4;
                                $finish = 1;

                                foreach ($posts as $post) {
                                    if (is_multiple($start, 4)) {
                                        echo '<li>';
                                    }
                                    echo '<p class="pubdate">'.date('F d Y', strtotime($post->post_date)).'</p>';
                                    echo "<h3><a href='".home_url('blog/'.$post->post_name)."/' title=\"{$post->post_title}\" data-through=\"gateway\" data-postid=\"{$post->ID}\">{$post->post_title}</a></h3>";
                                    if (is_multiple($finish, 4)) {
                                        echo '</li>';
                                    }
                                    $start++;
                                    $finish++;
                                }
                                ?>
                        </ul>
                      </div>
                    </div><!-- /all-posts -->

                </div><!-- /grids -->
            </div><!-- END .inner-section -->
        </section><!-- END #blog.section-block -->
        <?php
        echo $after_widget;
    }
}
