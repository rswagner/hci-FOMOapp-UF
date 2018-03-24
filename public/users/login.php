<?php
require_once('../../private/initialize.php');

$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';
  $type = $_POST['type'] ?? '';

  //Validations
  if(is_blank($username)){
    $errors[] = "Username cannot be blank.";
  }
  if(is_blank($password)){
    $errors[] = "Password cannot be blank.";
  }
  if(is_blank($type)){
    $errors[] = "Type of user cannot be blank.";
  }
  if(empty($errors)){
    if ($type == "org"){
      $sql = "SELECT * FROM users.Organizations WHERE username='" . $username . "' ";
      $sql .= "AND password='" . $password . "' LIMIT 1";
    }else{
      $sql = "SELECT * FROM users.Users WHERE username='" . $username . "' ";
      $sql .= "AND password='" . $password . "' LIMIT 1";
    }
    $user_set = mysqli_query($db, $sql);
    $user = mysqli_fetch_assoc($user_set);

    if ($user == NULL){
      $errors[]= "Username/password not found.";
    }else {
      mysqli_free_result($user_set);

      log_in($user, $type);
      redirect_to(url_for('/users/allEvents.php'));
    }
  }
}

?>

<?php $page_title = 'Log in'; ?>

<div>
  <h1>Log in</h1>

  <?php echo display_errors($errors); ?>

  <form action="login.php" method="post">
    Username:<br />
    <input type="text" name="username" value="<?php echo h($username); ?>" /><br/>
    Password:<br/>
    <input type="password" name="password" value="" /><br/>
    <p>Log in as: </p>
    <input type="radio" name="type" value="student">Student<br>
    <input type="radio" name="type" value="org">Organization<br><br>
    <input type="submit" name="submit" value="Submit"  />
  </form>

</div>
</html>
