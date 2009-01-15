<?php
if (! defined('SIMPLE_TEST')) {
  define('SIMPLE_TEST', './simpletest/');
}

require_once('otpauthHtmlReporter.class.php');
require_once('../nutils.php');

class rShiftTests extends UnitTestCase {
  function rShiftTests() {
    $this->UnitTestCase("");
  }


//        function rshft_ulong($ulong, $amount, $wrap = 0) {
}

class lShiftTests extends UnitTestCase {
  function rShiftTests() {
    $this->UnitTestCase("");
  }

//        function lshft_ulong($ulong, $amount, $wrap = 0) {
}

class hexstr2IntTests extends UnitTestCase {
  function hexstr2IntTests() {
    $this->UnitTestCase("Proper functionality of hexstr2int");
  }

  function testNullParameter() {
    $parameter = null;
    
    try { 
      $this->assertFalse(hexstr2int($parameter), "null parameter should throw exception and return false.");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on null parameter");
    }
  }


  function testEmptyParameter() {
    $parameter = '';
    
    try { 
      $this->assertFalse(hexstr2int($parameter), "empty string parameter should throw exception and return false.");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on empty string parameter");
    }
  }

  function testIntegerParameter() {
    $parameter = 45;
    
    try { 
      $this->assertFalse(hexstr2int($parameter), "integer parameter should throw exception and return false.");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on integer parameter");
    }
  }


  function testArrayParameter() {
    $parameter = array();
    $parameter[0] = "zero";
    $parameter[1] = "one";
    
    try { 
      $this->assertFalse(hexstr2int($parameter), "array parameter should throw exception and return false.");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on array parameter");
    }
  }


  function testNonHexString() {
    $parameter = "55999ZZ";
    try { 
      $this->assertFalse(hexstr2int($parameter), "non-hex string parameter should throw exception and return false.");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on non-hex string parameter");
    }
  }


  function testValidHexString() {
    $parameter = "AA9900";
    $decval = 11180288;
    $retval = hexstr2int($parameter);

    $this->assertTrue($decval==$retval, "hex string $parameter should convert to $decval, converted to $retval");
  }

  function testValidShortHexString() {
    $parameter = "05c";
    $decval = 92;
    $retval = hexstr2int($parameter);

    $this->assertTrue($decval==$retval, "hex string $parameter should convert to $decval, converted to $retval");
  }


  function testValid8DigitHexString() {
    $parameter = "12345678";
    $decval = 305419896;
    $retval = hexstr2int($parameter);

    $this->assertTrue($decval==$retval, "hex string $parameter should convert to $decval, converted to $retval");
  }



  function testValid10DigitHexString() {
    $parameter = "123456789a";
    $decval = 78187493530;
    $retval = hexstr2int($parameter);

    $this->assertTrue($decval==$retval, "hex string $parameter should convert to $decval, converted to $retval");
  }


  function testValid12DigitHexString() {
    $parameter = "123456789abc";
    $decval = 20015998343868;
    $retval = hexstr2int($parameter);
    $this->assertTrue($decval==$retval, "hex string $parameter should convert to $decval, converted to $retval");
  }


  function testValid14DigitHexString() {
    $parameter = "123456789abcde";
    $decval = 5124095576030430;
    $retval = hexstr2int($parameter);
    $this->assertTrue($decval==$retval, "hex string $parameter should convert to $decval, converted to $retval");
  }


  function testValid16DigitHexString() {
    $parameter = "123456789abcdeff";
    $decval = 1311768467463790300;
    $retval = hexstr2int($parameter);
    $this->assertTrue($decval==$retval, "hex string $parameter should convert to $decval, converted to $retval");
  }


  function testHexStringWithLeading0x() {
    $parameter = "0x123456789a";
    $decval = 78187493530;
    $retval = hexstr2int($parameter);
    $this->assertTrue($decval==$retval, "hex string $parameter should convert to $decval, converted to $retval");
  }

  function testValid48DigitHexString() {
    $parameter = "fffffffffffffffffffffffffFFFFFFFFFFFFFFFFFFFFFFF";
    $decval = 6.2771017353867E+57;
    $retval = hexstr2int($parameter);
    $this->assertTrue($decval==$retval, "hex string $parameter should convert to $decval, converted to $retval");
  }

  function testValidHexStringWithUpperLowerAndNumeric() {
    $parameter = "1aBcD5";
    $decval = 1752277;
    $retval = hexstr2int($parameter);
    $this->assertTrue($decval==$retval, "hex string $parameter should convert to $decval, converted to $retval");
  }


  function testValidHexStringWithLeadingZero() {
    $parameter = "01aBcD5";
    $decval = 1752277;
    $retval = hexstr2int($parameter);
    $this->assertTrue($decval==$retval, "hex string $parameter should convert to $decval, converted to $retval");
  }

  function testValidHexStringWithTrailingZeros() {
    $parameter = "01aBcD500";
    $decval = 448582912;
    $retval = hexstr2int($parameter);
    $this->assertTrue($decval==$retval, "hex string $parameter should convert to $decval, converted to $retval");
  }

}


class binstr2IntTests extends UnitTestCase {
  function binstr2IntTests() {
    $this->UnitTestCase("Proper functionality of binstr2int");
  }

  function testNullParameter() {
    $parameter = null;
    
    try { 
      $this->assertFalse(binstr2int($parameter), "null parameter should throw exception and return false.");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on null parameter");
    }
  }


  function testEmptyParameter() {
    $parameter = '';
    
    try { 
      $this->assertFalse(binstr2int($parameter), "empty string parameter should throw exception and return false.");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on empty string parameter");
    }
  }

  function testIntegerParameter() {
    $parameter = 45;
    
    try { 
      $this->assertFalse(binstr2int($parameter), "integer parameter should throw exception and return false.");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on integer parameter");
    }
  }


  function testInvalidArrayParameter() {
    $parameter = array();
    $parameter[0] = "zero";
    $parameter[1] = "one";
    
    try { 
      $this->assertFalse(hexstr2int($parameter), "bad array parameters should throw exception and return false.");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on array parameter");
    }
  }


  function testNonBinString() {
    $parameter = "55999ZZ";
    try { 
      $this->assertFalse(hexstr2int($parameter), "non-binary string parameter should throw exception and return false.");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on non-binary string parameter");
    }
  }

  function testValidBinString() {
    $parameter = "101100";
    $decval = 44;
    $retval = binstr2int($parameter);

    $this->assertTrue($decval==$retval, "bin string $parameter should convert to $decval, converted to $retval");
  }


  function testValidBinStringWithTrailingB() {
    $parameter = "101100b";
    $decval = 44;
    $retval = binstr2int($parameter);

    $this->assertTrue($decval==$retval, "bin string $parameter should convert to $decval, converted to $retval");
  }

  function testValidShortBinString() {
    $parameter = "1";
    $decval = 1;
    $retval = binstr2int($parameter);

    $this->assertTrue($decval==$retval, "bin string $parameter should convert to $decval, converted to $retval");
  }


  function testValid8DigitBinString() {
  }


  function testValid16DigitBinString() {
  }

  function testValid32DigitBinString() {
    $parameter = "111101100010101110011010110001101";
    $decval = 16133018;
    $retval = binstr2int($parameter);

    $this->assertTrue($decval==$retval, "bin string $parameter should convert to $decval, converted to $retval");
  }

  function testValid33DigitBinString() {
    //should return invalid value, due to overflow
  }

  function testValidBinStringWithLeadingZero() {
  }

  function testValidBinStringWithTrailingZeros() {
  }

}


class ulong2binstrTests extends UnitTestCase {
  function ulong2binstrTests() {
    $this->UnitTestCase("");
  }
//	ulong2binstr
}


class ulong2hexstrTests extends UnitTestCase {
  function ulong2hexstrTests() {
    $this->UnitTestCase("");
  }
//        function ulong2hexstr($ulong, $padLength = -1) {
}


class strbin2ulongTests extends UnitTestCase {
  function strbin2ulong() {
    $this->UnitTestCase("");
  }
//        function strbin2ulong($value) {
}


class str2arrTests extends UnitTestCase {
  function str2arrTests() { 
    $this->UnitTestCase("");
  }
//        function str2arr($string) {
}


class hexString_2_booleanArrayTests extends UnitTestCase {
  function hexString_2_booleanArrayTests() {
    $this->UnitTestCase("");
  }

//        function hexString_2_booleanArray($hex) {
}


class booleanArray_2_hexStringTests extends UnitTestCase {
  function booleanArray_2_hexStringTests() {
    $this->UnitTestCase("");
  }

//        function booleanArray_2_hexString($boolArr) {
}


class readbit_ulongTests extends UnitTestCase {
  function readbit_ulongTests() {
    $this->UnitTestCase("");
  }
//        function readbit_ulong($val, $bit) {
}



class writebit_ulongTests extends UnitTestCase {
  function writebit_ulongTests() {
    $this->UnitTestCase("");
  }
// function writebit_ulong($val, $bit, $set = 'ON') {
}



class writebit_ulong_setTests extends UnitTestCase {
  function writebit_ulong_setTests() {
    $this->UnitTestCase("");
  }
//        function writebit_ulong_set($val, $bit) {

}


class writebit_ulong_unsetTests extends UnitTestCase {
  function writebit_ulong_unsetTests() {
    $this->UnitTestCase("");
  }
//        function writebit_ulong_unset($val, $bit) {
}

class randomBooleanArrayTests extends UnitTestCase {
  function randomBooleanArrayTests() {
    $this->UnitTestCase("");
  }

//        function randomBooleanArray($numBits) {
}


class randomBytesTests extends UnitTestCase {
  function randomBytesTests() {
    $this->UnitTestCase("");
  }

  function testRandom1ByteIsRandom() {
    $NUM_TESTS = 100;
    $NUM_BITS = 16;

    $randoms = array();
    for ($i=0; $i < $NUM_TESTS; ++$i) { 
      $randoms[] = randomBytes($NUM_BITS);
    }

    $randoms_uniq = array_unique($randoms);

    $this->assertTrue(count($randoms)==count($randoms_uniq), "Randoms array count (".count($randoms).") should be equal to randoms_uniq array count (".count($randoms_uniq).").");
  }




  function testRandom16BytesAreRandom() {
    $NUM_TESTS = 100;
    $NUM_BITS = 128;

    $randoms = array();
    for ($i=0; $i < $NUM_TESTS; ++$i) { 
      $randoms[] = randomBytes($NUM_BITS);
    }

    $randoms_uniq = array_unique($randoms);

    $this->assertTrue(count($randoms)==count($randoms_uniq), "Randoms array count (".count($randoms).") should be equal to randoms_uniq array count (".count($randoms_uniq).").");
  }

  function testRandom1024BytesAreRandom() {
    $NUM_TESTS = 100;
    $NUM_BITS = 8192;

    $randoms = array();
    for ($i=0; $i < $NUM_TESTS; ++$i) { 
      $randoms[] = randomBytes($NUM_BITS);
    }

    $randoms_uniq = array_unique($randoms);

    $this->assertTrue(count($randoms)==count($randoms_uniq), "Randoms array count (".count($randoms).") should be equal to randoms_uniq array count (".count($randoms_uniq).").");
  }





}

function nutils_run_tests(&$reporter) {

  $test = &new rShiftTests(); 
  $test->run($reporter);

  $test = &new lShiftTests();
  $test->run($reporter);

  $test = &new hexstr2IntTests(); 
  $test->run($reporter);

  $test = &new binstr2IntTests();
  $test->run($reporter);

  $test = &new ulong2binstrTests(); 
  $test->run($reporter);

  $test = &new ulong2hexstrTests();
  $test->run($reporter);

  $test = &new strbin2ulongTests(); 
  $test->run($reporter);

  $test = &new str2arrTests(); 
  $test->run($reporter);

  $test = &new hexString_2_booleanArrayTests(); 
  $test->run($reporter);

  $test = &new booleanArray_2_hexStringTests();
  $test->run($reporter);

  $test = &new readbit_ulongTests(); 
  $test->run($reporter);

  $test = &new writebit_ulongTests(); 
  $test->run($reporter);

  $test = &new writebit_ulong_setTests(); 
  $test->run($reporter);

  $test = &new writebit_ulong_unsetTests(); 
  $test->run($reporter);

  $test = &new randomBooleanArrayTests(); 
  $test->run($reporter);

  $test = &new randomBytesTests(); 
  $test->run($reporter);

}

?>
