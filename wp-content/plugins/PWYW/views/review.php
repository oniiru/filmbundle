<?php
// Set the input name prefix
$prefix = "films[{$array_id}][reviews][$id]"
?>

<script type="text/javascript" >
jQuery(document).ready(function($) {

  $('#film_<?php echo $array_id; ?>_review_image_button_<?php echo $id; ?>').click(function() {
    wp.media.editor.send.attachment = function(props, attachment) {
      $('#film_<?php echo $array_id; ?>_review_image_<?php echo $id; ?>').val(attachment.url);
    }
    wp.media.editor.open(this);
    return false;
  });

  $('#film_<?php echo $array_id; ?>_delete_review_<?php echo $id; ?>').click(function() {
      var id = <?php echo $array_id; ?>;
      var result = confirm("Are you sure you want to delete the review?");
      if (result) {
        $('#film_<?php echo $array_id; ?>_review_<?php echo $id; ?>').hide();
        $('[name="films\[<?php echo $array_id; ?>\]\[reviews\]\[<?php echo $id; ?>\]\[deleted\]"]').val('true');
      }
  });

});
</script>

<div id="film_<?php echo $array_id; ?>_review_<?php echo $id; ?>">
    <input name="<?php echo $prefix; ?>[id]" type="hidden" value="<?php echo $review->id; ?>" />
    <input name="<?php echo $prefix; ?>[deleted]" type="hidden" value="" />


    <p>
      <textarea name="<?php echo $prefix; ?>[review]" cols="80" rows="5" class="large-text" placeholder="Review"><?php echo $review->review; ?></textarea>
    </p>

    <p>
     <input name="<?php echo $prefix; ?>[author]" type="text" value="<?php echo $review->author; ?>" style="width:459px;" class="regular-text" placeholder="Author" />
     <input name="<?php echo $prefix; ?>[publication]" type="text" value="<?php echo $review->publication; ?>" style="width:459px;" class="regular-text" placeholder="Publication" />
    </p>


    <p>
      <input name="<?php echo $prefix; ?>[image]" id="film_<?php echo $array_id; ?>_review_image_<?php echo $id; ?>" type="text" value="<?php echo $review->image; ?>" class="regular-text" style="width:600px;" placeholder="Image" />
      <a class="button-secondary" id="film_<?php echo $array_id; ?>_review_image_button_<?php echo $id; ?>" title="Media Image Library">Media Image Library</a>
    </p>

    <p>
     <input name="<?php echo $prefix; ?>[link]" type="text" value="<?php echo $review->link; ?>" class="large-text" placeholder="Link" />
    </p>

    <p>
      <a id="film_<?php echo $array_id; ?>_delete_review_<?php echo $id; ?>" class="button button-small">Delete Review</a>
    </p>

    <hr style="border: none; border-bottom: 1px dotted #dfdfdf; margin: 24px 0 20px 0;" />
</div>
