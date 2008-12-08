<?php
	/* **************************************************************************************
	* FILE            : otp_stubs.php
	* LAST UPDATED    : December 2008 by james.barkley@gmail.com
	*
	* DESCRIPTION     : This piece of code has a number of i/o functions that are application
	*                   specific. Library users will need to fill this in with their own code
        *                   to use this library.
	*
	* FUNCTIONS       : set_last_otp
	*                   compare_last_otp
	*                   store_hash
	*
	* LICENSE         : GPL
	*
	************************************************************************************** */


	/* **************************************************************************************
         *
         *      YOUR SYSTEM SPECIFIC FUNCTIONS. YOU FILL THESE IN !!!!
         *
	************************************************************************************** */
	








 
	 
	 
	/* **************************************************************************************
	* FUNCTION          : set_last_otp
        *
	* LAST UPDATED      : 17 March 2005
        *
	* PARAMS            : 
        *   $cur	      last used otp
	*
	* DESCRIPTION       : sets $cur as the last otp used by that user
	*
	************************************************************************************** */
	function set_last_otp($cur) {
		$sql = "UPDATE otp SET last_otp='$cur',
	        	sequence='$seq' WHERE user_id='$uid'";
		db_query($sql);
		$sql = "UPDATE session set lock_state=0
		        WHERE user_id=$uid";
		db_query($sql);
		return true;
	}
	 
	/* **************************************************************************************
	* FUNCTION          : compare_last_otp
        *
	* LAST UPDATED      : 17 March 2005
        *
	* PARAMS            : 
        *   $last             an otp expected to be the last one requested.
	*
	* DESCRIPTION       : Takes an OTP, presumably from the user, and compares it with the 
	*                     database/datasource to see if it is the correct OTP.
	*
	************************************************************************************** */
	function compare_last_otp($last) {
		/* look at user credentials,
		retrieve last used otp,
		compare last used otp with passed in variable,
		return true if equal, false otherwise
		*/
		$uid = user_getid();
		if (!$uid) { return false; }
		$sql = "SELECT * FROM otp WHERE user_id='$uid'
		        AND last_otp='$last'";
		$res = db_query($sql);
		if (!$res || db_numrows($res)<1) { return false; }
		if (db_numrows($res)>1 ) { return false; }
		else {
			$row  = db_fetch_array($match);
			$seq = $row['sequence'];
			return ($seq-1);
		}
		return false; /* catch-all */
	}
	 
	 
	/* **************************************************************************************
	* FUNCTION          : store_hash
        *
	* LAST UPDATED      : 17 March 2005
        *
	* PARAMS            : 
        *   $sequence	      sequence to store 
        *   $initial          initial otp 
	*
	* DESCRIPTION       : initialize otp status of $user to $sequence and $initial
	*
	************************************************************************************** */
	function store_hash ($sequence, $initial) {
		/*  initialize otp status of $user to $sequence and $initial */
		if (!$uid) { $uid = user_getid(); }
		if (!$uid) { return false; }
		$sql = "SELECT * FROM otp WHERE user_id=$uid";
		$res = db_query($sql);
		if (!$res || db_numrows($res)<1) {
			$sql = "INSERT INTO otp (user_id, sequence, last_otp, time)
        		VALUES ($uid, ".($sequence+__CN_OPTSIZE-1).", '$initial', ".time().")";
		} else {
			$sql = "UPDATE otp set sequence='".($sequence+__CN_OPTSIZE-1)."'
				, last_otp='$initial'
				, time='".time()."'
			        WHERE user_id='$uid'";
		}
		db_query($sql);
	}
	 
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
