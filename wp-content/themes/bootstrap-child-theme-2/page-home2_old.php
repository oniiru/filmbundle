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
  <?php $homebundle = get_option('Bundle_1'); ?>

 <script>
 	// ********************homepage sliders **************
var min=0;
var max=100;

$(function() {
        $( ".selector" ).slider(   
        { animate: true },
        { min: min },
        { max: max },
        {change: function(event, ui) {
            $('.filmmakerpercent').val($("#slider_filmmakers").slider("value"));
            $('.charitypercent').val($("#slider_charities").slider("value"));
            $('.bundlepercent').val($("#slider_bundle").slider("value"));
        }},
        {slide: function(event, ui) {
            $('.filmmakerpercent').val($("#slider_filmmakers").slider("value"));
            $('.charitypercent').val($("#slider_charities").slider("value"));
            $('.bundlepercent').val($("#slider_bundle").slider("value"));
        }});
        
         $("#slider_filmmakers").slider('value', <?php echo $homebundle['mainslider1']; ?>);
    $("#slider_charities").slider('value', <?php echo $homebundle['mainslider2']; ?>);
    $("#slider_bundle").slider('value', <?php echo $homebundle['mainslider3']; ?>);

    $('.filmmakerpercent').val($("#slider_filmmakers").slider("value"));
    $('.charitypercent').val($("#slider_charities").slider("value"));
    $('.bundlepercent').val($("#slider_bundle").slider("value"));
    
    $(".charitypercent").change(function() {
    $("#slider_charities").slider("value" , $(this).val())
		});

    $(".filmmakerpercent").change(function() {
    $("#slider_filmmakers").slider("value" , $(this).val())
		});

    $(".bundlepercent").change(function() {
    $("#slider_bundle").slider("value" , $(this).val())
		});
    	
    	$(function () {
	$('div.linked3').linkedSliders({ 
    total: 100,  // The total for all the linked sliders 
    policy: 'all' // Adjustment policy: 'next', 'prev', 'first', 'last', 'all' 
});
});
    	
});
 </script>
<div class="container">
  	<div class="bodyhome">
		<div class="inner">
			<div class="titlebox">
				<h1>Indie Bundle 1</h1>
				<h3>Discover Indie Films, Support Filmmakers, Help Charities.</h3>
				<h3 class="line2">Pay what you want to get all the films below.</h3>	
				<p id="scroll" class="btn btn-info homebutton btn-large">Purchase</p>	
					<div class="homecountdown">
						<?php dynamic_sidebar('Countdowndiv') ?>
					</div>
				<p class="timeremaining">Time Remaining</p>
			</div>
		</div>
		
		<div class="content1">
		
			<div class="shelf">
				<?php echo apply_filters('the_content', '[myvideogall:current]'); ?>
			</div>
			<div class="charities">
				<h2>Supported Charities</h2>
				<a href="#charitymodal1" data-toggle="modal"><img src="/wp-content/themes/bootstrap-child-theme-2/img/sundance.jpeg">
				</a>
				<a href="#charitymodal2" data-toggle="modal"><img src="/wp-content/themes/bootstrap-child-theme-2/img/charity2.jpeg">
				</a> 
			</div>        
			<div class="shelf2">
				<div class="shelf2films">
					<?php echo apply_filters('the_content', '[myvideogall:above]'); ?>
				</div>
				<p class="averageprice">Pay more than the average of <span>$6.23</span> to get these great films too!</p>
			</div>
			
			<div style="position:absolute; top:350px; width:100%; margin-top:15px">
			
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
			<div class="statsbox">
				<div class="statsleft">
					<ul>
						<li>Total Payments:</li>
						<li>Total Sales:</li>
						<li>Average Purchase:</li>
					</ul>
				</div>
				<div class="statsmiddle">
					<h3>Top Contributers:</h3>
					<ul>
						<li>1.</li>
						<li>2.</li>
						<li>3.</li>
						<li>4.</li>
						<li>5.</li>
						<li>6.</li>
						<li>7.</li>
						<li>8.</li>
						<li>9.</li>
						<li>10.</li>
					</ul>
				</div>
				<div class="statsright">
					<h3>How do they stack up? </h3>
					<div id="chart3">
					</div>
					<div class="chartlegend">
						<h3>Films:</h3>
						<div class="legenditem">
							<div class="legendcolor lc1"></div>
							<div class="legendtitle">BoomTown</div>
						</div>
						<div class="legenditem">
							<div class="legendcolor lc2"></div>
							<div class="legendtitle">My Town</div>
						</div>
	
						<div class="legenditem">
							<div class="legendcolor lc3"></div>
							<div class="legendtitle">Any Town</div>
						</div>
						<div class="legenditem">
							<div class="legendcolor lc4"></div>
							<div class="legendtitle">This Town</div>
						</div>
						<h3>Charities:</h3>
						<div class="legenditem">
							<div class="legendcolor lc5"></div>
							<div class="legendtitle">Sundance Institute</div>
						</div>
						<div class="legenditem">
							<div class="legendcolor lc6"></div>
							<div class="legendtitle">Film Independent</div>
						</div> 
					</div>
				</div>
			</div>
			<h2>Purchase</h2>
			<div class="step1">
				<div class="buttonslidegroup">
					<div class="btn-group" data-toggle="buttons-radio">
						<button onclick="hideDiv()" value="<?php echo $homebundle['indivvalues1']; ?>" class="btn btn-info">$<?php echo $homebundle['indivvalues1']; ?></button>
  						<button onclick="hideDiv()" value="<?php echo $homebundle['indivvalues2']; ?>"class="btn btn-info">$<?php echo $homebundle['indivvalues2']; ?></button>
  						<button onclick="hideDiv()" value="<?php echo $homebundle['indivvalues3']; ?>"class="btn btn-info">$<?php echo $homebundle['indivvalues3']; ?></button>
  						<button onclick="showDiv()" value="<?php echo $homebundle['indivvalues4']; ?>"class=" btn btn-info">Custom</button>
  					</div>
  					<div class="input-prepend customshow" style="display:none;">
  					<span class="add-on">$</span><input class="span1 custompricefield currenciesOnly" onchange="checkvalue()" value="<?php echo $homebundle['indivvalues4']; ?>" type="text">
  					</div>
  				</div>	
			</div>	
			<div class="alertboxes">
				<div class="lowpaymentwarning alert alert-error" style="display:none">Pay only <b>$4.25</b> more to unlock the bonus films. Come on, help some starving filmmakers out. ;)
				</div>
				<div class="leaderboardinput alert alert-success" style="display:none"><b>You Rock!</b> This amount makes you one of the top contributors. Enter your	
					 <span class="add-on">@</span><input class="span2" id="PrependedInput" placeholder="twitterhandle" type="text"> or any <input class="span2" placeholder="username" type="text"> to be added on our top contributor board.
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
							<li>Cinema Bundle:</li>
						</ul>
					</div>	
					<div class="conteneur">
   						<div id="slider_filmmakers" value="<?php echo $homebundle['mainslider1']; ?>" class="linked3 selector inactive sliderhome"></div>
    					<div style="clear"></div>
    					<div id="slider_charities" value="<?php echo $homebundle['mainslider2']; ?>" class="linked3 selector inactive sliderhome"></div>
    					<div style="clear"></div>
    					<div id="slider_bundle" value="<?php echo $homebundle['mainslider3']; ?>" class="linked3 selector inactive sliderhome"></div>
    					<div style="clear"></div>	
					</div>​ 
					<div class="divedeeper input-append">
						<ul>
							<li><input type="text" value="<?php echo $homebundle['mainslider1']; ?>" class="filmmakerpercent percent"><span class="add-on">%</span><a class="btn btn-info btn-small" href="#slider1modal" data-toggle="modal" type="button">Dive Deeper</a></li>
							<li><input type="text" value="<?php echo $homebundle['mainslider2']; ?>" class="charitypercent percent"><span class="add-on">%</span><a class="btn btn-info btn-small" href="#slider2modal" data-toggle="modal" type="button">Dive Deeper</a></li>
							<li><input type="text" value="<?php echo $homebundle['mainslider3']; ?>" class="bundlepercent percent"><span class="add-on">%</span></li>
						</ul>
					</div>
				</div>
				<a href="#" class="btn btn-large btn-success"> Checkout </a>
			</div>
			<div class="content3"> 
			</div>
		</div>
	</div>


<!-- Slider 1 Modal -->

	<div class="modal hide fade" id="slider1modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 		<div class="modal-header">
  			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  	  		<h3 id="myModalLabel">Films</h3>
       		 <p>Decide exactly how much the work of each filmmaker is worth.</p>
  		</div>
  		<div class="modal-body">  	
  			<div class="slidertitles">
  				<ul>
  					<li>BoomTown:</li>
  					<li>MooTown:</li>
  					<li>The Deciders:</li>
  					<li>Jessie James:</li>
  					<li>Killers:</li>
  				</ul>
  			</div>
  			<div class="conteneur">	 
   				<div id="slider_filmmaker1" class="selector inactive sliderhome"></div>
   				<div style="clear"></div>
   				<div id="slider_filmmaker2" class="selector inactive sliderhome"></div>
  				<div style="clear"></div>
  				<div id="slider_filmmaker3" class="selector inactive sliderhome"></div>
 				<div style="clear"></div>
     			<div id="slider_filmmaker4" class="selector inactive sliderhome"></div>
    			<div style="clear"></div>
  				<div id="slider_filmmaker5" class="selector inactive sliderhome"></div>
    			<div style="clear"></div>
			</div>​
	
	
			<div class="divedeeper input-append">
				<ul>
					<li> <input type="text"><span class="add-on">%</span></li>
					<li> <input type="text"><span class="add-on">%</span></li>
					<li> <input type="text"><span class="add-on">%</span></li>
					<li> <input type="text"><span class="add-on">%</span></li>
					<li> <input type="text"><span class="add-on">%</span></li>
				</ul>
			</div>
  		</div>
		<div class="modal-footer">
   			<button class="btn">Reset</button>
    		<button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Save and Close</button>
  		</div>
	</div>

<!-- Slider 2 Modal -->
 	<div class="modal hide fade" id="slider2modal" tabindex="-1" role="dialog" aria-labelledby="slider1Label" aria-hidden="true">
  		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    		<h3 id="myModalLabel">Charities</h3>
            <p>Decide exactly how much should go to each charity.</p>
  		</div>
  		<div class="modal-body">
  			<div class="slidertitles">
  				<ul>
  					<li>Sundance Institute:</li>
  					<li>Film Independent:</li>
  				</ul>
  			</div>
  			<div class="conteneur">	 
   				<div id="slider_charity1" class="selector inactive sliderhome"></div>
   		 		<div style="clear"></div>
    			<div id="slider_charity2" class="selector inactive sliderhome"></div>
    			<div style="clear"></div>
			</div>​
			<div class="divedeeper input-append">
				<ul>
					<li> <input type="text" id="appendedInput" ><span class="add-on">%</span> </li>
					<li> <input type="text" id="appendedInput"><span class="add-on">%</span></li>
				</ul>
			</div>
 		 </div>
  		<div class="modal-footer">
    		<button class="btn">Reset</button>
    		<button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Save and Close</button>
  		</div>
	</div>

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



 
<hr class="soften">
<div class="marketing">

</div><!-- /.marketing -->
<?php get_footer();?>
