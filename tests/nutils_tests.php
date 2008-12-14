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
    $this->UnitTestCase("");
  }
//        function hexstr2int($string) {
}


class binstr2IntTests extends UnitTestCase {
  function binstr2IntTests() {
    $this->UnitTestCase("");
  }

//        function binstr2int($string) {
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
//        function randomBytes($numBits) {
}

function nutils_run_tests(&$reporter) {

//  $test = &new ivcsTransformToInvalidDataTest();
//  $test->run($reporter);
}

?>
