<h2>Charities</h2>

<div id="charities">
  <?php 
    $data = array('id' => 1);
    echo Pwyw_View::make('charity', $data);
  ?>
</div>

<div style="text-align: right;">
<?php submit_button('Save Changes', 'primary', 'submit', false); ?> 
<a class="button-secondary" id="">+ Add Charity</a>
</div>
