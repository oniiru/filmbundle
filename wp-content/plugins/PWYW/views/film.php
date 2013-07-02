<script>
jQuery(document).ready(function($) {
  $('#film_title_<?php echo $array_id; ?>').keyup(function() {
    updateTitle(<?php echo $array_id; ?>);
  });
  updateTitle(<?php echo $array_id; ?>);

  function updateTitle(array_id) {
    var title = $('#film_title_'+array_id).val();
    if (title == '') {
      title = '(no title set)';
    }
    $('#film_'+array_id+' h3 span').text(title);
  }

  $('#film_image_button_<?php echo $array_id; ?>').click(function() {
    wp.media.editor.send.attachment = function(props, attachment) {
      $('#film_image_<?php echo $array_id; ?>').val(attachment.url);
    }
    wp.media.editor.open(this);
    return false;
  });

  $('#delete_film_<?php echo $array_id; ?>').click(function() {
      var id = <?php echo $array_id; ?>;
      var result = confirm("Are you sure you want to delete the film?");
      if (result) {
        $('#film_<?php echo $array_id; ?>').hide();
        $('[name="films\[<?php echo $array_id; ?>\]\[deleted\]"]').val('true');
      }
  });
});
</script>

<div class="postbox" id="film_<?php echo $array_id; ?>" style="background: #fff">
  <div class="handlediv" title="Click to toggle"><br /></div>
  <h3 class="hndle"><span>(no title set)</span></h3>
  <div class="inside">
    <input name="films[<?php echo $array_id; ?>][id]" type="hidden" value="<?php echo $film->id; ?>" />
    <input name="films[<?php echo $array_id; ?>][deleted]" type="hidden" value="" />
    <p>
      <input name="films[<?php echo $array_id; ?>][image]" id="film_image_<?php echo $array_id; ?>" type="text" value="<?php echo $film->image; ?>" class="regular-text" style="width:600px;" placeholder="Image" />
      <a class="button-secondary" id="film_image_button_<?php echo $array_id; ?>" title="Media Image Library">Media Image Library</a>
    </p>
    <p>
     <input name="films[<?php echo $array_id; ?>][title]" id="film_title_<?php echo $array_id; ?>" type="text" value="<?php echo $film->title; ?>" class="regular-text" style="width:738px;" placeholder="Title" />
    </p>

    <p>
      <label for="films[<?php echo $array_id; ?>][rating]">Above/below average?</label>
      <select name="films[<?php echo $array_id; ?>][rating]" id="films[<?php echo $array_id; ?>][rating]" style="width: 200px; margin-left: 20px;">
        <option value="above">Above</option>
        <option value="below">Below</option>
      </select>
    </p>

    <hr style="border: none; border-bottom: 1px dashed #dfdfdf; margin: 24px 0 20px 0;" />
    <h2>Overview</h2>

    <p>
     <textarea name="films[<?php echo $array_id; ?>][embed]" cols="80" rows="5" class="large-text" placeholder="Embed Code"><?php echo $film->embed; ?></textarea>
    </p>
    <p>
     <input name="films[<?php echo $array_id; ?>][logline]" type="text" value="<?php echo $film->logline; ?>" class="large-text" placeholder="Logline" />
    </p>
    <p>
     <input name="films[<?php echo $array_id; ?>][genre]" type="text" value="<?php echo $film->genre; ?>" style="width:459px;" class="regular-text" placeholder="Genre" />
     <input name="films[<?php echo $array_id; ?>][runtime]" type="text" value="<?php echo $film->runtime; ?>" style="width:459px;" class="regular-text" placeholder="Runtime" />
    </p>

    <p>
     <input name="films[<?php echo $array_id; ?>][director]" type="text" value="<?php echo $film->director; ?>" class="large-text" placeholder="Director" />
    </p>
    <p>
     <input name="films[<?php echo $array_id; ?>][writers]" type="text" value="<?php echo $film->writers; ?>" class="large-text" placeholder="Writer(s)" />
    </p>
    <p>
     <input name="films[<?php echo $array_id; ?>][stars]" type="text" value="<?php echo $film->stars; ?>" class="large-text" placeholder="Star(s)" />
    </p>

    <p>
     <input name="films[<?php echo $array_id; ?>][website]" type="text" value="<?php echo $film->website; ?>" class="large-text" placeholder="Website" />
    </p>

    <p>
      <textarea name="films[<?php echo $array_id; ?>][note]" cols="80" rows="5" class="large-text" placeholder="Note from Filmmaker"><?php echo $film->note; ?></textarea>
    </p>

    <hr style="border: none; border-bottom: 1px dashed #dfdfdf; margin: 24px 0 20px 0; width:924px;" />
    <h2>Reviews</h2>
    <p style="text-align: right; width:924px;">
      <a id="add_review_<?php echo $array_id; ?>" class="button">+ Add Review</a>
    </p>

  <label for="films[<?php echo $array_id; ?>][user_reviews]">
    <input name="films[<?php echo $array_id; ?>][user_reviews]" id="films[<?php echo $array_id; ?>][user_reviews]" type="checkbox" value="1" />
    Include User Reviews
  </label>



    <hr style="border: none; border-bottom: 1px dashed #dfdfdf; margin: 24px 0 20px 0; width:924px;" />
    <h2>Special Features</h2>
    <p style="text-align: right; width:924px;">
      <a id="add_feature_<?php echo $array_id; ?>" class="button">+ Add Special Feature</a>
    </p>

    <hr style="border: none; border-bottom: 1px dashed #dfdfdf; margin: 24px 0 20px 0; width:924px;" />
    <p>
      <a id="delete_film_<?php echo $array_id; ?>" class="button button-small">Delete Film</a>
    </p>
  </div>
</div>
