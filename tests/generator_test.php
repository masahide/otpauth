< html >
< body >
< h1 > generator_test.php < /h1 >
<?php
     
    require_once('otp.php');
    require_once('random_utils.php');
    require_once('nutils.php');
     
    echo "Generator Test", "<BR><BR>";
     
    $time1 = time();
    $result = generator();
    $time2 = time();
    echo "<BR>";
    echo "elapsed time = ", $time2 - $time1 , " seconds.<BR>";
    echo "Generated ", count($result), " user OTP's<BR>";
     
    echo "<BR>";
    echo "Result of applying hash to OTP #1 (", $result[0], ")<BR>";
    echo "hex version of OTP #1 = " , ivcs_transform_from(explode(" ", $result[0])), "<BR>";
    //echo "hash of ",strtolower(ivcs_transform_from(explode(" ",$result[0])))," = " , __cn_hash(sha1(strtolower(ivcs_transform_from(explode(" ",$result[0]))))),"<BR>";
    echo "hash of ", ivcs_transform_from(explode(" ", $result[0])), " = " , __cn_hash(sha1(ivcs_transform_from(explode(" ", $result[0])))), "<BR>";
     
    echo "<BR>symmetry test<BR>";
    echo "1st OTP from generator = ", $result[0], "<BR>";
    $hex = ivcs_transform_from(explode(" ", $result[0]));
    echo "Hex result from ivcs_transform_from = ", $hex, "<BR>";
    $six = ivcs_transform_to($hex);
    echo "Re-encoding result from ivcs_transform_to ", (implode(" ", $six)), "<BR>";
    echo "<BR>";
     
     
    echo "<BR>";
    echo "Test of OTP table : <BR>";
     
    $index = 1;
    $lastHash = __cn_hash(sha1(ivcs_transform_from(explode(" ", $result[0]))));
    $numfailed = 0;
    $numpassed = 0;
    foreach($result as $sixword) {
        $currentHash = ivcs_transform_from(explode(" ", $sixword));
        $verifyHash = __cn_hash(sha1($currentHash));
        if (strcmp($verifyHash, $lastHash) == 0) {
            //echo "SUCCESS at ",$index, " : hash(", $sixword, ") = ",$verifyHash, ", expected ", $lastHash,"<BR>";
            $numpassed++;
        } else {
            echo "FAILURE at ", $index, " : hash(", $sixword, ") = ", $verifyHash, ", expected ", $lastHash, "<BR>";
            $numfailed++;
        }
        $lastHash = $currentHash;
        $index++;
    }
    echo $numfailed , " failed, ", $numpassed, " passed.";
     
    echo "<BR><BR>";
    echo "Test of valid_otp() : <BR>";
    $index = 1;
    $numfailed = 0;
    $numpassed = 0;
    foreach($result as $sixword) {
        if (valid_otp($sixword)) {
            $numpassed++;
        } else {
            echo "FAILURE at ", $index, " : ", $sixword, "<BR>";
            $numfailed++;
        }
        $index++;
    }
    echo $numfailed , " failed, ", $numpassed, " passed.";
     
     
     
     
    echo "<BR>";
    echo "<BR>";
    echo "OTP table (to be printed and given to user) : <BR><BR>";
     
    $index = 1;
    foreach($result as $sixword) {
        echo $index, " : ", $sixword, "<BR>";
        $index++;
    }
     
     
?>
</body>
</html>
