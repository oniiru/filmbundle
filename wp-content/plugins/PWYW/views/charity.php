<script>
jQuery(document).ready(function($) {
  $('#charity_title_<?php echo $array_id; ?>').keyup(function() {
    updateTitle(<?php echo $array_id; ?>);
  });
  updateTitle(<?php echo $array_id; ?>);

  function updateTitle(array_id) {
    var title = $('#charity_title_'+array_id).val();
    if (title == '') {
      title = '(no title set)';
    }
    $('#charity_'+array_id+' h3 span').text(title);
  }

  $('#charity_image_button_<?php echo $array_id; ?>').click(function() {
    wp.media.editor.send.attachment = function(props, attachment) {
      $('#charity_image_<?php echo $array_id; ?>').val(attachment.url);
    }
    wp.media.editor.open(this);
    return false;
  });

  $('#delete_<?php echo $array_id; ?>').click(function() {
      var id = <?php echo $array_id; ?>;
      var result = confirm("Are you sure you want to delete the charity?");
      if (result) {
        $('#charity_<?php echo $array_id; ?>').hide();
        $('[name="charities\[<?php echo $array_id; ?>\]\[deleted\]"]').val('true');
      }
  });

});
</script>

<div class="postbox" id="charity_<?php echo $array_id; ?>" style="background: #fff">
  <div class="handlediv" title="Click to toggle"><br /></div>
  <h3 class="hndle"><span>(no title set)</span></h3>
  <div class="inside">
    <input name="charities[<?php echo $array_id; ?>][id]" type="hidden" value="<?php echo $charity->id; ?>" />
    <input name="charities[<?php echo $array_id; ?>][deleted]" type="hidden" value="" />
    <p>
      <input name="charities[<?php echo $array_id; ?>][image]" id="charity_image_<?php echo $array_id; ?>" type="text" value="<?php echo $charity->image; ?>" class="regular-text" style="width:600px;" placeholder="Image" />
      <a class="button-secondary" id="charity_image_button_<?php echo $array_id; ?>" title="Media Image Library">Media Image Library</a>
    </p>

    <p>
     <input name="charities[<?php echo $array_id; ?>][title]" id="charity_title_<?php echo $array_id; ?>" type="text" value="<?php echo $charity->title; ?>" class="regular-text" style="width:738px;" placeholder="Title" />
    </p>

    <p>
     <input name="charities[<?php echo $array_id; ?>][url]" id="charity_url_<?php echo $array_id; ?>" type="text" value="<?php echo $charity->url; ?>" class="regular-text" style="width:738px;" placeholder="Url" />
    </p>

    <p>
     <textarea name="charities[<?php echo $array_id; ?>][embed]" cols="80" rows="5" class="large-text" placeholder="Video Embed"><?php echo $charity->embed; ?></textarea>
    </p>

    <p>
      <textarea name="charities[<?php echo $array_id; ?>][description]" cols="80" rows="5" class="large-text" placeholder="Description"><?php echo $charity->description; ?></textarea>
    </p>

    <p>
      <a id="delete_<?php echo $array_id; ?>" class="button button-small">Delete</a>
    </p>
  </div>
</div>
