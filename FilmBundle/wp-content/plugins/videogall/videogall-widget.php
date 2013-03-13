<?php
class VideogallWidget extends WP_Widget {
    var $settings = array('title','category','number_of_videos');
    function VideogallWidget() {
        $widget_ops = array('description' => __('Display video gallery on sidebar', 'videogall'));
        parent::WP_Widget(false, __('Videogall', 'videogall'), $widget_ops);
    }

    function widget($args, $instance) {
        global $videogall_options;
        extract($args, EXTR_SKIP);
        $instance = $this->widget_enforce_defaults($instance);
        extract($instance, EXTR_SKIP);

        $unique_id = $args['widget_id'];
        echo $before_widget;
        if ($title) {
	    echo $before_title.apply_filters('widget_title', $title, $instance, $this->id_base).$after_title;
	} else echo '';

        echo videogall_gallery($category,$number_of_videos,true);
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $new_instance = $this->widget_enforce_defaults($new_instance);
        return $new_instance;
    }

    function widget_enforce_defaults($instance) {
        $defaults = $this->widget_get_settings();
        $instance = wp_parse_args($instance, $defaults);
        $instance['title'] = strip_tags($instance['title']);
        $instance['category'] = $instance['category'];
        $instance['number_of_videos'] = intval($instance['number_of_videos']);
        if(trim($instance['number_of_videos']) == '') $instance['number_of_videos'] = 10;
        return $instance;
    }

    function widget_get_settings() {
        // Set the default to a blank string
        $settings = array_fill_keys($this->settings, '');
        // Now set the more specific defaults
        $settings['category'] = "";
        $settings['number_of_videos'] = 10;
        return $settings;
    }

    function form($instance) {
        global $shortname;
        $instance = $this->widget_enforce_defaults($instance);
        extract($instance, EXTR_SKIP);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):', 'videogall'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:', 'videogall'); ?></label>
	    <select name="<?php echo $this->get_field_name('category'); ?>" id="<?php echo $this->get_field_id('category'); ?>">
                <option value=""></option>
                <?php foreach(get_option('videogall_categories') as $cat_entry) { ?>
                    <option value="<?php echo $cat_entry; ?>" <?php selected($category, $cat_entry); ?>><?php echo $cat_entry; ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number_of_videos'); ?>"><?php _e('Number of videos:', 'videogall'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('number_of_videos'); ?>"  value="<?php echo esc_attr($number_of_videos); ?>" class="widefat" id="<?php echo $this->get_field_id('number_of_videos'); ?>" />
        </p>
        <?php
    }
}
register_widget('VideogallWidget');
?>