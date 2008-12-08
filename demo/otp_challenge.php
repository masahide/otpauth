<?php
	/* LICENSED UNDER THE GPL */
	###############################################################################################
	#
	# if they have clicked the login button
	#
	###############################################################################################
	if ($login) {
		$success = valid_otp($form_challenge_response, $user);
		if ($success) {
			/* update session/auth state and redirect to system resources */
		}
	}
	 
	 
	 
	 
	###############################################################################################
	#
	# print out login page
	#
	###############################################################################################
	print "<HTML><HEAD><TITLE>Login</TITLE></HEAD></HTML>";
	 
	$sequence = get_otp_seq();
	if ($sequence == -1) {
		/* print error message and exit; */
	}
	 
	print "
		<p>
		<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
		<p>
		<INPUT TYPE=\"TEXT\" NAME=\"user\" VALUE=\"$user\">
		<p>
		Enter One-Time Password for Challenge number <B>".get_otp_seq()."</B>:
		<br><INPUT TYPE=\"TEXT\" NAME=\"form_challenge_response\" VALUE=\"$form_challenge_response\" SIZE=\"31\">
		<p>
		<INPUT TYPE=\"SUBMIT\" NAME=\"LOGIN\" VALUE=\"Login\">
		</FORM>
		<P>
		";
?>
<?php

	/* **************************************************************************************
	* FUNCTION          : get_otp_seq
        *
	* LAST UPDATED      : 17 March 2005
        *
	* PARAMS            : none
	*
	* DESCRIPTION       : retrieves the challenge number, or sequence number, that is used 
        *                     to question the user for an OTP.
	*
	* PRECONDITION      : user has initialized an OTP
	*
	* POSTCONDITION     : function returns the challenge number or errs out
	*
	************************************************************************************** */
	function get_otp_seq() {
		/*  look at user credentials,
		retrieve sequence number for that user,
		and return sequence number or err out
		*/
		//1. Find user credentials
		//$uid = getuid();
		//2. Retrieve sequence number for user 
		//$sql = "SELECT sequence FROM otp WHERE user_id='$uid'";
		//$res = db_query($sql);

		//3. Err out or return challenge number
		if (!$res || db_numrows($res)<1) {

		} else if (db_numrows($res)>1) {

		} else {
			//$row = db_fetch_array($res);
			//return $row['sequence'];
		}
	}
?>
<?php
	/*
	-----BEGIN PGP MESSAGE-----
	Version: GnuPG v1.2.1 (GNU/Linux)
	 
	hQIOA6jz1R+atzBZEAf9EJXPCKrk9SPzLNALLY61g9oxSIq/eExVKDkTeTed9y5p
	HV37pp2tJXBoT5kNJ46Y2/xd1tDmfnSCD/cOVcjOafis7eGKElR39o4VXFi6ToqN
	w7RKZyY6TvL+uaFkNTHED4oSFRH7IYK9zxHBKoiO9qAcWBSaoMMgA1uyBoDvM6Hf
	+1TpyAO3I10KG50/rdWVLXWLaNaPk+dhmx7s965k9wrmYV6fdH79P1E/Z7grjv8o
	oPbNnF0PSruSc42ZTk4nfoMHI5ORJ5qAtN0BfWsFm+/zuwCci/zdNWDyY/7jrJWN
	lc2We5rVF4F6OLmKXUWWIIS2okAorIRmZt9Xc/e7Zgf9HtMZeJAJgHoLRgV9IHuw
	9Ul6hqk2634UpcIiRwfMU/0towB8qGRmm6f8ZEGy8FsYvdlO7JmRinVTY5RulhPD
	R8LWN/Y6kUd5DnS2ddfn75WrUuInTBtq0LKpLPZt6dZimdqO4skCxC2qkwVGEtjH
	hgyH9ItonQPD8Wkp2KliTq3D7NeTDfYC1fEkGzO2avIjue80mA0yfzCW1UNk2wd3
	kvHTicScLi40sUq57nKPZc4EM0/KngegNjSFNRuunN5iJ0Y4cvRs8bh/toLfcrQi
	7DxDs9BQMcPcbXSWoWYYwjWkcgI/mYAEKNnaegqG2NUh+yXJzhUSZsEnCLYEsKUg
	vtKZAb5HIw8MWdSSWzBvmzVDBX7TnXtwQVHfUTtZQZ17ZHE1pzKhSYQCOG/4OcFa
	EVMhXzyPRJ+DyrnZc85/5vrpAYNE1GLYatSb2jky2c4Alguk8KjzYvlZtDbnn8hs
	LgDvOA4zFzaVdEwlqJYzdRA5cEDDMDPWUaXgGYcfUoacp41fLPv9uWb/RHlaR4Ku
	ArepJGt9N5/Ztc3i
	=YHhe
	-----END PGP MESSAGE-----
	*/
?>
