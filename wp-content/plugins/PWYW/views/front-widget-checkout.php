<div class='pwyw-stats'>
    <div class='pwyw-stats-wrap'>

        <!-- ===================================================================
        || Display of generic statistics
        ==================================================================== -->
        <div class='pwyw-stats-section'>
            <div class='pwyw-stats-title-section'>
                <h3>The Stats</h3>
            </div>
        </div><div class='pwyw-stats-section'>
            <span class='value'><?php echo $totalSales; ?></span>
            Number of Purchases
        </div><div class='pwyw-stats-section center'>
            <span class='value'><?php echo $averagePrice; ?></span>
            Average Purchase
        </div><div class='pwyw-stats-section right'>
            <span class='value'><?php echo $totalPayments; ?></span>
            Total Payments
        </div>

        <hr />
        
        <!-- ===================================================================
        || List of Top Contributors
        ==================================================================== -->
        <?php
        // Prepare
        $contributors = array();
        foreach ($bundle['top'] as $contributor) {
            if ($contributor->amount == '-') {
                $contributors[] = "<li>{$contributor->display_name}</li>";
            } else {
                $contributors[] = "<li>{$contributor->display_name} <span class='pull-right'>\${$contributor->amount}</span></li>";
            }
        }
        ?>
        <div class='pwyw-contributor-section'>
            <div class='pwyw-stats-title-section'>
                <h3>Top Contributors</h3>
                <p>
                    These heroes have really gone to<br/>
                    bat for indie filmmakers everywhere.<br/>
                    Isn't it your turn to be on the list?
                </p>
            </div>
        </div>
        <div class='pwyw-contributor-section'>
            <ol class='contributor-left'>
                <?php
                for ($i = 0; $i < 5; $i++) {
                    echo $contributors[$i];
                }
                ?>
            </ol>
        </div>
        <div class='pwyw-contributor-section'>
            <ol start='6' class='contributor-right'>
                <?php
                for ($i = 5; $i < 10; $i++) {
                    echo $contributors[$i];
                }
                ?>
            </ol>
        </div>

    </div>
</div>


<!-- ===========================================================================
|| Checkout section
============================================================================ -->
<div class='pwyw-checkout'>
    <h2>Purchase the Bundle</h2>
    <p>Complete the purchase below and these amazing films are all yours!</p>

    <ol>
        <li>
            <p>Choose how much the bundle is worth to you.</p>
            <p>
                <script type='text/javascript'>
                    var bundle_checkout_amount = 100;

                </script>
                <div class="pwyw-amount btn-group" data-toggle="buttons-radio">
                    <button  value="<?=$bundle['bundle']->suggested_val_1; ?>" class="btn btn-info active">$<?=$bundle['bundle']->suggested_val_1; ?></button>
                    <button  value="<?=$bundle['bundle']->suggested_val_2; ?>" class="btn btn-info">$<?=$bundle['bundle']->suggested_val_2; ?></button>
                    <button value="<?=$bundle['bundle']->suggested_val_3; ?>" class="btn btn-info">$<?=$bundle['bundle']->suggested_val_3; ?></button>
                    <button id="custom_price" value="<?=$bundle['bundle']->pwyw_val; ?>" class=" btn btn-info">Custom</button>
                </div>

                <div class="input-prepend customshow">
                    <span class="add-on">$</span>
                    <input class="custompricefield currenciesOnly" 
                           value="<?=$bundle['bundle']->pwyw_val; ?>" 
                           type="text"
                    />
                </div>
            </p>
        </li>

        <li>
            <p>Where would you like your contribution to go?</p>

            <?php foreach($bundle['categories'] as $key => $cat_obj) {
                $title = $cat_obj['info']['title'];
                if ($title == 'Bundle') {
                    $title = 'FilmBundle';
                }
                $titleLow = strtolower($title);
            ?>
                <div class='pwyw-checkout-slider clearfix'>
                    <div class='pwyw-slider-title'><?php echo $title; ?></div>

                    <div id="slider_<?php echo strtolower($cat_obj['info']['title']) ?>" value="<?php echo $cat_obj['info']['val'] ?>" class="linked3 selector inactive"></div>

                    <div class="input-prepend">
                        <span class="add-on">$</span>
                        <input id='<?php echo strtolower($cat_obj['info']['title']) ?>_inp' name="categories[<?php echo $key ?>]" type="text" value="<?php echo $cat_obj['info']['val'] ?>" class="percent">
                    </div>

                    <?php if ($key !=3) {
                        $type = ($key == 1) ? 'films' : 'charities';
                        $tooltip = "Allocate your contribution<br/>to specific {$type}.";
                    ?>
                        <a
                            data-id='#dive-<?php echo $titleLow; ?>'
                            class="btn btn-info dive-deeper"
                            type="button"
                            data-toggle="tooltip"
                            data-title="<?php echo $tooltip; ?>"
                        >Dive Deeper!</a>
                    <?php } ?>
                </div>

                <?php /** Handle the sub categories */ ?>
                <div id='dive-<?php echo $titleLow;?>' class='clearfix'>
                    <?php
                    if($key != 3) {
                        $smalltitle = strtolower($cat_obj['info']['title']);
                        foreach ($cat_obj['sub'] as $key_s => $sub) { ?>
                            <div class='pwyw-checkout-slider pwyw-checkout-sub-slider clearfix'>
                                <div class='pwyw-slider-title'><?php echo $sub['info']['title']; ?></div>

                                <div
                                    id="slider_<?php echo $smalltitle ?>_<?= $key_s ?>"
                                    value="<?= $sub['info']['val'] ?>"
                                    class="selector sub_<?php echo $smalltitle ?> inactive"></div>

                                <div class="input-prepend">
                                    <span class="add-on">$</span>
                                    <input 
                                        id="<?php echo $smalltitle ?>_<?= $key_s ?>_inp"
                                        name="categories[<?php echo $key_s ?>]" 
                                        class="<?php echo $smalltitle ?>_percent" 
                                        type="text" 
                                        value="<?= $sub['info']['val'] ?>"
                                    />
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>

            <?php } ?>
        </li>

        <li>
            Checkout and claim your films!
        </li>
    </ol>
</div>







            <div class="alertboxes">
                <div class="lowpaymentwarning alert alert-error" style="display:none">Pay only <b id="difference"></b> more to unlock the bonus films. Come on, help some starving filmmakers out. ;)
                </div>
                <div class="leaderboardinput alert alert-success" style="display:none"><b>You Rock!</b> This amount makes you one of the top contributors. Enter your   
                     <span class="add-on">@</span><input class="span2" id="PrependedInput" placeholder="twitterhandle" type="text"> or any <input  class="span2" placeholder="username" type="text"> to be added on our top contributor board.
                </div>
                <div class="nozero alert alert-error" style="display:none">We're all about paying what you want, but we've got to draw the line somewhere. Please pay at least $0.01. :)
                </div>
            </div> 



<?php
$pwyw = Pwyw::getInstance();
$pwyw_data = $pwyw->pwyw_get_bundle_info();
$nonce = wp_create_nonce('pwyw_bundle_checkout');
$nonce2 = wp_create_nonce('pwyw_ajax');
?>

<script type='text/javascript'>
jQuery(document).ready(function($) {
    var pwyw_data = {};
    var main_cat = [];
    var alias; 
    var user_alias,twitter_alias; 

    pwyw_data = <?php echo json_encode($pwyw_data); ?>;
    //console.log(pwyw_data);

    var min_amount,avg_price;
    
    if (pwyw_data.payment_info == null) {
       min_amount = 0;
    } else {
       min_amount = parseFloat(pwyw_data.min_amount);
    }

    if(pwyw_data.payment_info == null){
        avg_price = 0;
    }else{
        avg_price =  parseFloat(pwyw_data.payment_info.avg_price);
    }

    $('.btn-success').click(function(){
        user_alias = $('input[placeholder="username"]').val();
        twit_alias = $('input[placeholder="twitterhandle"]').val();

        var is_twitter = 0;
        
        if(twit_alias!=''){
            alias = twit_alias;
            is_twitter = 1
        }else if(user_alias!=''){
            alias = user_alias;
        }
        
        
        $('input[name="alias"]').val(alias);
        $('input[name="is_twitter"]').val(is_twitter);

          var btn = $('.buttonslidegroup').find('button.active');
          if(!btn.length||$(btn).attr('id') == 'custom_price'){
              c_price = $('input.custompricefield').val();
          }else{
             c_price = $(btn).val(); 
          }

          $('input[name="c_price"]').val(c_price);

          if(c_price >= 0.01){
              check = true;
          }
            
          $('#bundle_checkout').submit();
          return false;  
    });
});
</script>

<div class="container">
    <div class="bodyhome">
        <form id="bundle_checkout" method="POST" action="<?php echo $pwyw->plugin_url ?>bundle_checkout.php">
                    <input type="hidden" name="c_price" value=""/>
                    <input type="hidden" name="alias" value=""/>
                    <input type="hidden" name="action" value="checkout"/>
                    <input type="hidden" name="is_twitter" value=""/>
                    <input type="hidden" name="_ajax_nonce" value="<?php echo $nonce ?>"/>
                    <input type="hidden" name="bid" value="<?php echo $pwyw_data['bundle']->id?>"/>

        <div class="content1">
        
            <div class="shelf2">
                <p class="averageprice">Pay more than the average of <span>$<?php echo !empty($pwyw_data['payment_info'])&&$pwyw_data['payment_info']->avg_price>0?number_format($pwyw_data['payment_info']->avg_price,2):'0.00' ?></span> to get these great films too!</p>
            </div>
        </div>

        <div class="content2">

  
            <div class="step2">
                <a href="#" class="btn btn-large btn-success"> Checkout </a>
            </div>
        </div>
    </div>

</form>

































































<h1>Checkout out widget</h1>

<h2>Pubnub test</h2>
<script src='http://cdn.pubnub.com/pubnub-3.5.3.min.js'></script>
<script type="text/javascript" >
jQuery(document).ready(function($) {
    var pubnub = $.PUBNUB.init({
        subscribe_key : 'sub-c-ef114922-f1ea-11e2-b383-02ee2ddab7fe'
    });

    pubnub.subscribe({
        channel : 'filmbundle',
        message : function(m){
            console.log(m);
            $('#pubnub-server').text(m.server);
            $('#pubnub-time').text(m.server_time);
        }
    });
});
</script>

<p>Latest pubnub update<br/>
<em>(refresh any page in admin, for a new pubhub to be pushed)</em><br/>
From server: <span id='pubnub-server'></span><br/>
At server time: <span id='pubnub-time'></span><br/>
</p>

<p>
<?php
echo do_shortcode(
'[purchase_link id="306" text="Purchase" style="button" color="blue"]');
?>


</p>
