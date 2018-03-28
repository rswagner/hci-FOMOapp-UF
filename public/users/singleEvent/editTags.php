<?php require_once('../../../private/initialize.php'); ?>

<?php $page_title = 'Edit Tags';
  if(!isset($_GET['id'])) {
    redirect_to(url_for('/users/allEvents.php'));
  }
  $id = $_GET['id'] ;

  if (is_post_request()){
    $sql = "DELETE FROM users.EventTags WHERE EventID = '" . $id . "'";
    $result = mysqli_query($db, $sql);

    if ($result){
      foreach($_POST['checkTagList'] as $checkTagID) {
        $sql = "INSERT INTO users.EventTags";
        $sql .= "(TagID, EventID) ";
        $sql .= "VALUES (";
        $sql .= "'" . $checkTagID . "',";
        $sql .= "'" . $id . "'";
        $sql .= ")";
        $result = mysqli_query($db, $sql);

      }
      redirect_to(url_for('/users/singleEvent/info.php?id=' . $id));
    } else {
      // UPDATE failed
      echo mysqli_error($db);
    }

  }

  $sql = "SELECT users.Tags.*, users.EventTags.EventID = '" . $id . "' ";
  $sql .= "FROM users.Tags LEFT JOIN users.EventTags ";
  $sql .= "ON users.Tags.TagID=users.EventTags.TagID Order by users.Tags.TagName";
  $allTags_set = mysqli_query($db, $sql);

?>

<form action="<?php echo url_for('/users/singleEvent/editTags.php?id=' . $id)?>" method="post">
  <?php while ($tag = mysqli_fetch_assoc($allTags_set)) {
      if ($tag["users.EventTags.EventID = '" . $id . "'"]){?>
        <input type="checkbox" name="checkTagList[]" value="<?php echo $tag['TagID'];?>" checked="checked"><?php echo $tag['TagName']?><br>
<?php } else{ ?>
        <input type="checkbox" name="checkTagList[]" value="<?php echo $tag['TagID'];?>"><?php echo $tag['TagName']?><br>
<?php }
    }
  mysqli_free_result($allTags_set);?>
  <input type="submit" value="Submit">
</form>
