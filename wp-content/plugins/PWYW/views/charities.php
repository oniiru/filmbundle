<script type="text/javascript" >
  jQuery(document).ready(function($) {
    var charity_data = {
        action: 'pwyw_add_charity',
        array_id: 1
    };

    function addCharity() {
      $.post(ajaxurl, charity_data, function(response) {
        charity_data.array_id++;
        $('#charities').append(response);
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
    $data = array('array_id' => 0);
    echo Pwyw_View::make('charity', $data);
  ?>
</div>

<div style="text-align: right;">
  <?php submit_button('Save Changes', 'primary', 'submit', false); ?> 
  <a class="button-secondary" id="add_charity">+ Add Charity</a>
</div>
