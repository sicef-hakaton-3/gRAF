$(document).ready(function () {
    gMap = {
        map: null,
        markers: [],
        places: [],
        days: [],
        directionsService: null,
        directionsDisplay: null,
        stepDisplay: null
    };
    $.getJSON(location.href.replace('/days', '/api/days'), function (d){
        gMap.days = d;
        var firstKey;
        for (firstKey in gMap.days.days) break;

        var locations = [];
        for (var i = 0; i < gMap.days.days[firstKey].length; i++) {
            locations[i] = {
                "name": gMap.days.days[firstKey][i].name,
                "lat": gMap.days.days[firstKey][i].lat,
                "lng": gMap.days.days[firstKey][i].lng
            };
        }

        pins(gMap, locations);

        $('.markersOnTimeline').on('click', function(){
            var firstKey = $(this).data('time');

            var locations = [];
            for (var i = 0; i < gMap.days.days[firstKey].length; i++) {
                locations[i] = {
                    "name": gMap.days.days[firstKey][i].name,
                    "lat": gMap.days.days[firstKey][i].lat,
                    "lng": gMap.days.days[firstKey][i].lng
                };
            }
            pins(gMap, locations);
        });
    });

    initMap(gMap);

});


function initMap(gMap) {
    var mapDiv = document.getElementById(mapID);

    gMap.map = new google.maps.Map(mapDiv, {
        center: {
            lat: lat,
            lng: lng
        },
        zoom: 8
    });

}


function pins(gMap, locations) {

    if (gMap.directionsDisplay != null && gMap.directionsDisplay != undefined) {

        gMap.directionsDisplay.setMap();
    }

    for (var i = 0; i < gMap.markers.length; i++) {
        gMap.markers[i].setMap(null);

    }
    gMap.markers = [];


    gMap.directionsService = new google.maps.DirectionsService;
    gMap.directionsDisplay = new google.maps.DirectionsRenderer({map: gMap.map});
    gMap.stepDisplay = new google.maps.InfoWindow;

    var bounds = new google.maps.LatLngBounds();

    for (var i = 0; i < locations.length; i++) {

        gMap.markers.push(new google.maps.Marker({
            position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
            map: gMap.map
        }));

        //extend the bounds to include each marker's position
        bounds.extend(gMap.markers[i].position);

        google.maps.event.addListener(gMap.markers[i], 'click', (function(i) {
            return function() {
                infowindow.setContent(locations[i].name);
                infowindow.open(gMap.map, gMap.markers[i]);
            }
        })(i));

    }

    calculateAndDisplayRoute(
        gMap.directionsDisplay, gMap.directionsService,
        gMap.markers, gMap.stepDisplay, gMap.map
    );


    gMap.map.fitBounds(bounds);
}

function calculateAndDisplayRoute(directionsDisplay, directionsService,
                                  markerArray, stepDisplay, map) {
    // First, remove any existing markers from the map.
    for (var i = 0; i < markerArray.length; i++) {
        markerArray[i].setMap(null);
    }

    // Retrieve the start and end locations and create a DirectionsRequest using
    // WALKING directions.
    directionsService.route({
        origin: markerArray[0].position,
        destination: markerArray[markerArray.length - 1].position,
        travelMode: 'WALKING'
    }, function(response, status) {
        // Route the directions and pass the response to a function to create
        // markers for each step.
        if (status === 'OK') {
            directionsDisplay.setDirections(response);

            showSteps(response, markerArray, map);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
}

function showSteps(directionResult, markerArray, stepDisplay, map) {

    // For each step, place a marker, and add the text to the marker's infowindow.
    // Also attach the marker to an array so we can keep track of it and remove it
    // when calculating new routes.
    var myRoute = directionResult.routes[0].legs[0];
    for (var i = 0; i < myRoute.steps.length; i++) {
        var marker = markerArray[i] = markerArray[i] || new google.maps.Marker;
        marker.setMap(map);
        marker.setPosition(myRoute.steps[i].start_location);
        attachInstructionText(
            stepDisplay, marker, myRoute.steps[i].instructions, map);
    }
}

function attachInstructionText(stepDisplay, marker, text, map) {
    google.maps.event.addListener(marker, 'click', function() {
        // Open an info window when the marker is clicked on, containing the text
        // of the step.
        stepDisplay.setContent(text);
        stepDisplay.open(map, marker);
    });
}
