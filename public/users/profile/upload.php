<?php require_once('../../../private/initialize.php'); ?>
<?php require_login();
     use Aws\S3\S3Client;
     use Aws\S3\Exception\S3Exception;
?>

<?php $page_title = 'Profile';

  $sql = "SELECT ImageID FROM users.images";
  $image_set = mysqli_query($db, $sql);
  
// Get picture from database
$sql = "INSERT INTO users.images (ImageID, ImageName)
VALUES ('https://s3.us-east-2.amazonaws.com/hci-fomo/17834191_1662791180405412_2566039718950503940_o.jpg', 
'Logan')";

$row = mysqli_fetch_array($image_set);
//$content = $row['https://s3.us-east-2.amazonaws.com/hci-fomo/logan.jpg'];
$image = mysqli_fetch_assoc($image_set); 		
//readfile($content);


?>

<?php
include('C:\wamp64\www\private\db_credentials.php');
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
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
} else {
    if( move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		
		/*
		$image_name_actual = time().".".$ext;
		$name = $_FILES['fileToUpload']['name'];
		$size = $_FILES['fileToUpload']['size'];
		$tmp = $_FILES['fileToUpload']['tmp_name'];
		//$ext = getExtension($name);
		
		try {
			
			$client->putObject(array(
					 'Bucket'=>$bucket,
					 'Key' =>  'logan.jpg',
					 'SourceFile' => $tmp,
					 'StorageClass' => 'REDUCED_REDUNDANCY'
			));
			$message = "S3 Upload Successful.";
				$s3file='http://'.$bucket.'.s3.amazonaws.com/'.$actual_image_name;
				echo "<img src='$s3file'/>";
				echo 'S3 File URL:'.$s3file;

			} 
			catch (S3Exception $e) { // Catch an S3 specific exception.
				echo $e->getMessage();
			}
			$result = $client->putObject(array(
				'Bucket' => $bucket,
				'Key'    => 'fileToUpload',
				'LocationConstraint' => 'us-east-1'
			
			));
			*/
		// Get the URL the object can be downloaded from
		//echo $result['ObjectURL'] . "\n";
			
	} 
	else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

