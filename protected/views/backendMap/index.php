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
      var LocationData = [
        <?php foreach($data AS $row){
          echo "[{$row['lat']}, {$row['lng']}, '{$row['name']} ({$row['count']})'], ";
        } ?>
          
      ];
       
      function initialize()
      {
          var map = 
              new google.maps.Map(document.getElementById('map-canvas'));
          var bounds = new google.maps.LatLngBounds();
          var infowindow = new google.maps.InfoWindow();
           
          for (var i in LocationData)
          {
              var p = LocationData[i];
              var latlng = new google.maps.LatLng(p[0], p[1]);
              bounds.extend(latlng);
               
              var marker = new google.maps.Marker({
                  position: latlng,
                  map: map,
                  //animation: google.maps.Animation.DROP,
                  title: p[2]
              });
           
              google.maps.event.addListener(marker, 'click', function() {
                  infowindow.setContent(this.title);
                  infowindow.open(map, this);
              });
          }
          
          
          /*for (var i in CountryData)
          {
              var p = CountryData[i];
              var latlng = new google.maps.LatLng(p[0], p[1]);
              bounds.extend(latlng);
               
              var marker = new google.maps.Marker({
                  position: latlng,
                  map: map,
                  //animation: google.maps.Animation.DROP,
                  icon:'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                  title: p[2]
              });
           
              google.maps.event.addListener(marker, 'click', function() {
                  infowindow.setContent(this.title);
                  infowindow.open(map, this);
              });
          }*/
           
          map.fitBounds(bounds);
      }
       
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
    <div id="map-canvas"/>
  </body>
</html>