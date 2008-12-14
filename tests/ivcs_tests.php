<?php
if (! defined('SIMPLE_TEST')) {
  define('SIMPLE_TEST', './simpletest/');
}

require_once('otpauthHtmlReporter.class.php');
require_once('../otp.php'); //otp.php includes ivcs dictionary


class ivcsIntegrityCheck extends UnitTestCase {
  function ivcsIntegrityCheck() {
    $this->UnitTestCase("Tests ivcs dictionary and reverse arrays");
  }

  function testSizeIvcsArray() {
    global $ivcs;
    $correct = false;
    if (2048==sizeof($ivcs)) {
      $correct = true;
    } else {
      $correct = false;
    }

    $this->assertTrue($correct, '$ivcs array should be 2048 in length, is '.sizeof($ivcs));
  }

  function testSizeIvcsInverseArray() {
    global $rev_ivcs;
    $correct = false;
    if (2048==sizeof($rev_ivcs)) {
      $correct = true;
    } else {
      $correct = false;
    }

    $this->assertTrue($correct, '$ivcs array should be 2048 in length, is '.sizeof($rev_ivcs));

  }

  function testIvcsAndReverseArrayEquivalence() {
    global $ivcs, $rev_ivcs;
    $correct = true;
    $bad_item = '';
    $message = '$ivcs array and $rev_ivcs array should match';

    foreach ($ivcs as $k=>$v) {
      if ($k!=$rev_ivcs[$v]) {
        $correct = false;
        $bad_item = $v; 
        $message .= " but $bad_item does not.";
        $break;
      }
    }
  
    $this->assertTrue($correct, $message);
  }

  function testIvcsShortWords() {
    global $ivcs;
    $correct = true;
    $bad_item = '';
    $message = '$ivcs array words should be strings from 1 to 5 chars in length';

    /*
      iterate through either array (or both) 
      test that each is a string, 
      uppercase, 
      more than 1 character, 
      and less than 7 characters
    */
    foreach ($ivcs as $k=>$v) {
      if (!is_string($v)) {
        $correct = false;
        $bad_item = $v;
        $message .= " but $bad_item is not";
        $break;
      } 

      if (!(strlen($v)>0)) {
        $correct = false;
        $bad_item = $v;
        $message .= " but $bad_item is not";
        $break;
      }

      if (!(strlen($v)<6)) {
        $correct = false;
        $bad_item = $v;
        $message .= " but $bad_item is not";
        $break;
      }
    }

    $this->assertTrue($correct, $message);
  }

}


class ivcsTransformArrayToInvalidDataTest extends UnitTestCase {
  function ivcsTransformArrayToInvalidDataTest() {
    $this->UnitTestCase("Transform array of hashes to IVCS six-word format");
  }

  function testEmptyArray() {
    $otplist = array();
    try {
      $this->assertFalse(ivcs_transform_array_to($otplist), "Should throw exception on empty array");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on empty array");
    }
  }

  function testStringNotArray() {
    $otplist = "OAF A OAR O BERG BEN";
    try {
      $this->assertFalse(ivcs_transform_array_to($otplist), "Should throw exception on improper data type (string)");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on improper data type (string)");
    }
  }

  function testIntNotArray() {
    $otplist = 45;
    try {
      $this->assertFalse(ivcs_transform_array_to($otplist), "Should throw exception on improper data type (int)");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on improper data type (int)");
    }
  }

  function testNullNotArray() {
    $otplist = 45;
    try {
      $this->assertFalse(ivcs_transform_array_to($otplist), "Should throw exception on null list");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on null list");
    }
  }

  function testNullArrayItem() {
    $otplist[0]  = "ff11EE22DD33CC44";
    $otplist[1]  = "0123456789AbcDef";
    $otplist[2]  = "10fe32dc54ba7694";
    $otplist[3]  = "1f11EE22DD33CC44";
    $otplist[4]  = null;
    $otplist[5]  = "30fe32dc54ba7694";
    $otplist[6]  = "4f11EE22DD33CC44";
    $otplist[7]  = "5123456789AbcDef";
    $otplist[8]  = "60fe32dc54ba7694";
    $otplist[9]  = "7f11EE22DD33CC44";
    $otplist[10] = "8123456789AbcDef";
    $otplist[11] = "90fe32dc54ba7694";

    $sixword_list = ivcs_transform_array_to($otplist);

    $this->assertNull($sixword_list[4], "null item in the list should return a null item at same element");
  }

 
  function testEmptyArrayItem() {
    $otplist[0]  = "ff11EE22DD33CC44";
    $otplist[1]  = "0123456789AbcDef";
    $otplist[2]  = "10fe32dc54ba7694";
    $otplist[3]  = "1f11EE22DD33CC44";
    $otplist[4]  = '';
    $otplist[5]  = "30fe32dc54ba7694";
    $otplist[6]  = "4f11EE22DD33CC44";
    $otplist[7]  = "5123456789AbcDef";
    $otplist[8]  = "60fe32dc54ba7694";
    $otplist[9]  = "7f11EE22DD33CC44";
    $otplist[10] = "8123456789AbcDef";
    $otplist[11] = "90fe32dc54ba7694";

    $sixword_list = ivcs_transform_array_to($otplist);

    $this->assertNull($sixword_list[4], "empty item in the list should return a null item at same element");
  } 

  function testNonStringArrayItem() {
    $otplist[0]  = "ff11EE22DD33CC44";
    $otplist[1]  = "0123456789AbcDef";
    $otplist[2]  = "10fe32dc54ba7694";
    $otplist[3]  = "1f11EE22DD33CC44";
    $otplist[4]  = 45;
    $otplist[5]  = "30fe32dc54ba7694";
    $otplist[6]  = "4f11EE22DD33CC44";
    $otplist[7]  = "5123456789AbcDef";
    $otplist[8]  = "60fe32dc54ba7694";
    $otplist[9]  = "7f11EE22DD33CC44";
    $otplist[10] = "8123456789AbcDef";
    $otplist[11] = "90fe32dc54ba7694";

    $sixword_list = ivcs_transform_array_to($otplist);

    $this->assertNull($sixword_list[4], "integer item in the list should return a null item at same element");
  }


  function testNonStringArrayItem2() {
    $otplist[0]  = "ff11EE22DD33CC44";
    $otplist[1]  = "0123456789AbcDef";
    $otplist[2]  = "10fe32dc54ba7694";
    $otplist[3]  = "1f11EE22DD33CC44";
    $otplist[4]  = array();
    $otplist[5]  = "30fe32dc54ba7694";
    $otplist[6]  = "4f11EE22DD33CC44";
    $otplist[7]  = "5123456789AbcDef";
    $otplist[8]  = "60fe32dc54ba7694";
    $otplist[9]  = "7f11EE22DD33CC44";
    $otplist[10] = "8123456789AbcDef";
    $otplist[11] = "90fe32dc54ba7694";

    $sixword_list = ivcs_transform_array_to($otplist);

    $this->assertNull($sixword_list[4], "item which is array in the list should return a null item at same element");
  }

 
}



class ivcsTransformToInvalidDataTest extends UnitTestCase {


//  $hash[0]  = "ff11EE22DD33CC44";
//  $hash[1]  = "0123456789AbcDef";
//  $hash[2]  = "10fe32dc54ba7694";
//  $hash[3]  = "1f11EE22DD33CC44";
//  $hash[4]  = "2123456789AbcDef";
//  $hash[5]  = "30fe32dc54ba7694";
//  $hash[6]  = "4f11EE22DD33CC44";
//  $hash[7]  = "5123456789AbcDef";
//  $hash[8]  = "60fe32dc54ba7694";
//  $hash[9]  = "7f11EE22DD33CC44";
//  $hash[10] = "8123456789AbcDef";
//  $hash[11] = "90fe32dc54ba7694";


  function ivcsTransformToInvalidDataTest() { 
    $this->UnitTestCase("IVCS transform attempts from hex data on invalid data"); 
  }

  function testToTransformWithTooShortNumber() {
//    $hash = '00f';
//    $six_word = ivcs_transform_to($hash);
//print "<h1>$six_word</h1>";
  }

  function testToTransformWithTooLongNumber() {

  }

  function testToTransformWithNull() { 

  }

  function testToTransformWithEmptyString() {

  }

}


class ivcsTransformFromInvalidDataTest extends UnitTestCase {
  function ivcsTransformFromInvalidDataTest() { 
    $this->UnitTestCase("IVCS transform attempts from six-word format on invalid data"); 
  }

}


class ivcsTransformToWithValidData {
  function ivcsTransformToWithValidData() {
    $this->UnitTestCase("IVCS 'to' transforms with valid data");
  }


  function testToTransformWithUpperLowerAndNumericHexDigits() {
    $hash = "ff11EE22DD33CC44"; //", "0123456789AbcDef"}
    $hash_answer = 
    $transform = ivcs_transform_to($hash);
/*
    $this->assertTrue($hash_answer==$transform, 
                      "'$hash' should transform to '$hash_answer' but transformed to '$transform' instead");
print_r($transform);
*/
  }

  function testToTransformWithLowerAndNumericHexDigits() { 

  }

  function testToTransformWithUpperAndNumericHexDigits() {

  }

}


class ivcsTransformFromWithValidData {
  function ivcsTransformFromWithValidData() {
    $this->UnitTestCase("IVCS 'from' transforms with valid data");
  }
}


class ivcsTransformCorrectChecksums {
  function ivcsTransformCorrectChecksums() {
    $this->UnitTestCase("IVCS from and to transforms with, expecting correct data");
  }
}

class ivcsTransformIncorrectChecksums {
  function ivcsTransformIncorrectChecksums() {
    $this->UnitTestCase("IVCS from and to transforms with, expecting correct data");
  }

}

class ivcsToTransformTimingTest {
  function ivcsToTransformTimingTest() {
    $this->UnitTestCase("IVCS from and to transforms with, expecting correct data");
  }
}

class ivcsFromTransformTimingTest {
  function ivcsFromTransformTimingTest() {
    $this->UnitTestCase("IVCS from and to transforms with, expecting correct data");
  }
}


/*
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
*/



function ivcs_run_tests(&$reporter) {
  $test = &new ivcsIntegrityCheck();
  $test->run($reporter);

  $test = &new ivcsTransformArrayToInvalidDataTest();
  $test->run($reporter); 

  $test = &new ivcsTransformToInvalidDataTest();
  $test->run($reporter);
 
  $test = &new testToTransformWithTooShortNumber();
  $test->run($reporter);

  $test = &new testToTransformWithTooLongNumber();
  $test->run($reporter);

  $test = &new testToTransformWithNull();
  $test->run($reporter);

  $test = &new testToTransformWithEmptyString();
  $test->run($reporter);

  $test = &new ivcsTransformFromInvalidDataTest(); 
  $test->run($reporter);

  $test = &new ivcsTransformToWithValidData(); 
  $test->run($reporter);

  $test = &new testToTransformWithUpperLowerAndNumericHexDigits();
  $test->run($reporter);

  $test = &new testToTransformWithLowerAndNumericHexDigits(); 
  $test->run($reporter);

  $test = &new testToTransformWithUpperAndNumericHexDigits();
  $test->run($reporter);

  $test = &new ivcsTransformFromWithValidData();
  $test->run($reporter);

  $test = &new ivcsTransformCorrectChecksums(); 
  $test->run($reporter);

  $test = &new ivcsTransformIncorrectChecksums(); 
  $test->run($reporter);

  $test = &new ivcsToTransformTimingTest(); 
  $test->run($reporter);

  $test = &new ivcsFromTransformTimingTest();
  $test->run($reporter);

}




?>
