<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Single Event Saved';
$id = $_POST['id'] ;
$sql = "INSERT INTO users.SavedEvents";
$sql .= "(SavedEventID, StudentID) ";
$sql .= "VALUES (";
$sql .= "'" . $id . "',";
$sql .= "'" . $_SESSION['id'] . "'";
$sql .= ")";
$result = mysqli_query($db, $sql);
echo "We saved it!";
?>