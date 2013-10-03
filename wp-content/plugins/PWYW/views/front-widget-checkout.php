<script type='text/javascript'>
    /** Global variables */
    var bundle = <?php echo json_encode($bundle); ?>;
    var min_amount;
    var avg_price;
    var edd_above_average = <?php echo $bundle['bundle']->aboveaverage; ?>;
    var edd_below_average = <?php echo $bundle['bundle']->belowaverage; ?>;

    if (bundle.payment_info == null) {
       min_amount = 0;
    } else {
       min_amount = parseFloat(bundle.min_amount);
    }

    if (bundle.payment_info == null) {
        avg_price = 0;
    } else {
        avg_price =  parseFloat(bundle.payment_info.avg_price);
    }
</script>
<div id='pwyw-checkout-widget' class='pwyw-stats'>
    <div class='pwyw-stats-wrap'>
	
        <!-- ===================================================================
        || List of Top Contributors
        ==================================================================== -->
        <?php
        // Prepare
        $contributors = array();
        foreach ($bundle['top'] as $contributor) {
            $contributors[] = "
            <li>
                {$contributor->display_name}
                <span class='pull-right'>\${$contributor->amount}</span>
            </li>";
        }
        ?>
        <div class='pwyw-contributor-section contleft'>
            <div class='pwyw-stats-title-section'>
                <h3>Top Contributors</h3>
                <p>	
                    These heroes have really gone to<br/>
                    bat for indie filmmakers everywhere.<br/>
                    Isn&#39;t it your turn to be on the list?
                </p>
            </div>
           </div>
           <div class='pwyw-contributor-section contright'>
		   
            <ol class='contributor-left'>
                <?php
                for ($i = 0; $i < 5; $i++) {
                    echo $contributors[$i];
                }
                ?>
            </ol>
                 <ol start='6' class='contributor-right'>
                <?php
                for ($i = 5; $i < 10; $i++) {
                    echo $contributors[$i];
                }
                ?>
            </ol>
        </div>
  <hr />
        <!-- ===================================================================
        || Display of generic statistics
        ==================================================================== -->
       <div class='pwyw-stats-section pwyw-statsleft'>
            <span id='pwyw-total-sales' class='value'><?php echo $totalSales; ?></span>
         <p class='inthecorner'>   Purchases </p>
        </div><div class='pwyw-stats-section center pwyw-statsmiddle'>
            <span id='pwyw-average-price' class='value'><?php echo $averagePrice; ?></span>
           <p class='inthecorner'> Average</p>
        </div><div class='pwyw-stats-section right pwyw-statsright'>
            <span id='pwyw-total-payments' class='value'><?php echo $totalPayments; ?></span>
           <p class='inthecorner'> Total Raised</p>
        </div>

      

   
    </div>
	<div class="stats-footer">
	<div class="statsfootertriangle"></div>
	<p>Beat the average of <span><?php echo $averagePrice; ?></span> to unlock the special features and bonus films!</p>
	</div>
	
</div>


<!-- ===========================================================================
|| Checkout section
============================================================================ -->
<div class='pwyw-checkout'>
    <h2>Checkout</h2>


    <!-- =======================================================================
    || Handle checkout errors
    ======================================================================== -->
    <?php if (isset($_POST['pwyw-checkout-error'])) { ?>
        <div id="pwyw-checkout-error" class="alert alert-error">
            <strong>Checkout Error!</strong><br/>
            <?php echo $_POST['pwyw-checkout-error']; ?>
        </div>
    <?php } ?>

    <form id='bundle-checkout-form' method='post' action=''>
    <ol>
	<div id="amountbuttons">
	
        <!-- ===================================================================
        || Amount buttons
        ==================================================================== -->
        <li>
            <p class="thesteps">Step 1. Choose how much the bundle is worth to you.</p>
                <div class="pwyw-amount btn-group" data-toggle="buttons-radio">
                    <button type="button" value="<?=$bundle['bundle']->suggested_val_1; ?>" class="btn">$<?=$bundle['bundle']->suggested_val_1; ?></button>
                    <button type="button" value="<?=$bundle['bundle']->suggested_val_2; ?>" class="btn">$<?=$bundle['bundle']->suggested_val_2; ?></button>
                    <button type="button" value="<?=$bundle['bundle']->suggested_val_3; ?>" class="btn">$<?=$bundle['bundle']->suggested_val_3; ?></button>
                    <button type="button" id="custom_price" value="<?=$bundle['bundle']->pwyw_val; ?>" class=" btn">Custom</button>
                </div>

                <div class="input-prepend customshow">
                    <span class="add-on">$</span>
                    <input class="custompricefield numeric-only"
                           value="<?=$bundle['bundle']->pwyw_val; ?>"
                           type="text"
                    />
                </div>
</div>
            <div class="alertboxes">
                <div class="lowpaymentwarning alert alert-error" style="display:none">
                    Pay only $<b id="difference"></b> more to unlock the bonus films. Come on, help some starving filmmakers out. ;)
                </div>

                <div class="leaderboardinput alert alert-success" style="display:none">
                    <b>You Rock!</b> This amount makes you a top contributor. Enter your
                    <div class="input-prepend">
                        <span class="add-on">@</span>
                        <input name="twitterhandle" placeholder="twitterhandle" type="text" style="width: 200px;">
                    </div>
                    <br/>or any
                    <input name="username" placeholder="username" type="text" style="width: 200px; margin: 0px 10px;">
                    to be added on our top contributor board.
                </div>

                <div class="nozero alert alert-error" style="display:none">
                    We&#39;re all about paying what you want, but we&#39;ve got to draw the line somewhere. <br>Please pay at least $0.01. :)
                </div>

                <div class="no-amount alert alert-error" style="display:none">
                    Please choose what you want to pay for the bundle first :)
                </div>
            </div>
        </li>
<div id="slidersandcheckout">

        <!-- ===================================================================
        || Sliders
        ==================================================================== -->
        <li>
            <p class="thesteps">Step 2. Where would you like your contribution to go?</p>

            <?php foreach($bundle['categories'] as $key => $cat_obj) {
                $title = $cat_obj['info']['title'];
                if ($title == 'Bundle') {
                    $title = 'FilmBundle';
                }
                $titleLow = strtolower($title);
            ?>
                <div class='pwyw-checkout-slider clearfix  <?php if ($key ==3) {
					echo 'thirdslider';
				};
                    ?>'>
                    <div class='pwyw-slider-title'><?php echo $title; ?></div>

                    <div id="slider_<?php echo strtolower($cat_obj['info']['title']) ?>" value="<?php echo $cat_obj['info']['val'] ?>" class="linked3 selector inactive"></div>

                    <div class="input-prepend">
                        <span class="add-on">$</span>
                        <input id='<?php echo strtolower($cat_obj['info']['title']) ?>_amount' name="categoriesAmount[<?php echo $key ?>]" type="text" value="" class="amount numeric-only">
                        <input id='<?php echo strtolower($cat_obj['info']['title']) ?>_inp' name="categories[<?php echo $key ?>]" type="hidden" value="<?php echo $cat_obj['info']['val'] ?>" class="percent" tabindex="-1">
                    </div>

                    <?php if ($key !=3) {
                        $type = ($key == 1) ? 'films' : 'charities';
                        $tooltip = "Allocate your contribution<br/>to specific {$type}.";
                    ?>
                        <a
                            data-id='#dive-<?php echo $titleLow; ?>'
                            class="dive-deeper"
                            type="button"
                            data-toggle="tooltip"
                            data-title="<?php echo $tooltip; ?>"
                        >Dive Deeper!</a>
                    <?php }?>
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
                                        id="<?php echo $smalltitle ?>_<?= $key_s ?>_amount"
                                        name="categoriesAmount[<?php echo $key_s ?>]"
                                        class="<?php echo $smalltitle ?>_amount numeric-only"
                                        type="text"
                                        value=""
                                    />
                                    <input
                                        id="<?php echo $smalltitle ?>_<?= $key_s ?>_inp"
                                        name="categories[<?php echo $key_s ?>]"
                                        class="<?php echo $smalltitle ?>_percent"
                                        type="hidden"
                                        value="<?= $sub['info']['val'] ?>"
                                        tabindex="-1"
                                    />
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>

            <?php } ?>
        </li>

        <!-- ===================================================================
        || Create account
        ==================================================================== -->
        <?php if (!is_user_logged_in()) { ?>
        <li id='pwyw-create-account'>
            <p class="thesteps">Step 3. Create your account</p>
            <p>
                <input name='email' type='text' placeholder='Email'
                    style='width: 300px; margin: 0 20px 0 0;' />
                <input name='password' type='password' placeholder='Password'
                    style='width: 300px; margin: 0;' />
            </p>
        </li>
        <?php } ?>


        <!-- ===================================================================
        || Checkout Button
        ==================================================================== -->

        <li class="nocount">
            <!-- <p>
                Checkout and claim your films!
            </p> -->

            <div style="display:none" class='pwyw-select-payment pwyw-clearfix'>
                <div class='pwyw-gateways'>
                <?php
                // List available gateways
                $gateways = edd_get_enabled_payment_gateways();
                foreach ($gateways as $gateway_id => $gateway) {
                    $checked = checked($gateway_id, edd_get_default_gateway(), false);
                    echo '<label for="edd-gateway-'.$gateway_id.'" class="edd-gateway-option" id="edd-gateway-option-'.$gateway_id.'">';
                    echo '<input type="radio" name="edd-gateway" class="edd-gateway" id="edd-gateway-'.$gateway_id.'" value="'.$gateway_id.'"'.$checked.'>'.$gateway['checkout_label'].'</option>';
                    echo '</label>';
                }
                ?>
                </div>

                <?php
                    // Let's display the payment icons
                    edd_show_payment_icons();
                ?>
            </div>
			<div class="nomove">
            <button name='bundle_checkout' type='submit' value='checkout' class='checkoutbutton'>Checkout</button>
            <input type="hidden" name="bundleCheckout" value="1" />
            <input type="hidden" name="download_id" value="0" />
            <input type="hidden" name="bid" value="<?php echo $bundle['bundle']->id; ?>" />
            <input type="hidden" name="average_price" value="0" />
            <input type="hidden" name="total_amount" value="0" />
		</div>
        </li>
		</div>
    </ol>
    </form>
</div>
