<?php
class FilmBundle_ExternalBlog
{
    private static $instance = false;
    private static $database = false;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {}

    public function database($user, $password, $name, $host)
    {
        $this->database = new wpdb($user, $password, $name, $host);
    }

    public function featuredPost()
    {
        $query = "SELECT ID, post_title, post_date, post_name, post_content FROM wp_posts
                  WHERE post_status = 'publish'
                  AND post_type = 'post'
                  ORDER BY post_date DESC 
                  LIMIT 1";
        $post = $this->database->get_row($query, OBJECT);
        return $post;
    }

    public function thumbnail($id)
    {
        // Get the featured image
        $query = "SELECT p.*
                  FROM wp_postmeta AS pm
                  INNER JOIN wp_posts AS p ON pm.meta_value=p.ID 
                  WHERE pm.post_id = $id
                  AND pm.meta_key = '_thumbnail_id' 
                  ORDER BY p.post_date DESC 
                  LIMIT 15";
        $thumbnail = $this->database->get_row($query);
        if (is_null($thumbnail)) {
            return false;
        }
        $path = dirname($thumbnail->guid);

        // Get the metadata for the featued image
        $query = "SELECT *
                  FROM wp_postmeta
                  WHERE post_id = $thumbnail->ID
                  AND meta_key = '_wp_attachment_metadata'";

        $meta = $this->database->get_row($query);
        $meta = unserialize($meta->meta_value);
        if (!isset($meta['sizes']['thumbnail'])) {
            return false;
        } 

        // Get the url to the thumbnail
        $file = $meta['sizes']['thumbnail']['file'];
        $url =  "{$path}/{$file}";

        // Get the alt attribute
        $query = "SELECT *
                  FROM wp_postmeta
                  WHERE post_id = $thumbnail->ID
                  AND meta_key = '_wp_attachment_image_alt'";
        $alt = $this->database->get_row($query);
        $alt = is_null($alt) ? '' : $alt->meta_value;

        // Build array to return
        $thumbnail = array(
            'url'    => $url,
            'width'  => $meta['sizes']['thumbnail']['width'],
            'height' => $meta['sizes']['thumbnail']['height'],
            'alt'    => $alt
        );
        return $thumbnail;
    }

    public function allPosts()
    {
        $query = "SELECT ID, post_title, post_date, post_name FROM wp_posts
                  WHERE post_status = 'publish'
                  AND post_type = 'post'
                  ORDER BY post_date DESC 
                  LIMIT 1, 999";
        $posts = $this->database->get_results($query, OBJECT);
        return $posts;
    }
}

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

                $ext = FilmBundle_ExternalBlog::getInstance();
                $ext->database(
                    $instance['db_user'],
                    $instance['db_password'],
                    $instance['db_name'],
                    $instance['db_host']
                );
                ?>
                <div class="grids">
                    <div class="grid-6 featured-post">
                        <?php
                        $post = $ext->featuredPost();
                        $post_url = home_url('blog/'.$post->post_name.'/');
                        echo '<p class="pubdate">'.date('F d Y', strtotime($post->post_date)).'</p>';
                        echo "<h2><a href=\"{$post_url}\" title=\"{$post->post_title}\">{$post->post_title}</a></h2>";
                        ?>
                        <div class="entry-content">
                            <?php
                            $tn = $ext->thumbnail($post->ID);
                            if ($tn) {
                                echo "<a href='{$post_url}'>";
                                echo "<img src='{$tn['url']}' width='{$tn['width']}' height='{$tn['height']}' class='attachment-thumbnail wp-post-image' alt='{$tn['alt']}' />";
                                echo "</a>";
                            }
                            echo wp_trim_words($post->post_content, 35, '... ');
							echo " - <a class='readmore' href='{$post_url}'>Read More...</a>";
                            ?>
                        </div>
                    </div><!-- /featured-post -->

                    <!-- Implementing external posts -->
                    <div class="grid-6 all-posts">
                        <div id="blog-post-slider" class="flexslider">
                            <ul class="slides">
                                <?php
                                $posts = $ext->allPosts();
                                $start = 3;
                                $finish = 1;

                                foreach ($posts as $post) {
                                    if (is_multiple($start, 3)) {
                                        echo '<li>';
                                    }
									echo '<div class="row">';
                                    echo '<p class="pubdate">'.date('F d Y', strtotime($post->post_date)).'</p>';
                                    echo "<h3><a href='".home_url('blog/'.$post->post_name)."/' title=\"{$post->post_title}\">{$post->post_title}</a></h3></div>";
                                    if (is_multiple($finish, 3)) {
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
add_action('widgets_init', create_function('', 'return register_widget("stag_section_blog");'));
