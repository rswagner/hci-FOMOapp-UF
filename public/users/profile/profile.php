<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Profile';

if ($_SESSION['type'] == "student"){
  $sql = "SELECT * FROM users.Events WHERE EventID IN";
  $sql .= "(SELECT SavedEventID FROM users.SavedEvents WHERE ";
  $sql .= "StudentID = '" . $_SESSION['id'] . "')";
  $savedEvents_set = mysqli_query($db, $sql);

  $sql = "SELECT TagName FROM users.Tags WHERE TagID IN";
  $sql .= "(SELECT TagID FROM users.UserTags WHERE ";
  $sql .= "StudentID = '" . $_SESSION['id'] . "')";
  $userTags_set = mysqli_query($db, $sql);
}else {
  $sql = "SELECT OrganizationDescription FROM users.Organizations WHERE ";
  $sql .= "OrganizationID = '" . $_SESSION['id'] . "'";
  $organizationInfo_set = mysqli_query($db, $sql);

  $organizationInfo = mysqli_fetch_assoc($organizationInfo_set);
  mysqli_free_result($organizationInfo_set);
}

?>

<?php include(SHARED_PATH . '/user_header.php'); ?>
  <body>
  <h1><?php echo $_SESSION['name'] ?? ''; ?> Profile</h1>
    <?php if ($_SESSION['type'] == 'student'){ ?>
    <table>
	  <th>Your Saved Events</th>
      <tr>
        <th>Name</th>
        <th>&nbsp;</th>
      </tr>
      <?php while($savedEvent = mysqli_fetch_assoc($savedEvents_set)){ ?>
      <tr>
        <td><?php echo $savedEvent['EventName'] ?></td>
        <!-- Dynamically go through a for loop and echo the id in the url! -->
        <td><a href="<?php echo url_for('/users/singleEvent/info.php?id=' . $savedEvent['EventID']);?>">View</a></td>
      </tr>
    <?php } ?>
    </table>
    <?php
      mysqli_free_result($savedEvents_set);
    ?>
    <h3>My Tags</h3>
    <a href="<?php echo url_for('/users/profile/editTags.php');?>">Edit Tags</a>
    <ul>
      <?php while($userTag = mysqli_fetch_assoc($userTags_set)){ ?>
      <li> <?php echo $userTag['TagName']; ?> </li>
      <?php }?>
    </ul>
  <?php }else { ?>
    <h3>Description</h3>
    <p><?php echo $organizationInfo['OrganizationDescription']; ?></p>
  <?php } ?>
  </body>
</html>
