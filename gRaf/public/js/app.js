$(document).ready(function () {
    gMap = {
        map: null,
        curr: null,
        places: []
    };

    console.clear();

    $(".place").on('click', function() {
        var tmp = $(this).find(".like");
        if (tmp.hasClass("glyphicon-heart")) {
            tmp.addClass("glyphicon-heart-empty");
            tmp.removeClass("glyphicon-heart");
            gMap.places.remove($(this).data("id"));
        } else {
            tmp.addClass("glyphicon-heart");
            tmp.removeClass("glyphicon-heart-empty");
            gMap.places.push($(this).data("id"));
        }

    });

    $(".place").on('mouseenter', function(){
        if (gMap.curr != null)
            gMap.curr.setMap(null);

        gMap.curr = {
            title: $(this).data("name"),
            lat: $(this).data("lat"),
            lng: $(this).data("lng"),
        }
        gMap.info = {
            bounds: new google.maps.LatLngBounds(),
            infowindow: new google.maps.InfoWindow()
        };

        addMarker(gMap);
    });

    $("#planForm").on('submit', function(e){

        $("#places").val(gMap.places.join("-graf-"));
        var days = [];
        $(".days-hours").each(function(i, item){
            if (item.value == "") {
                days.push(0);
            } else {
                days.push(parseInt(item.value));
            }
        });

        $("#times").val(days.join("-"));
        // return false;
    });

    initMap(gMap);

});


function initMap(gMap) {


    var mapDiv = document.getElementById('cityMap');
    if (mapID == "cityMapDashboard") {
      console.log(mapID);
      var mapDiv = document.getElementById(mapID);
    }

    gMap.map = new google.maps.Map(mapDiv, {
        center: {
            lat: lat,
            lng: lng
        },
        zoom: 8
    });

}

function addMarker(gMap) {

    gMap.curr = new google.maps.Marker({
        position: new google.maps.LatLng(gMap.curr.lat, gMap.curr.lng),
        title: gMap.curr.title,
        map: gMap.map
    });

    gMap.info.bounds.extend(gMap.curr.position);

    google.maps.event.addListener(gMap.curr, 'click', function() {
        console.log("Marker");

        gMap.info.infowindow.setContent(gMap.curr.title);
        gMap.info.infowindow.open(gMap.map, gMap.curr);
    });

    gMap.map.fitBounds(gMap.info.bounds);
    var listener = google.maps.event.addListener(gMap.map, "idle", function() {
        if (gMap.map.getZoom() > 16) gMap.map.setZoom(16);
        google.maps.event.removeListener(listener);
    });
}
