<script type="text/javascript" >
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

  // Image Insert buttons
  $('#film_image_button_<?php echo $array_id; ?>').click(function() {
    wp.media.editor.send.attachment = function(props, attachment) {
      $('#film_image_<?php echo $array_id; ?>').val(attachment.url);
    }
    wp.media.editor.open(this);
    return false;
  });
  $('#film_altimage_button_<?php echo $array_id; ?>').click(function() {
    wp.media.editor.send.attachment = function(props, attachment) {
      $('#film_altimage_<?php echo $array_id; ?>').val(attachment.url);
    }
    wp.media.editor.open(this);
    return false;
  });
  $('#filmmaker_image_button_<?php echo $array_id; ?>').click(function() {
    wp.media.editor.send.attachment = function(props, attachment) {
      $('#filmmaker_image_<?php echo $array_id; ?>').val(attachment.url);
    }
    wp.media.editor.open(this);
    return false;
  });
  $('#curator_image_button_<?php echo $array_id; ?>').click(function() {
    wp.media.editor.send.attachment = function(props, attachment) {
      $('#curator_image_<?php echo $array_id; ?>').val(attachment.url);
    }
    wp.media.editor.open(this);
    return false;
  });




  // Delete button
  $('#delete_film_<?php echo $array_id; ?>').click(function() {
      var id = <?php echo $array_id; ?>;
      var result = confirm("Are you sure you want to delete the film?");
      if (result) {
        $('#film_<?php echo $array_id; ?>').hide();
        $('[name="films\[<?php echo $array_id; ?>\]\[deleted\]"]').val('true');
      }
  });

  // ---------------------------------------------------------------------------
  // Handle Reviews
  // ---------------------------------------------------------------------------
  $('#add_review_<?php echo $array_id; ?>').click(function() {
    if ($(this).attr('disabled') == 'disabled') {
      return;
    }
    $('#add_review_<?php echo $array_id; ?>').attr('disabled', 'disabled');
    addReview();
  });

  var review_data = {
      action: 'pwyw_add_review',
      array_id: <?php echo $array_id; ?>,
      id: <?php echo count($reviews); ?>
  };

  function addReview() {
    $.post(ajaxurl, review_data, function(response) {
      review_data.id++;
      $('#film_<?php echo $array_id; ?>_reviews').append(response);
      $('#add_review_<?php echo $array_id; ?>').removeAttr('disabled');
    });
  };

  // ---------------------------------------------------------------------------
  // Handle Special Features
  // ---------------------------------------------------------------------------
  $('#add_feature_<?php echo $array_id; ?>').click(function() {
    if ($(this).attr('disabled') == 'disabled') {
      return;
    }
    $('#add_feature_<?php echo $array_id; ?>').attr('disabled', 'disabled');
    addFeature();
  });

  var feature_data = {
      action: 'pwyw_add_feature',
      array_id: <?php echo $array_id; ?>,
      id: <?php echo count($features); ?>
  };

  function addFeature() {
    $.post(ajaxurl, feature_data, function(response) {
      feature_data.id++;
      $('#film_<?php echo $array_id; ?>_features').append(response);
      $('#add_feature_<?php echo $array_id; ?>').removeAttr('disabled');
    });
  };
});
</script>

<?php
  $film->meta = unserialize($film->meta);
  $closed = ($film->meta['postboxState'] == 'closed') ? 'closed' : '';
  $postboxstate = $closed ? 'closed' : 'open';
?>
<div class="postbox <?php echo $closed; ?>" id="film_<?php echo $array_id; ?>" style="background: #fff">
  <div class="handlediv" title="Click to toggle"><br /></div>
  <h3 class="hndle"><span>(no title set)</span></h3>
  <div class="inside">
    <input name="films[<?php echo $array_id; ?>][id]" type="hidden" value="<?php echo $film->id; ?>" />
    <input name="films[<?php echo $array_id; ?>][deleted]" type="hidden" value="" />
    <input name="films[<?php echo $array_id; ?>][sort]" id="film_<?php echo $array_id; ?>_sort" type="hidden" value="<?php echo $array_id; ?>" />
    <input name="films[<?php echo $array_id; ?>][meta][postboxState]" id="film_<?php echo $array_id; ?>_postboxstate" type="hidden" value="<?php echo $postboxstate; ?>" />
    <p>
      <input name="films[<?php echo $array_id; ?>][image]" id="film_image_<?php echo $array_id; ?>" type="text" value="<?php echo $film->image; ?>" class="regular-text" style="width:600px;" placeholder="Image" />
      <a class="button-secondary" id="film_image_button_<?php echo $array_id; ?>" title="Media Image Library">Media Image Library</a>
    </p>
    <p>
      <input name="films[<?php echo $array_id; ?>][altimage]" id="film_altimage_<?php echo $array_id; ?>" type="text" value="<?php echo $film->altimage; ?>" class="regular-text" style="width:600px;" placeholder="Alt Image" />
      <a class="button-secondary" id="film_altimage_button_<?php echo $array_id; ?>" title="Media Image Library">Media Image Library</a>
    </p>
    <p>
     <input name="films[<?php echo $array_id; ?>][title]" id="film_title_<?php echo $array_id; ?>" type="text" value="<?php echo $film->title; ?>" class="regular-text" style="width:738px;" placeholder="Title" />
    </p>

    <p>
      <label for="films[<?php echo $array_id; ?>][rating]">Above/below average?</label>
      <select name="films[<?php echo $array_id; ?>][rating]" id="films[<?php echo $array_id; ?>][rating]" style="width: 200px; margin-left: 20px;">
        <option value="above" <?php selected($film->rating, 'above', true); ?>>Above</option>
        <option value="below" <?php selected($film->rating, 'below', true); ?>>Below</option>
      </select>
    </p>

    <p>
      <label for="films[<?php echo $array_id; ?>][linkedpage]">Film Page</label>
      <select name="films[<?php echo $array_id; ?>][linkedpage]" id="films[<?php echo $array_id; ?>][linkedpage]" style="width: 200px; margin-left: 20px;">
		  <option value="" <?php selected($film->linkedpage, '', true); ?>>Select a film...</option>
		  <?php  $filmposts = get_posts(
        array(
            'post_type'  => 'films',
            'numberposts' => -1
        )
    );
	foreach( $filmposts as $fp )
	    { 	$filmtitlenew = esc_html( $fp->post_title );
			$filmpermnew = get_permalink( $fp );


?>

	        <option value="<?php echo $filmpermnew; ?>" <?php selected($film->linkedpage, $filmpermnew, true); ?>><?php echo $filmtitlenew ?></option>
		  	<?php 	};
		  	?>

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
      <textarea name="films[<?php echo $array_id; ?>][filmmaker_note]" cols="80" rows="5" class="large-text" placeholder="Note from Filmmaker"><?php echo $film->filmmaker_note; ?></textarea>
    </p>
    <p>
      <input name="films[<?php echo $array_id; ?>][filmmaker_image]" id="filmmaker_image_<?php echo $array_id; ?>" type="text" value="<?php echo $film->filmmaker_image; ?>" class="regular-text" style="width:600px;" placeholder="Filmmaker Image" />
      <a class="button-secondary" id="filmmaker_image_button_<?php echo $array_id; ?>" title="Media Image Library">Media Image Library</a>
    </p>
    <p>
     <input name="films[<?php echo $array_id; ?>][filmmaker_name]" type="text" value="<?php echo $film->filmmaker_name; ?>" class="regular-text" style="width:738px;" placeholder="Filmmaker Name" />
    </p>

    <p>
      <textarea name="films[<?php echo $array_id; ?>][curator_note]" cols="80" rows="5" class="large-text" placeholder="Note from Curator"><?php echo $film->curator_note; ?></textarea>
    </p>
    <p>
      <input name="films[<?php echo $array_id; ?>][curator_image]" id="curator_image_<?php echo $array_id; ?>" type="text" value="<?php echo $film->curator_image; ?>" class="regular-text" style="width:600px;" placeholder="Curator Image" />
      <a class="button-secondary" id="curator_image_button_<?php echo $array_id; ?>" title="Media Image Library">Media Image Library</a>
    </p>
    <p>
     <input name="films[<?php echo $array_id; ?>][curator_name]" type="text" value="<?php echo $film->curator_name; ?>" class="regular-text" style="width:738px;" placeholder="Curator Name" />
    </p>

    <hr style="border: none; border-bottom: 1px dashed #dfdfdf; margin: 24px 0 20px 0; width:924px;" />
    <h2>Reviews</h2>
    <div id="film_<?php echo $array_id; ?>_reviews">
    <?php
      foreach ($reviews as $key => $review) {
        $data = array(
          'array_id' => $array_id,
          'id' => $key,
          'review' => $review
        );
        echo Pwyw_View::make('review', $data);
      }
    ?>
    </div>

    <p style="text-align: right; width:924px;">
      <a id="add_review_<?php echo $array_id; ?>" class="button">+ Add Review</a>
    </p>
    <label for="films[<?php echo $array_id; ?>][user_reviews]">
      <input name="films[<?php echo $array_id; ?>][user_reviews]" id="films[<?php echo $array_id; ?>][user_reviews]" type="checkbox" value="1" <?php checked($film->user_reviews, 1, true); ?> />
      Include User Reviews
    </label>

    <hr style="border: none; border-bottom: 1px dashed #dfdfdf; margin: 24px 0 20px 0; width:924px;" />
    <h2>Special Features</h2>
    <div id="film_<?php echo $array_id; ?>_features">
    <?php
      foreach ($features as $key => $feature) {
        $data = array(
          'array_id' => $array_id,
          'id' => $key,
          'feature' => $feature
        );
        echo Pwyw_View::make('feature', $data);
      }
    ?>
    </div>

    <p style="text-align: right; width:924px;">
      <a id="add_feature_<?php echo $array_id; ?>" class="button">+ Add Special Feature</a>
    </p>

    <hr style="border: none; border-bottom: 1px dashed #dfdfdf; margin: 24px 0 20px 0; width:924px;" />
    <p>
      <a id="delete_film_<?php echo $array_id; ?>" class="button button-small">Delete Film</a>
    </p>
  </div>
</div>
