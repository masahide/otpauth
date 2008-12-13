<?php


function auth_db_initialized() {
	$error = '';
	$dbhandle = sqlite_open('demo_auth_db.sqlite');
	$sql = "select * from user";
	$query = sqlite_exec($dbhandle, $sql, $error);
	if (!$query) { 
		echo "authentication database not initialized: '$error'<br/><br/>\n\n";
		return false;
	} 
	else { 
		/* echo "db has been initialized<br/><br/>\n\n"; */ 
		return true;
	}
}

function initialize_auth_db() {
	$error = '';
	$dbhandle = sqlite_open('demo_auth_db.sqlite');

	/******************************************
         *
	 * create user table 
         *
	 ******************************************/
        $user_create_stmt = "
          CREATE TABLE user (
            id int auto_increment,
            username varchar(40) NOT NULL,
            pw varchar(40) NOT NULL default '',
            realname varchar(40) NOT NULL default '',
            status char(1) NOT NULL default 'A',
            add_date int(11) NOT NULL default '0',
            confirm_hash varchar(40) default NULL,
            phone_number varchar(20) NOT NULL default '',
            last_pw_change int(11) NOT NULL default '0',
            otp_enabled  tinyint(1) NOT NULL default '0', 
            PRIMARY KEY  (id)
          ) ";

	$query = sqlite_exec($dbhandle, $user_create_stmt, $error);
	if (!$query) { echo "Error in user create statement: '$error'<br/><br/>\n\n" . 
                            "Does apache have write permission to the demo directory?<br/><br/>\n\n"; 
        }
	else { echo "user table created<br/><br/>\n\n"; }

 
	/******************************************
         *
	 * create session table 
         *
	 ******************************************/
        $session_create_stmt = "CREATE TABLE session (
				user_id int(11) default '0',
				session_hash char(32) NOT NULL default '',
				ip_addr char(15) NOT NULL default '',
                                otp_auth tinyint(1) NOT NULL default '0', 
				time int(11) NOT NULL default '0',
                                locked tinyint(1) NOT NULL default '0', 
				PRIMARY KEY  (session_hash)
				) ";

        $query = sqlite_exec($dbhandle, $session_create_stmt, $error);
	if (!$query) { echo "Error in session create statement: '$error'<br/><br/>\n\n"; } 
	else { echo "session table created<br/><br/>\n\n"; }

	/******************************************
         *
	 * create otp table 
         *
	 ******************************************/
	$otp_create_stmt = " CREATE TABLE otp (
				id int auto_increment, 
				user_id int(11) NOT NULL default '0',
				sequence int(11) NOT NULL default '0',
				otp char(60) NOT NULL default '',
				PRIMARY KEY  (id)
				)";

        $query = sqlite_exec($dbhandle, $otp_create_stmt, $error);
	if (!$query) { echo "Error in otp create statement: '$error'<br/><br/>\n\n"; } 
	else { echo "otp table created<br/><br/>\n\n"; }



	/******************************************
         *
	 * insert demo user
         *
	 ******************************************/
	$pw = sha1('demopass');
	$user_insert_stmt = "INSERT INTO user (id, username, pw, status) 
			     VALUES (1, 'demo', '$pw', 'A')";
        $query = sqlite_exec($dbhandle, $user_insert_stmt, $error);
	if (!$query) { echo "Error in user insert statement: '$error'<br/><br/>\n\n"; } 
	else { echo "user inserted<br/><br/>\n\n"; }
}





function enterprise_db_initialized() {
	$error = '';
	$dbhandle = sqlite_open('demo_enterprise_db.sqlite');
	$sql = "select * from user_articles";
	$query = sqlite_exec($dbhandle, $sql, $error);
	if (!$query) { 
		echo "enterprise database not initialized: '$error'<br/><br/>\n\n";
		return false;
	} 
	else { 
		/* echo "db has been initialized<br/><br/>\n\n"; */ 
		return true;
	}
}

function initialize_enterprise_db() {
	$error = '';
	$dbhandle = sqlite_open('demo_enterprise_db.sqlite');

	/******************************************
         *
	 * create sample data table 
         *
	 ******************************************/
        $data_create_stmt = "
          CREATE TABLE user_articles (
            id int auto_increment,
            user_id int NOT NULL, 
            title text NOT NULL,
            text text NOT NULL default '',
            PRIMARY KEY  (id)
          ) ";

	$query = sqlite_exec($dbhandle, $data_create_stmt, $error);
	if (!$query) { echo "Error in article create statement: '$error'<br/><br/>\n\n" . 
                            "Does apache have write permission to the demo directory?<br/><br/>\n\n"; 
        }
	else { echo "article table created<br/><br/>\n\n"; }

 
	/******************************************
         *
	 * insert sample article
         *
	 ******************************************/
        $article_text = mysql_real_escape_string("Software as a service....");
	$data_insert_stmt = "INSERT INTO user_articles (id, user_id, title, text) 
			     VALUES (1, 1, 'software as a service', '$article_text')";
        $query = sqlite_exec($dbhandle, $data_insert_stmt, $error);
	if (!$query) { echo "Error in article insert statement: '$error'<br/><br/>\n\n"; } 
	else { echo "article inserted<br/><br/>\n\n"; }
}




function get_recent_articles($uid) {
	$dbhandle = sqlite_open('demo_enterprise_db.sqlite');
        $sql = "SELECT * FROM user_articles WHERE user_id=1";
	$res = sqlite_query($dbhandle, $sql, $error);

        $articles = array();
        while ($entry = sqlite_fetch_array($res, SQLITE_ASSOC)) {
          $article["title"] = $entry["title"];
          $article["text"] = $entry["text"];
          $articles[] = $article;
        }

	return $articles;
}

?>
