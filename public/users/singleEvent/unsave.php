<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Single Event Saved';
if(!isset($_GET['id'])) {
  redirect_to(url_for('/users/allEvents.php'));
}
$id = $_GET['id'] ;
$sql = "DELETE FROM users.SavedEvents WHERE SavedEventID='" . $id . "'";
$sql .= "AND StudentID='" . $_SESSION['id'] . "'";
$result = mysqli_query($db, $sql);

if ($result){
  redirect_to(url_for('/users/singleEvent/info.php?id=' . $id));
}else {
  // UPDATE failed
  echo mysqli_error($db);
}

?>
