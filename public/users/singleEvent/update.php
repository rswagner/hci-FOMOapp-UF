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

if(is_post_request()) {
  if ($_FILES["fileToUpload"]["name"]){
    $target_dir = "../profile/uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      // Check if image file is a actual image or fake image
      if(isset($_POST["submit"])) {
          $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
          if($check !== false) {
              $uploadOk = 1;
          } else {
              $uploadOk = 0;
              $message = "File is not an image.";
              echo "<script type='text/javascript'>alert('$message');</script>";
          }
      }
      // Check if file already exists
      if (file_exists($target_file)) {
          $message = "Sorry, file already exists.";
          echo "<script type='text/javascript'>alert('$message');</script>";
          $uploadOk = 0;
      }
      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 5000000) {
          $message = "Sorry, your file is too large.";
          echo "<script type='text/javascript'>alert('$message');</script>";
          $uploadOk = 0;
      }
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
          $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          echo "<script type='text/javascript'>alert('$message');</script>";
          $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          $message = "Sorry, your file was not uploaded.";
          echo "<script type='text/javascript'>alert('$message');</script>";
      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

            $event['EventName'] = $_POST['eventName'] ?? '';
            $event['Location'] = $_POST['location'] ?? '';
            $event['Date'] = $_POST['date'] ?? '';
            $event['StartTime'] = $_POST['startTime'] ?? '';
            $event['EndTime'] = $_POST['endTime'] ?? '';
            $event['Description'] = $_POST['description'] ?? '';
            $event['Latitude'] = $_POST['lat'] ?? '';
            $event['Longitude'] = $_POST['long'] ?? '';
            $event['EventPic'] = $target_file;


            $sql = "UPDATE users.Events SET ";
            $sql .= "EventName='" . mysql_real_escape_string($event['EventName']) . "', ";
            $sql .= "Location='" . mysql_real_escape_string($event['Location']) . "', ";
            $sql .= "Date='" . $event['Date'] . "', ";
            $sql .= "StartTime='" . $event['StartTime'] . "', ";
            $sql .= "EndTime='" . $event['EndTime'] . "', ";
            $sql .= "Description='" . mysql_real_escape_string($event['Description']) . "', ";
            $sql .= "Longitude='" . $event['Longitude'] . "', ";
            $sql .= "Latitude='" . $event['Latitude'] . "', ";
            $sql .= "EventPic='" . $event['EventPic'] . "' ";
            $sql .= "WHERE EventID='" . $id . "' ";
            $sql .= "LIMIT 1";

            $result = mysqli_query($db, $sql);
            if ($result){
              redirect_to(url_for('/users/singleEvent/info.php?id=' . $id));
            }else {
              // UPDATE failed
              echo mysqli_error($db);
            }

          } else {
              echo "Sorry, there was an error uploading your file.";
        }
    }
  } else {
    $event['EventName'] = $_POST['eventName'] ?? '';
    $event['Location'] = $_POST['location'] ?? '';
    $event['Date'] = $_POST['date'] ?? '';
    $event['StartTime'] = $_POST['startTime'] ?? '';
    $event['EndTime'] = $_POST['endTime'] ?? '';
    $event['Description'] = $_POST['description'] ?? '';
    $event['Latitude'] = $_POST['lat'] ?? '';
    $event['Longitude'] = $_POST['long'] ?? '';


    $sql = "UPDATE users.Events SET ";
    $sql .= "EventName='" . mysqli_real_escape_string($db, $event['EventName']) . "', ";
    $sql .= "Location='" . mysqli_real_escape_string($db, $event['Location']) . "', ";
    $sql .= "Date='" . $event['Date'] . "', ";
    $sql .= "StartTime='" . $event['StartTime'] . "', ";
    $sql .= "EndTime='" . $event['EndTime'] . "', ";
    $sql .= "Description='" . mysqli_real_escape_string($db, $event['Description']) . "', ";
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

<form action="<?php echo url_for('/users/singleEvent/update.php?id=' . $id);?>" method="post" enctype="multipart/form-data">
  Event Name:<br />
  <input type="text" name="eventName" value="<?php echo $event['EventName']; ?>" /><br/>
  Select Event Picture:<br/>
  <input type="file" name= "fileToUpload" id="fileToUpload"><br/>
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
