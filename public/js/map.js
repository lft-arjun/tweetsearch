// The following example creates complex markers to indicate beaches near
      // Sydney, NSW, Australia. Note that the anchor is set to (0,32) to correspond
      // to the base of the flagpole.
$(document).ready(function() {
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>}
        });

        setMarkers(map);
      }
      var beaches = <?php echo json_encode($twitterData) ?>;
      
      function setMarkers(map) {
   
        // Display multiple markers on a map
      var infoWindow = new google.maps.InfoWindow(), marker, i, beach;

        for (i = 0; i < beaches.length; i++) {
          beach = beaches[i];
    var image = {
          url: beach[4],
          // This marker is 20 pixels wide by 32 pixels high.
          size: new google.maps.Size(20, 32),
          // The origin for this image is (0, 0).
          origin: new google.maps.Point(0, 0),
          // The anchor for this image is the base of the flagpole at (0, 32).
          anchor: new google.maps.Point(0, 32)
        };
        // Shapes define the clickable region of the icon. The type defines an HTML
        // <area> element 'poly' which traces out a polygon as a series of X,Y points.
        // The final coordinate closes the poly by connecting to the first coordinate.
        var shape = {
          coords: [1, 1, 1, 20, 18, 20, 18, 1],
          type: 'poly'
        };

           
           marker = new google.maps.Marker({
            position: {lat: beach[1], lng: beach[2]},
            map: map,
           icon: image,
          shape: shape,
            title: beach[0],
            zIndex: beach[3]
          })


      
           // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              console.log(beaches[i][5])
                infoWindow.setContent(beaches[i][5]);
                infoWindow.open(map, marker);
            }
        })(marker, i));


        }

      }
    });