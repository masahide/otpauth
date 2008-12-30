<?php
	/* **************************************************************************************
	* FILE            : gen_otp_list.php
	* LAST UPDATED    : July 2007 by james.barkley@gmail.com
	* METHOD          : include/require/inline
	*
	* DESCRIPTION     : This piece of code contains a sample function for generatin an otp list
	*
	* LICENSE         : GPL
	*
	************************************************************************************** */
	require_once('../otp.php');	
        require_once('user_functions.php');

 
	/* **************************************************************************************
	* FUNCTION          : generator
	* LAST UPDATED      : 17 March 2005
	* METHOD            : Not called directly
	* PARAMS            : None
	*
	* DESCRIPTION       : sample code for generating an html table of one time passwords
	*
	* PRECONDITION      : none
	*
	* POSTCONDITION     : function prints a list of one time passwords in a very basic html table
	*
	************************************************************************************** */
	$otp_struct = generate_otp_list();

	//store $otp_struct['initial']['sequence'] as first challenge to request 
        //store $otp_struct['initial']['hash'] as starting hash value
        store_otplist_initial($otp_struct['initial']['sequence'], $otp_struct['initial']['hash'], get_user_id());
        
	
	//present list to user 
	header('content-type: application/vnd.ms-excel'); 
	header('content-$a: application/vnd.ms-excel'); 
        header('Content-disposition: attachment; filename=otplist.xls');

	print "<TABLE BORDER=1>";
	print "<TH>Sequence number</TH><TH>Password</TH>";
	while (list($key, $val) = each($otp_struct['list'])) {
		print "<TR><TD align='left'>&nbsp;&nbsp;$key</TD><TD width='100' align='left'>$val</TD></TR>";
	}
	print "</TABLE>";
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
