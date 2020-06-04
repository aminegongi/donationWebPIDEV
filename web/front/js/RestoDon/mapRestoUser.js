var fb = window.document.getElementById('fb');
var web = window.document.getElementById('web');
var card = document.getElementById('left');
var classes = card.className.split(' ');
var collapsed = classes.indexOf('collapsed') === 3;
var idDiv= 1;



mapboxgl.accessToken = 'pk.eyJ1Ijoic2FmcmF0aXgiLCJhIjoiY2s4dGppaTl1MDB0bTNpcnp3MWRuZTd3MSJ9.4N2a8yFjGEvHPuAjmOV03w';
mapboxgl.setRTLTextPlugin(
    'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js',
    null,
    true // Lazy load the plugin
);

var geojson = allRestoJSON;
geojson = JSON.parse(geojson);



var map = new mapboxgl.Map({
    container: 'map', // container id
    style: 'mapbox://styles/safratix/ck9d001o20cki1ipi02gw2qcm', // stylesheet location
    center: [10.183825, 36.816298], // starting position [lng, lat]
    pitch: 60, // pitch in degrees
    bearing: -11.23, // bearing in degrees
    zoom: 17 // starting zoom
});

// Add geolocate control to the map.
map.addControl(
    new mapboxgl.GeolocateControl({
        positionOptions: {
            enableHighAccuracy: true,
            timeout:6000
        },
        trackUserLocation: true,
        showAccuracyCircle: false,
        showUserLocation: true

    })
);

var lastClicked = "donations";

geojson.features.forEach(function(marker) {
// create a DOM element for the marker
    var el = document.createElement('div');
    el.className = 'marker';
    el.style.backgroundImage =
        'url(/uploads/UserImg/' + marker.properties.icon + '/)';
    el.style.width = '50px';
    el.style.height = '50px';
    el.style.backgroundSize= 'cover';
    el.style.cursor = 'pointer';
    el.id = idDiv++;

    // card.setAttribute("name", marker.properties.fb);


    el.addEventListener('click', function() {
        // window.alert(marker.properties.fb);
        fb.src = marker.properties.fb;
        web.src = marker.properties.web;

        if (lastClicked === "donations"){
            toggleSidebar('left');
            map.flyTo({
                center: marker.geometry.coordinates,
                speed: 0.2
            });
            lastClicked = el.id;
            centred = el.id;
        }else{
            if ( lastClicked === el.id ){
            toggleSidebar('left');
            map.flyTo({
                center: marker.geometry.coordinates,
                speed: 0.2
            });
                lastClicked = el.id;
                centred = el.id;
            } else {
                if (card.getAttribute("name") === "collapsed"){
                    toggleSidebar('left');
                    map.flyTo({
                        center: marker.geometry.coordinates,
                        speed: 0.2
                    });
                    lastClicked = el.id;
                    centred = el.id;
                } else{
                map.flyTo({
                    center: marker.geometry.coordinates,
                    speed: 0.2
                });
                lastClicked = el.id;
                centred = el.id;
                }
            }
        }


        fb.addEventListener('click', function() {
            var win = window.open(fb.src, '_blank');
            win.focus();
        });

        web.addEventListener('click', function() {
            var win = window.open(web.src, '_blank');
            win.focus();
        });
        // var win = window.open(marker.properties.web, '_blank');
        // win.focus();
    });

    el.addEventListener('mouseover', function() {
        el.style.width = '60px';
        el.style.height = '60px';
    });

    el.addEventListener('mouseout', function() {
        el.style.width = '50px';
        el.style.height = '50px';
    });

// add marker to map
    new mapboxgl.Marker(el)
        .setLngLat(marker.geometry.coordinates)
        .addTo(map);

});


function toggleSidebar(id) {
    var elem = document.getElementById(id);
    var classes = elem.className.split(' ');
    var collapsed = classes.indexOf('collapsed') !== -1;

    var padding = {};

    if (collapsed) {
        elem.setAttribute("name", "notCollapsed");
// Remove the 'collapsed' class from the class list of the element, this sets it back to the expanded state.
        classes.splice(classes.indexOf('collapsed'), 1);

        padding[id] = 600; // In px, matches the width of the sidebars set in .sidebar CSS class
        map.easeTo({
            padding: padding,
            duration: 1000 // In ms, CSS transition duration property for the sidebar matches this value
        });
    } else {
        elem.setAttribute("name", "collapsed");
        padding[id] = 0;
// Add the 'collapsed' class to the class list of the element
        classes.push('collapsed');

        map.easeTo({
            padding: padding,
            duration: 1000
        });
    }

// Update the class list on the element
    elem.className = classes.join(' ');
}

// map.on('load', function() {
//     toggleSidebar('left');
// });



