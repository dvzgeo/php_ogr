<?php
require_once 'phpunit-0.5/phpunit.php';
require_once("util.php");

class OGRSFDriverMiscellaneousTest1 extends PHPUnit_TestCase {
    var $strPathToData;
    var $strPathToOutputData;
    var $bUpdate;
    var $hOGRSFDriver;
    var $strFilename;
    var $strCapability;

    // constructor of the test suite
    function OGRSFDriverMiscellaneousTest1($name){
        printf("in constructor OGRSFDriverMiscellaneousTest\n");

        $this->PHPUnit_TestCase($name);
    }
    // called before the test functions will be executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here
    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strPathToOutputData = "../../ogrtests/testcase/";
        $this->strFilename = "NewDataSource";
        $this->bUpdate = FALSE;
        $this->strCapability = ODrCCreateDataSource;
    }
    // called after the test functions are executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here    
    function tearDown() {
        // delete your instance
        unset($this->strPathToData);
        unset($this->strPathToOutputData);
        unset($this->strFilename);
        unset($this->bUpdate);
        unset($this->strCapability);
    }
    /*Registered drivers supposed to be zero.*/
    function testOGRGetDriverCount1() {
        $result = OGRGetDriverCount();
        printf("result = %d\n", $result);
        $expected = 0;
        $this->assertEquals($expected, $result, "Driver count is supposed".
                            " to be ".expected, 0 /*$delta*/);
    }

    /*Adding one driver.  PROBLEM WITH OGRGetDriver when no registered
      driver exist.  TO COME BACK TO.*/
/*    function testOGRGetDriverCount2() {
        $result = OGRGetDriver(0);
        printf("driver = %d\n", $result);
        $this->assertNull($result, "Return driver is not NULL");
        $result = OGRGetDriverCount();
        printf("result = %d\n", $result);
        $expected = 0;
        $this->assertEquals($expected, $result, "Driver count is supposed".
                            " to be ".expected, 0 );
    }
*/
    /*Verify driver count with all drivers registered.*/
    function testOGRGetDriverCount3() {
        OGRRegisterAll();
        $result = OGRGetDriverCount();
        printf("result = %d\n", $result);
        $expected = 10;
        $this->assertEquals($expected, $result, "Driver count is supposed".
                            " to be".$expected, 0 /*$delta*/);
    }

    /*Verify driver count after registering a new driver.
     ERROR TO COME BACK TO.  OGRRegisterDriver seems to have 
     no utility here.  hOGRSFDriver is not supposed to be null
    after calling OGROpen().*/
    function testOGRGetDriverCount4() {

        $result = OGROpen($this->strPathToData, $this->bUpdate, 
                          $this->hOGRSFDriver);
        printf("result = %d\n", $result);
        $this->assertNotNull($result, "hOGRDataSource is NULL");
        $result = OGRGetDriverCount();
        printf("result = %d\n", $result);
        $expected = 10;
        $this->assertEquals($expected, $result, "Driver count is supposed".
                            " to be".$expected, 0 /*$delta*/);
        OGRRegisterDriver($this->hOGRSFDriver);
        $result = OGRGetDriverCount();
        printf("result = %d\n", $result);
        $expected = 10;
        $this->assertEquals($expected, $result, "Driver count is supposed".
                            " to be".$expected, 0 /*$delta*/);
    }
    /*Get a driver handle after execution OGRRegisterAll() in a preceeding
      test unit.*/
    function testOGRGetDriver1() {
        $result = OGRGetDriver(0);
        printf("driver = %d\n", $result);
        $this->assertNotNull($result, "Driver zero is not supposed".
                            " to be NULL");
    }
    /*Getting a driver with an id out of range.*/
    function testOGRGetDriver2() {
        $result = OGRGetDriver(50);
        printf("driver = %d\n", $result);
        $this->assertNull($result, "Driver zero is supposed".
                            " to be NULL");
    }
    /*Adding an existing driver has no effect.*/
    function testOGRGetDriver3() {
        $hDriver = OGRGetDriver(2);
        printf("driver = %d\n", $hDriver);
        $this->assertNotNull($hDriver, "Driver zero is not supposed".
                            " to be NULL");
        OGRRegisterDriver($hDriver);
        $nDriverCount = OGRGetDriverCount();
        printf("result = %d\n", $nDriverCount);
        $expected = 10;
        $this->assertEquals($expected, $nDriverCount, "Driver count is".
                            "supposed to be".$expected, 0 /*$delta*/);
    }
    /*Getting driver name.*/
    function testOGR_Dr_GetName1() {
        $hDriver = OGRGetDriver(7);
        $strDriverName = OGR_Dr_GetName($hDriver);
        printf("Driver name= %s\n", $strDriverName);
        $expected = "GML";
        $this->assertEquals($expected, $strDriverName, "Driver name is not".
                            "corresponding\n");
    }

    /*Creating a data source with MapInfo File driver*/
    function testOGR_Dr_CreateDataSource1(){

        printf("Source name =%s\n", $this->strPathToOutputData.$this->strFilename);

        $hDriver = OGRGetDriver(5);
        $astrOptions[0] = "FORMAT=MIF";
        system( "rm -R ".$this->strPathToOutputData.$this->strFilename);
        $hDataSource = OGR_Dr_CreateDataSource($hDriver, 
                                               $this->strPathToOutputData.
                                               $this->strFilename,
                                               $astrOptions );
        $this->assertNotNull($hDataSource, "New data source is NULL\n");
        OGR_DS_Destroy($hDataSource);
        $this->assertNull($hDataSource, "New data source is not NULL after".
                          " OGR_DS_Destroy()\n");
    }

    /*Opening an existing data source with MapInfo File driver*/
    function testOGR_Dr_Open1(){
        $hDriver = OGRGetDriver(5);
        $astrOptions[0] = "FORMAT=MIF";
  
        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                               $this->strPathToData.
                                               $this->strFilename,
                                               $this->bUpdate);

        $this->assertNotNull($hExistingDataSource, 
                             "Existing data source is NULL\n");
        OGR_DS_Destroy($hExistingDataSource);
        $this->assertNull($hExistingDataSource, 
                          "New data source is not NULL after".
                          " OGR_DS_Destroy()\n");

    }
    function testOGR_Dr_TestCapability1(){
        $hDriver = OGRGetDriver(5);
        $iCapability = OGR_Dr_TestCapability($hDriver, $this->strCapability);
        $this->assertTrue($iCapability,"Capability is supposed to be".
                          " supported" );
    }
}
?> 
