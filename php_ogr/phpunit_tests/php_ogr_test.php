<?php
require_once 'phpunit-0.5/phpunit.php';

require_once 'php_ogr_testcase1.php';
require_once 'php_ogr_testcase2.php';
require_once 'php_ogr_testcase3.php';
require_once 'php_ogr_testcase4.php';
require_once 'php_ogr_testcase5.php';
require_once 'php_ogr_testcase6.php';
require_once 'php_ogr_testcase7.php';
require_once 'php_ogr_testcase8.php';
require_once 'php_ogr_testcase9.php';
require_once 'php_ogr_testcase10.php';
require_once 'php_ogr_testcase11.php';
require_once 'php_ogr_testcase12.php';
require_once 'php_ogr_testcase13.php';
require_once 'php_ogr_testcase14.php';
require_once 'php_ogr_testcase15.php';
require_once 'php_ogr_testcase16.php';
require_once 'php_ogr_testcase17.php';
//require_once 'php_ogr_testcase18.php'; /*Not with MapInfo File.*/


printf("
/***********************************************************************
*                           Beginning suite 1
*                          
************************************************************************/
");
$suite1 = new PHPUnit_TestSuite("OGRSFDriverRegistrarTest0");
$suite1->addTest(new PHPUnit_TestSuite
                ("OGRSFDriverRegistrarTest1"));
$suite1->addTest(new PHPUnit_TestSuite
                ("OGRSFDriverRegistrarTest2"));
$suite1->addTest(new PHPUnit_TestSuite
                ("OGRSFDriverRegistrarTest3"));
$suite1->addTest(new PHPUnit_TestSuite
                ("OGRSFDriverTest0"));

$result = PHPUnit::run($suite1);

echo $result -> toString();


printf("
/***********************************************************************
*                           Beginning suite 2
*                          
************************************************************************/
");

$suite2 = new PHPUnit_TestSuite("OGRDataSourceTest0");

$result = PHPUnit::run($suite2);

echo $result -> toString();


printf("
/***********************************************************************
*                           Beginning suite 3
*                          
************************************************************************/
");

$suite3 = new PHPUnit_TestSuite("OGRLayerTest0");
$suite3->addTest(new PHPUnit_TestSuite("OGRLayerTest1"));
$suite3->addTest(new PHPUnit_TestSuite("OGRLayerTest2"));

$result = PHPUnit::run($suite3);

echo $result -> toString();

printf("
/***********************************************************************
*                           Beginning suite 4
*                          
************************************************************************/
");
$suite4 = new PHPUnit_TestSuite("OGRFeatureTest0");
$suite4->addTest(new PHPUnit_TestSuite("OGRFeatureTest1"));
$suite4->addTest(new PHPUnit_TestSuite("OGRFeatureTest2"));
$suite4->addTest(new PHPUnit_TestSuite("OGRFeatureTest3"));
$suite4->addTest(new PHPUnit_TestSuite("OGRFeatureTest4"));
/*Not used the following test suite with MapInfo File.  List not supported.*/
//$suite4->addTest(new PHPUnit_TestSuite("OGRFeatureTest5"));

$result = PHPUnit::run($suite4);

echo $result -> toString();

printf("
/***********************************************************************
*                           Beginning suite 6
*                          
************************************************************************/
");
$suite5 = new PHPUnit_TestSuite("OGRGeometryTest0");
$suite5->addTest(new PHPUnit_TestSuite("OGRGeometryTest1"));

$result = PHPUnit::run($suite5);

echo $result -> toString();

printf("-----------Beginning suite 6--------- \n");

$suite6 = new PHPUnit_TestSuite("OGRFieldDefnTest0");

$result = PHPUnit::run($suite6);

echo $result -> toString();

printf("
/***********************************************************************
*                           Beginning suite 7
*                          
************************************************************************/
");
$suite7 = new PHPUnit_TestSuite("OGRFeatureDefnTest0");
$suite7->addTest(new PHPUnit_TestSuite("OGRFeatureDefnTest1"));

$result = PHPUnit::run($suite7);

echo $result -> toString();

printf("
/***********************************************************************
*                           Beginning suite 8
*                          
************************************************************************/
");

$suite8 = new PHPUnit_TestSuite("OGRGeometryTest2");

$result = PHPUnit::run($suite8);

echo $result -> toString();

?> 
