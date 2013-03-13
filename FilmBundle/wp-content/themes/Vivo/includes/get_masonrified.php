<script>
/*****
    Isotope: Portfolio
*****/
$(window).load(function() { //Adding window load fixes filter/masonry bug

    var $container = $('#work_container');

    //Run to initialise column sizes
    updateSize();

    //Load masonry when images all loaded
    $container.imagesLoaded( function(){

        $container.animate({'opacity': '1'});
        $('#loader').fadeOut("fast");

        $container.isotope({
            // options
            itemSelector : '.work_item',
            layoutMode : 'masonry',
            transformsEnabled: false,
            columnWidth: function( containerWidth ) {
                containerWidth = $browserWidth;
                return Math.floor(containerWidth / $cols);
              }
        });
    });

    // update columnWidth on window resize
    $(window).smartresize(function(){  
        updateSize();
        $container.isotope( 'reLayout' );
    });

    //Set item size
    function updateSize() {
        $browserWidth = $container.width();
        $cols = 0;

        if ($browserWidth >= 1200) {
            $cols = 4;
        }
        else if ($browserWidth >= 800 && $browserWidth < 1200) {
            $cols = 3;
        }
        else if ($browserWidth >= 401 && $browserWidth < 800) {
            $cols = 2;
        }
        else if ($browserWidth < 401) {
            $cols = 1;
        }

        //console.log("Browser width is:" + $browserWidth);
        //console.log("Cols is:" + $cols);

        $gutterTotal = $cols * 20;
        $browserWidth = $browserWidth - $gutterTotal;
        $itemWidth = $browserWidth / $cols;
        $itemWidth = Math.floor($itemWidth);

        jQuery(".work_item").each(function(index){
            jQuery(this).css({"width":$itemWidth+"px"});             
        });
    }

    // filter items when filter link is clicked
    $('#filters a').click(function(){
    	var selector = $(this).attr('data-filter');
    	$container.isotope({ filter: selector });
    	return false;
    });

});
</script>