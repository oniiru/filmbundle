<script type="text/javascript" >
  jQuery(document).ready(function($) {
    var film_data = {
        action: 'pwyw_add_film',
        array_id: <?php echo count($films); ?>
    };

    function addFilm() {
      $.post(ajaxurl, film_data, function(response) {
        film_data.array_id++;
        postboxes.add_postbox_toggles();
        $('#films').append(response);
        postboxes.add_postbox_toggles();
        $('#add_film').removeAttr('disabled');
      });
    };

    $('#add_film').click(function() {
      if ($(this).attr('disabled') == 'disabled') {
        return;
      }
      $('#add_film').attr('disabled', 'disabled');
      addFilm();
    });
  });
</script>

<h2>Films</h2>

<div id="films">
  <div class="meta-box-sortables">
    <?php
      foreach ($films as $key => $film) {
        $data = array(
          'array_id' => $key,
          'film' => $film,
          'features' => Pwyw_Films::allFeatures($film->id),
          'reviews' => Pwyw_Films::allReviews($film->id)
        );
        echo Pwyw_View::make('film', $data);
      }
    ?>
  </div>
</div>

<div style="text-align: right;">
  <?php submit_button('Save Changes', 'primary', 'submit', false); ?>
  <a class="button-secondary" id="add_film">+ Add Film</a>
</div>
