<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Map';
  $sql = "SELECT * FROM users.Events";
  $eventCoors_set = mysqli_query($db, $sql);

  $i = 0;
  while($event = mysqli_fetch_assoc($eventCoors_set)){
    $eventCoors[$i]['longitude'] = floatval($event['Longitude']);
    $eventCoors[$i]['latitude'] = floatval($event['Latitude']);
    $eventCoors[$i]['name'] = $event['EventName'];
    $eventCoors[$i]['id'] = $event['EventID'];
    $eventCoors[$i]['url'] = url_for('/users/singleEvent/info.php?id=' . $event['EventID']);
    $eventCoors[$i]['location'] = $event['Location'];
    $eventCoors[$i]['date'] = date('m/d/Y', strtotime($event['Date']));
    $eventCoors[$i]['startTime'] = date('h:i a', strtotime($event['StartTime']));

    $i++;
  }

?>
<?php include(SHARED_PATH . '/user_header.php'); ?>
  </head>
  <body>
    <div id="map" style="height: 500px; width: 600px; margin: auto;"></div>
  </body>
  <script>
    var eventDetails = <?php echo json_encode($eventCoors); ?>;

    function initMap() {
      var myLatLng = {lat: 29.6478715, lng: -82.3510823};

      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: myLatLng
      });

      var markers = [];
      var infowindow = [];
      for (i in eventDetails) {
          var pos = {lat: eventDetails[i].latitude, lng: eventDetails[i].longitude};

          markers[i] = new google.maps.Marker({
              position: pos,
              map: map
          });
          var windowContent = "<a href='" + eventDetails[i].url + "'>" + eventDetails[i].name + "</a><br>";
          windowContent += eventDetails[i].location + "<br>" + eventDetails[i].date + " " + eventDetails[i].startTime;

          infowindow[i] = new google.maps.InfoWindow({
            content: windowContent
          });

          google.maps.event.addListener(markers[i], 'click', (function(marker, i) {
          return function() {
            infowindow[i].open(map, markers[i]);
          }
        })(markers[i], i));
      }
    }
  </script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSLycBJS9PbQbeqJzrik9q7JQa4blLq-U&callback=initMap">
  </script>
</html>