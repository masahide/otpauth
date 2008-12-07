<html>
<body>
<h1>ivcs_transform_test.php</h1>
<?php

require_once('otp.php'); 

echo "Demonstration of correct checksum (for values shown in RFC2289): <BR>";

$in[0] = "85c43ee03857765b";

$result = ivcs_transform_to($in[0]);
echo "ivcs_transform_to($in[0]) = ";
echo implode(",",$result),"<BR>";

$invert = ivcs_transform_from($result);
if($invert == false ) echo "Unexpected checksum error ! Something is wrong.<BR>";
$printres =implode(",",$result);
echo "ivcs_transform_from($printres) = ", $invert,"<BR>";
echo "Last codeword should be OAF <BR>";



$in[0]  = "ff11EE22DD33CC44";
$in[1]  = "0123456789AbcDef";
$in[2]  = "10fe32dc54ba7694";
$in[3]  = "1f11EE22DD33CC44";
$in[4]  = "2123456789AbcDef";
$in[5]  = "30fe32dc54ba7694";
$in[6]  = "4f11EE22DD33CC44";
$in[7]  = "5123456789AbcDef";
$in[8]  = "60fe32dc54ba7694";
$in[9]  = "7f11EE22DD33CC44";
$in[10] = "8123456789AbcDef";
$in[11] = "90fe32dc54ba7694";

$i =0;
foreach($in as $x)
{
   $converted[$i++] = ivcs_transform_to($x);
}


echo "<BR>";
echo "Testing Inverses:   testHexData == ivcs_transform_from(ivcs_transform_to(testHexData)))  <BR>";

$ptr = 0;
$successCount = 0;
$failureCount = 0;
foreach($converted as $x)
{

    $original = strtolower($in[$ptr]);
    $transformToAndFrom = ivcs_transform_from($x);
    if($transformToAndFrom == false)
    {  
       echo "Unexpected checksum error ! Something is wrong.<BR>";
       echo "Input = ", $in[$ptr],"<BR>";
       echo "Code Words = " , implode(",",$x), " <BR>";
    }
    $transformToAndFrom = strtolower($transformToAndFrom);
    echo $original;
    if(strcmp(strtolower($transformToAndFrom),strtolower($in[$ptr]))==0)
    {
       echo "  (passed) <BR>";
       $successCount++;
    }
    else
    {
        echo "<BR>";
        echo $transformToAndFrom,"<BR>";
        echo "^^^^^FAILED^^^^^^^^<BR>";
       $failureCount++;
    }
    $ptr++;
}
echo $failureCount , "  failures, ",$successCount," successes, out of ",$ptr," total <BR>";


$iterations = 40;

//--TIMING ivcs_transform_from------------------------------------------------------

echo "<BR>";
echo "Timing ivcs_transform_from()<BR>";
////////////////////////////////////////////////////
$time1 = time();
$counter = 0;
for($i = 0; $i < $iterations; $i++){foreach($converted as $codewords){
///////////////////////////////////////////////////


$result = ivcs_transform_from($codewords);


///////////////////////////////////////////////////
$counter++;
}}
$time2=time();
echo "elapsed time = ", $time2 - $time1 ," seconds.<BR>";
echo "For $counter six-word code groups converted.<BR>";
//////////////////////////////////////////////////



//--TIMING ivcs_transform_to------------------------------------------------------

echo "<BR>";
echo "Timing ivcs_transform_to()<BR>";
////////////////////////////////////////////////////
$time1 = time();
$counter = 0;
for($i = 0; $i < $iterations; $i++){foreach($in as $hex){
///////////////////////////////////////////////////


$result = ivcs_transform_to($hex);


///////////////////////////////////////////////////
$counter++;
}}
$time2=time();
echo "elapsed time = ", $time2 - $time1 ," seconds.<BR>";
echo "For $counter hex values converted.<BR>";

?>
</body>
</html>
