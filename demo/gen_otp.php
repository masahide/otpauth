<?php
  //spit out excel headers and 
  //let it interpret the html
  //(because I am a big fat cheater)
  header('');
  header('');
  header('');


  $otp_list = generator();
	 
  print "<TABLE BORDER=1>";
  print "<TH>Sequence number</TH><TH>Password</TH>";
  while (list($key, $val) = each($otp_list)) {
    print "<TR><TD>$key</TD><TD>$val</TD></TR>";
  }
  print "</TABLE>";




?>
