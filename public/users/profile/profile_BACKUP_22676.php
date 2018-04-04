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
  $profile_pic = mysqli_fetch_assoc($image_set);
   mysqli_free_result($image_set);
}
// org
else {
  $sql = "SELECT OrganizationDescription FROM users.Organizations WHERE ";
  $sql .= "OrganizationID = '" . $_SESSION['id'] . "'"; 
  $organizationInfo_set = mysqli_query($db, $sql); 

  $organizationInfo = mysqli_fetch_assoc($organizationInfo_set);
  mysqli_free_result($organizationInfo_set);
}
// Get picture from database


//$row = mysqli_fetch_array($image_set);
//$content = $row['https://s3.us-east-2.amazonaws.com/hci-fomo/logan.jpg'];
//readfile($content);
if (is_post_request()){
	$profile_pic; 
	$target_dir = "uploads/";
	$target_file = $target_dir . basename( $_FILES["fileToUpload"]["name"] );
	$profile_pic['ProfilePic'] = $target_dir . basename( $_FILES["fileToUpload"]["name"] );
	$sql = "UPDATE users.Users SET ";
	$sql .= "ProfilePic='" . $profile_pic['ProfilePic'] . "' ";
    $sql .= "WHERE UserID='" . $_SESSION['id'] . "' ";
    $sql .= "LIMIT 1";	
	$result = mysqli_query($db, $sql);

	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false	) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} 
	else {
		if( move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} 
		else {
			echo "Sorry, there was an error uploading your file.";
		}	
	}
}	
?>		

<?php include(SHARED_PATH . '/user_header.php'); ?>
<<<<<<< HEAD
  <body>
    <div class="content-box">
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

    </div>

=======

<head>
    <meta charset="utf-8">
    <title>FOMO UF APP</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--Custom imports !-->
    <link rel="stylesheet" href="<?=WWW_ROOT?>/css/profile.css">
</head>

<body>
    <div class="profile-container">
        <h1><?php echo $_SESSION['name'] ?? ''; ?></h1>

      <!-- when database works:   <img src="" alt="image" /> -->

        <?php if ($_SESSION['type'] == 'student'){ ?>
        <!--<p>"<?php echo $profile_pic['ProfilePic'] ?>" </p>-->
          <img style="width:200px;height:170px;" src="<?php echo $profile_pic['ProfilePic'] ?>" alt="image" >
          <form action= "<?php echo url_for('/users/profile/profile.php');?>" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" class="inputfile" data-multiple-caption="{count} files selected" multiple>
            <label for="fileToUpload"><span>Choose File</span></label>
            <input type="submit" id="submitForFileUpload" value="Upload Image" name="submit" class="inputFile">
            <label for="submitForFileUpload">Upload Image</label>
          </form>
        <div class="card horizontal profile-events-card">
            <table>  
              <th>Your Saved Events</th>
              <tr>
                <!--<th class="event-name-column-header">Name</th>
                <th>&nbsp;</th>-->
              </tr>
              <?php while($savedEvent = mysqli_fetch_assoc($savedEvents_set)){ ?>
              <tr>
                <td><?php echo $savedEvent['EventName'] ?></td>
                <!-- Dynamically go through a for loop and echo the id in the url! -->
                <td><a href="<?php echo url_for('/users/singleEvent/info.php?id=' . $savedEvent['EventID']);?>">View</a></td>
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
                    <a href="<?php echo url_for('/users/profile/editUserTags.php');?>">Edit Tags</a> 
                </div> 
            </div>
        </div>
      <?php }else { ?>
        <h3>Description</h3>
        <p><?php echo $organizationInfo['OrganizationDescription']; ?></p>
      <?php } ?>
    </div>
    
    <footer>
        <div class="footer-bar">
            <center>
                <a href="https://www.studentinvolvement.ufl.edu/Student-Organizations"><img src="../../images/soar.png" alt="SOAR" style="height: 30px; margin: 10px"></a>
            </center>
        </div>
    </footer>
>>>>>>> 35c2ae1aa86711946f80093f362d845e02e6b104
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
