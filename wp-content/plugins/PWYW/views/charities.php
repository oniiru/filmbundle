<h2>Charities</h2>

<div id="charities">
  <?php 
    $data = array('id' => 1);
    echo Pwyw_View::make('charity', $data);
  ?>
</div>

<script type="text/javascript" >
  jQuery(document).ready(function($) {
    var poll = {
        action: 'pwyw_add_charity',
        task: 'add'
    };

    function pollBulkStatus() {
        $.post(ajaxurl, poll, function(response) {
            // response = JSON.parse(response);
            console.log(response);
        $('#add_charity').removeAttr('disabled');

        });
    };

    $('#add_charity').click(function() {
        if ($(this).attr('disabled') == 'disabled') {
            // The process is already running
            return;
        }

      $('#add_charity').attr('disabled', 'disabled');

      console.log('click');
      pollBulkStatus();
    });
  });
</script>

<div style="text-align: right;">
<?php submit_button('Save Changes', 'primary', 'submit', false); ?> 
<a class="button-secondary" id="add_charity">+ Add Charity</a>
</div>
