<?php
// Set the input name prefix
$prefix = "films[{$array_id}][features][$id]"
?>

<script type="text/javascript" >
jQuery(document).ready(function($) {

  $('#film_<?php echo $array_id; ?>_feature_image_button_<?php echo $id; ?>').click(function() {
    wp.media.editor.send.attachment = function(props, attachment) {
      $('#film_<?php echo $array_id; ?>_feature_image_<?php echo $id; ?>').val(attachment.url);
    }
    wp.media.editor.open(this);
    return false;
  });

  $('#film_<?php echo $array_id; ?>_delete_feature_<?php echo $id; ?>').click(function() {
      var id = <?php echo $array_id; ?>;
      var result = confirm("Are you sure you want to delete the special feature?");
      if (result) {
        $('#film_<?php echo $array_id; ?>_feature_<?php echo $id; ?>').hide();
        $('[name="films\[<?php echo $array_id; ?>\]\[features\]\[<?php echo $id; ?>\]\[deleted\]"]').val('true');
      }
  });

});
</script>

<div id="film_<?php echo $array_id; ?>_feature_<?php echo $id; ?>">
    <input name="<?php echo $prefix; ?>[id]" type="hidden" value="<?php echo $feature->id; ?>" />
    <input name="<?php echo $prefix; ?>[deleted]" type="hidden" value="" />
    <p>
      <input name="<?php echo $prefix; ?>[image]" id="film_<?php echo $array_id; ?>_feature_image_<?php echo $id; ?>" type="text" value="<?php echo $feature->image; ?>" class="regular-text" style="width:600px;" placeholder="Image" />
      <a class="button-secondary" id="film_<?php echo $array_id; ?>_feature_image_button_<?php echo $id; ?>" title="Media Image Library">Media Image Library</a>
    </p>

    <p>
     <input name="<?php echo $prefix; ?>[title]" type="text" value="<?php echo $feature->title; ?>" class="large-text" placeholder="Title" />
    </p>

    <p>
     <input name="<?php echo $prefix; ?>[subtitle]" type="text" value="<?php echo $feature->subtitle; ?>" class="large-text" placeholder="Sub-title" />
    </p>

    <p>
     <input name="<?php echo $prefix; ?>[runtime]" type="text" value="<?php echo $feature->runtime; ?>" class="large-text" placeholder="Runtime" />
    </p>

    <p>
      <a id="film_<?php echo $array_id; ?>_delete_feature_<?php echo $id; ?>" class="button button-small">Delete Special Feature</a>
    </p>

    <hr style="border: none; border-bottom: 1px dotted #dfdfdf; margin: 24px 0 20px 0;" />
</div>
