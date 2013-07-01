<div class="metabox-holder">
  <div class="meta-box-sortables">
    <div class="postbox" id="charity_<?php echo $array_id; ?>" style="background: #fff">
      <div class="handlediv" title="Click to toggle"><br /></div>
      <h3 class="hndle"><span>(no title set)</span></h3>
      <div class="inside">
          <script>
          jQuery(document).ready(function($) {
            $('#charity_title_<?php echo $array_id; ?>').keyup(function() {
              var title = $('#charity_title_<?php echo $array_id; ?>').val();
              if (title == '') {
                title = '(no title set)';
              }
              $('#charity_<?php echo $array_id; ?> h3 span').text(title);
            });
            $('#charity_image_button_<?php echo $array_id; ?>').click(function() {
              wp.media.editor.send.attachment = function(props, attachment) {
                $('#charity_image_<?php echo $id; ?>').val(attachment.url);
              }
              wp.media.editor.open(this);
              return false;
            });
          });
          </script>
        <p>
          <input name="charities[<?php echo $array_id; ?>][id]" type="hidden" value="<?php echo $id; ?>" />
          <input name="charities[<?php echo $array_id; ?>][image]" id="charity_image_<?php echo $array_id; ?>" type="text" value="" class="regular-text" style="width:600px;" placeholder="Image" />
          <a class="button-secondary" id="charity_image_button_<?php echo $array_id; ?>" title="Media Image Library">Media Image Library</a>
        </p>
        <p>
         <input name="charities[<?php echo $array_id; ?>][title]" id="charity_title_<?php echo $array_id; ?>" type="text" value="" class="regular-text" style="width:738px;" placeholder="Title" />
        </p>
        <p>
         <textarea name="charities[<?php echo $array_id; ?>][embed]" cols="80" rows="5" class="large-text" placeholder="Video Embed"></textarea>
        </p>
        <p>
          <textarea name="charities[<?php echo $array_id; ?>][description]" cols="80" rows="5" class="large-text" placeholder="Description"></textarea>
        </p>
      </div>
    </div>
  </div>
</div>