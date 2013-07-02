<script type="text/javascript" >
jQuery(document).ready(function($) {

  $('#feature_image_button_<?php echo $id; ?>').click(function() {
    wp.media.editor.send.attachment = function(props, attachment) {
      $('#feature_image_<?php echo $id; ?>').val(attachment.url);
    }
    wp.media.editor.open(this);
    return false;
  });

});
</script>

<?php
// Set the input name prefix
$prefix = "films[{$array_id}][features][$id]"
?>
<input name="<?php echo $prefix; ?>[id]" type="hidden" value="<?php echo $feature->id; ?>" />
<input name="<?php echo $prefix; ?>[deleted]" type="hidden" value="" />
<p>
  <input name="<?php echo $prefix; ?>[image]" id="feature_image_<?php echo $id; ?>" type="text" value="<?php echo $feature->image; ?>" class="regular-text" style="width:600px;" placeholder="Image" />
  <a class="button-secondary" id="feature_image_button_<?php echo $id; ?>" title="Media Image Library">Media Image Library</a>
</p>

<p>
 <input name="<?php echo $prefix; ?>[title]" type="text" value="<?php echo $feature->title; ?>" class="large-text" placeholder="Title" />
</p>

<p>
 <input name="<?php echo $prefix; ?>[subtitle]" type="text" value="<?php echo $feature->subtitle; ?>" class="large-text" placeholder="Sub-title" />
</p>
