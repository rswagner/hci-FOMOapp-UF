<?php
if (!isset($page_title)) $page_title = 'User Area'
 ?>
<html lang="en">
  <head>
    <title><?php echo $page_title;?></title>
    <meta charset="utf-8">
  </head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <body>
    <p>User: <?php echo $_SESSION['username'] ?? ''; ?></p>
    <a href="<?php echo url_for('/users/logout.php');?>">Logout</a>
    <a href="<?php echo url_for('/users/allEvents.php');?>">Explore Events</a>
    <a href="<?php echo url_for('/users/profile.php');?>">Profile</a><br><br>
