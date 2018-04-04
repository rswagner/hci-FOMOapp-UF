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
  $sql = "SELECT ProfilePic, OrganizationDescription FROM users.Organizations WHERE ";
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

<head>
    <title>Profile View</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?=WWW_ROOT?>/css/profile.css">
</head>

<body>
    <div class="profile-container">
        <h1><?php echo $_SESSION['name'] ?? ''; ?></h1>
        <div class="reframe card">
            <img src="<?php echo $info['ProfilePic'] ?>" alt="image" >
        </div>
        <form class="upload-file-form" action= "<?php echo url_for('/users/profile/profile.php');?>" method="post" enctype="multipart/form-data">
          <input type="file" name="fileToUpload" id="fileToUpload" class="inputfile" data-multiple-caption="{count} files selected" multiple>
          <label for="fileToUpload"><span>Choose File</span></label>
          <input type="submit" id="submitForFileUpload" value="Upload Image" name="submit" class="inputFile">
          <label for="submitForFileUpload">Upload Image</label>
        </form>
        <?php if ($_SESSION['type'] == 'student'){ ?>
        <div class="card horizontal profile-events-card">
            <table>
              <th>Your Saved Events</th>
              <?php while($savedEvent = mysqli_fetch_assoc($savedEvents_set)){ ?>
              <tr>
                <td><?php echo $savedEvent['EventName'] ?></td>
                <!-- Dynamically go through a for loop and echo the id in the url! -->
                <td>
                    <?php
                        $date = str_replace("-","",$savedEvent['Date']);
                        $location = $savedEvent['Location'];
                        $startTime = str_replace(":","",$savedEvent['StartTime']);
                        $endTime = str_replace(":","",$savedEvent['EndTime']);
                        $title = $savedEvent['EventName'];
                        $description = $savedEvent['Description'];
                    ?>
                    <a href="<?php echo url_for('/users/singleEvent/info.php?id=' . $savedEvent['EventID']);?>">View</a></td>
                <td><a href="ical.php?date=<?=$date?>&amp;location=<?=$location?>&amp;startTime=<?=$startTime?>&amp;endTime=<?=$endTime?>&amp;title=<?=$title?>&amp;description=<?=$description?>">Add to Cal</a></td>
              </tr>
            <?php } ?>
            </table>
        </div>
        <?php
          mysqli_free_result($savedEvents_set);
        ?>
        <div class="card horizontal tag-card">
            <div class="card-stacked">
                <div class="card-content tag-card-content">
                    <h2>My Tags</h2>
                    <ul>
                      <?php while($userTag = mysqli_fetch_assoc($userTags_set)){ ?>
                      <li class="tag"> <?php echo $userTag['TagName']; ?> </li>
                      <?php }?>
                    </ul>
                </div>
                <div class="card-action">
                    <a href="<?php echo url_for('/users/profile/editUserTags.php');?>">Reset Tags</a>
                </div>
            </div>
        </div>
      <?php }else { ?>
        <h3>Description</h3>
        <p><?php echo $info['OrganizationDescription']; ?></p>
      <?php } ?>
    </div>
    <div style="height: 50px;"></div>
    <footer>
        <div class="footer-bar">
            <center>
                <a href="https://www.studentinvolvement.ufl.edu/Student-Organizations"><img src="../../images/soar.png" alt="SOAR" style="height: 30px; margin: 10px"></a>
            </center>
        </div>
    </footer>
  </body>
</html>
<script>
    var inputs = document.querySelectorAll( '.inputfile' );
    Array.prototype.forEach.call( inputs, function( input ) {
        var label	 = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
            var fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.querySelector( 'span' ).innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });
    });
</script>
