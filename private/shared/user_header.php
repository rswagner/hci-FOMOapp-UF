<?php
if (!isset($page_title)) $page_title = 'User Area'
 ?>
<!doctype html>

<html lang="en">
  <head>
    <title><?php echo $page_title;?></title>
    <meta charset="utf-8">
  </head>

  <body>
    <p>User: <?php echo $_SESSION['username'] ?? ''; ?></p>
    <a href="<?php echo url_for('/users/logout.php');?>">Logout</a>
    <a href="<?php echo url_for('/users/allEvents.php');?>">Explore Events</a>
    <a href="">Profile</a><br><br>
