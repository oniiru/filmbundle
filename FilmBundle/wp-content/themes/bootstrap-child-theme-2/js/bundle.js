//******jqplot donut chart *******
var plot3;
function plot(data){
    plot3 = $.jqplot('chart3', data, {
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
                seriesColors: [ "#49AFCD", "#DA4F49", "#FAA732", "#5BB75B", "#006DCC", "#00E49F", "#9E2F18", "#6D00E4", "#E47600" ]

            }
        },
        grid: {
            drawGridLines: true,        // wether to draw lines across the grid or not.
            background: 'transparent',      // CSS color spec for background color of grid.
            borderColor: 'transparent',     // CSS color spec for border around grid.
            shadow: false               // draw a shadow for grid.
        }
    //Place the legend here....

    });
}

function update_view(data){
    pwyw_data = data;

    $('.averageprice span').empty().html('$'+number_format(data.payment_info.avg_price));
     var main_info ='<li class="averageprice1">$' + number_format(data.payment_info.avg_price,2)+'</li>';
    main_info +='<li class="averageprice2">Average Purchase</li>';
    main_info +='<li class="lineseparator"></li>';
    main_info +='<li class="totalpurchase1">'+data.payment_info.total_sales +'</li>';
    main_info +='<li class="totalpurchase2">Total Purchases</li>';
        main_info +='<li class="lineseparator"></li>';

    main_info +='<li class="totalpayments1">$'+number_format(data.payment_info.total_payments)+'</li>';
    main_info +='<li class="totalpayments2">Total Payments</li>';

    $('.statsleft ul').empty().html(main_info);

    var top = '';
    var j = 1;
    for(var k in data.top){
        top +='<tr><td>'+j+'. '+data.top[k].display_name+'</td> <td> <span class="top_price">$'+data.top[k].amount+'</span></td></tr>';
        j++;
    }

    $('.statsmiddle table').empty().html(top);

    // plot3.remove();

    
    plot_data = [];

    for(var line in data.js_line){
        var l = [];

        for(var el in data.js_line[line]){
            l.push([data.js_line[line][el].title,data.js_line[line][el].allocate]);
        }
        plot_data.push(l);
    }

    
    if(plot_data.length){
        plot3.destroy();
        plot(plot_data);
    }

    min_amount = number_format(parseFloat(data.min_amount),2);
    avg_price =  number_format(parseFloat(data.payment_info.avg_price),2);

}



var difference;

//  ****** Alert boxes and custom prices *******
//function showDiv(price) {
//    //var customprice = parseFloat($('.custompricefield').val());
//    

//    
//    avg_price = parseFloat(avg_price);
//    min_amount = parseFloat(min_amount);
//
//    $('.customshow:hidden').show('slide', 500);
//    if(customprice > min_amount&&(min_amount>avg_price||(min_amount<=avg_price&&customprice>avg_price))) {
//
//        $('.leaderboardinput:hidden').show('slide', 500)
//    }
//    else if(customprice < avg_price) {
//
//        difference = number_format(avg_price - customprice,2);
//       
//        $('#difference').html(difference);
//        $('.lowpaymentwarning:hidden').show('slide', 500);
//        $('.leaderboardinput:visible').hide('slide', 500)
//    }
//    else $('.alert:visible').hide();
//		
//}
//
//function hideDiv() {
//    $('.customshow:visible').hide('slide', 500);
//    $('.alert:visible').hide('slide', 500);
//		
//}
alias = 'Anonymous';
function checkvalue(price) {
    
    if(price == null){
        price = parseFloat($('.custompricefield').val());
    }

    avg_price = parseFloat(avg_price);
    min_amount = parseFloat(min_amount);
    var top_count = 10;
    if(typeof(pwyw_data.top)!='undefined'){
        top_count = pwyw_data.top.length;
    }
   
    if((top_count==10&&price>min_amount)||(top_count<10&&price>=0.01)){
        // console.log(parseFloat($('.pricefield').val()),parseFloat(pwyw_data.min_amount));
        $('.leaderboardinput:hidden').fadeIn('slow');
       // console.log(avg_price,price);
        if(price>avg_price){
           $('.lowpaymentwarning:visible').hide();
        }
        $('.nozero:visible').hide();
        
    }
    if((price < avg_price)&& (price > 0.00)){
        difference = number_format(avg_price - price + 0.01,2);
        $('#difference').html(difference);
        $('.lowpaymentwarning:hidden').fadeIn('slow');
        if((top_count==10&&price<=min_amount)){
           $('.leaderboardinput:visible').hide();
        }
        $('.nozero:visible').hide()
    }
    if(price < 0.01) {

        $('.leaderboardinput:visible').hide();
        $('.lowpaymentwarning:visible').hide();
        $('.nozero:hidden').fadeIn('slow');

    }
    //else $('.alert:visible').hide();
}
	


// ********* buy now button ************

jQuery("document").ready(function() {

    jQuery('.homebutton').click(function() {

        jQuery('html, body').animate({
            scrollTop : jQuery(".content2").offset().top
        }, 1000);
    });
});
var check = false;


$(document).ready(function() {
    
    if(typeof(plot_data)!='undefined'){
        plot(plot_data);
    }
    
    
    $('.btn-info').click(function(event){
        var price;
        if(!$(this).hasClass('btn-small')){
            if($(this).attr('id') == 'custom_price'){
                price = parseFloat($('.custompricefield').val());
                $('.customshow:hidden').fadeIn('slow');
            
            }else{
                $('.customshow:visible').fadeOut('slow');
                price = parseFloat($(this).attr('value'));
            }

            checkvalue(price);
        } 
    })
    
    $('#bundle_checkout').submit(function(){

        if(check) return true;
        return false;
    })
    
    $(".percent").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
            // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
            // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
});

// ******************custom price field *********************

$(document).ready(function () {

    $("input[type=text].currenciesOnly").live('keydown', currenciesOnly)
    //    .live('blur', function () {
    //        $(this).formatCurrency();
    //    });

    $('')
});


// JavaScript I wrote to limit what types of input are allowed to be keyed into a textbox 
var allowedSpecialCharKeyCodes = [46,8,37,39,35,36,9];
var numberKeyCodes = [44, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105];
var decimalKeyCode = [190,110];

function currenciesOnly(event) {
    var legalKeyCode =
    (!event.shiftKey && !event.ctrlKey && !event.altKey)
    &&
    (jQuery.inArray(event.keyCode, allowedSpecialCharKeyCodes) >= 0
        ||
        jQuery.inArray(event.keyCode, numberKeyCodes) >= 0
        ||
        jQuery.inArray(event.keyCode, decimalKeyCode) >= 0);

    // Allow for $
    if (!legalKeyCode && event.shiftKey && event.keyCode == 52)
        legalKeyCode = true;

    if (legalKeyCode === false)
        event.preventDefault();
}

function number_format( number, decimals, dec_point, thousands_sep ) {	// Format a number with grouped thousands
    //
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +	 bugfix by: Michael White (http://crestidg.com)

    var i, j, kw, kd, km;

    // input sanitation & defaults
    if( isNaN(decimals = Math.abs(decimals)) ){
        decimals = 2;
    }
    if( dec_point == undefined ){
        dec_point = ".";
    }
    if( thousands_sep == undefined ){
        thousands_sep = ".";
    }

    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

    if( (j = i.length) > 3 ){
        j = j % 3;
    } else{
        j = 0;
    }

    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    //kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


    return km + kw + kd;
}


	