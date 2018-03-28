<?php require_once('../../../private/initialize.php'); ?>

<?php $page_title = 'Edit Tags';

  if (is_post_request()){
    $sql = "DELETE FROM users.UserTags WHERE StudentID = '" . $_SESSION['id'] . "'";
    $result = mysqli_query($db, $sql);

    if ($result){
      foreach($_POST['checkTagList'] as $checkTagID) {
        $sql = "INSERT INTO users.UserTags";
        $sql .= "(TagID, StudentID) ";
        $sql .= "VALUES (";
        $sql .= "'" . $checkTagID . "',";
        $sql .= "'" . $_SESSION['id'] . "'";
        $sql .= ")";
        $result = mysqli_query($db, $sql);

      }
      redirect_to(url_for('/users/profile/profile.php'));

    } else {
      // UPDATE failed
      echo mysqli_error($db);
    }

  }

  $sql = "SELECT users.Tags.*, users.UserTags.StudentID = '" . $_SESSION['id'] . "' ";
  $sql .= "FROM users.Tags LEFT JOIN users.UserTags ";
  $sql .= "ON users.Tags.TagID=users.UserTags.TagID Order by users.Tags.TagName";
  $allTags_set = mysqli_query($db, $sql);

?>

<form action="<?php echo url_for('/users/profile/editTags.php')?>" method="post">
  <?php while ($tag = mysqli_fetch_assoc($allTags_set)) {
      if ($tag["users.UserTags.StudentID = '" . $_SESSION['id'] . "'"]){?>
        <input type="checkbox" name="checkTagList[]" value="<?php echo $tag['TagID'];?>" checked="checked"><?php echo $tag['TagName']?><br>
<?php } else{ ?>
        <input type="checkbox" name="checkTagList[]" value="<?php echo $tag['TagID'];?>"><?php echo $tag['TagName']?><br>
<?php }
    }
  mysqli_free_result($allTags_set);?>
  <input type="submit" value="Submit">
</form>
