@extends('layouts.master')

@section('title', 'Page Title')
@section('content')
<div class="row">
	<div class="col-sm-12 tweets-page">
		<h3 class="text-center">TWEET ABOUT <?php echo strtoupper($city); ?></h3>
    	<div id="map"></div>
	    	<form method="get" action="/tweets">
	    	<div class="search-form">
				<div class="form-group col-xs-12 col-sm-8 col-md-9 col-lg-10 no-h-padding">
					<input type="text" name="search" class="form-control" placeholder="Search Tweets By City"/>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 no-h-padding">
					<button type="submit" class="btn btn-primary">Search</button>
					<button type="submit" class="btn btn-primary">History</button>
				</div>
				</div>
			</form>
    </div>

</div>
<script>
    var lats=<?php echo $lat; ?>;
    var longs = <?php echo $long; ?>;
    var beaches = <?php echo json_encode($twitterData) ?>;
      // The following example creates complex markers to indicate beaches near
      // Sydney, NSW, Australia. Note that the anchor is set to (0,32) to correspond
      // to the base of the flagpole.
      // 
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {lat: lats , lng: longs }
        });
        setMarkers(map);
      }
      /**
       * Set marker
       * @param {[type]} map [description]
       */
      function setMarkers(map) {
   
        // Display multiple markers on a map
    	var infoWindow = new google.maps.InfoWindow(), marker, i, beach;

        for (i = 0; i < beaches.length; i++) {
        	beach = beaches[i];
			var image = {
				url: beach[4],
				// This marker is 20 pixels wide by 32 pixels high.
				size: new google.maps.Size(80, 80),
				// The origin for this image is (0, 0).
				origin: new google.maps.Point(0, 0),
				// The anchor for this image is the base of the flagpole at (0, 32).
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(71, 71)
	        };
	        // Shapes define the clickable region of the icon. The type defines an HTML
	        // <area> element 'poly' which traces out a polygon as a series of X,Y points.
	        // The final coordinate closes the poly by connecting to the first coordinate.
	        // var shape = {
	        //   coords: [1, 1, 1, 20, 18, 20, 18, 1],
	        //   type: 'poly'
	        // };
	        var shape = {
	          coords: [beach[1], beach[2], 50000],
	          type: 'circle'
	        };
	
           
			marker = new google.maps.Marker({
				position: {lat: beach[1], lng: beach[2]},
				map: map,
				icon: image,
				title: beach[0],
				zIndex: beach[3],
				shape: shape,
				// animation:google.maps.Animation.BOUNCE
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
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBd84SRSI_zX3M86W7SXWhf4KL8pS0NFdU&callback=initMap">
    </script>
    
@endsection