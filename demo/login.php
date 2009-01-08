<?php
  require_once('db_functions.php');
  require_once('user_functions.php');

  /* for demo app only, make sure we've created sqlite auth db */
  if (!auth_db_initialized()) { initialize_auth_db(); }
  
  /* for demo app only, make sure we've created sqlite enterprise db */
  if (!enterprise_db_initialized()) { initialize_enterprise_db(); }
	if ($_POST['login']) {

		$user = $_POST['user'];
		$pw = $_POST['password'];
		$require_otp = $_POST['require_otp'];


		$uid = check_login($user, $pw);
		if ($uid) {
/*
			if ($require_otp) {
                       	 	//error if no otp's have been generated
				$otp_ready = check_otplist_generated($uid);
				if (!$otp_ready) {
					print "<H1>OTP authentication cannot be enabled!</h1>";
					print "No otp password list has been generated for this user\n<br/>";
					print "Please login without OTP and generate a list from the 'account settings' page\n<br/><br/>";
					print_login_page();
					exit();
				}
				enable_otp_on_demo_account();
			} else {
				disable_otp_on_demo_account();
			}
*/

			init_session($uid);
			//redirect to requested page
			header("Location: index.php");
			exit();
		} else {
			print "<H1>LOGIN FAILED!</H1>\n<br/>";
			print_login_page();
			exit();
		}

	} else {
		print_login_page();
		exit();
	}
?>
<?php
	function print_login_page() {
		print "Please login with <b>user 'demo'</b> and <b>password 'demopass'</b>.";

		print "<br/><br/>";

		print "<form action='login.php' method='post'>";

		print "Username: <input type='text' name='user' value='demo'>";
		print "<br/>";
		print "<br/>";
		print "Password: <input type='password' name='password' value='demopass'>";
		print "<br/>";
		print "<br/>";
		print "<!--<input type='checkbox' name='require_otp'>Require OTP login-->";
		print "<br/>";
		print "<br/>";
		print "<input type='submit' name='login' value='login'>";

		print "</form>";
	}

?>
