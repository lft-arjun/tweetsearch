function initMap() {
  var myLatLng = {lat: 28.0, lng: 84.0};
  var map = new google.maps.Map(document.getElementById('map'), {
    center: myLatLng,
    zoom: 3,
    styles: [{
      featureType: 'poi',
      stylers: [{ visibility: 'off' }]  // Turn off points of interest.
    }, {
      featureType: 'transit.station',
      stylers: [{ visibility: 'off' }]  // Turn off bus stations, train stations, etc.
    }],
    disableDoubleClickZoom: true
  });
  
  // Create a marker and set its position.
  var marker = new google.maps.Marker({
    map: map,
    position: myLatLng,
    title: 'Hello World!'
  });

  // map.addListener('click', function(e) {
  //   var marker = new google.maps.Marker({
  //     position: {lat: e.latLng.lat(), lng: e.latLng.lng()},
  //     map: map
  //   });
  // });

}