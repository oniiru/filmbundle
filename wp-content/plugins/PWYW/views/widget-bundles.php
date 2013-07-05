<label for="<?php echo $widget->get_field_name('bundle'); ?>">Bundle:</label>
<select class="widefat" 
        id="<?php echo $widget->get_field_id('bundle'); ?>"
        name="<?php echo $widget->get_field_name('bundle'); ?>">
    <?php
    foreach ($bundles as $bundle) {
        $sel = selected($instance['bundle'], $bundle->id, false);
        echo "<option value='{$bundle->id}' {$sel}>{$bundle->title}</option>";
    }
    ?>
</select>
