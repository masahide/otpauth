<?php

function get_user_name() {
	return "demo";
}

function get_user_id() {
  //attempt to retrieve user session
  $session = user_getsession();
  
  //retrieve user id 
  $uid = $session['user_id'];

  return $uid;
}

function user_loggedin() {
  return false;
}

function logout($uid) {
	$error = '';
	$dbhandle = sqlite_open('demo_auth_db.sqlite');

	//nuke old sessions for safety
	$sql = "DELETE FROM session WHERE user_id=1";
	$query = sqlite_exec($dbhandle, $sql, $error);
	if (!$query) { 
		echo "Cannot delete old sessions: '$error'<br/><br/>\n\n";
		return false;
	} 
	else { 
		/* echo "db has been initialized<br/><br/>\n\n"; */ 
	}
}

function init_session($uid) {
	$error = '';
	$dbhandle = sqlite_open('demo_auth_db.sqlite');

	//nuke old sessions for safety
	$sql = "DELETE FROM session WHERE user_id=1";
	$query = sqlite_exec($dbhandle, $sql, $error);
	if (!$query) { 
		echo "Cannot delete old sessions: '$error'<br/><br/>\n\n";
		return false;
	} 
	else { 
		/* echo "db has been initialized<br/><br/>\n\n"; */ 
	}

	//random session hash
	$hash = sha1("randomstring");

	//insert new session
	$sql = "INSERT INTO session (user_id, session_hash, ip_addr, otp_auth, locked) 
		VALUES ($uid, '$hash', '127.0.0.1', 0, 0)";

	$query = sqlite_exec($dbhandle, $sql, $error);
	if (!$query) { 
		echo "Cannot create session: '$error'<br/><br/>\n\n";
		return false;
	} 
	else { 
		/* echo "db has been initialized<br/><br/>\n\n"; */ 
	}

	$success = setcookie('__otp_demo_session', $hash, time()+60*60*1); //expire in 1 hour
}

function user_getsession() {
        $hash = $_COOKIE['__otp_demo_session'];
	$error = '';
	$dbhandle = sqlite_open('demo_auth_db.sqlite');

        $sql = "SELECT * FROM session WHERE session_hash='$hash'";
	$res = sqlite_query($dbhandle, $sql, SQLITE_ASSOC, $error);

        $sess = array();
        while ($entry = sqlite_fetch_array($res)) {
          $sess["user_id"] = $entry["user_id"];
          $sess["otp_auth"] = $entry["otp_auth"];
          $sess["time"] = $entry["time"];
          $sess["locked"] = $entry["locked"];

	  return $sess;
        }
}



function set_session_lock($uid) {
	$dbhandle = sqlite_open('demo_auth_db.sqlite');

	$sql = "UPDATE session SET locked=1 WHERE user_id=$uid";
	$query = sqlite_exec($dbhandle, $sql, $error);
	if (!$query) { 
		echo "Cannot lock session!: '$error'<br/><br/>\n\n";
		exit();
	} 
	else { 
		/* echo "db has been initialized<br/><br/>\n\n"; */ 
	}
}

function unset_session_lock($uid)  {
	$dbhandle = sqlite_open('demo_auth_db.sqlite');

	$sql = "UPDATE session SET locked=0 WHERE user_id=$uid";
	$query = sqlite_exec($dbhandle, $sql, $error);
	if (!$query) { 
		echo "Cannot lock session!: '$error'<br/><br/>\n\n";
		exit();
	} 
	else { 
		/* echo "db has been initialized<br/><br/>\n\n"; */ 
	}
}


function user_getotpauth($uid) {
	$dbhandle = sqlite_open('demo_auth_db.sqlite');
	$sql = "SELECT otp_enabled from user WHERE id='$uid'";
	$res = sqlite_query($dbhandle, $sql, SQLITE_ASSOC, $error);

        $sess = array();
        $otp_auth_enabled = null;
        while ($entry = sqlite_fetch_array($res)) {
             $otp_auth_enabled = $res['otp_enabled'];
        }

        if (is_null($otp_auth_enabled)) {
            /* @todo handle error condition */
        }

        return $otp_auth_enabled;
}



function check_login($user, $pw) {
	$dbhandle = sqlite_open('demo_auth_db.sqlite');
	$real_pw = sha1($pw);
	$sql = "SELECT * from user WHERE username='$user' AND pw='$real_pw'"; 
	$res = sqlite_query($dbhandle, $sql);

	if (sqlite_num_rows($res)<1) {
          return false;
        } elseif (sqlite_num_rows($res)>1) {
          return 1;
        } else {
          return true;
        }
}


function check_otplist_generated($uid) {
	$dbhandle = sqlite_open('demo_auth_db.sqlite');
	$sql = "SELECT * from otp WHERE user_id='$uid'";
	$res = sqlite_query($dbhandle, $sql, SQLITE_ASSOC, $error);

        $sess = array();
        $otp_ready = null;
        while ($entry = sqlite_fetch_array($res)) {
             $otp_ready = true;
        }

        return $otp_ready;
}


$locktime = false;
function spinlock_timeout_reached() {
  global $locktime;
  
  //acquire lock time if not set 
  if (!$locktime) {
    $locktime = time();
  }

  $curtime = time();

  //release lock, return true
  if (($curtime-$locktime)>30) {
    $locktime = false;
    return true;
  } else {
    return false; 
  }

}







?>
