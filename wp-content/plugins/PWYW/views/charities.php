<h2>Charities</h2>
<div class="metabox-holder">
  <div class="meta-box-sortables">
    <div class="postbox" id="third" style="background: #fff">
      <div class="handlediv" title="Click to toggle"><br /></div>
      <h3 class="hndle"><span>(no title set)</span></h3>
      <div class="inside">
        <p>
          <script>

          jQuery(document).ready(function($) {
            $('#title').keyup(function() {
              var title = $('#title').val();
              if (title == '') {
                title = '(no title set)';
              }
              $('#third h3 span').text(title);
            });
            $('#charity_image_button').click(function() {
              wp.media.editor.send.attachment = function(props, attachment) {
                $('#charity_image').val(attachment.url);
              }
              wp.media.editor.open(this);
              return false;
            });
          });

          </script>
          <input name="charities[0][id]" type="hidden" value="" />
          <input name="charities[0][image]" id="charity_image" type="text" value="" class="regular-text" style="width:600px;" placeholder="Image" />
          <a class="button-secondary" id="charity_image_button" title="Media Image Library">Media Image Library</a>
        </p>
        <p>
         <input name="charities[0][title]" id="title" type="text" value="" class="regular-text" style="width:738px;" placeholder="Title" />
        </p>
        <p>
         <textarea name="charities[0][embed]" id="" cols="80" rows="5" class="large-text" placeholder="Video Embed"></textarea>
        </p>
        <p>
          <textarea name="charities[0][description]" id="" cols="80" rows="5" class="large-text" placeholder="Description"></textarea>
        </p>
      </div>
    </div>
  </div>
</div>

<div style="text-align: right;">
<?php submit_button('Save Changes', 'primary', 'submit', false); ?> 
<a class="button-secondary" id="">+ Add Charity</a>
</div>
