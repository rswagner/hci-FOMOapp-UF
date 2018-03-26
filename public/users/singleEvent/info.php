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
  $sql = "SELECT OrganizationName FROM users.Organizations WHERE OrganizationID='" . $event['OrganizationID'] . "'";
  $org_of_event_set = mysqli_query($db, $sql);
  $org_of_event = mysqli_fetch_assoc($org_of_event_set);
  mysqli_free_result($org_of_event_set);
  $sql = "SELECT * FROM users.SavedEvents WHERE SavedEventID='" . $id . "'";
  $sql .= "AND StudentID='" . $_SESSION['id'] . "'";
  //$sql .= "AND SavedEventName='" .  'testName' . "'";
  $saved_event_set = mysqli_query($db, $sql);
  
  $saved_event = mysqli_fetch_assoc($saved_event_set);
  mysqli_free_result($saved_event_set);
?>
<?php include(SHARED_PATH . '/user_header.php'); ?>

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
    <h3>By <?php echo  $org_of_event['OrganizationName']?></h3>
    <h4><?php echo $event['Location']; ?></h4>
    <h4><?php echo $event['Time']; ?></h4>
    <p><?php echo $event['Description']; ?></p>
    <?php if ($_SESSION['type'] == 'org'){?>
      <a href="<?php echo url_for('/users/singleEvent/update.php?id=' . $event['EventID']);?>">Update</a>
      <a href="<?php echo url_for('/users/singleEvent/delete.php?id=' . $event['EventID']);?>" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
    <?php }else { ?>
      <button type="button" id="saveEvent"></button>
    <?php }?>
  </div>
</html>