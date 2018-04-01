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

  $sql = "INSERT INTO users.Events";
  $sql .= "(OrganizationID, Location, Date, StartTime, EndTime, Description, EventName) ";
  $sql .= "VALUES (";
  $sql .= "'" . $event['OrganizationID'] . "',";
  $sql .= "'" . $event['Location'] . "',";
  $sql .= "'" . $event['Date'] . "',";
  $sql .= "'" . $event['StartTime'] . "',";
  $sql .= "'" . $event['EndTime'] . "',";
  $sql .= "'" . $event['Description'] . "',";
  $sql .= "'" . $event['EventName'] . "'";
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

<form action="<?php echo url_for('/users/singleEvent/create.php');?>" method="post">
  Event Name:<br/>
  <input type="text" name="eventName"/><br/>
  Location:<br/>
  <input type="text" name="location"/><br/>
  Date: (MM/DD/YYYY)<br />
  <input type="date" name="date"/><br/>
  Start Time:<br/>
  <input type="time" name="startTime"/><br/>
  End Time:<br/>
  <input type="time" name="endTime"/><br/>
  Description<br/>
  <textarea name="description" cols="40" rows="5"></textarea>
  <input type="submit" name="submit" value="Submit"  />
</form>

</html>
