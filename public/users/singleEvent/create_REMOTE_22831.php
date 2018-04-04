<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Create New Event';

if (is_post_request()){
  $event;
  $event['EventName'] = $_POST['eventName'] ?? '';
  $event['Location'] = $_POST['location'] ?? '';
  $event['Date'] = $_POST['date'] ?? '';
  $event['StartTime'] = $_POST['startTime'] ?? '';
  $event['EndTime'] = $_POST['endTime'] ?? '';
  $event['Description'] = $_POST['description'] ?? '';
  $event['OrganizationID'] = $_SESSION['id'] ?? '';
  $event['Latitude'] = $_POST['lat'] ?? '';
  $event['Longitude'] = $_POST['long'] ?? '';
  $event['EventPic'] = 'uploads/default.jpg' ?? '';
	
  $sql = "INSERT INTO users.Events";
  $sql .= "(OrganizationID, Location, Date, StartTime, EndTime, Description, EventName, Longitude, Latitude) ";
  $sql .= "VALUES (";
  $sql .= "'" . $event['OrganizationID'] . "',";
  $sql .= "'" . $event['Location'] . "',";	
  $sql .= "'" . $event['Date'] . "',";
  $sql .= "'" . $event['StartTime'] . "',";
  $sql .= "'" . $event['EndTime'] . "',";
  $sql .= "'" . $event['Description'] . "',";
  $sql .= "'" . $event['EventName'] . "',";
  $sql .= "'" . $event['Longitude'] . "',";
  $sql .= "'" . $event['Latitude'] . "',";
  $sql .= "'" . $event['EventPic'] . "'";
  $sql .= ")";
  $result = mysqli_query($db, $sql);

  if ($result){
    redirect_to(url_for('/users/allEvents.php'));
  }else {
    // UPDATE failed
    echo mysqli_error($db);
  }
}

?>

<?php include(SHARED_PATH . '/user_header.php'); ?>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDSLycBJS9PbQbeqJzrik9q7JQa4blLq-U&libraries=places" type="text/javascript"></script>

<script type="text/javascript">
    function initialize() {
        var input = document.getElementById('searchTextField');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            document.getElementById('location').value = place.name;
            document.getElementById('cityLat').value = place.geometry.location.lat();
            document.getElementById('cityLng').value = place.geometry.location.lng();
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<form action="<?php echo url_for('/users/singleEvent/create.php');?>" method="post">
  Event Name:<br/>
  <input type="text" name="eventName"/><br/>
  Location:<br/>
  <input id="searchTextField" type="text" size="50" autocomplete="on" runat="server" /><br/>
  <input type="hidden" id="cityLat" name="lat" />
  <input type="hidden" id="cityLng" name="long" />
  <input type="hidden" id="location" name="location" />
  Date: (MM/DD/YYYY)<br />
  <input type="date" name="date"/><br/>
  Start Time:<br/>
  <input type="time" name="startTime"/><br/>
  End Time:<br/>
  <input type="time" name="endTime"/><br/>
  Description<br/>
  <textarea name="description" cols="40" rows="5"></textarea><br/>
  <input type="submit" name="submit" value="Submit"  />
</form>

</html>
