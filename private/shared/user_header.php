<?php
if (!isset($page_title)) $page_title = 'User Area'
 ?>
<html lang="en">
  <head>
    <title><?php echo $page_title;?></title>
    <meta charset="utf-8">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <!--Import Google Icon Font-->
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <!--Let browser know website is optimized for mobile-->
     <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!--Custom imports !-->
    <link rel="stylesheet" href="<?=WWW_ROOT?>/css/user_header.css">
  </head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <body>
  <div class="nav-fixed">
      <nav>
        <div class="nav-wrapper">
          <a href="index.html" class="brand-logo"><img src="<?=WWW_ROOT?>/images/uf.png" alt="UF"></a>
          <h1>FOMO@UF </h1>
          <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
          <ul class="right hide-on-med-and-down">
            <li><a href="<?php echo url_for('/users/profile/profile.php');?>">MY PROFILE</a></li>
            <li><a href="<?php echo url_for('/users/allEvents.php');?>">EXPLORE EVENTS</a></li>
            <li><a href="<?php echo url_for('/users/logout.php');?>">LOGOUT</a></li>
          </ul>
          <ul class="side-nav" id="mobile-demo">
            <li><a href="<?php echo url_for('/users/profile/profile.php');?>">MY PROFILE</a></li>
            <li><a href="<?php echo url_for('/users/allEvents.php');?>">EXPLORE EVENTS</a></li>
            <li><a href="<?php echo url_for('/users/logout.php');?>">LOGOUT</a></li>
          </ul>
        </div>
      </nav>
    </div>
