<script type="text/javascript" >
  jQuery(document).ready(function($) {
    var charity_data = {
        action: 'pwyw_add_charity',
        array_id: <?php echo count($charities); ?> 
    };

    function addCharity() {
      $.post(ajaxurl, charity_data, function(response) {
        charity_data.array_id++;
        postboxes.add_postbox_toggles();
        $('#charities').append(response);
        postboxes.add_postbox_toggles();
        $('#add_charity').removeAttr('disabled');
      });
    };

    $('#add_charity').click(function() {
      if ($(this).attr('disabled') == 'disabled') {
        return;
      }
      $('#add_charity').attr('disabled', 'disabled');
      addCharity();
    });
  });
</script>

<h2>Charities</h2>

<div id="charities">
  <?php
    foreach ($charities as $key => $charity) {
      $data = array('array_id' => $key, 'charity' => $charity);
      echo Pwyw_View::make('charity', $data);
    }
  ?>
</div>

<div style="text-align: right;">
  <?php submit_button('Save Changes', 'primary', 'submit', false); ?> 
  <a class="button-secondary" id="add_charity">+ Add Charity</a>
</div>
