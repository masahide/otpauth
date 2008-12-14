<?php

  //simpletest base path
  if (! defined('SIMPLE_TEST')) {
    define('SIMPLE_TEST', './simpletest/');
  }

  //simpletest includes
  require_once(SIMPLE_TEST . 'unit_tester.php');
  require_once(SIMPLE_TEST . 'reporter.php');

  //overridden simple test class includes
  require_once('otpauthHtmlReporter.class.php');

  //unit test includes
  require_once('ivcs_tests.php');
  require_once('otp_tests.php');
  require_once('nutils_tests.php');


  $reporter = new otpauthHtmlReporter();

  nutils_run_tests($reporter);
  ivcs_run_tests($reporter);
  otp_run_tests($reporter);

?>
