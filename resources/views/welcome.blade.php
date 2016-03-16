<!DOCTYPE html>
<html>
  <head>
    <style type="text/css">
      html, body { height: 100%; margin: 0; padding: 0; }
      #map { height: 100%; }
    </style>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  </head>
  <body>
    <?php echo @$_SERVER['HTTP_CLIENT_IP']; ?>
    <div id="map"></div>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBd84SRSI_zX3M86W7SXWhf4KL8pS0NFdU
        &libraries=visualization&callback=initMap">
    </script>
    <script type="text/javascript" src="{{ URL::asset('js/map.js') }}"></script>
  </body>
</html>