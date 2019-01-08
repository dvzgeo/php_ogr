<?php
require_once __DIR__ . '/../vendor/autoload.php';

printf(
    "
/***********************************************************************
*                           Testing php_ogr extension
*                          
************************************************************************/
"
);

$bSuccess = false;
$nTests = 0;
$nFailures = 0;
$nErrors = 0;
$resultPrinter = new PHPUnit_TextUI_ResultPrinter();


printf(
    "
/***********************************************************************
*                           Beginning suite 1
*                          
************************************************************************/
"
);
$suite1 = new PHPUnit_Framework_TestSuite("OGRSFDriverRegistrarTest0");
$suite1->addTestSuite("OGRSFDriverRegistrarTest1");
$suite1->addTestSuite("OGRSFDriverRegistrarTest2");
$suite1->addTestSuite("OGRSFDriverRegistrarTest3");
$suite1->addTestSuite("OGRSFDriverTest0");

printf("var_dump suite1\n");
printf("test case count = %d\n", $suite1->count());
printf("after var_dump suite1\n");


$result = $suite1->run();

$resultPrinter->printResult($result);

$nTests = $result->count();

if ($result->wasSuccessful() == false) {
    $bSuccess = false;
}

$nFailures = $result->failureCount();
$nErrors = $result->errorCount();

printf(
    "
/***********************************************************************
*                           Beginning suite 2
*                          
************************************************************************/
"
);

$suite2 = new PHPUnit_Framework_TestSuite("OGRDataSourceTest0");

$result = $suite2->run();

$resultPrinter->printResult($result);

$nTests = $nTests + $result->count();

if ($result->wasSuccessful() == false) {
    $bSuccess = false;
}

$nFailures = $nFailures + $result->failureCount();
$nErrors = $nErrors + $result->errorCount();

printf(
    "
/***********************************************************************
*                           Beginning suite 3
*                          
************************************************************************/
"
);

$suite3 = new PHPUnit_Framework_TestSuite("OGRLayerTest0");
$suite3->addTestSuite("OGRLayerTest1");
$suite3->addTestSuite("OGRLayerTest2");

$result = $suite3->run();

$resultPrinter->printResult($result);

$nTests = $nTests + $result->count();

if ($result->wasSuccessful() == false) {
    $bSuccess = false;
}

$nFailures = $nFailures + $result->failureCount();
$nErrors = $nErrors + $result->errorCount();


printf(
    "
/***********************************************************************
*                           Beginning suite 4
*                          
************************************************************************/
"
);
$suite4 = new PHPUnit_Framework_TestSuite("OGRFeatureTest0");
$suite4->addTestSuite("OGRFeatureTest1");
$suite4->addTestSuite("OGRFeatureTest2");
$suite4->addTestSuite("OGRFeatureTest3");
$suite4->addTestSuite("OGRFeatureTest4");
/*Not used the following test suite with MapInfo File.  List not supported.*/
//$suite4->addTestSuite("OGRFeatureTest5");

$result = $suite4->run();

$resultPrinter->printResult($result);

$nTests = $nTests + $result->count();

if ($result->wasSuccessful() == false) {
    $bSuccess = false;
}

$nFailures = $nFailures + $result->failureCount();
$nErrors = $nErrors + $result->errorCount();

printf(
    "
/***********************************************************************
*                           Beginning suite 5
*                          
************************************************************************/
"
);
$suite5 = new PHPUnit_Framework_TestSuite("OGRGeometryTest0");
$suite5->addTestSuite("OGRGeometryTest1");

$result = $suite5->run();

$resultPrinter->printResult($result);

$nTests = $nTests + $result->count();

if ($result->wasSuccessful() == false) {
    $bSuccess = false;
}

$nFailures = $nFailures + $result->failureCount();
$nErrors = $nErrors + $result->errorCount();

printf(
    "
/***********************************************************************
*                           Beginning suite 6
*                          
************************************************************************/
"
);

$suite6 = new PHPUnit_Framework_TestSuite("OGRFieldDefnTest0");

$result = $suite6->run();

$resultPrinter->printResult($result);

$nTests = $nTests + $result->count();

if ($result->wasSuccessful() == false) {
    $bSuccess = false;
}

$nFailures = $nFailures + $result->failureCount();
$nErrors = $nErrors + $result->errorCount();

printf(
    "
/***********************************************************************
*                           Beginning suite 7
*                          
************************************************************************/
"
);
$suite7 = new PHPUnit_Framework_TestSuite("OGRFeatureDefnTest0");
$suite7->addTestSuite("OGRFeatureDefnTest1");

$result = $suite7->run();

$resultPrinter->printResult($result);

$nTests = $nTests + $result->count();

if ($result->wasSuccessful() == false) {
    $bSuccess = false;
}

$nFailures = $nFailures + $result->failureCount();
$nErrors = $nErrors + $result->errorCount();


printf(
    "
/***********************************************************************
*                           Beginning suite 8
*                          
************************************************************************/
"
);

$suite8 = new PHPUnit_Framework_TestSuite("OGRGeometryTest2");

$result = $suite8->run();

$resultPrinter->printResult($result);

$nTests = $nTests + $result->count();

if ($result->wasSuccessful() == false) {
    $bSuccess = false;
}

$nFailures = $nFailures + $result->failureCount();
$nErrors = $nErrors + $result->errorCount();

printf(
    "
/***********************************************************************
*                           Statistics
*                          
************************************************************************/
"
);

printf("Number of tests run:  %d\n", $nTests);
printf("Success:  %d\n", $bSuccess);
printf("Number of failures:  %d\n", $nFailures);
printf("Number of errors:  %d\n", $nErrors);


?> 
