<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'List of All Events';
if ($_SESSION['type'] == "student"){
  $sql = "SELECT * FROM users.Events ORDER BY EventName ASC";
}else{
  $sql = "SELECT * FROM users.Events WHERE OrganizationID = '" . $_SESSION['id'] . "' ORDER BY EventName ASC";
}
$event_set = mysqli_query($db, $sql);

if ($_SESSION['type'] == "student"){
  $sql = "SELECT * FROM users.Events where users.Events.EventID in ";
  $sql .= "(SELECT users.EventTags.EventID FROM users.EventTags WHERE users.EventTags.TagID  in ";
  $sql .= "(SELECT users.UserTags.TagID FROM users.UserTags WHERE users.UserTags.StudentID = '" . $_SESSION['id'] . "'))";
  $recommendEvent_set = mysqli_query($db, $sql);
}

?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

<script type="text/javascript">
  $(document).ready(function() {
    var allEventsText = "<tr><th>Name</th><th>Location</th><th>&nbsp;</th></tr>";
    <?php while($event = mysqli_fetch_assoc($event_set)){ ?>
    allEventsText += "<tr><td><?php echo $event['EventName'] ?></td>";
    allEventsText += "<td><?php echo $event['Location'] ?></td>";
    allEventsText += "<td><a href='<?php echo url_for('/users/singleEvent/info.php?id=' . $event['EventID']);?>'>View</a><td></tr>";
    <?php }
    mysqli_free_result($event_set); ?>
    $("#eventsData").html(allEventsText);

    <?php if ($_SESSION['type'] == "student"){?>
      var recommendText = "<tr><th>Name</th><th>Location</th><th>&nbsp;</th></tr>";
      <?php while($event = mysqli_fetch_assoc($recommendEvent_set)){ ?>
      recommendText += "<tr><td><?php echo $event['EventName'] ?></td>";
      recommendText += "<td><?php echo $event['Location'] ?></td>";
      recommendText += "<td><a href='<?php echo url_for('/users/singleEvent/info.php?id=' . $event['EventID']);?>'>View</a><td></tr>";
      <?php }
      mysqli_free_result($recommendEvent_set); ?>

      $("#recommend").click(function(){ $("#eventsData").html(recommendText); });

      $("#current").click(function(){ $("#eventsData").html(allEventsText); });
    <?php }?>
  });
  </script>

  <body>
    <?php if ($_SESSION['type'] == 'org'){?>
      <a href="<?php echo url_for('/users/singleEvent/create.php');?>">Create New Event</a>
    <?php }else{ ?>
      <button type="button" id="current">Current Events</button>
      <button type="button" id="recommend">Recommended Events</button>
    <?php }?>
    <table id="eventsData">
    </table>
  </body>
</html>
