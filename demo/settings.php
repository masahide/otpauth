<?php
  //checks to make sure user is authenticated 
  require_once('lib.php');


  $update = $_POST['update'];
  $require_otp = $_POST['require_otp'];

  $uid = get_user_id();

  if ($update) {
    //error if no otp's have been generated
    if ($require_otp) { 
      $otp_ready = check_otplist_generated($uid);
      if (!$otp_ready) {
        print "<H1>OTP authentication cannot be enabled!</h1>";
        print "No otp password list has been generated for this user\n<br/>";
        print "Please generate a list first!\n<br/><br/>";
        print_settings_page();
        exit();
      } 
      enable_otp_on_demo_account($uid);
    } else {
      disable_otp_on_demo_account($uid);
    } 
  }

  print_settings_page();
?>

<?php

function print_settings_page() {

  $uid = get_user_id();
  $username = get_user_name();

  //check of otp auth has been enabled on account
  $otp_auth_enabled = user_getotpauth($uid); //retrieves otp_enabled flag from user table


  print "<h1>Welcome, $username, to the account settings page</h1>";
  print " (<a href='logout.php'>logout</a> | <a href='settings.php'>account settings</a>)";

  print "<h3>Your preferences</h3>";

  print "<hr size=1 noshade>";

  
  print "<form action='settings.php' method='post'>";

  print "<a href='gen_otp_list.php'>Generate new otp list</a><br/><br/>";
  if ($otp_auth_enabled) {
    print "<input type='checkbox' name='require_otp' checked>Require OTP login";
  } else {
    print "<input type='checkbox' name='require_otp'>Require OTP login";
  }
  print "<br/>";
  print "<br/>";
  print "<input type='submit' name='update' value='update'>";
  print "</form>";

}

?>
