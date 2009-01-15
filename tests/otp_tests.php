<?php
if (! defined('SIMPLE_TEST')) {
  define('SIMPLE_TEST', './simpletest/');
}

require_once('otpauthHtmlReporter.class.php');
require_once('../otp.php');

class __otp_hashTests extends UnitTestCase {
  function __otp_hashTests() {
    $this->UnitTestCase("");
  }
  function testDifferentHashes() {
    $NUM_HASHES = 50;
    $md5s = array();
    $sha1s = array();
    $sha256s = array();

    
     

    
    try { 
      $this->assertFalse(hexstr2int($parameter), "null parameter should throw exception and return false.");
    } catch (Exception $e) {
      $this->pass("Properly threw exception on null parameter");
    }
  }
}

class rfc2289_checksumTests extends UnitTestCase {
  function rfc2289_checksumTests() {
    $this->UnitTestCase("");
  }
//        function rfc2289_checksum($boolArr) // returns 2 lsb's of checksum in an array
}


class validate_otpTests extends UnitTestCase {
  function validate_otpTests() {
    $this->UnitTestCase("");
  }
//        function validate_otp($otp) {
}

class generate_otp_listTests extends UnitTestCase {
  function generate_otp_listTests() {
    $this->UnitTestCase("");
  }
//        function generate_otp_list() {
}


class simplifiedInitialStepTests extends UnitTestCase {
  function simplifiedInitialStep() {
    $this->UnitTestCase();
  }
//        function simplifiedInitialStep() {
}

class computationStepTests extends UnitTestCase {
  function computationStepTests() {
    $this->UnitTestCase();
  }

//        function computationStep($S, $numberOfOTPs) {
}

function otp_run_tests(&$reporter) {

//  $test = &new ivcsTransformToInvalidDataTest();
//  $test->run($reporter);
}

?>
