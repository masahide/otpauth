<?php

  require_once('db_functions.php');
  require_once('user_functions.php');

  /* for demo app only, make sure we've created sqlite auth db */
  if (!auth_db_initialized()) { initialize_auth_db(); }
  
  /* for demo app only, make sure we've created sqlite enterprise db */
  if (!enterprise_db_initialized()) { initialize_enterprise_db(); }

  /* if user has not logged in at all, send to login page */
  if (!user_loggedin()) {
    header("Location: login.php");
    exit();
  }

  //retrieve user id 
  $uid = user_getid();

  //attempt to retrieve user session
  $session = user_getsession($uid);
  
  if (!$session) { 
    $session = user_create_session($uid); //create session 
  }

  //check to see if user is already authenticating
  //this prevents RFC 2289 specified race condition
  while ($session['locked']) {
    /* spin until lock is released or timeout happens */
    $session = user_getsession($uid);
    if (spinlock_timeout_reached()) {
      header("Location: retry.php");
      exit();
    }
  }

  //lock account while authenticating
  set_session_lock($uid); //sets "locked" flag on session table

  //check of otp auth has been enabled on account
  $otp_auth_enabled = user_getotpauth($uid); //retrieves otp_enabled flag from user table

  if ($otp_auth_enabled) {
    if ($session['otp_auth']) {
      /* success, user has already authenticated with otp */
    } else {
      /* user has logged in but not otp auth'd */

      //untrusted_host() compares the IP of the current 
      //session with the user's specified trusted list
      if (trusted_host($uid)) {
        /*user is coming from address which won't require OTP auth */
      } else {
        /* user must otp auth */
        header("Location: otp_challenge.php");
        exit();
      }
    }
  }

//in all but otp required case 
//the user ends up here
//release lock and proceed to page-specific code
unset_session_lock($uid);

?>
