<?php

$testSuites_list[] = "OGRSFDriverRegistrarTest0";                             
                             
class OGRSFDriverRegistrarTest0 extends PHPUnit_TestCase {
    var $strPathToData;
    var $bUpdate;
    var $hOGRSFDriver;
    var $strFilename;

    // constructor of the test suite
    function OGRSFDriverRegistrarTest0($name){
        $this->PHPUnit_TestCase($name);
    }
    // called before the test functions will be executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here
    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strFilename = "road.tab";
        $this->bUpdate = FALSE;
    }
    // called after the test functions are executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here    
    function tearDown() {
        // delete your instance
        unset($this->strPathToData);
        unset($this->strFilename);
        unset($this->bUpdate);
    }
/***********************************************************************
*                       testOGROpen0()
*
************************************************************************/
    function testOGROpen0() {

        $hDS = @OGROpen($this->strPathToData, $this->bUpdate, 
                          $this->hOGRSFDriver);

        $this->assertNull($hDS, "Problem with OGROpen():  ".
                          "handle is supposed to be NULL when ".
                          "no driver is registered.");
    }
/***********************************************************************
*                       testOGROpen1()
*
************************************************************************/
    function testOGROpen1() {
        OGRRegisterAll();

        $hDS = OGROpen($this->strPathToData, $this->bUpdate, 
                          $this->hOGRSFDriver);

        $this->assertNotNull($hDS, "Problem with OGROpen():  handle ".
                             "is not supposed to be NULL when all drivers ".
                             "are registered.");

        $this->assertNotNull($this->hOGRSFDriver, "Problem with OGROpen():  ".
                             "hOGRSFDriver is not supposed to be NULL ".
                             "when all drivers are registered.");
        OGR_DS_Destroy($hDS);
    }
}
$testSuites_list[] = "OGRSFDriverRegistrarTest1";                             

class OGRSFDriverRegistrarTest1 extends PHPUnit_TestCase {
    var $strPathToData;
    var $bUpdate;
    var $hOGRSFDriver;
    var $strFilename;

    // constructor of the test suite
    function OGRSFDriverRegistrarTest1($name) {
        $this->PHPUnit_TestCase($name);
    }

    // called before the test functions will be executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here
    function setUp() {
        $this->strPathToData = "./dataBad/mif";
        $this->strFilename = "road.tab";
        $this->bUpdate = FALSE;
        $this->hOGRSFDriver = null;
    }
    // called after the test functions are executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here    
    function tearDown() {
        // delete your instance
        unset($this->strPathToData);
        unset($this->strFilename);
        unset($this->bUpdate);
        unset($this->hOGRSFDriver);
    }
/***********************************************************************
*                       testOGROpen0()
*
************************************************************************/

    function testOGROpen0() {
        $hDS = @OGROpen($this->strPathToData, $this->bUpdate, 
                          $this->hOGRSFDriver);

        $this->assertNull($hDS, "Problem with OGROpen():  handle ".
                             "is supposed to be NULL when a bad path ".
                             "is entered.");

        $this->assertNull($this->hOGRSFDriver, "Problem with OGROpen():  ".
                             "hOGRSFDriver is supposed to be NULL ".
                             "when a bad path is specified.");

    }
/***********************************************************************
*                       testOGROpen1()
*
************************************************************************/

    function testOGROpen1() {
        OGRRegisterAll();

        $hDS = @OGROpen($this->strPathToData, $this->bUpdate, 
                          $this->hOGRSFDriver);

        $this->assertNull($hDS, "Problem with OGROpen():  handle ".
                             "is supposed to be NULL when a bad path ".
                             "is entered eventhough, all drivers are ".
                             "registered.");

        $this->assertNull($this->hOGRSFDriver, "Problem with OGROpen():  ".
                             "hOGRSFDriver is supposed to be NULL ".
                             "when a bad path is specified, eventhough ".
                             "all drivers are registered.");
    }
}
$testSuites_list[] = "OGRSFDriverRegistrarTest2";                             

class OGRSFDriverRegistrarTest2 extends PHPUnit_TestCase {
    var $strPathToData;
    var $bUpdate;
    var $hOGRSFDriver;
    var $strFilename;

    // constructor of the test suite
    function OGRSFDriverRegistrarTest2($name) {
        $this->PHPUnit_TestCase($name);
    }
    // called before the test functions will be executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here
    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strFilename = "road.tab";
        $this->bUpdate = FALSE;
        $this->hOGRSFDriver = null;
    }
    // called after the test functions are executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here    
    function tearDown() {
        // delete your instance
        unset($this->strPathToData);
        unset($this->strFilename);
        unset($this->bUpdate);
        unset($this->hOGRSFDriver);
    }
/***********************************************************************
*                       testOGROpen0()
*
************************************************************************/
    function testOGROpen0() {
        $hDS = @OGROpen($this->strPathToData, $this->bUpdate, 
                          $this->hOGRSFDriver);

        $this->assertNull($hDS, "Problem with OGROpen():  handle ".
                             "is supposed to be NULL when no driver ".
                             "is registered.");

        $this->assertNull($this->hOGRSFDriver, "Problem with OGROpen():  ".
                             "hOGRSFDriver is supposed to be NULL when ".
                             "no driver is registered.");
    }
/***********************************************************************
*                       testOGROpen1()
*
************************************************************************/
    function testOGROpen1() {
        OGRRegisterAll();

        $hDS = @OGROpen($this->strPathToData, $this->bUpdate, 
                          $this->hOGRSFDriver);


        $this->assertNotNull($hDS, "Problem with OGROpen():  handle ".
                             "is not supposed to be NULL when all drivers ".
                             "are registered.");

        $this->assertNotNull($this->hOGRSFDriver, "Problem with OGROpen():  ".
                             "hOGRSFDriver is not supposed to be NULL when ".
                             "all drivers are registered.");

        OGR_DS_Destroy($hDS);
    }
}

?> 
