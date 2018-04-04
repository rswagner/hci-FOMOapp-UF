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

<<<<<<< HEAD
<title>Create View</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script type="text/javascript" src="<?=WWW_ROOT?>/javascript/createEvent.js"></script>
<link rel="stylesheet" href="<?=WWW_ROOT?>/css/create.css">
=======
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
>>>>>>> 35c2ae1aa86711946f80093f362d845e02e6b104

</script>
<h1>CREATE A NEW EVENT</h1>
  <div class="page-content">

    <div class="row">
    <form class="col s12"action="<?php echo url_for('/users/singleEvent/create.php');?>" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="input-field col s6">
          <input id="eventName" type="text" class="validate">
          <label for="eventName">Name of the Event</label>
        </div>
        <div class="input-field col s6">
          <div class="file-field input-field">
            <div class="btn">
              <span>Select Picture</span>
                <input type="file" name= "fileToUpload" style="margin-bottom:20px;border-bottom:.990px">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <input id="searchTextField" type="text" size="50" autocomplete="on" runat="server" /><br/>
          <input type="hidden" id="cityLat" name="lat" />
          <input type="hidden" id="cityLng" name="long" />
          <input type="hidden" id="location" name="location" />
        </div>
        <div class="input-field col s6">
          <input name="date" type="text" class="datepicker">
          <label for="date">Date</label>
        </div>
        </div>
        <div class="row">
          <div class="input-field col s6">
            <input name="startTime" type="text" class="timepicker" >
            <label for="startTime">Start Time</label>
          </div>
          <div class="input-field col s6">
            <input name="endTime" type="text" class="timepicker" >
            <label for="endtime">End Time</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <textarea id="textarea1" class="materialize-textarea" data-length="200"></textarea>
            <label for="textarea1">Event Description</label>
          </div>
        </div>
          <button class="btn waves-effect waves-light" type="submit" name="action" id="submit">Submit
            <i class="material-icons right">send</i>
          </button>
        </form>
    </form>
  </div>
  </div>
<footer>
    <div class="footer-bar">
        <center>
            <a href="https://www.studentinvolvement.ufl.edu/Student-Organizations"><img src="<?=WWW_ROOT?>/images/soar.png" alt="SOAR" style="height: 30px; margin: 10px"></a>
        </center>
    </div>
</footer>
</html>
