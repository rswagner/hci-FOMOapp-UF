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

  $sql = "SELECT ProfilePic FROM users.Users WHERE ";
  $sql .= "UserID ='" . $_SESSION['id'] . "'";
  $image_set = mysqli_query($db, $sql);
  $info = mysqli_fetch_assoc($image_set);
   mysqli_free_result($image_set);
}
// org
else {
  $sql = "SELECT OrganizationDescription, ProfilePic FROM users.Organizations WHERE ";
  $sql .= "OrganizationID = '" . $_SESSION['id'] . "'";
  $organizationInfo_set = mysqli_query($db, $sql);

  $info = mysqli_fetch_assoc($organizationInfo_set);
  mysqli_free_result($organizationInfo_set);
}
// Get picture from database

//$row = mysqli_fetch_array($image_set);
//$content = $row['https://s3.us-east-2.amazonaws.com/hci-fomo/logan.jpg'];
//readfile($content);

if (is_post_request()){
  if ($_FILES["fileToUpload"]["name"]){
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            $message = "File is not an image.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        $message = "Sorry, file already exists.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $message = "Sorry, your file is too large.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $message = "Sorry, your file was not uploaded.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          if ($_SESSION['type'] == "student"){
            $sql = "UPDATE users.Users SET ";
          	$sql .= "ProfilePic='" . $target_file . "' ";
            $sql .= "WHERE UserID='" . $_SESSION['id'] . "' ";
            $sql .= "LIMIT 1";
          	$result = mysqli_query($db, $sql);
          }else {
            $sql = "UPDATE users.Organizations SET ";
          	$sql .= "ProfilePic='" . $target_file . "' ";
            $sql .= "WHERE OrganizationID='" . $_SESSION['id'] . "' ";
            $sql .= "LIMIT 1";
          	$result = mysqli_query($db, $sql);
          }
          if ($result){
            $message = 'The file '. basename( $_FILES['fileToUpload']['name']). ' has been uploaded.';
            echo "<script type='text/javascript'>alert('$message');</script>";
          }else {
            echo mysqli_error($db);
          }
        } else {
            $message = "Sorry, there was an error uploading your file.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
      }
    }else {
      $message = "Sorry, you need to choose a file before uploading.";
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
  }
?>

<?php include(SHARED_PATH . '/user_header.php'); ?>
  <body>
  <h1><?php echo $_SESSION['name'] ?? ''; ?></h1>
  <?php if ($info['ProfilePic']){ ?>
     <img style="width:200px;height:170px;" src="<?php echo $info['ProfilePic'] ?>" alt="image" >
  <?php } ?>
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
    <a href="<?php echo url_for('/users/profile/editUserTags.php');?>">Edit Tags</a>
    <ul>
      <?php while($userTag = mysqli_fetch_assoc($userTags_set)){ ?>
      <li> <?php echo $userTag['TagName']; ?> </li>
      <?php }?>
    </ul>
  <?php }else { ?>
    <h3>Description</h3>
    <p><?php echo $info['OrganizationDescription']; ?></p>
  <?php } ?>

  <form action= "<?php echo url_for('/users/profile/profile.php');?>" method="post" enctype="multipart/form-data">
      <input type="file" name= "fileToUpload" id="fileToUpload">
      <input type="submit" value="Change Profile Image" name="submit">
  </form>
  </body>
</html>
