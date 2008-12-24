<?php
  require_once('db_functions.php');
  require_once('user_functions.php');

  //attempt to retrieve user session
  $session = user_getsession();

  /* if user has not logged in at all, send to login page */
  if (!$session) { 
    header("Location: login.php");
    exit();
  } else {
    logout($session['user_id']);
  }

    header("Location: login.php");
    exit();
?>
