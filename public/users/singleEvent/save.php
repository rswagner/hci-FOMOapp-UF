<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Single Event Saved';
if(!isset($_GET['id'])) {
  redirect_to(url_for('/users/allEvents.php'));
}
$id = $_GET['id'] ;
$sql = "INSERT INTO users.SavedEvents";
$sql .= "(SavedEventID, StudentID) ";
$sql .= "VALUES (";
$sql .= "'" . $id . "',";
$sql .= "'" . $_SESSION['id'] . "'";
$sql .= ")";
$result = mysqli_query($db, $sql);

if ($result){
  redirect_to(url_for('/users/singleEvent/info.php?id=' . $id . '&message=Saved'));
}else {
  // UPDATE failed
  echo mysqli_error($db);
}

?>
