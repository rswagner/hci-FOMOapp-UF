<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Create New Event';

if (is_post_request()){
  $event;
  $event['EventName'] = $_POST['eventName'] ?? '';
  $event['Location'] = $_POST['location'] ?? '';
  $event['Time'] = $_POST['dateTime'] ?? '';
  $event['Description'] = $_POST['description'] ?? '';
  $event['OrganizationID'] = $_SESSION['id'] ?? '';

  $sql = "INSERT INTO users.Events";
  $sql .= "(OrganizationID, Location, Time, Description, EventName) ";
  $sql .= "VALUES (";
  $sql .= "'" . $event['OrganizationID'] . "',";
  $sql .= "'" . $event['Location'] . "',";
  $sql .= "'" . $event['Time'] . "',";
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
  Event Name:<br />
  <input type="text" name="eventName"/><br/>
  Location:<br/>
  <input type="text" name="location"/><br/>
  Date: (MM/DD/YYYY)<br />
  <input type="datetime-local" name="dateTime"/><br/>
  Description<br/>
  <textarea name="description" cols="40" rows="5"></textarea>
  <input type="submit" name="submit" value="Submit"  />
</form>

</html>