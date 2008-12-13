<?php

function get_user_name() {
	return "demo";
}

function get_user_id() {
	return 1;
}

function user_loggedin() {
  return false;
}

function init_session() {

}


function check_login($user, $pw) {
	$dbhandle = sqlite_open('demo_auth_db.sqlite');
	$real_pw = sha1($pw);
print "<H1>|$pw|$real_pw|</h1>";
	$sql = "SELECT * from user WHERE username='$user' AND pw='$real_pw'"; 
	$res = sqlite_query($dbhandle, $sql);

print "<h1>$sql|".sqlite_num_rows($res)."|</h1>";
	if (sqlite_num_rows($res)<1) {
          return false;
        } elseif (mysql_num_rows($res)>1) {
          return false;
        } else {
          return true;
        }
}


?>
