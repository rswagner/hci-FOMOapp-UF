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
  $event['Time'] = $_POST['dateTime'] ?? '';
  $event['Description'] = $_POST['description'] ?? '';

  $sql = "UPDATE users.Events SET ";
  $sql .= "EventName='" . $event['EventName'] . "', ";
  $sql .= "Location='" . $event['Location'] . "', ";
  $sql .= "Time='" . $event['Time'] . "', ";
  $sql .= "Description='" . $event['Description'] . "' ";
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

<form action="<?php echo url_for('/users/singleEvent/update.php?id=' . $id);?>" method="post">
  Event Name:<br />
  <input type="text" name="eventName" value="<?php echo $event['EventName']; ?>" /><br/>
  Location:<br/>
  <input type="text" name="location" value="<?php echo $event['Location']; ?>" /><br/>
  Date: (MM/DD/YYYY)<br />
  <input type="datetime-local" name="dateTime" value="2018-06-01T08:30" /><br/>
  Description<br/>
  <textarea name="description" cols="40" rows="5"><?php echo $event['Description']; ?></textarea>
  <input type="submit" name="submit" value="Submit"  />
</form>

</html>
