<?php
	require_once('db_functions.php');

	//print "<h1>".$_POST['login']."</h1>";
	print_r($_POST);

	if (!db_initialized()) {
		initialize_db();
	}

	if ($_POST['login']) {
		$user = $_POST['user'];
		$pw = $_POST['password'];
		if (check_login($user, $pw)) {
			print "LOGIN PASSED!\n<br/>";
		} else {
			print "LOGIN FAILED!\n<br/>";
		}

	} else {
		print_login_page();
	}
?>
<?php
	function print_login_page() {
		print "Please login with <b>user 'demo'</b> and <b>password 'demopass'</b>.";

		print "<br/><br/>";

		print "<form action='.' method='post'>";

		print "Username: <input type='text' name='user' value='demo'>";
		print "<br/>";
		print "<br/>";
		print "Password: <input type='password' name='password' value='demopass'>";
		print "<br/>";
		print "<br/>";
		print "<input type='submit' name='login' value='login'>";

		print "</form>";
	}

?>
