<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>

<?php $page_title = 'Organization Info';
  $id = $_GET['id'];

  $sql = "SELECT users.Events.*, users.Organizations.* FROM users.Events INNER JOIN users.Organizations ";
  $sql .= "ON users.Events.OrganizationID = users.Organizations.OrganizationID ";
  $sql .= "WHERE users.Organizations.OrganizationID = '" . $id . "'";

  $organizationInfo_set = mysqli_query($db, $sql);

  $info = mysqli_fetch_assoc($organizationInfo_set);
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
        <h1><?php echo $info['OrganizationName'] ?? ''; ?></h1>

        <div class="reframe card">
            <img src="<?php echo $info['ProfilePic'] ?>" alt="image" >
        </div>
        <h3>Description</h3>
        <p><?php echo $info['OrganizationDescription']; ?></p>
        <div class="card horizontal profile-events-card">
            <table>
              <th>Host Events</th>
              <tr>
                <td><?php echo $info['EventName'] ?></td>
                <!-- Dynamically go through a for loop and echo the id in the url! -->
                <td>
                    <?php
                        $date = str_replace("-","",$info['Date']);
                        $location = $info['Location'];
                        $startTime = str_replace(":","",$info['StartTime']);
                        $endTime = str_replace(":","",$info['EndTime']);
                        $title = $info['EventName'];
                        $description = $info['Description'];
                    ?>
                    <a href="<?php echo url_for('/users/singleEvent/info.php?id=' . $info['EventID']);?>">View</a></td>
                <td><a href="ical.php?date=<?=$date?>&amp;location=<?=$location?>&amp;startTime=<?=$startTime?>&amp;endTime=<?=$endTime?>&amp;title=<?=$title?>&amp;description=<?=$description?>">Add to Cal</a></td>
              </tr>
              <?php while($info = mysqli_fetch_assoc($organizationInfo_set)){ ?>
              <tr>
                <td><?php echo $info['EventName'] ?></td>
                <!-- Dynamically go through a for loop and echo the id in the url! -->
                <td>
                    <?php
                        $date = str_replace("-","",$info['Date']);
                        $location = $info['Location'];
                        $startTime = str_replace(":","",$info['StartTime']);
                        $endTime = str_replace(":","",$info['EndTime']);
                        $title = $info['EventName'];
                        $description = $info['Description'];
                    ?>
                    <a href="<?php echo url_for('/users/singleEvent/info.php?id=' . $info['EventID']);?>">View</a></td>
                <td><a href="ical.php?date=<?=$date?>&amp;location=<?=$location?>&amp;startTime=<?=$startTime?>&amp;endTime=<?=$endTime?>&amp;title=<?=$title?>&amp;description=<?=$description?>">Add to Cal</a></td>
              </tr>
            <?php } ?>
            </table>
        </div>
        <?php
          mysqli_free_result($organizationInfo_set);
        ?>
    </div>
  </body>
    <footer>
        <div class="footer-bar">
            <center>
                <a href="https://www.studentinvolvement.ufl.edu/Student-Organizations"><img src="../../images/soar.png" alt="SOAR" style="height: 30px; margin: 10px"></a>
            </center>
        </div>
    </footer>
</html>
