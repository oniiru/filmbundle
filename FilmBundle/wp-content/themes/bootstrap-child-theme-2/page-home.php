<?php
/**
 *
 * Template Name: Home Hero Template with 3 widget areas
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
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  	
  	<div class="bodyhome">
  		
  		<div class="inner">
   			<div class="titlebox">
				<h1>Indie Bundle 1</h1>
				<h3>Discover Indie Films, Support Filmmakers, Help charities.</h3>
				<h3 class="line2">Pay what you want to get all the films below.</h3>
				<p id="scroll" class="btn btn-info homebutton btn-large">Purchase</p>	
				<div class="homecountdown"><?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Countdowndiv')) : else : ?> 
				</div>

				<?php endif; ?><p>Time Remaining</p>

			</div>
		</div>
		 

    
   </div> 
      		<div class="shelf"><?php echo apply_filters('the_content', '[myvideogall:current]'); ?></div>

<div class="content1">  <div class="charities"> <h2>Supported Charities</h2><a href="#charitymodal1" data-toggle="modal"><img src="/wp-content/themes/bootstrap-child-theme-2/img/sundance.jpeg"></a><a href="#charitymodal2" data-toggle="modal"><img src="/wp-content/themes/bootstrap-child-theme-2/img/charity2.jpeg"></a> </div>         <div class="shelf2"><div class="shelf2films"><?php echo apply_filters('the_content', '[myvideogall:above]'); ?></div>
	<p>Pay more than the average of <span>$6.23 </span> to get these great films too!</p></div>
	<div style="position:absolute; top:350px; width:100%">
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
		<p>Total Payments:</p>
		<p>rawr:</p>
		<p>Average Purchase:</p>

		
		
		</div>
	<div class="statsmiddle">
Top Contributors:<br />
1.<br />
2.<br />
3.<br />
4.<br />
5.<br />
6.<br />
7.<br />
8.<br />
9.<br />
10.<br />
</div>
	<div class="statsright">
		<h3>How do they stack up? </h3>
<div id="chart3"></div>
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
<script>
	function showDiv() {
		$('#customshow:hidden').show('slide', 750);
		if(parseFloat($("#PrependedInput").val()) > 45.00) {
			$('.leaderboardinput:hidden').show('slide', 500)}
		else if(parseFloat($("#PrependedInput").val()) < 5.00) {
			$('.lowpaymentwarning:hidden').show('slide', 500);
			$('.leaderboardinput').hide() } 
		else $('.alert').hide();
		
	}

	function hideDiv() {
		$('#customshow:visible').hide('slide', 750);
		$('.alert:visible').hide('slide', 750);
		
	}
	
	function checkvalue() {
		if(parseFloat($("#PrependedInput").val()) > 45.00) {
			$('.leaderboardinput:hidden').show('slide', 500);
			$('.lowpaymentwarning').hide();
			$('.nozero').hide() }
		else if((parseFloat($("#PrependedInput").val()) < 5.00)&& (parseFloat($("#PrependedInput").val()) > 0.00)){
			$('.lowpaymentwarning:hidden').show('slide', 500);
			$('.leaderboardinput').hide();
			$('.nozero').hide() } 
		else if(parseFloat($("#PrependedInput").val()) < 0.01) {
			$('.nozero').show('slide', 750)
		}
		else $('.alert').hide();
	}
</script>

<div class="step1"> 1. Choose how much you want to pay.
	<div class="btn-group" data-toggle="buttons-radio">
  <button onclick="hideDiv()" class="btn btn-info">$57.00</button>
  <button  onclick="hideDiv()" class="btn btn-info">$37.00</button>
  <button onclick="hideDiv()" class="btn btn-info">$25.00</button>
    <button onclick="showDiv()" class=" btn btn-info">Custom</button>
	</div>
	<div id="customshow" class="input-prepend customshow">
  <span class="add-on">$</span><input class="currenciesOnly" onkeyup="checkvalue()" value="15.00" type="text">
</div>
</div>
<div class="alertboxes">
<div class="lowpaymentwarning alert alert-error" style="display:none">Pay only <b>$4.25</b> more to unlock the bonus films. Come on, help some starving filmmakers out. ;)</div>
<div class="leaderboardinput alert alert-success" style="display:none"><b>You Rock!</b> This amount makes you one of the top contributors. Enter your	
	 <span class="add-on">@</span><input class="span2" id="PrependedInput" placeholder="twitterhandle" type="text"> or any <input class="span2" placeholder="username" type="text"> to be added on our top contributor board.
	</div>
<div class="nozero alert alert-error" style="display:none">We're all about paying what you want, but we've got to draw the line somewhere. Please pay at least $0.01. :)</div>

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
    <div id="slider_filmmakers" class="selector inactive sliderhome"></div>
    <div style="clear:both"></div>
    <div id="slider_charities" class="selector inactive sliderhome"></div>
    <div style="clear:both"></div>
    <div id="slider_bundle" class="selector inactive sliderhome"></div>
    <div style="clear:both"></div>	

</div>​ 

<div class="divedeeper input-append">
	<ul>
		<li> <input type="text" id="appendedInput" class="filmmakerpercent"><span class="add-on">%</span> <a class="btn btn-info btn-small" href="#slider1modal" data-toggle="modal" type="button">Dive Deeper</a> </li>
	<li> <input type="text" id="appendedInput" class="charitypercent"><span class="add-on">%</span> <a class="btn btn-info btn-small" href="#slider2modal" data-toggle="modal" type="button">Dive Deeper</a></li>
	<li> <input type="text" id="appendedInput" class="bundlepercent"><span class="add-on">%</span> </li>
	</ul>

	   

</div>
</div>
<a href="#" class="btn btn-large btn-success"> Checkout </a>
        </div>
      </div>
<div class="content3"> 
	
	
	</div>


</div>
<?php endwhile; endif; ?>
<hr class="soften">
<div class="marketing">
</div><!-- /.marketing -->
 	  <script type="text/javascript">
		jQuery("document").ready(function() {

			jQuery('.homebutton').click(function() {

				jQuery('html, body').animate({
					scrollTop : jQuery(".content2").offset().top
				}, 1000);
			});
		});
</script>


<script>
	var min = 0;
	var max = 100;

	$('.selector').slider({
		animate : true
	}, {
		min : min
	}, {
		max : max
	}, {
		change : function(event, ui) {
			totalvalue = $("#slider_filmmakers").slider("value") + $("#slider_charities").slider("value") + $("#slider_bundle").slider("value");
			$('.filmmakerpercent').val($("#slider_filmmakers").slider("value"));
			$('.charitypercent').val($("#slider_charities").slider("value"));
			$('.bundlepercent').val($("#slider_bundle").slider("value"));

		}
	}, {
		slide : function(event, ui) {
			$('.filmmakerpercent').val($("#slider_filmmakers").slider("value"));
			$('.charitypercent').val($("#slider_charities").slider("value"));
			$('.bundlepercent').val($("#slider_bundle").slider("value"));

		}
	});

	$("#slider_filmmakers").slider('value', 20);
	$("#slider_charities").slider('value', 30);
	$("#slider_bundle").slider('value', 50);

	$('.filmmakerpercent').val($("#slider_filmmakers").slider("value"));
	$('.charitypercent').val($("#slider_charities").slider("value"));
	$('.bundlepercent').val($("#slider_bundle").slider("value"));

	function refreshSliders(slidermainin) {
		var valuefilmmakers = $("#slider_filmmakers").slider("option", "value");
		var valuecharities = $("#slider_charities").slider("option", "value");
		var valuebundle = $("#slider_bundle").slider("option", "value");
		var valuechange = (valuefilmmakers + valuecharities + valuebundle) - 100;
		var valuemain = 0, valueother1 = 0, valueother2 = 0;

		switch(slidermainin) {
			case 1:
				slidermain = "#slider_filmmakers";
				sliderother1 = "#slider_charities";
				sliderother2 = "#slider_bundle";
				valuemain = valuefilmmakers;
				valueother1 = valuecharities;
				valueother2 = valuebundle;
				break;
			case 2:
				slidermain = "#slider_charities";
				sliderother1 = "#slider_filmmakers";
				sliderother2 = "#slider_bundle";
				valuemain = valuecharities;
				valueother1 = valuefilmmakers;
				valueother2 = valuebundle;
				break;
			case 3:
				slidermain = "#slider_bundle";
				sliderother1 = "#slider_filmmakers";
				sliderother2 = "#slider_charities";
				valuemain = valuebundle;
				valueother1 = valuefilmmakers;
				valueother2 = valuecharities;
				break;
		}

		if (valueother1 === 0 || valueother2 === 0) {
			if (valueother1 === 0) {
				if (valuechange <= 0) {
					$(sliderother1).slider('value', valueother1 - (valuechange / 2));
					$(sliderother2).slider('value', valueother2 - (valuechange / 2));
				} else {
					$(sliderother2).slider('value', valueother2 - valuechange);
				}
			} else {
				if (valuechange <= 0) {
					$(sliderother1).slider('value', valueother1 - (valuechange / 2));
					$(sliderother2).slider('value', valueother2 - (valuechange / 2));
				} else {
					$(sliderother1).slider('value', valueother1 - valuechange);
				}
			}
		} else {
			$(sliderother1).slider('value', valueother1 - (valuechange / 2));
			$(sliderother2).slider('value', valueother2 - (valuechange / 2));
		}
	}

	var bindSliders = function(selector, value) {
		$(selector).bind("slidechange slide", function(event, ui) {
			event.originalEvent && (event.originalEvent.type == 'mousemove' || event.originalEvent.type == 'mouseup' || event.originalEvent.type == 'keydown') && refreshSliders(value);
		});
	};

	bindSliders("#slider_filmmakers", 1);
	bindSliders("#slider_charities", 2);
	bindSliders("#slider_bundle", 3);

</script>
<script>$(document).ready(function(){
  var s1 = [['mootown',6], ['boomtown',8], ['anytown',14], ['thistown',20],['Film Independent', 0],['Sundance Institute', 0]];
  var s2 = [['mootown',0], ['boomtown',0], ['anytown',0], ['thistown',0],['Film Independent', 8], ['Sundance Institute', 12]];
   
  var plot3 = $.jqplot('chart3', [s1,s2], {
    seriesDefaults: {
      // make this a donut chart.
      renderer:$.jqplot.DonutRenderer,
      rendererOptions:{          
          thickness:20,
          ringMargin:3,
          padding:0,
        sliceMargin: 3,
        // Pies and donuts can start at any arbitrary angle.
        startAngle: -90,
        showDataLabels: true,
        // By default, data labels show the percentage of the donut/pie.
        // You can show the data 'value' or data 'label' instead.
        dataLabels: 'percent',
        seriesColors: [ "#49AFCD", "#DA4F49", "#FAA732", "#5BB75B", "#006DCC", "#00E49F", "#9E2F18", "#6D00E4", "#E47600" ],

      }
    },
       grid: {
    drawGridLines: true,        // wether to draw lines across the grid or not.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: 'transparent',     // CSS color spec for border around grid.
        shadow: false,               // draw a shadow for grid.
}, 
      //Place the legend here....
    
  });
    
   }); </script> 
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
		<li> <input type="text" id="appendedInput" ><span class="add-on">%</span> </li>
	<li> <input type="text" id="appendedInput"><span class="add-on">%</span></li>
	<li> <input type="text" id="appendedInput" ><span class="add-on">%</span> </li>
		<li> <input type="text" id="appendedInput" ><span class="add-on">%</span> </li>
	<li> <input type="text" id="appendedInput" ><span class="add-on">%</span> </li>

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
<?php get_footer(); ?>
