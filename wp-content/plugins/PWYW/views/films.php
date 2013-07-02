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
  <?php
    // foreach ($charities as $key => $charity) {
    //   $data = array('array_id' => $key, 'charity' => $charity);
    //   echo Pwyw_View::make('charity', $data);
    // }
  ?>
</div>

<div style="text-align: right;">
  <?php submit_button('Save Changes', 'primary', 'submit', false); ?> 
  <a class="button-secondary" id="add_film">+ Add Film</a>
</div>
