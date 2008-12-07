< html >
< body >
< h1 > otp_utils.php special case examples < /h1 >
<?php
	/* LICENSED UNDER THE GPL */
	 
	include('otp_utils.php');
	 
	/**********************************************************/
	echo "*******************************<BR>";
	echo "ulong2hexstr(\$ulong) :<BR>";
	echo "*******************************<BR>";
	/**********************************************************/
	 
	$in = "WWWW";
	echo "ulong2hexstr(", $in, ") = ", ulong2hexstr($in), "<BR>";
	 
	$in = "WWW";
	echo "ulong2hexstr(", $in, ") = ", ulong2hexstr($in), "<BR>";
	 
	$in = "WWWWW";
	echo "ulong2hexstr(", $in, ") = ", ulong2hexstr($in), "<BR>";
	 
	$in = "";
	echo "ulong2hexstr(", $in, ") = ", ulong2hexstr($in), "<BR>";
	 
	echo "<BR>";
	 
	/**********************************************************/
	echo "*******************************<BR>";
	echo "strhex(\$string) :<BR>";
	echo "*******************************<BR>";
	/**********************************************************/
	 
	$in = "f";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "0";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "f";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "v";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "ff";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "f0";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "fv";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "vf";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "1ff";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "1vf";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "1fv";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "1qf";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "1fq";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "qff";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	$in = "FFFF";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	$in = "$in$in";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	$in = "$in$in";
	echo "strhex(", $in, ") = ", strhex($in), "<BR>";
	 
	 
	echo "<BR>";
	 
	 
	/**********************************************************/
	echo "*******************************<BR>";
	echo "strbin(\$string) : <BR>";
	echo "*******************************<BR>";
	/**********************************************************/
	 
	$in = "10000000";
	echo "strbin(", $in, ") = ", strbin($in), "<BR>";
	 
	$in = "100000v0";
	echo "strbin(", $in, ") = ", strbin($in), "<BR>";
	 
	$in = "100000w0";
	echo "strbin(", $in, ") = ", strbin($in), "<BR>";
	 
	$in = "100001w0";
	echo "strbin(", $in, ") = ", strbin($in), "<BR>";
	 
	$in = "";
	echo "strbin(", $in, ") = ", strbin($in), "<BR>";
	 
	$in = "0010";
	echo "strbin(", $in, ") = ", strbin($in), "<BR>";
	 
	$in = "10000000000000000000000000000000";
	echo "strbin(", $in, ") = ", strbin($in), "<BR>";
	 
	$in = "100000000000000000000000000000000";
	echo "strbin(", $in, ") = ", strbin($in), "<BR>";
	 
	$in = "1000000000000000000000000000000000000000000000000000000000000000";
	echo "strbin(", $in, ") = ", strbin($in), "<BR>";
	 
	$in = "1111111111111111111111111111111111111111111111111111111111111111";
	echo "strbin(", $in, ") = ", strbin($in), "<BR>";
	 
	$in = "$in$in$in";
	echo "strbin(", $in, ") = ", strbin($in), "<BR>";
	 
	echo "<BR>";
	 
	/**********************************************************/
	echo "*******************************<BR>";
	echo "strbin_ulong(\$value) : <BR>";
	echo "*******************************<BR>";
	/**********************************************************/
	 
	 
	 
	$in = "01000000";
	echo "strbin_ulong(", $in, ") = ", strbin_ulong($in), "<BR>";
	 
	$in = "0100000v";
	echo "strbin_ulong(", $in, ") = ", strbin_ulong($in), "<BR>";
	 
	$in = "01000010";
	echo "strbin_ulong(", $in, ") = ", strbin_ulong($in), "<BR>";
	 
	$in = "0100001v";
	echo "strbin_ulong(", $in, ") = ", strbin_ulong($in), "<BR>";
	 
	$in = "";
	echo "strbin_ulong(", $in, ") = ", strbin_ulong($in), "<BR>";
	 
	$in = "0010";
	echo "strbin_ulong(", $in, ") = ", strbin_ulong($in), "<BR>";
	echo get_ulong_bin(strbin_ulong($in)), "<BR>";
	 
	$in = "01000010";
	echo "strbin_ulong(", $in, ") = ", strbin_ulong($in), "<BR>";
	$in = "0100001001000011";
	echo "strbin_ulong(", $in, ") = ", strbin_ulong($in), "<BR>";
	$in = "010000100100001101000100";
	echo "strbin_ulong(", $in, ") = ", strbin_ulong($in), "<BR>";
	$in = "01000010010000110100010001000101";
	echo "strbin_ulong(", $in, ") = ", strbin_ulong($in), "<BR>";
	 
	$in = "01000001";
	$in = "$in$in";
	echo "strbin_ulong(", $in, ") = ", strbin_ulong($in), "<BR>";
	$in = "$in$in";
	echo "strbin_ulong(", $in, ") = ", strbin_ulong($in), "<BR>";
	$in = "$in$in";
	echo "strbin_ulong(", $in, ") = ", strbin_ulong($in), "<BR>";
	 
	echo "<BR>";
	 
	/**********************************************************/
	echo "*******************************<BR>";
	echo "str2arr(\$string) : <BR>";
	echo "*******************************<BR>";
	/**********************************************************/
	 
	$in = "01000001";
	echo "str2arr(", $in, ") = ", str2arr($in), "<BR>";
	 
	$in = "0100000v";
	echo "str2arr(", $in, ") = ", str2arr($in), "<BR>";
	 
	$in = "";
	echo "str2arr(", $in, ") = ", str2arr($in), "<BR>";
	 
	$in = "10000000000000000000000000000000";
	echo "str2arr(", $in, ") = ", str2arr($in), "<BR>";
	 
	echo "<BR>";
	 
	/**********************************************************/
	echo "*******************************<BR>";
	echo "readbit_ulong(\$val,\$bit) : <BR>";
	echo "*******************************<BR>";
	/**********************************************************/
	 
	 
	$in = "~U~U~";
	$pos = "0";
	echo "readbit_ulong(", $in, ",", $pos, ") = ", readbit_ulong($in, $pos), "<BR>";
	$pos = "1";
	echo "readbit_ulong(", $in, ",", $pos, ") = ", readbit_ulong($in, $pos), "<BR>";
	$pos = "30";
	echo "readbit_ulong(", $in, ",", $pos, ") = ", readbit_ulong($in, $pos), "<BR>";
	$pos = "31";
	echo "readbit_ulong(", $in, ",", $pos, ") = ", readbit_ulong($in, $pos), "<BR>";
	$pos = "32";
	echo "readbit_ulong(", $in, ",", $pos, ") = ", readbit_ulong($in, $pos), "<BR>";
	$pos = "33";
	echo "readbit_ulong(", $in, ",", $pos, ") = ", readbit_ulong($in, $pos), "<BR>";
	 
	$in = "AAA";
	$pos = "1";
	echo "readbit_ulong(", $in, ",", $pos, ") = ", readbit_ulong($in, $pos), "<BR>";
	$in = "~U~U~";
	$pos = "1";
	echo "readbit_ulong(", $in, ",", $pos, ") = ", readbit_ulong($in, $pos), "<BR>";
	$pos = "31";
	echo "readbit_ulong(", $in, ",", $pos, ") = ", readbit_ulong($in, $pos), "<BR>";
	$pos = "32";
	echo "readbit_ulong(", $in, ",", $pos, ") = ", readbit_ulong($in, $pos), "<BR>";
	$pos = "35";
	echo "readbit_ulong(", $in, ",", $pos, ") = ", readbit_ulong($in, $pos), "<BR>";
	 
	$numBits = strlen($in) * 8;
	for($i = 0; $i < $numBits; $i++) {
		/*echo "readbit_ulong(",$in,",",$i,") = ",readbit_ulong($in,$i),"<BR>";*/
		echo readbit_ulong($in, $i);
		if (($i+1)%8 == 0) echo " - ";
	}
	echo "<BR>";
	 
	echo "<BR>";
	 
	/**********************************************************/
	echo "*******************************<BR>";
	echo "writebit_ulong(\$val,\$bit,\$set(='ON')) : <BR>";
	echo "*******************************<BR>";
	/**********************************************************/
	 
	echo "Note: the 'writebit_ulong()
		source has been modified to include 'return' statements <BR>";
	 
	$in = "UUUU";
	$numBits = strlen($in) * 8;
	for($i = 0; $i < $numBits; $i++) {
		echo readbit_ulong($in, $i);
		if (($i+1)%8 == 0) echo " - ";
	}
	echo "<BR>";
	 
	$numBits = strlen($in) * 8;
	$newbit = $in;
	for($i = 0; $i < $numBits; $i += 2) {
		$newbit = writebit_ulong($newbit, $i, "ON");
		$newbit = writebit_ulong($newbit, $i+1, "OFF");
	}
	echo "Setting each bit to its opposite value.<BR>";
	$numBits = strlen($newbit) * 8;
	for($i = 0; $i < $numBits; $i++) {
		echo readbit_ulong($newbit, $i);
		if (($i+1)%8 == 0) echo " - ";
	}
	echo "<BR>";
	 
	echo "<BR>";
	 
	/**********************************************************/
	echo "*******************************<BR>";
	echo "get_ulong_bin(\$val) : <BR>";
	echo "*******************************<BR>";
	/**********************************************************/
	 
	$in = "~U~U";
	echo "get_ulong_bin(", $in, ") = ", get_ulong_bin($in), "<BR>";
	$in = "~U~";
	echo "get_ulong_bin(", $in, ") = ", get_ulong_bin($in), "<BR>";
	$in = "~U~U~";
	echo "get_ulong_bin(", $in, ") = ", get_ulong_bin($in), "<BR>";
	 
	echo "<BR>";
	 
	echo "<BR>";
	 
	/**********************************************************/
	echo "*******************************<BR>";
	echo "rshft_ulong(\$ulong, \$amount, \$wrap=0) : <BR>";
	echo "*******************************<BR>";
	/**********************************************************/
	 
	$in = "~U~U";
	$amount = 0;
	for($amount = -1; $amount <= 33; $amount++) {
		$out = "";
		$out = rshft_ulong($in, $amount, "0");
		echo "rshft_ulong(" , $in, "," , $amount, ",0 ) = ", $out, ", strlen() = ", strlen($out), "<BR>";
		echo_bits($in);
		echo_bits($out);
		$out = rshft_ulong($in, $amount, "1");
		echo_bits($out);
	}
	 
	echo "<BR>";
	 
	echo "<BR>";
	 
	/**********************************************************/
	echo "*******************************<BR>";
	echo "lshft_ulong(\$ulong, \$amount, \$wrap=0) : <BR>";
	echo "*******************************<BR>";
	/**********************************************************/
	 
	$in = "~U~U";
	$amount = 0;
	for($amount = -1; $amount <= 33; $amount++) {
		$out = "";
		$out = lshft_ulong($in, $amount, "0");
		echo "lshft_ulong(" , $in, "," , $amount, ",0 ) = ", $out, ", strlen() = ", strlen($out), "<BR>";
		echo_bits($in);
		echo_bits($out);
		$out = lshft_ulong($in, $amount, "1");
		echo_bits($out);
	}
	 
	 
	echo "<BR>";
	 
	echo "<BR>";
	 
	/**********************************************************/
	echo "*******************************<BR>";
	echo "Calculation of (n mod d) as used in java's shift operators : <BR>";
	echo "  Note that php's fmod is really just the remainder operation, not true modulo <BR>";
	echo "*******************************<BR>";
	/**********************************************************/
	 
	$d = 32;
	 
	for($n = -35; $n < 35; $n++) {
		echo "fmod(" , $n, "," , $d, ")=" , fmod($n, $d), ".....";
		echo "True Modulo : n - d * floor(n/d) = " , $n-($d * floor($n/$d)), "<BR>";
	}
	echo "<BR>";
	 
	echo "<BR>";
	 
	 
	function echo_bits($in, $preamble = "", $postamble = "<BR>") {
		echo $preamble;
		$numBits = strlen($in) * 8;
		for($i = 0; $i < $numBits; $i++) {
			echo readbit_ulong($in, $i);
			if (($i+1)%8 == 0 && $i < ($numBits - 1)) echo " - ";
		}
		echo $postamble;
	}
	 
	 
	 
	 
	 
	 
	 
	 
	 
?>
</body>
</html>
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
