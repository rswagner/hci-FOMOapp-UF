<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Single Event Saved';

$id = $_POST['id'] ;
$sql = "DELETE FROM users.SavedEvents WHERE SavedEventID='" . $id . "'";
$sql .= "AND StudentID='" . $_SESSION['id'] . "'";
$result = mysqli_query($db, $sql);

echo "We unsaved it!";
?>
