<?php
//---- ogrsfdrivertest.php ----    
                             
require_once 'php_ogr_testcase1.php';
require_once 'php_ogr_testcase2.php';
require_once 'php_ogr_testcase3.php';
require_once 'php_ogr_testcase4.php';
require_once 'php_ogr_testcase5.php';
require_once 'phpunit-0.5/phpunit.php';

/*
printf("-----------Beginning suite 1--------- \n");

$suite1 = new PHPUnit_TestSuite("OGRSFDriverPathSetGoodhOGRSFDriverNotSetTest");
$suite1->addTest(new PHPUnit_TestSuite
                ("OGRSFDriverPathSetBadhOGRSFDriverSetToNULLTest"));
$suite1->addTest(new PHPUnit_TestSuite
                ("OGRSFDriverPathSetOkhOGRSFDriverSetToNULLTest"));
$suite1->addTest(new PHPUnit_TestSuite
                ("OGRSFDriverMiscellaneousTest1"));


$result = PHPUnit::run($suite1);

echo $result -> toString();


printf("-----------Beginning suite 2--------- \n");

$suite2 = new PHPUnit_TestSuite("OGRDataSourceTest1");

$result = PHPUnit::run($suite2);

echo $result -> toString();
*/


printf("-----------Beginning suite 3--------- \n");

$suite3 = new PHPUnit_TestSuite("OGRLayerTest0");
$suite3->addTest(new PHPUnit_TestSuite
                ("OGRLayerTest1"));

$result = PHPUnit::run($suite3);

echo $result -> toString();

?> 





