<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Single Event';
if(!isset($_GET['id'])) {
  redirect_to(url_for('/users/allEvents.php'));
}
  $id = $_GET['id'];

  $sql = "SELECT users.Events.*, users.Organizations.OrganizationName FROM users.Events ";
  $sql .= "INNER JOIN users.Organizations ON users.Events.OrganizationID = users.Organizations.OrganizationID ";
  $sql .= "WHERE EventID ='" . $id . "'";
  $single_event_set = mysqli_query($db, $sql);
  $event = mysqli_fetch_assoc($single_event_set);
  mysqli_free_result($single_event_set);

  $sql = "SELECT * FROM users.SavedEvents WHERE SavedEventID='" . $id . "'";
  $sql .= "AND StudentID='" . $_SESSION['id'] . "'";
  $saved_event_set = mysqli_query($db, $sql);

  $saved_event = mysqli_fetch_assoc($saved_event_set);
  mysqli_free_result($saved_event_set);

  $sql = "SELECT TagName FROM users.Tags WHERE TagID IN";
  $sql .= "(SELECT TagID FROM users.EventTags WHERE ";
  $sql .= "EventID = '" . $id . "')";
  $eventTags_set = mysqli_query($db, $sql);
?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

<head>
    <meta charset="utf-8">
    <title>Single Event View</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?=WWW_ROOT?>/css/info.css">
</head>
  <script type="text/javascript">
    $(document).ready(function() {
      <?php if ($saved_event){ ?>
        $("#saveEvent").html("Unsave Event")
      <?php } else { ?>
        $("#saveEvent").html("Save Event")
      <?php }?>
      $("#saveEvent").click(function(){
        if ($("#saveEvent").html() == "Unsave Event"){
          $.ajax({
              url: "<?php echo url_for('/users/singleEvent/unsave.php');?>",
              type: "POST",
              data: {
                id: <?php echo $id; ?>
              },
              success: function(data){
                $("#saveEvent").html("Save Event")
              }
          });
        }else {
          $.ajax({
              url: "<?php echo url_for('/users/singleEvent/save.php');?>",
              type: "POST",
              data: {
                id: <?php echo $id; ?>
              },
              success: function(){
                $("#saveEvent").html("Unsave Event")
              }
          });
        }
      });
    });
  </script>

  <div>
    <h2><?php echo $event['EventName']; ?></h2>
    <h3>By <?php echo  $event['OrganizationName']?></h3>
    <h4><?php echo $event['Location']; ?></h4>
    <h4><?php echo date('m/d/Y', strtotime($event['Date'])); ?></h4>
    <h4><?php echo date('h:i a', strtotime($event['StartTime'])); ?> - <?php echo date('h:i a', strtotime($event['EndTime'])); ?></h4>
    <p><?php echo $event['Description']; ?></p>
    <h3>Event Tags</h3>
    <?php if ($_SESSION['type'] == 'org'){?>
      <a href="<?php echo url_for('/users/singleEvent/editEventTags.php?id=' . $event['EventID']);?>">Edit Tags</a>
    <?php } ?>
    <ul>
      <?php while($eventTag = mysqli_fetch_assoc($eventTags_set)){ ?>
      <li> <?php echo $eventTag['TagName']; ?> </li>
      <?php }
      mysqli_free_result($eventTags_set);?>
    </ul>
    <?php if ($_SESSION['type'] == 'org'){?>
      <a href="<?php echo url_for('/users/singleEvent/update.php?id=' . $event['EventID']);?>">Update</a>
      <a href="<?php echo url_for('/users/singleEvent/delete.php?id=' . $event['EventID']);?>" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
    <?php }else { ?>
      <button type="button" id="saveEvent"></button>
    <?php }?>
  </div>
</html>
