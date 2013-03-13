<?php
/**
 *
 * Template Name: Home Page Take 2
 *
 *
 * @package WP-Bootstrap
 * @subpackage Default_Theme
 * @since WP-Bootstrap 0.5
 *
 * Last Revised: March 4, 2012
 */
get_header();
 ?>
<!--<div pub-key="pub-055f1968-8c42-4146-80b1-195d34e6c4c5" sub-key="sub-5f5a6c30-278a-11e2-964e-034399c6c504" ssl="off" origin="pubsub.pubnub.com" id="pubnub"></div>-->
<?php 
$pwyw = new pwyw();
$pwyw_data = $pwyw->pwyw_get_bundle_info() ;
$nonce = wp_create_nonce('pwyw_bundle_checkout');
$nonce2 = wp_create_nonce('pwyw_ajax');

?>

<script type="text/javascript">
    var min=0;
    var max=100;
    var pwyw_data = {};
    var main_cat = [];
    var alias; 
    var user_alias,twitter_alias; 
    pwyw_data = <?php echo json_encode($pwyw_data); ?>;
console.log(pwyw_data);

    var min_amount,avg_price;
    
    if(pwyw_data.payment_info == null){
       min_amount = 0;
    }
    else{
       min_amount = parseFloat(pwyw_data.min_amount);
    }

    if(pwyw_data.payment_info == null){
        avg_price = 0;
    }else{
        avg_price =  parseFloat(pwyw_data.payment_info.avg_price);
    }

    var plot_data = [];
    <?php
    $j = 1;

    if (!empty($pwyw_data['js_line'])):
        foreach ($pwyw_data['js_line'] as $elems):

            $string = '';
            foreach ($elems as $el) {
                $string .= "['{$el['title']}',{$el['allocate']}],";
            }
            $string = '[' . rtrim($string, ',') . ']';?>
                var s<?php echo $j?> = <?php echo $string?>;
                plot_data.push(s<?php echo $j?>);

    <?php
            $j++;
        endforeach;
    endif;
    ?>


    function setSliderHandlers(slider_class,input_class){
        var default_val = 0;
        $('.'+input_class).val(0);


        $( "."+slider_class ).slider(
        { animate: true },
        { min: min },
        { max: max },
        {change: function(event, ui) {
                var id = $(this).attr('id').match(/slider_(.+)/)[1];
                $('#'+id+'_inp').val($(this).slider('value'));
            }},
        {slide: function(event, ui) {
                var id = $(this).attr('id').match(/slider_(.+)/)[1];
                $('#'+id+'_inp').val($(this).slider('value'));
            }});

        $('.'+input_class).each(function(){
            var id = $(this).attr('id').match(/(.+)_inp/)[1];
            var slider = $('#slider_'+id);

            if(slider.attr('value') != ''){
                $(this).val(slider.attr('value'));
                slider.slider("value",slider.attr('value'));
            }else{
                $(this).val(default_val);
            }

            $(this).change(function(){
                slider.slider("value" , $(this).val());
            })
        })

        $('div.'+slider_class).linkedSliders({
            total: 100,  // The total for all the linked sliders
            policy: 'next' // Adjustment policy: 'next', 'prev', 'first', 'last', 'all'
        });

    }
    
$(function(){


        //if(pwyw_data.payment_info!=null){
            var interval = window.setInterval(function(){
                $.ajax({
                    type:'POST',
                    url:'<?php echo $pwyw->plugin_url?>ajax.php',
                    data:{bid:'<?php echo $pwyw_data['bundle']->id?>',_ajax_nonce: '<?php echo $nonce2?>'},
                    dataType:'json',
                    success: function(data){
                        if(typeof(data.error) == 'undefined'){
                            if(typeof(data.payment_info)!='undefined'&&data.payment_info!=null){
                                  update_view(data);                              
                            }

                        }
                        else{console.log(data.error)}
                    }
                })
            },1000);
       // }



        setSliderHandlers('linked3','percent');
        setSliderHandlers('charities','charities_percent');
        setSliderHandlers('filmmakers','filmmakers_percent');
        
        $('.btn_reset').click(function(){
            var title = '';
            var parent_cat;
            var slider_class = $(this).parents('.modal').find('div.selector');
            for(var key in pwyw_data.categories){
                parent_cat = pwyw_data.categories[key];
                title = parent_cat['info']['title'].toLowerCase();
                if(key !== 3){
                    if(slider_class.eq(0).attr('class').indexOf(title)){
                        for(var k in parent_cat['sub']){
                            $('#'+title+'_'+k+'_inp').val(parent_cat['sub'][k]['info']['val']);
                            $('#slider_'+title+'_'+k).slider({value:parent_cat['sub'][k]['info']['val']});
                        }
                    }
                }
            }

        })
        
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
            
        })
    })
     
</script>

<div class="container">
  	<div class="bodyhome">
  		
		<div class="inner">
			<div class="titlebox">
				<h1>Bundle 1</h1>
				<h3>Discover Indie Films, Support Filmmakers, Help Charities.</h3>
				<h3 class="line2">Pay what you want to get all the films below.</h3>	
				<p id="scroll" class="btn btn-info homebutton btn-large">Purchase</p>	
					<div class="homecountdown">
						<?php dynamic_sidebar('Countdowndiv') ?>
					</div>
				<p class="timeremaining">Time Remaining</p>
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
		
			<div class="shelf">
				<?php echo apply_filters('the_content', '[myvideogall:current]'); ?>
			</div>
			<div class="charities-mod">
				<h2>Supported Charities</h2>
				<a href="#charitymodal1" data-toggle="modal"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/charity2.jpeg">
				</a>
				<a href="#charitymodal2" data-toggle="modal"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/filmaidlogo.jpg" width="150px" style="height:75px !important">
				</a> 
			</div>        
			<div class="shelf2">
				<div class="shelf2films">
					<?php echo apply_filters('the_content', '[myvideogall:above]'); ?>
				</div>
				<p class="averageprice">Pay more than the average of <span>$<?php echo !empty($pwyw_data['payment_info'])&&$pwyw_data['payment_info']->avg_price>0?number_format($pwyw_data['payment_info']->avg_price,2):'0.00' ?></span> to get these great films too!</p>
			</div>
			
				<div class="fourpointscontain">

			
				<div class="fourpoints">
					<h3>Support Filmmakers</h3>
					<p>
						Show talented Independent Filmmakers some love! Pay however much you think their 
						<br /> work is worth.
						</p>
				</div>
				<div class="fourpoints">
					<h3>Discover Amazing Films</h3>
						<p>
						These films are amazing and many don't get the distribution they deserve. Pick up a bundle and get the inside track.
						</p>
				</div>
				<div class="fourpoints">
					<h3>Donate to charities</h3>
					<p>We partner with two arts driven non-profits on each bundle. You choose how much of your purchase goes to them.</p>
				</div>
				<div class="fourpoints">
					<h3>Pay What You Want</h3>
					<p>
					Pay only what you think the bundle is worth, and choose exactly where your money will go. Split it up evenly, or give it all to a specific filmaker or charities.
					</p>
				</div>
			</div>
		</div>

		<div class="content2">
                    <?php // if(!empty($pwyw_data['payment_info'])):?>
			<div class="statsbox">
				<!-- <div class="statsboxtitle">
					<div class="statsboxtitleline"></div>
					Bundle Stats
					<div class="statsboxtitleline"></div>

				</div> -->
				<div class="statsleft">
					<h3>Bundle Stats</h3>
					<ul>
                        <li class="averageprice1">$<?php echo isset($pwyw_data['payment_info']->avg_price)?number_format($pwyw_data['payment_info']->avg_price,2):'0.00' ?></li>
                    	<li class="averageprice2">Average Purchase</li>
                    	<li class="lineseparator"></li>
                    	<li class="totalpurchase1"><?php echo isset($pwyw_data['payment_info']->total_sales)?$pwyw_data['payment_info']->total_sales:'0' ?> </li>
						<li class="totalpurchase2">Total Purchases</li>
						<li class="lineseparator"></li>
                        <li class="totalpayments1">$<?php echo isset($pwyw_data['payment_info']->total_payments)?number_format($pwyw_data['payment_info']->total_payments,2):'0.00'?></li>
						<li class="totalpayments2">Total Payments</li>

					</ul>
				</div>
				<div class="statsmiddle">
					<h3>Top Contributors:</h3>
<!--					<ul>-->
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
<!--					</ul>-->
				</div>
				<div class="statsright">
					<h3>How do they stack up? </h3>
					<div id="chart3">
					</div>
					<div class="chartlegend">
                                        <?php
                                              $j = 1;
                                              foreach($pwyw_data['categories'] as $key=>$cat_obj):
                                                   
                                                   if($key != 3):?>
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

                                                    <h3><?php echo $ctitle ?></h3>
                                                    <?php foreach ($cat_obj['sub'] as $key_s => $sub): ?>
                                                        <div class="legenditem">
                                                            <div class="legendcolor lc<?php echo $j ?>"></div>
                                                            <div class="legendtitle"><?php echo $sub['info']['title'] ?></div>
                                                        </div>
                                                    <?php $j++;
                                                        endforeach; ?>
                                                <?php endif; ?>

                                            <?php endforeach;?>
					</div>
				</div>
			</div>
                    <?php //endif; ?>
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
		<div class="content3"> 
			<div class="pagefooterleft">
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>/about">About</a></li>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>/support">Support</a></li>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>/contact">Contact</a></li>
				</ul>
			</div>
			<div class="pagefootermiddle">
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>/blog">Blog</a></li>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>/terms">Terms and Conditions</a></li>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>/privacy">Privacy Policy</a></li>
				</ul>
			</div>
				<div class="pagefootermiddle">
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>/suggest">Suggest a Film</a></li>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>/submit">Submit a Film</a></li>
				</ul>
			</div>
			<div class="pagefooterright">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Twitter.png">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Facebook.png">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/img/YouTube.png">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Vimeo.png">

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

<!-- Film 1 Modal -->

	<div class="modal hide fade" id="filmmodal1" tabindex="-1" role="dialog" aria-labelledby="badboysLabel" aria-hidden="true">
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
       		<?php the_block('filmmodaltitle1'); ?>
 		</div>
  		<div class="modal-body">  	
  			<?php the_block('filmmodal1'); ?>
		</div>
	</div>
	
<!-- Film 2 Modal -->

	<div class="modal hide fade" id="filmmodal2" tabindex="-1" role="dialog" aria-labelledby="badboysLabel" aria-hidden="true">
  		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    		<?php the_block('filmmodaltitle2'); ?>
  		</div>
  		<div class="modal-body">  	
  			<?php the_block('filmmodal2'); ?>
		</div>
	</div>
	
<!-- Film 3 Modal -->

	<div class="modal hide fade" id="filmmodal3" tabindex="-1" role="dialog" aria-labelledby="badboysLabel" aria-hidden="true">
  		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    		<?php the_block('filmmodaltitle3'); ?>
  		</div>
  		<div class="modal-body">  	
  			<?php the_block('filmmodal3'); ?>
		</div>
	</div>

<!-- Film 4 Modal -->

	<div class="modal hide fade" id="filmmodal4" tabindex="-1" role="dialog" aria-labelledby="badboysLabel" aria-hidden="true">
		<div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	<?php the_block('filmmodaltitle4'); ?>
  		</div>
  		<div class="modal-body">  	
  			<?php the_block('filmmodal4'); ?>
		</div>
	</div>

<!-- Film 5 Modal -->

	<div class="modal hide fade" id="filmmodal5" tabindex="-1" role="dialog" aria-labelledby="badboysLabel" aria-hidden="true">
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      		<?php the_block('filmmodaltitle5'); ?>
  		</div>
  		<div class="modal-body">  	
  			<?php the_block('filmmodal5'); ?>
		</div>
	</div>

<!-- Film 6 Modal -->

	<div class="modal hide fade" id="filmmodal6" tabindex="-1" role="dialog" aria-labelledby="badboysLabel" aria-hidden="true">
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    		<?php the_block('filmmodaltitle6'); ?>
  		</div>
  		<div class="modal-body">  	
  			<?php the_block('filmmodal6'); ?>
		</div>
	</div>
  
<!-- Film 7 Modal -->

	<div class="modal hide fade" id="filmmodal7" tabindex="-1" role="dialog" aria-labelledby="badboysLabel" aria-hidden="true">
  		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
   			<?php the_block('filmmodaltitle7'); ?>
  		</div>
  		<div class="modal-body">  	
  			<?php the_block('filmmodal7'); ?>
		</div>
	</div>

<!-- Film 8 Modal -->

	<div class="modal hide fade" id="filmmodal8" tabindex="-1" role="dialog" aria-labelledby="badboysLabel" aria-hidden="true">
  		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<?php the_block('filmmodaltitle8'); ?>
  		</div>
  		<div class="modal-body">  	
  			<?php the_block('filmmodal8'); ?>
		</div>
	</div>

<!-- Film 9 Modal -->

	<div class="modal hide fade" id="filmmodal9" tabindex="-1" role="dialog" aria-labelledby="badboysLabel" aria-hidden="true">
		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    		<?php the_block('filmmodaltitle9'); ?>
  		</div>
  		<div class="modal-body">  	
  			<?php the_block('filmmodal9'); ?>
		</div>
	</div> 

<!-- Film 10 Modal -->

	<div class="modal hide fade" id="filmmodal10" tabindex="-1" role="dialog" aria-labelledby="badboysLabel" aria-hidden="true">
 		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<?php the_block('filmmodaltitle10'); ?>
	 	</div>
		<div class="modal-body">  	
  			<?php the_block('filmmodal10'); ?>
		</div>
	</div>

<!-- Charity 1 Modal -->

	<div class="modal hide fade" id="charitymodal1" tabindex="-1" role="dialog" aria-labelledby="badboysLabel" aria-hidden="true">
  		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  			<?php the_block('charitymodaltitle1'); ?>
  		</div>
  		<div class="modal-body">  	
  			<?php the_block('charitymodal1'); ?>
		</div>
	</div>
<!-- charity 2 Modal -->

	<div class="modal hide fade" id="charitymodal2" tabindex="-1" role="dialog" aria-labelledby="badboysLabel" aria-hidden="true">
  		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
 			<?php the_block('charitymodaltitle2'); ?>
  		</div>
  		<div class="modal-body">  	
  			<?php the_block('charitymodal2'); ?>
		</div>
	</div>



 
<div class="marketing">

</div><!-- /.marketing -->
<?php get_footer();?>
