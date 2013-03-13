<?php
//get map type
$mtype = get_option('of_maps_type');
switch ($mtype) {
    case Roadmap:
        $mtype = 'ROADMAP';
        break;
    case Satellite:
        $mtype = 'SATELLITE';
        break;
    case Terrain:
        $mtype = 'TERRAIN';
        break;
    case Hybrid:
        $mtype = 'HYBRID';
        break;
}
?>
<div id="map_canvas"></div>
<script type="text/javascript">
jQuery(document).ready(function(){
    var latlng = new google.maps.LatLng(<?php echo get_option('of_maps_location') ?>); /* latitude and longitude for the center of the map*/
    var myOptions = {
        zoom: <?php echo get_option('of_maps_zoom') ?>, /* zoom level of the map */
        center: latlng,
        mapTypeId: google.maps.MapTypeId.<?php echo $mtype; ?>,
        mapTypeControl: false,      /* disable the Satelite-Roadmap switch */
        panControl: false,          /* disable the pan controller */
        streetViewControl: false,   /* disable the streetView option */
        zoomControl: false,         /* disable the zoom level buttons, the user will still be able to control the zoom by scrolling  */
        scaleControl: true,         /* optional: shows the scale of the map */
        scaleControlOptions: {
            /* since we decided to show the scale, we tell the script to show it in the corner we like, in this case Bottom Left */
            position: google.maps.ControlPosition.BOTTOM_LEFT
        }
    } /*end myOptions*/
    
    /*Connect to the database and iterate through our records, appending them to the mapLocations array*/
    var mapLocations = [
        /*Generate each marker entry in the array*/
        ["Title", <?php echo get_option('of_maps_location') ?>, "Desc"],
    ];
    
    /*Create the map*/
    var map = new google.maps.Map(document.getElementById("map_canvas"),
        myOptions); /* show the map in the element with the id: map_canvas */
    
    /*Run function to place markers onto map*/
    setMarkers(map, mapLocations);                 
})

/*Create the markers*/
function createMarker(map, latlng, label, html) {
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: label,
    });
}

/*Loop through markers array and place onto map*/
function setMarkers(map, locations) {
    for (var i = 0; i < locations.length; i++) {
        var currentMarker = locations[i];
        var myLatLng = new google.maps.LatLng(currentMarker[1], currentMarker[2]);
        var marker = createMarker(map,myLatLng,currentMarker[0],currentMarker[3],currentMarker[5],currentMarker[4]);
    }
}
</script>