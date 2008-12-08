<?php

initialize_db();

print "Please login with <b>user 'demo'</b> and <b>password 'demopass'</b>.";


print "<br/><br/>";


print "<form>";

print "Username: <input type='text' name='user' value='demo'>";
print "<br/>";
print "<br/>";
print "Password: <input type='text' name='password' value=''>";
print "<br/>";
print "<br/>";
print "<input type='submit' name='login'>";


print "</form>";


?>
<?php

function initialize_db() {
	$dbhandle = sqlite_open('demodb.sqllite');


	$query = sqlite_exec($dbhandle, "CREATE TABLE test (id int(11), requests int(11), PRIMARY KEY (id))", $error);
	if (!$query) {
		exit("Error in query: '$error'");
	} else {
		echo 'Number of rows modified: ', sqlite_changes($dbhandle);
	}
}
?>
