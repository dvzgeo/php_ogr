<?php
//---- ogrsfdrivertest.php ----    
                             
require_once 'php_ogr_testcase1.php';
require_once 'php_ogr_testcase2.php';
require_once 'phpunit-0.5/phpunit.php';

printf("in php_ogr_test \n");

$suite = new PHPUnit_TestSuite("OGRSFDriverPathSetGoodhOGRSFDriverNotSetTest");
$suite->addTest(new PHPUnit_TestSuite
                ("OGRSFDriverPathSetBadhOGRSFDriverSetToNULLTest"));
$suite->addTest(new PHPUnit_TestSuite
                ("OGRSFDriverPathSetOkhOGRSFDriverSetToNULLTest"));
$suite->addTest(new PHPUnit_TestSuite("OGRSFDriverMiscellaneousTest"));
printf("-----------Beginning--------- \n");

$result = PHPUnit::run($suite);

echo $result -> toString();

?> 
