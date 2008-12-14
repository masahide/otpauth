<?php
	/***************************************************************************************
	* FILE            : nutils.php
	* LAST UPDATED    : December 2008 by james.barkley@gmail.com
	*
	* DESCRIPTION     : This piece of code has a number of utility functions for handling
	*                   numbers and converting between formats and types 
        *                   (long,bin,hex,str,etc.). Standard size binary word here is 32-bits 
        *                   unsigned long int. Some of these functions may only work with little 
        *                   endian byte-ordered machines. This code is licensed under the GPL
	*
	* FUNCTIONS       : ulong2binstr
	*                   str2arr
	*                   binstr2int
	*                   strbin2ulong
	*                   hexstr2int
	*                   ulong2hexstr
	*                   lshft_ulong
	*                   rshft_ulong
	*                   readbit_ulong
	*                   writebit_ulong
	*                   writebit_ulong_set
	*                   writebit_ulong_unset
	*                   randomBooleanArray
	*                   randomBytes
        *
	* LICENSE         : GPL
	*
	************************************************************************************** */
	 
	/* **************************************************************************************
	* FUNCTION          : ulong2hexstr
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $ulong          : machine-packed unsigned long number
	*
	* DESCRIPTION       : takes a packed, unsigned long number and returns a hex string
	*                     that represents that number.
	*
	* PRECONDITION      : function is given a machine-packed, 32-bit (4-byte) number
	*
	* POSTCONDITION     : function returns a hexadecimal string representation of the number
	*
	************************************************************************************** */
	function ulong2hexstr($ulong, $padLength = -1) {
		 
		// this fix allows the function to work as before, but allows an arbitrary
		//   left 0 pad to be applied.
		return str_pad(base_convert(ulong2binstr($ulong), 2, 16), 8, "0", STR_PAD_LEFT);
		 
		// This was the original line
		//return base_convert(ulong2binstr($ulong), 2, 16);
		 
		// This was the initial fix of the bug
		//$boolArr = str2arr(ulong2binstr($ulong));
		//return booleanArray_2_hexString($boolArr);
	}
	 
	/* **************************************************************************************
	* FUNCTION          : hexstr2int
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $string         : string representation of hex number
	*
	* DESCRIPTION       : takes a string hex number and returns a numeric integer representation
	*                     note that strings prefixed with 0x are not handled.  
        *                     Here are some examples:
	*                     0xFF = 255
	*                     aBcD = 43981
	*                     FFFF = 65535
	*                     FFFFFF = 16777215
	*                     FFFFFFFF = 4294967295
	*                     FFFFFFFFFF = 1099511627775
	*                     FFFFFFFFFFFF = 2.8147497671066E+14
	*                     fffffffffffffffffffffffffFFFFFFFFFFFFFFFFFFFFFFF = 6.2771017353867E+57
	*                     0x00 = 0
	*                     0x0j = false 
	*
	* PRECONDITION      : function is passed a string that is a hexadecimal numeric format
	*
	* POSTCONDITION     : function returns an integer value equivalent to the value of the 
        *                     hex number passed in or throws exception and returns false on error
	*
	************************************************************************************** */
	function hexstr2int($string) {
		if (!is_string($string)) {
			throw new Exception("hexstr2int(): non-string value cannot be converted to int");
			return false;
		}
			

		if (null==$string) {
			throw new Exception("hexstr2int(): null value cannot be converted to int");
			return false;
		}

		if (''==$string || strlen($string)<1) {
			throw new Exception("hexstr2int(): empty string cannot be converted to int");
			return false;
		}

		/* normalize string
		1.  make it all lowercase
		2.  strip whitespace
		3.  strip leading 0x if necessary
		4.  check that all chars are in allowable range */
		$string = strtolower($string);
		/* use this if you expect whitespace in mid-string
		preg_replace("/\s/", "", $string); */
		$string = trim($string);
		$string = preg_replace("/0x/", "", $string);
		if (!preg_match("/^[0-9a-f]+$/", $string)) {
			throw new Exception("hexstr2int(): $string is not valid hex");
			return false;
		}
		 
		/* this is a really naive algorithm
		and in the future hopefully will be changed out with
		something more optimum */
		$cum = 0;
		for ($i = strlen($string); $i > 0; $i--) {
			$cur_chr = substr($string, $i-1, 1);
			switch ($cur_chr) {
				case '0':
				$cur = 0;
				 break;
				case '1':
				$cur = 1;
				 break;
				case '2':
				$cur = 2;
				 break;
				case '3':
				$cur = 3;
				 break;
				case '4':
				$cur = 4;
				 break;
				case '5':
				$cur = 5;
				 break;
				case '6':
				$cur = 6;
				 break;
				case '7':
				$cur = 7;
				 break;
				case '8':
				$cur = 8;
				 break;
				case '9':
				$cur = 9;
				 break;
				case 'a':
				$cur = 10;
				 break;
				case 'b':
				$cur = 11;
				 break;
				case 'c':
				$cur = 12;
				 break;
				case 'd':
				$cur = 13;
				 break;
				case 'e':
				$cur = 14;
				 break;
				case 'f':
				$cur = 15;
				 break;
			}
			$pow = pow(16, strlen($string)-$i);
			$cur = $cur * $pow;
			$cum += $cur;
		}
		return $cum;
	}
	 
	/* **************************************************************************************
	* FUNCTION          : binstr2int
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $string         : string or array representation of binary number
	*
	* DESCRIPTION       : convert a string or array of binary numbers to numeric integer value
	*                     Examples:
	*                     "01101101010"
	*                     $string[0] = "0", $string[1] = "1", ..., $string[31] = "0"
        *
	* PRECONDITION      : $string is a string or array consisting of only 1 and 0 values and 
        *                     possibly ending with a 'b'
        *
	* POSTCONDITION     : returns a numeric representation of the string as an integer
	*
	* NOTE              : This is a pretty naive algorithm - there is probably a better way
	*                     to compute this without chewing up so much CPU cycles
	*
	************************************************************************************** */
	function binstr2int($string) {
		if (null==$string) {
			throw new Exception("binstr2int(): null value cannot be converted to int");
			return false;
		}


		/* make sure string is a string and not an array */
		if (is_array($string)) {
			$string = implode('', $string);
		}

		/* make sure string is a string at this point */
 		if (!is_string($string)) {
			throw new Exception("binstr2int(): non-string cannot be converted to int");
			return false;
		}

		/* make sure string is not empty */
		if (''==$string || strlen($string)<1) {
			throw new Exception("binstr2int(): empty string cannot be converted to int");
			return false;
		}

		/* normalize string to lower */
		$string = strtolower($string);

		/* check for and remove 'b' notation on end of string */
		$string = preg_replace("/b$/", "", $string);

		$cum = 0;
		for ($i = strlen($string); $i > 0; $i--) {
			$cur_chr = substr($string, $i-1, 1);
			switch ($cur_chr) {
				case '0':
				$cur = 0;
				 break;
				case '1':
				$cur = 1;
				 break;
				default:
					/* error condition */
					throw new Exception("binstr2int(): string should only have '1' or '0' chars");
					return false;
			}
			$pow = pow(2, strlen($string)-$i);
			$cur = $cur * $pow;
			$cum += $cur;
		}
		return $cum;
	}
	 
	/* **************************************************************************************
	* FUNCTION          : strbin2ulong
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $value          : a string or array representation of a binary number
	*
	* DESCRIPTION       : ingests a string or array representation of a binary number
	*                     and returns a machine-native packed unsigned long integer.
	*                     Standard size here is 32-bit (4-byte) value returned.  Note
	*                     that big/little endian byte-order is not enforced.
	*                     Examples:
	*                     "01101101010"
	*                     $string[0] = "0", $string[1] = "1", ..., $string[31] = "0"
	*                     returns a numeric representation of the string
	*                     as a machine-packed, unsigned ulong.
	*
	* PRECONDITION      : $value is a string or array consisting of only 1 and 0 values
	*                     and possibly ending with a 'b'
        *
	* POSTCONDITION     : returns a native-machine format packed binary number of
	*                     the value repesented by $value in binary
	*
	* NOTES             : WARNING, unpacking a ulong number greater than 31 bits in length
	*                     will result in overflow to a negative number.  PHP does not
	*                     handle unsigned ints or signed ones greater than 31 bits in length.
	*
	************************************************************************************** */
	function strbin2ulong($value) {
		if (!is_array($value)) {
			$value = str2arr($value);
		}
		/* make sure value is a value */
		$ulong = pack("L", binstr2int($value));
		return $ulong;
	}
	 
	 
	/* **************************************************************************************
	* FUNCTION          : str2arr
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $string         : a string of any size or characters
	*
	* DESCRIPTION       : ingests a string and returns and returns an ordered array of the string
	*                     accepts a string, returns an ordered array
	*                     with each character being one array element
	*
	* PRECONDITION      : $string is a string variable of any size or characters
        *
	* POSTCONDITION     : returns a numbered array (ordered 0 through (n-1) where n is the 
        *                     length of the string)
	*
	*
	************************************************************************************** */
	function str2arr($string) {
		if (!is_string($string)) {
			return -1;
		}
		$count = 0;
		for ($i = 0; $i < strlen($string); ++$i) {
			$arr[$i] = substr($string, $i, 1);
		}
		return $arr;
	}
	 
	/* **************************************************************************************
	* FUNCTION          : readbit_ulong
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $val            : a machine-packed, unsigned long int (32-bit/4-byte)
	*   $bit            : a integer representing a bit position from 0 to 31.  bit 0 is 
        *                     most significant
	*
	* DESCRIPTION       :  accepts a machine-packed, unsigned long int
	*                      and a bit position and returns the value
	*                      of the bit at that position of the integer as a character 
        *                      value of either '0' or '1'
	*                      - note the difference
	*                      between '1' and 1 and also the difference
	*                      between '0' and 0)
	*
	* PRECONDITION      : $val is a machine-packed, unsigned long int (32-bit/4-byte) 
        *                     and $bit is an int from 0 to 31
        *
	* POSTCONDITION     : returns a '0' character or a '1' character representing the bit 
        *                     at $bit of $val
	*
	************************************************************************************** */
	function readbit_ulong($val, $bit) {
		if (!($bit >= 0 AND $bit <= 31)) {
			return -1;
		}
		$mask_string = pack("L", pow(2, 31-$bit));
		$tmp = unpack("Ltmp", $mask_string);
		$tmp = $tmp['tmp'];
		$val = ($val & $mask_string);
		$val = unpack("Ltmp", $val);
		$val = $val['tmp'];
		if ($val == 0) {
			return '0';
		} else {
			return '1';
		}
	}
	 
	/* accepts a machine-packed, unsigned long int
	and a bit position and a set value (either 'ON' or 'OFF').
	/* **************************************************************************************
	* FUNCTION          : writebit_ulong
	* LAST UPDATED      : 06 December 2008
	* PARAMS            :
	*   $val            : a machine-packed, unsigned long int (32-bit/4-byte)
	*   $bit            : a integer representing a bit position from 0 to 31.  bit 0 is 
        *                     most significant
        *   $set            : either "ON" or "OFF". Tells function which way to flip the bigt
	*
	* DESCRIPTION       :  accepts a machine-packed, unsigned long int
	*                      and a bit position and a set value (either 'ON or 'OFF').
	*                      Function sets the value of the bit at that position of the integer
        *                      Bit 1 is most significant.
	*
	* PRECONDITION      : $val is a machine-packed, unsigned long int (32-bit/4-byte), 
        *                     $bit is an int from 0 to 31,
        *                     $set is either "ON" or "OFF"
        *
	* POSTCONDITION     : sets a '0' character or a '1' character representing the bit 
        *                     at $bit of $val
	*
	************************************************************************************** */
	function writebit_ulong($val, $bit, $set = 'ON') {
		if ($set == 'ON') {
			writebit_ulong_set($val, $bit);
		}
		else if ($set == 'OFF') {
			writebit_ulong_unset($val, $bit);
		} else {
			//error message
                }
	}
	 
	/* helper function for writebit_ulong - sets a bit to 1 */
	/* **************************************************************************************
	* FUNCTION          : writebit_ulong_set
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $val            : a machine-packed, unsigned long int (32-bit/4-byte)
	*   $bit            : a integer representing a bit position from 0 to 31.  bit 0 is 
        *                     most significant
	*
	* DESCRIPTION       :  accepts a machine-packed, unsigned long int
	*                      and a bit position and a set value (either 'ON or 'OFF').
	*                      Function sets the value of the bit at that position of the integer
        *                      to a 1. Bit 1 is most significant.
	*
	* PRECONDITION      : $val is a machine-packed, unsigned long int (32-bit/4-byte), 
        *                     $bit is an int from 0 to 31,
        *
	* POSTCONDITION     : sets a 1 representing the bit 
        *                     at $bit of $val
	*
	************************************************************************************** */
	function writebit_ulong_set($val, $bit) {
		$bin_val = ulong2binstr($val);
		$bin_arr = str2arr($bin_val);
		$bin_arr[$bit] = 1;
		$bin_val = implode("", $bin_arr);
		return (strbin2ulong($bin_val));
	}
	 
	/* **************************************************************************************
	* FUNCTION          : writebit_ulong_unset
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $val            : a machine-packed, unsigned long int (32-bit/4-byte)
	*   $bit            : a integer representing a bit position from 0 to 31.  bit 0 is 
        *                     most significant
	*
	* DESCRIPTION       :  accepts a machine-packed, unsigned long int
	*                      and a bit position and a set value (either 'ON or 'OFF').
	*                      Function sets the value of the bit at that position of the integer
        *                      to a 0. Bit 1 is most significant.
	*
	* PRECONDITION      : $val is a machine-packed, unsigned long int (32-bit/4-byte), 
        *                     $bit is an int from 0 to 31,
        *
	* POSTCONDITION     : sets a 0 representing the bit 
        *                     at $bit of $val
	*
	************************************************************************************** */
	function writebit_ulong_unset($val, $bit) {
		$bin_val = ulong2binstr($val);
		$bin_arr = str2arr($bin_val);
		$bin_arr[$bit] = 0;
		$bin_val = implode("", $bin_arr);
		return (strbin2ulong($bin_val));
	}
	 
	 
	/* **************************************************************************************
	* FUNCTION          : ulong2binstr
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $val            : a machine-packed, unsigned long int (32-bit/4-byte)
	*
	* DESCRIPTION       :  accepts a machine-packed, unsigned long int
	*                      and returns a string representation of the 
	*                      binary entity (e.g. 10110010101....)
	*
	* PRECONDITION      : $val is a machine-packed, unsigned long int (32-bit/4-byte), 
        *
	* POSTCONDITION     : returns a string representation of the ulong
	*
	************************************************************************************** */
	function ulong2binstr($val) {
		$binstr = '';
		for ($i = 0; $i < 32; ++$i) {
			$binstr .= readbit_ulong($val, $i);
		}
		return $binstr;
	}
	 
	 
	/* **************************************************************************************
	* FUNCTION          : rshft_ulong
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $ulong          : a machine-packed, unsigned long int (32-bit/4-byte)
	*   $amount         : an integer representing the number of bits to shift 
	*   $wrap           : a binary (1 or 0) value indicating whether or not the shift 
        *                     should wrap the numbers that are moved out to the other side 
        *                     of the ulong or if it should be filled with zeroes.
	*
	* DESCRIPTION       :  accepts a machine-packed, unsigned long int, shift amount, and wrap.  
        *                      PHP does not support these types of operations for 32-bit unsigned
	*                      integers.  This function shifts $ulong by $amount and fills in newly 
        *                      shifted in positions to $wrap.
        *
	*                      Example 1:
	*                      rshft_ulong(pack("L",0x0), 31, 0) results in:
	*                      original value:  1000 0000 0000 0000 0000 0000 0000 0000
 	*                      returned value:  0000 0000 0000 0000 0000 0000 0000 0001
	* 
	*                      Example 2:
	*                      rshft_ulong(pack("L", 5), 2, 1) results in:
	*                      original value:  0000 0000 0000 0000 0000 0000 0000 0101
	*                      returned value:  1100 0000 0000 0000 0000 0000 0000 0001
	*
	* PRECONDITION      : $val is a machine-packed, unsigned long int (32-bit/4-byte), 
        *                     $amount is an integer, and $wrap is a binary 
        *
	* POSTCONDITION     : returns $ulong shifted by $amount with wrapped digits or zeroed
	*
	************************************************************************************** */
	function rshft_ulong($ulong, $amount, $wrap = 0) {
		$orig = str2arr(ulong2binstr($ulong));
		for ($i = 0; $i < $amount; ++$i) {
			for ($j = 0; $j < 32; ++$j) {
				if ($j == 0) {
					$shifted[$j] = $wrap;
				} else {
					$shifted[$j] = $orig[$j-1];
				}
			}
			$orig = $shifted;
		}
		return strbin2ulong($shifted);
	}
	 
	 
	 
	/* **************************************************************************************
	* FUNCTION          : lshft_ulong
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $ulong          : a machine-packed, unsigned long int (32-bit/4-byte)
	*   $amount         : an integer representing the number of bits to shift 
	*   $wrap           : a binary (1 or 0) value indicating whether or not the shift 
        *                     should wrap the numbers that are moved out to the other side 
        *                     of the ulong or if it should be filled with zeroes.
	*
	* DESCRIPTION       :  accepts a machine-packed, unsigned long int, shift amount, and wrap.  
        *                      PHP does not support these types of operations for 32-bit unsigned
	*                      integers.  This function shifts $ulong by $amount and fills in newly 
        *                      shifted in positions to $wrap.
        *
	* PRECONDITION      : $val is a machine-packed, unsigned long int (32-bit/4-byte), 
        *                     $amount is an integer, and $wrap is a binary 
        *
	* POSTCONDITION     : returns $ulong shifted right by $amount with wrapped digits or zeroed
	*
	************************************************************************************** */
	function lshft_ulong($ulong, $amount, $wrap = 0) {
		$orig = str2arr(ulong2binstr($ulong));
		for ($i = 0; $i < $amount; ++$i) {
			 
			/* have to init array because php glues arrays not in order of keys,
			but in order of insertion into the array.  Another undocumented "feature"  */
			for ($k = 0; $k < 32; ++$k) {
				$shifted[$k] = '';
			}
			 
			for ($j = 31; $j >= 0; --$j) {
				if ($j == 31) {
					$shifted[$j] = $wrap;
				} else {
					$shifted[$j] = $orig[$j+1];
				}
			}
			for ($k = 0; $k < 31; ++$k ) {
				$shifted[$k] = $shifted[$k];
			}
			#print "<H1>|".implode('',$orig)."|".implode('',$shifted)."|</H1>";
			$orig = $shifted;
		}
		return strbin2ulong($shifted);
	}
	 
	/* **************************************************************************************
	* FUNCTION          : hexString_2_booleanArray($hex)
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $hex            : a string representing a hex number
	*
	* DESCRIPTION       : This routine takes a hex string and transforms it into 
        *                     a boolean array
        *
	* PRECONDITION      : $hex is a hex string
        *
	* POSTCONDITION     : returns an array representing a binary unsigned long, with 
        *                     each position of the array set as a 1 or a 0
        *
	* NOTES             : This routine is much faster than the routine it replaces (see 
        *                     commented out code) and is general purpose. 
	*
	************************************************************************************** */
	function hexString_2_booleanArray($hex) {
		$len = strlen($hex);
		$t = "0000000100100011010001010110011110001001101010111100110111101111";
		$binString = "";
		for($i = 0; $i < $len; $i++) {
			$binString .= substr($t, (hexdec(substr($hex, $i, 1))) * 4, 4);
		}
		return str2arr($binString);
	}
	 
	/*
	function hexString_2_booleanArray($hex) {
	for ($i = 0; $i < 2; ++$i) {
	$fin[$i] = hexstr2int(substr($hex,$i*8,8));
	$fin[$i] = pack("L", $fin[$i]);
	}
	 
	$binString1 = ulong2binstr($fin[0]);
	$binString2 = ulong2binstr($fin[1]);
	 
	$binArray1 = str2arr($binString1);
	$binArray2 = str2arr($binString2);
	 
	$binArray1 = array_merge($binArray1,$binArray2);
	return $binArray1;
	}
	*/
	 
	/* **************************************************************************************
	* FUNCTION          : booleanArray_2_hexString
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $boolArr        : a boolean array that represents an unsigned int 
	*
	* DESCRIPTION       : This routine takes a boolean array transforms it into 
        *                     a hex string
        *
	* PRECONDITION      : $boolArr is an array representation of a binary entity
        *
	* POSTCONDITION     : returns an string of hex digits that is equal numerically 
        *                     to the binary number it ingested
        *
	* NOTES             : WARNING, This consumes 4 bit nibbles and ignores any trailing bits. 
        *                    
	*
	************************************************************************************** */
	function booleanArray_2_hexString($boolArr) {
		$t = "0123456789abcdef"; // lower case letter to conform with sha1() convention
		$length = floor(count($boolArr)/4);
		$hex = "";
		for($i = 0; $i < $length; $i++) {
			$index = binStr2int(implode(array_slice($boolArr, $i * 4, 4)));
			$hex = $hex.substr($t, $index, 1);
		}
		return $hex;
	}
	
 
	/***************************************************************************************
	* FUNCTION          : randomBooleanArray
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $numBits        : an integer representing the amount of random data in bits 
        *                     you want returned
	*
	* DESCRIPTION       : This routine takes an integer and returns a random 
        *                     boolean array of that many bits
        *
	* PRECONDITION      : $numBits is a positive integer
        *
	* POSTCONDITION     : returns an array of bools representing a random binary number
        *
	*
	************************************************************************************** */
	function randomBooleanArray($numBits) {
		$bytesString = randomBytes($numBits);
		$hexString = bin2Hex($bytesString);
		$booleanArray = hexString_2_booleanArray($hexString);
		return array_slice($booleanArray, 0, $numBits);
	}

	/***************************************************************************************
	* FUNCTION          : randomBytes
	* LAST UPDATED      : 17 March 2005
	* PARAMS            :
	*   $numBits        : an integer representing the amount of random data in bits 
        *                     you want returned
	*
	* DESCRIPTION       : This routine takes an integer and returns a random string 
        *                     of bytes
        *
	* PRECONDITION      : $numBits is a positive integer
        *
	* POSTCONDITION     : returns an string $numBites of bits in length 
        *
	*
	************************************************************************************** */
        function randomBytes($numBits) {
		$numBytes = floor(($numBits+7)/8);
                //if (/dev/urandom available) {
			$fh = fopen("/dev/urandom", rb);
			$bytesString = fread($fh, $numBytes);
			fclose($fh);
                //} else {
			//use php rand function
		//}
                return bytesString;
        }
	 
?>
<?php
	/**************************************************************************************************
	GNU GENERAL PUBLIC LICENSE
	Version 2, June 1991
	 
	Copyright (C) 1989, 1991 Free Software Foundation, Inc.
	59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	Everyone is permitted to copy and distribute verbatim copies
	of this license document, but changing it is not allowed.
	 
	Preamble
	 
	The licenses for most software are designed to take away your
	freedom to share and change it.  By contrast, the GNU General Public
	License is intended to guarantee your freedom to share and change free
	software--to make sure the software is free for all its users.  This
	General Public License applies to most of the Free Software
	Foundation's software and to any other program whose authors commit to
	using it.  (Some other Free Software Foundation software is covered by
	the GNU Library General Public License instead.)  You can apply it to
	your programs, too.
	 
	When we speak of free software, we are referring to freedom, not
	price.  Our General Public Licenses are designed to make sure that you
	have the freedom to distribute copies of free software (and charge for
	this service if you wish), that you receive source code or can get it
	if you want it, that you can change the software or use pieces of it
	in new free programs; and that you know you can do these things.
	 
	To protect your rights, we need to make restrictions that forbid
	anyone to deny you these rights or to ask you to surrender the rights.
	These restrictions translate to certain responsibilities for you if you
	distribute copies of the software, or if you modify it.
	 
	For example, if you distribute copies of such a program, whether
	gratis or for a fee, you must give the recipients all the rights that
	you have.  You must make sure that they, too, receive or can get the
	source code.  And you must show them these terms so they know their
	rights.
	 
	We protect your rights with two steps: (1) copyright the software, and
	(2) offer you this license which gives you legal permission to copy,
	distribute and/or modify the software.
	 
	Also, for each author's protection and ours, we want to make certain
	that everyone understands that there is no warranty for this free
	software.  If the software is modified by someone else and passed on, we
	want its recipients to know that what they have is not the original, so
	that any problems introduced by others will not reflect on the original
	authors' reputations.
	 
	Finally, any free program is threatened constantly by software
	patents.  We wish to avoid the danger that redistributors of a free
	program will individually obtain patent licenses, in effect making the
	program proprietary.  To prevent this, we have made it clear that any
	patent must be licensed for everyone's free use or not licensed at all.
	 
	The precise terms and conditions for copying, distribution and
	modification follow.
	 
	GNU GENERAL PUBLIC LICENSE
	TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
	 
	0. This License applies to any program or other work which contains
	a notice placed by the copyright holder saying it may be distributed
	under the terms of this General Public License.  The "Program", below,
	refers to any such program or work, and a "work based on the Program"
	means either the Program or any derivative work under copyright law:
	that is to say, a work containing the Program or a portion of it,
	either verbatim or with modifications and/or translated into another
	language.  (Hereinafter, translation is included without limitation in
	the term "modification".)  Each licensee is addressed as "you".
	 
	Activities other than copying, distribution and modification are not
	covered by this License; they are outside its scope.  The act of
	running the Program is not restricted, and the output from the Program
	is covered only if its contents constitute a work based on the
	Program (independent of having been made by running the Program).
	Whether that is true depends on what the Program does.
	 
	1. You may copy and distribute verbatim copies of the Program's
	source code as you receive it, in any medium, provided that you
	conspicuously and appropriately publish on each copy an appropriate
	copyright notice and disclaimer of warranty; keep intact all the
	notices that refer to this License and to the absence of any warranty;
	and give any other recipients of the Program a copy of this License
	along with the Program.
	 
	You may charge a fee for the physical act of transferring a copy, and
	you may at your option offer warranty protection in exchange for a fee.
	 
	2. You may modify your copy or copies of the Program or any portion
	of it, thus forming a work based on the Program, and copy and
	distribute such modifications or work under the terms of Section 1
	above, provided that you also meet all of these conditions:
	 
	a) You must cause the modified files to carry prominent notices
	stating that you changed the files and the date of any change.
	 
	b) You must cause any work that you distribute or publish, that in
	whole or in part contains or is derived from the Program or any
	part thereof, to be licensed as a whole at no charge to all third
	parties under the terms of this License.
	 
	c) If the modified program normally reads commands interactively
	when run, you must cause it, when started running for such
	interactive use in the most ordinary way, to print or display an
	announcement including an appropriate copyright notice and a
	notice that there is no warranty (or else, saying that you provide
	a warranty) and that users may redistribute the program under
	these conditions, and telling the user how to view a copy of this
	License.  (Exception: if the Program itself is interactive but
	does not normally print such an announcement, your work based on
	the Program is not required to print an announcement.)
	 
	These requirements apply to the modified work as a whole.  If
	identifiable sections of that work are not derived from the Program,
	and can be reasonably considered independent and separate works in
	themselves, then this License, and its terms, do not apply to those
	sections when you distribute them as separate works.  But when you
	distribute the same sections as part of a whole which is a work based
	on the Program, the distribution of the whole must be on the terms of
	this License, whose permissions for other licensees extend to the
	entire whole, and thus to each and every part regardless of who wrote it.
	 
	Thus, it is not the intent of this section to claim rights or contest
	your rights to work written entirely by you; rather, the intent is to
	exercise the right to control the distribution of derivative or
	collective works based on the Program.
	 
	In addition, mere aggregation of another work not based on the Program
	with the Program (or with a work based on the Program) on a volume of
	a storage or distribution medium does not bring the other work under
	the scope of this License.
	 
	3. You may copy and distribute the Program (or a work based on it,
	under Section 2) in object code or executable form under the terms of
	Sections 1 and 2 above provided that you also do one of the following:
	 
	a) Accompany it with the complete corresponding machine-readable
	source code, which must be distributed under the terms of Sections
	1 and 2 above on a medium customarily used for software interchange; or,
	 
	b) Accompany it with a written offer, valid for at least three
	years, to give any third party, for a charge no more than your
	cost of physically performing source distribution, a complete
	machine-readable copy of the corresponding source code, to be
	distributed under the terms of Sections 1 and 2 above on a medium
	customarily used for software interchange; or,
	 
	c) Accompany it with the information you received as to the offer
	to distribute corresponding source code.  (This alternative is
	allowed only for noncommercial distribution and only if you
	received the program in object code or executable form with such
	an offer, in accord with Subsection b above.)
	 
	The source code for a work means the preferred form of the work for
	making modifications to it.  For an executable work, complete source
	code means all the source code for all modules it contains, plus any
	associated interface definition files, plus the scripts used to
	control compilation and installation of the executable.  However, as a
	special exception, the source code distributed need not include
	anything that is normally distributed (in either source or binary
	form) with the major components (compiler, kernel, and so on) of the
	operating system on which the executable runs, unless that component
	itself accompanies the executable.
	 
	If distribution of executable or object code is made by offering
	access to copy from a designated place, then offering equivalent
	access to copy the source code from the same place counts as
	distribution of the source code, even though third parties are not
	compelled to copy the source along with the object code.
	 
	4. You may not copy, modify, sublicense, or distribute the Program
	except as expressly provided under this License.  Any attempt
	otherwise to copy, modify, sublicense or distribute the Program is
	void, and will automatically terminate your rights under this License.
	However, parties who have received copies, or rights, from you under
	this License will not have their licenses terminated so long as such
	parties remain in full compliance.
	 
	5. You are not required to accept this License, since you have not
	signed it.  However, nothing else grants you permission to modify or
	distribute the Program or its derivative works.  These actions are
	prohibited by law if you do not accept this License.  Therefore, by
	modifying or distributing the Program (or any work based on the
	Program), you indicate your acceptance of this License to do so, and
	all its terms and conditions for copying, distributing or modifying
	the Program or works based on it.
	 
	6. Each time you redistribute the Program (or any work based on the
	Program), the recipient automatically receives a license from the
	original licensor to copy, distribute or modify the Program subject to
	these terms and conditions.  You may not impose any further
	restrictions on the recipients' exercise of the rights granted herein.
	You are not responsible for enforcing compliance by third parties to
	this License.
	 
	7. If, as a consequence of a court judgment or allegation of patent
	infringement or for any other reason (not limited to patent issues),
	conditions are imposed on you (whether by court order, agreement or
	otherwise) that contradict the conditions of this License, they do not
	excuse you from the conditions of this License.  If you cannot
	distribute so as to satisfy simultaneously your obligations under this
	License and any other pertinent obligations, then as a consequence you
	may not distribute the Program at all.  For example, if a patent
	license would not permit royalty-free redistribution of the Program by
	all those who receive copies directly or indirectly through you, then
	the only way you could satisfy both it and this License would be to
	refrain entirely from distribution of the Program.
	 
	If any portion of this section is held invalid or unenforceable under
	any particular circumstance, the balance of the section is intended to
	apply and the section as a whole is intended to apply in other
	circumstances.
	 
	It is not the purpose of this section to induce you to infringe any
	patents or other property right claims or to contest validity of any
	such claims; this section has the sole purpose of protecting the
	integrity of the free software distribution system, which is
	implemented by public license practices.  Many people have made
	generous contributions to the wide range of software distributed
	through that system in reliance on consistent application of that
	system; it is up to the author/donor to decide if he or she is willing
	to distribute software through any other system and a licensee cannot
	impose that choice.
	 
	This section is intended to make thoroughly clear what is believed to
	be a consequence of the rest of this License.
	 
	8. If the distribution and/or use of the Program is restricted in
	certain countries either by patents or by copyrighted interfaces, the
	original copyright holder who places the Program under this License
	may add an explicit geographical distribution limitation excluding
	those countries, so that distribution is permitted only in or among
	countries not thus excluded.  In such case, this License incorporates
	the limitation as if written in the body of this License.
	 
	9. The Free Software Foundation may publish revised and/or new versions
	of the General Public License from time to time.  Such new versions will
	be similar in spirit to the present version, but may differ in detail to
	address new problems or concerns.
	 
	Each version is given a distinguishing version number.  If the Program
	specifies a version number of this License which applies to it and "any
	later version", you have the option of following the terms and conditions
	either of that version or of any later version published by the Free
	Software Foundation.  If the Program does not specify a version number of
	this License, you may choose any version ever published by the Free Software
	Foundation.
	 
	10. If you wish to incorporate parts of the Program into other free
	programs whose distribution conditions are different, write to the author
	to ask for permission.  For software which is copyrighted by the Free
	Software Foundation, write to the Free Software Foundation; we sometimes
	make exceptions for this.  Our decision will be guided by the two goals
	of preserving the free status of all derivatives of our free software and
	of promoting the sharing and reuse of software generally.
	 
	NO WARRANTY
	 
	11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
	FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
	OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
	PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
	OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
	MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
	TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
	PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
	REPAIR OR CORRECTION.
	 
	12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
	WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
	REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
	INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
	OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
	TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
	YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
	PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
	POSSIBILITY OF SUCH DAMAGES.
	 
	END OF TERMS AND CONDITIONS
	 
	How to Apply These Terms to Your New Programs
	 
	If you develop a new program, and you want it to be of the greatest
	possible use to the public, the best way to achieve this is to make it
	free software which everyone can redistribute and change under these terms.
	 
	To do so, attach the following notices to the program.  It is safest
	to attach them to the start of each source file to most effectively
	convey the exclusion of warranty; and each file should have at least
	the "copyright" line and a pointer to where the full notice is found.
	 
	<one line to give the program's name and a brief idea of what it does.>
	Copyright (C) <year>  <name of author>
	 
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.
	 
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	 
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	 
	 
	Also add information on how to contact you by electronic and paper mail.
	 
	If the program is interactive, make it output a short notice like this
	when it starts in an interactive mode:
	 
	Gnomovision version 69, Copyright (C) year name of author
	Gnomovision comes with ABSOLUTELY NO WARRANTY; for details type `show w'.
	This is free software, and you are welcome to redistribute it
	under certain conditions; type `show c' for details.
	 
	The hypothetical commands `show w' and `show c' should show the appropriate
	parts of the General Public License.  Of course, the commands you use may
	be called something other than `show w' and `show c'; they could even be
	mouse-clicks or menu items--whatever suits your program.
	 
	You should also get your employer (if you work as a programmer) or your
	school, if any, to sign a "copyright disclaimer" for the program, if
	necessary.  Here is a sample; alter the names:
	 
	Yoyodyne, Inc., hereby disclaims all copyright interest in the program
	`Gnomovision' (which makes passes at compilers) written by James Hacker.
	 
	<signature of Ty Coon>, 1 April 1989
	Ty Coon, President of Vice
	 
	This General Public License does not permit incorporating your program into
	proprietary programs.  If your program is a subroutine library, you may
	consider it more useful to permit linking proprietary applications with the
	library.  If this is what you want to do, use the GNU Library General
	Public License instead of this License.
	******************************************************************************************
	/* Special thanks to |-|3xR3|g/\/$ for contributing, testing, and hardening this code (seriously w3 ph34r j00) */
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
