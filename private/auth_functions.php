<?php
  function log_in($user, $type) {
    session_regenerate_id();
    if ($type == "student") {
      $_SESSION['id'] = $user['UserID'];
      $_SESSION['name'] = $user['FirstName'] . " " . $user['LastName'];
    }
    else{
      $_SESSION['id'] = $user['OrganizationID'];
      $_SESSION['name'] = $user['OrganizationName'];
    }
    $_SESSION['username'] = $user['Username'];
    $_SESSION['type'] = $type;
    return true;
  }

  // Performs all actions necessary to log out an student
  function log_out_student() {
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['type']);
    return true;
  }

  function is_logged_in() {
    return isset($_SESSION['id']);
  }

  // Call require_login() at the top of any page which needs to
  // require a valid login before granting acccess to the page.
  function require_login() {
    if(!is_logged_in()) {
      redirect_to(url_for('/users/login.php'));
    } else {
      // Do nothing, let the rest of the page proceed
    }
  }

?>
