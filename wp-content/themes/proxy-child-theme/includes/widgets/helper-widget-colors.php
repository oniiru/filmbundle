<p>
  <label for="<?php echo $this->get_field_id('bg'); ?>"><?php _e('Background Color:', 'stag'); ?></label>
  <input type="text" name="<?php echo $this->get_field_name( 'bg' ); ?>" id="<?php echo $this->get_field_id( 'bg' ); ?>" value="<?php echo @$instance['bg']; ?>" />
  <script>jQuery('#<?php echo $this->get_field_id("bg") ?>').wpColorPicker();</script>
</p>

<p>
  <label for="<?php echo $this->get_field_id('color'); ?>"><?php _e('Text Color:', 'stag'); ?></label>
  <input type="text" name="<?php echo $this->get_field_name( 'color' ); ?>" id="<?php echo $this->get_field_id( 'color' ); ?>" value="<?php echo @$instance['color']; ?>" />
  <script>jQuery('#<?php echo $this->get_field_id("color") ?>').wpColorPicker();</script>
</p>

<p>
  <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link Color:', 'stag'); ?></label>
  <input type="text" name="<?php echo $this->get_field_name( 'link' ); ?>" id="<?php echo $this->get_field_id( 'link' ); ?>" value="<?php echo @$instance['link']; ?>" />
  <script>jQuery('#<?php echo $this->get_field_id("link") ?>').wpColorPicker();</script>

  <span class="description"><?php _e('Please save the widget, before using the color picker.', 'stag'); ?></span>
</p>