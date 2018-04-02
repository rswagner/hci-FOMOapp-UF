<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Single Event Update';
if(!isset($_GET['id'])) {
  redirect_to(url_for('/users/allEvents.php'));
}

$id = $_GET['id'] ;
if(is_get_request()) {

  $sql = "SELECT * FROM users.Events WHERE EventID='" . db_espace($db,$id) . "'";
  $single_event_set = mysqli_query($db, $sql);

  $event = mysqli_fetch_assoc($single_event_set);
  mysqli_free_result($single_event_set);
}else {
  $event['EventName'] = $_POST['eventName'] ?? '';
  $event['Location'] = $_POST['location'] ?? '';
  $event['Date'] = $_POST['date'] ?? '';
  $event['StartTime'] = $_POST['startTime'] ?? '';
  $event['EndTime'] = $_POST['endTime'] ?? '';
  $event['Description'] = $_POST['description'] ?? '';
  $event['Latitude'] = $_POST['lat'] ?? '';
  $event['Longitude'] = $_POST['long'] ?? '';

  $sql = "UPDATE users.Events SET ";
  $sql .= "EventName='" . $event['EventName'] . "', ";
  $sql .= "Location='" . $event['Location'] . "', ";
  $sql .= "Date='" . $event['Date'] . "', ";
  $sql .= "StartTime='" . $event['StartTime'] . "', ";
  $sql .= "EndTime='" . $event['EndTime'] . "', ";
  $sql .= "Description='" . $event['Description'] . "', ";
  $sql .= "Longitude='" . $event['Longitude'] . "', ";
  $sql .= "Latitude='" . $event['Latitude'] . "' ";
  $sql .= "WHERE EventID='" . $id . "' ";
  $sql .= "LIMIT 1";

  $result = mysqli_query($db, $sql);
  if ($result){
    redirect_to(url_for('/users/singleEvent/info.php?id=' . $id));
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

<form action="<?php echo url_for('/users/singleEvent/update.php?id=' . $id);?>" method="post">
  Event Name:<br />
  <input type="text" name="eventName" value="<?php echo $event['EventName']; ?>" /><br/>
  Location:<br/>
  <input id="searchTextField" type="text" size="50" autocomplete="on" runat="server" placeholder="<?php echo $event['Location']?>"/><br/>
  <input type="hidden" id="cityLat" name="lat" />
  <input type="hidden" id="cityLng" name="long" />
  <input type="hidden" id="location" name="location" />
  Date: (MM/DD/YYYY)<br />
  <input type="date" name="date" value="<?php echo $event['Date']; ?>" /><br/>
  Start Time:<br/>
  <input type="time" name="startTime" value="<?php echo $event['StartTime']; ?>" /><br/>
  End Time:<br/>
  <input type="time" name="endTime" value="<?php echo $event['EndTime']; ?>" /><br/>
  Description<br/>
  <textarea name="description" cols="40" rows="5"><?php echo $event['Description']; ?></textarea><br>
  <input type="submit" name="submit" value="Submit"  />
</form>

</html>
