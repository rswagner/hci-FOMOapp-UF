<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Profile';

if ($_SESSION['type'] == "student"){
  $sql = "SELECT * FROM users.Events WHERE EventID IN(";
  $sql .= "SELECT SavedEventID FROM users.SavedEvents WHERE ";
  $sql .= "StudentID = '" . $_SESSION['id'] . "'";
}

$savedEvents_set = mysqli_query($db, $sql);


if ($_SESSION['type'] == "student"){
	$sql = "SELECT * FROM users.Tags";
}
$tag_set = mysqli_query($db, $sql);

if (is_post_request()){
  $tags;
  $tags['id'] = $_POST['freeFood'] ?? '';

  $sql = "INSERT INTO users.Tags";
  $sql .= "(id) ";
  $sql .= "VALUES (";
  
  $sql .= "'" . $tags['id'] . "'";
  $sql .= ")";
  $result = mysqli_query($db, $sql);

  if ($result){
    redirect_to(url_for('/users/profile.php'));
  }
  else {
    // UPDATE failed
    echo mysqli_error($db);
  }
} // end post
?>


  <script type="text/javascript">
    $(document).ready(function() {
       $("#deleteTag").html("Remove Tag")

      $("#deleteTag").click(function(){
          $.ajax({
              url: "<?php echo url_for('/users/removeTag.php');?>",
              type: "POST",
              data: {
                id: <?php echo $id; ?>
              }
          });
        })
    });
  </script>
  
<?php include(SHARED_PATH . '/user_header.php') ?>
<!doctype html>


  <body>
  <center>
  <h1>Welcome <?php echo $_SESSION['username'] ?? ''; ?></h1>
  <!-- where profile pic will be: <img src="<?php echo $content; ?>" alt="image" /> -->
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
      mysqli_free_result($savedEvent_set);
    ?>
	
	
	<table>
      <tr>
        <th>Your Tags</th>
      </tr>
      <?php while($tags = mysqli_fetch_assoc($tag_set)){ ?>
      <tr>
        <td><?php echo $tags['id'] ?></td>
        <!-- Dynamically go through a for loop and echo the id in the url! -->
        <button type="button" id="deleteTag" name= <?php echo $tags['id'] ?> ></button>
      </tr>
    <?php } ?>
    </table>
	<?php
      mysqli_free_result($tag_set);
    ?>
	<form action="<?php echo url_for('/users/profile.php');?>" method="post">
		<table>
		  <tr>
			<th>All Tags</th>
			<th>&nbsp;</th>
		  </tr>
		  <tr>
			<td><input  value="Free Food" type="submit" id="freeFood" name="tag"></input></td>			
		 </tr>
		 <tr>
			<td><input  value="Video Games" type="submit" id="videoGames" name="tag"></input></td>		
		 </tr>
		</table>
	</form>
  </body>
</html>