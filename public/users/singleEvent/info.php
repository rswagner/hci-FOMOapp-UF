<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Single Event';
if(!isset($_GET['id'])) {
  redirect_to(url_for('/users/info.php'));
}
  $id = $_GET['id'];
  $message = $_GET['message'] ?? 'unsaved';

  $sql = "SELECT * FROM users.Events WHERE EventID='" . db_espace($db,$id) . "'";
  $single_event_set = mysqli_query($db, $sql);

  $event = mysqli_fetch_assoc($single_event_set);
  mysqli_free_result($single_event_set);

  $sql = "SELECT * FROM users.Organizations WHERE OrganizationID='" . $event['OrganizationID'] . "'";
  $org_of_event_set = mysqli_query($db, $sql);

  $org_of_event = mysqli_fetch_assoc($org_of_event_set);
  mysqli_free_result($org_of_event_set);
?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

  <div>
    <h2><?php echo $event['EventName']; ?></h2>
    <h3>By <?php echo  $org_of_event['OrganizationName']?></h3>
    <h4><?php echo $event['Location']; ?></h4>
    <h4><?php echo $event['Time']; ?></h4>
    <p><?php echo $event['Description']; ?></p>
    <?php if ($_SESSION['type'] == 'org'){?>
      <a href="<?php echo url_for('/users/singleEvent/update.php?id=' . $event['EventID']);?>">Update</a>
      <a href="<?php echo url_for('/users/singleEvent/delete.php?id=' . $event['EventID']);?>" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
    <?php
    } else {
      if ($message == 'Saved'){
        ?>
        <a href="<?php echo url_for('/users/singleEvent/unsave.php?id=' . $event['EventID']);?>">Unsave Event</a>
    <?php
      } else { ?>
        <a href="<?php echo url_for('/users/singleEvent/save.php?id=' . $event['EventID']);?>">Save Event</a>
  <?php
    }
  } ?>
  </div>
</html>
