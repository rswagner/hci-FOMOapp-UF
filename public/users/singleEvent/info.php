<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Single Event';
if(!isset($_GET['id'])) {
  redirect_to(url_for('/users/allEvents.php'));
}
  $id = $_GET['id'];

  $sql = "SELECT users.Events.*, users.Organizations.OrganizationName, users.Organizations.OrganizationID FROM users.Events ";
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

<title>Info view</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?=WWW_ROOT?>/css/info.css">

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
<div class="content-box">
    <?php if ($event['EventPic']){ ?>
    <img class="event-banner-pic" src="<?php echo $event['EventPic'] ?>" alt="image" />
    <?php } ?>
    <div class="event-info">
        <div class="title">
            <h2>
                <?php echo $event['EventName'];?>
            </h2>
            <?php if ($_SESSION['type'] == 'org'){?>
            <div class="admin-commands">
                <a href="<?php echo url_for('/users/singleEvent/update.php?id=' . $event['EventID']);?>" title="Edit Event"><i class="medium material-icons">edit</i>Edit Event</a>
                <a href="<?php echo url_for('/users/singleEvent/delete.php?id=' . $event['EventID']);?>" title="Delete Event" onclick="return confirm('Are you sure you want to delete this event?')"><i class="medium material-icons">delete</i>Delete Event</a>
            </div>
            <?php }?>
        </div>
        <?php if ($_SESSION['type'] == "student"){ ?>
          <h3>
            <a href="<?php echo url_for('/users/profile/orgInfo.php?id=' . $event['OrganizationID']);?>">
              By <?php echo  $event['OrganizationName'];?>
            </a>
          </h3>
        <?php }else { ?>
        <h3>By
            <?php echo  $event['OrganizationName'];?>
        </h3>
      <?php } ?>
        <h4>
          <a href="https://maps.google.com/?ll=<?php echo $event['Latitude']?>,<?php echo $event['Longitude']?>" target="_blank">
            <?php echo $event['Location']; ?>
          </a>
        </h4>
        <h4>
            <?php echo date('m/d/Y', strtotime($event['Date'])); ?>
        </h4>
        <h4>
            <?php echo date('h:i a', strtotime($event['StartTime'])); ?> -
            <?php echo date('h:i a', strtotime($event['EndTime'])); ?>
        </h4>

        <?php if ($_SESSION['type'] == 'student'){?>
        <a id="saveEvent" type=button class="waves-effect waves-light btn">Save Event</a>
        <?php }?>

        <div class="description">
            <h3>Description</h3>
            <p>
                <?php echo $event['Description']; ?>
            </p>
        </div>

        <div class="tags">
            <h3>Event Tags</h3>
            <?php if ($_SESSION['type'] == 'org'){?>
            <a href="<?php echo url_for('/users/singleEvent/editEventTags.php?id=' . $event['EventID']);?>" title="Edit tags">Reset Tags<i class="medium material-icons">open_in_browser</i></a>
            <?php } ?>
            <ul>
                <?php while($eventTag = mysqli_fetch_assoc($eventTags_set)){ ?>
                <li>
                    <?php echo $eventTag['TagName']; ?> <i class="material-icons">grade</i></li>
                <?php }
              mysqli_free_result($eventTags_set);?>
            </ul>
        </div>
    </div>

</div>
<footer>
    <div class="footer-bar">
        <center>
            <a href="https://www.studentinvolvement.ufl.edu/Student-Organizations"><img src="<?=WWW_ROOT?>/images/soar.png" alt="SOAR" style="height: 30px; margin: 10px"></a>
        </center>
    </div>
</footer>
</html>
