<div class='pwyw-stats'>
    <div class='pwyw-stats-wrap'>
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
        
        <div class='pwyw-stats-title-section'>
            <h3>Top Contributors</h3>
            <p>
                These heroes have really gone to<br/>
                bat for indie filmmakers everywhere.<br/>
                Isn't it your turn to be on the list?
            </p>
        </div>
    </div>
</div>

<div class='pwyw-checkout'>
    <h2>Purchase the Bundle</h2>
    <p>Complete the purchase below and these amazing films are all yours!</p>

    <ol>
        <li>
            Choose how much the bundle is worth to you.
        </li>
        <li>
            Where would you like your contribution to go?
        </li>
        <li>
            Checkout and claim your films!
        </li>
    </ol>
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
        
        <div class="inner">
            <div class="titlebox">
                <h1>Bundle 1</h1>
                <h3>Discover Indie Films, Support Filmmakers, Help Charities.</h3>
                <h3 class="line2">Pay what you want to get all the films below.</h3>    
                <p id="scroll" class="btn btn-info homebutton btn-large">Purchase</p>   
            </div>
        </div>
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
            <div class="statsbox">

                <div class="statsmiddle">
                    <h3>Top Contributors:</h3>
<!--                    <ul>-->
                        <?php
                            $j = 1;
                            if(isset($pwyw_data['top'])&&!empty($pwyw_data['top'])): ?>
                                <table>
                               <?php foreach($pwyw_data['top'] as $user):?>
                                    <tr><td><?php echo $j?>. <?php echo $user->display_name ?> </td><td> <span class="top_price">$<?php echo $user->amount?></span></td></tr>
                            <?php $j++;
                                 endforeach; ?>
                                   </table> 
                            <?php endif;
                             ?>
<!--                    </ul>-->
                </div>
            </div>
  
            <h2>Purchase</h2>
            <div class="step1">
                <div class="buttonslidegroup">
                    <div class="btn-group" data-toggle="buttons-radio">
                        <button  value="<?=$pwyw_data['bundle']->suggested_val_1; ?>" class="btn btn-info">$<?=$pwyw_data['bundle']->suggested_val_1; ?></button>
                        <button  value="<?=$pwyw_data['bundle']->suggested_val_2; ?>"class="btn btn-info">$<?=$pwyw_data['bundle']->suggested_val_2; ?></button>
                        <button value="<?=$pwyw_data['bundle']->suggested_val_3; ?>"class="btn btn-info">$<?=$pwyw_data['bundle']->suggested_val_3; ?></button>
                        <button id="custom_price" value="<?=$pwyw_data['bundle']->pwyw_val; ?>"class=" btn btn-info">Custom</button>
                    </div>
                    <div class="input-prepend customshow" style="display:none;">
                    <span class="add-on">$</span><input class="span1 custompricefield currenciesOnly" onchange="checkvalue()" value="<?=$pwyw_data['bundle']->pwyw_val; ?>" type="text">
                    </div>
                </div>  
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
            <div class="step2">
                <div class="slidercontent">
                    <div class="slidertitles">
                        <ul>
                            <li>Filmmakers:</li>
                            <li>Charities:</li>
                            <li>FilmBundle:</li>
                        </ul>
                    </div>  
                    <div class="conteneur">
                        <?php foreach($pwyw_data['categories'] as $key=>$cat_obj): ?>
                            <div id="slider_<?php echo strtolower($cat_obj['info']['title']) ?>" value="<?php echo $cat_obj['info']['val'] ?>" class="linked3 selector inactive sliderhome"></div>
                        <?php endforeach;?>
                    </div>​ 
                    <div class="divedeeper input-append">
                        <ul>
                            <?php foreach($pwyw_data['categories'] as $key=>$cat_obj): ?>
                                <li id="mcat_<?php echo $key ?>" class="mcat">
                                    <input id='<?php echo strtolower($cat_obj['info']['title']) ?>_inp' name="categories[<?php echo $key ?>]" type="text" value="<?php echo $cat_obj['info']['val'] ?>" class="percent">
                                    <span class="add-on">%</span>
                                    <?php if($key !=3):?>
                                        <a class="btn btn-info btn-small" href="#<?php echo strtolower($cat_obj['info']['title']) ?>_modal" data-toggle="modal" type="button">Want more control?</a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
                <a href="#" class="btn btn-large btn-success"> Checkout </a>
            </div>
        </div>
    </div>

<!-- Slider 1 Modal -->
       <?php foreach($pwyw_data['categories'] as $key=>$cat_obj):  ?>
               <?php if($key != 3):?>
        <?php 
        $smalltitle = strtolower($cat_obj['info']['title']);
        switch($key){
              case 1:
                  $ctitle = 'Films';
              break;
              case 2:
                  $ctitle = 'Charities';
              break;
          
              } 
        ?>   
                    <div class="modal hide fade" id="<?php echo $smalltitle ?>_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h3 id="myModalLabel"><?php echo $ctitle ?></h3>
                          <p>How should we split up your payment?</p>
                      </div>
                      <div class="modal-body">      
                          <div class="slidertitles">
                              <ul>
                                  <?php foreach ($cat_obj['sub'] as $key_s => $sub): ?>
                                      <li><?= $sub['info']['title'] ?>:</li>
                                  <?php endforeach; ?>
                              </ul>
                          </div>
                          <div class="conteneur">    
                              <?php foreach ($cat_obj['sub'] as $key_s => $sub): ?>
                              <div id="slider_<?php echo $smalltitle ?>_<?= $key_s ?>" value="<?= $sub['info']['val'] ?>" class="selector <?php echo $smalltitle ?> inactive sliderhome"></div>
                              <?php endforeach; ?>      
                          </div>​

                          <div class="divedeeper input-append">
                              <ul>
                                  <?php foreach ($cat_obj['sub'] as $key_s => $sub): ?>
                                      <li class="subcat"> <input id="<?php echo $smalltitle ?>_<?= $key_s ?>_inp" name="categories[<?php echo $key_s ?>]" class="<?php echo $smalltitle ?>_percent" type="text" value="<?= $sub['info']['val'] ?>"/><span class="add-on">%</span></li>
                                  <?php endforeach; ?>
                              </ul>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn_reset">Reset</button>
                        <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Save and Close</button>
                      </div>
                  </div>
            <?php endif; ?>
       <?php endforeach;?>
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
