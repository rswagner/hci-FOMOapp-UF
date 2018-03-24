<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'List of All Events';
if ($_SESSION['type'] == "student"){
  $sql = "SELECT * FROM users.Events ORDER BY EventName ASC";
}else{
  $sql = "SELECT * FROM users.Events WHERE OrganizationID = '" . $_SESSION['id'] . "' ORDER BY EventName ASC";
}
$event_set = mysqli_query($db, $sql);

?>
<?php include(SHARED_PATH . '/user_header.php') ?>
<!doctype html>

  <body>
    <?php if ($_SESSION['type'] == 'org'){?>
      <a href="<?php echo url_for('/users/singleEvent/create.php');?>">Create New Event</a>
    <?php } ?>
    <table>
      <tr>
        <th>Name</th>
        <th>Location</th>
        <th>&nbsp;</th>
      </tr>
      <?php while($event = mysqli_fetch_assoc($event_set)){ ?>
      <tr>
        <td><?php echo $event['EventName'] ?></td>
        <td><?php echo $event['Location'] ?></td>
        <!-- Dynamically go through a for loop and echo the id in the url! -->
        <td><a href="<?php echo url_for('/users/singleEvent/info.php?id=' . $event['EventID']);?>">View</a><td>
      </tr>
    <?php } ?>
    </table>
    <?php
      mysqli_free_result($event_set);
    ?>
  </body>
</html>
