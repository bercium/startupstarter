<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 100% }
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzHB4KqT61iivsLlWPwyBO4Ww2ThUQw9g&sensor=false">
    </script>
    <script type="text/javascript">
      function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(48, 20),
          zoom: 4
        };
        var map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);

        var infowindow = new google.maps.InfoWindow();
        var geocoder = new google.maps.Geocoder();
        var marker, i;

        var locations = [
        <?php
          foreach($data AS $row){
            if($row['city']){
              echo "['{$row['city']}, {$row['country']}', '{$row['count']}'],";
            } else {
              echo "['{$row['country']}', '{$row['count']}'],";
            }
          }
        ?>
        ];

        for (i = 0; i < locations.length; i++) {

            geocoder.geocode( { 'address': locations[i][0] }, function(results, status) {
                //alert(status);
                if (status == google.maps.GeocoderStatus.OK) {

                    //alert(results[0].geometry.location);
                    marker = new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map
                    }); 

                    //google.maps.event.addListener(marker, 'mouseover', function() { infowindow.open(map, marker);});
                    //google.maps.event.addListener(marker, 'mouseout', function() { infowindow.close();});

                }
                else
                {
                    alert("some problem in geocode" + status);
                }
            }); 
        }

      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
    <div id="map-canvas"/>
  </body>
</html>