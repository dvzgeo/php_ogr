<?php
require_once 'phpunit-0.5/phpunit.php';
                             
class OGRSFDriverPathSetGoodhOGRSFDriverNotSetTest extends PHPUnit_TestCase {
    var $strPathToData;
    var $bUpdate;
    var $hOGRSFDriver;
    var $strFilename;

    // constructor of the test suite
    function OGRSFDriverPathSetGoodhOGRSFDriverNotSetTest($name){
        printf("in constructor OGRSFDriverPathSetGoodhOGRSFDriverNotSetTest\n");

        $this->PHPUnit_TestCase($name);
    }
    // called before the test functions will be executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here
    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strFilename = "road.tab";
        $this->bUpdate = 0;
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
    function testOGROpen1() {
        printf("in OGRSFDriverPathSetGoodhOGRSFDriverNotSetTest\n");
        $result = NULL;
        $result = OGROpen($this->strPathToData, $this->bUpdate, 
                          $this->hOGRSFDriver);
        printf("result = %d\n", $result);
        $this->assertNull($result, "hOGRDataSource is not NULL");
    }
    function testOGROpen2() {
        OGRRegisterAll();
        $result = NULL;
        $result = OGROpen($this->strPathToData, $this->bUpdate, 
                          $this->hOGRSFDriver);
        printf("result = %d\n", $result);
        $this->assertNotNull($result, "hOGRDataSource is NULL");
        if(is_null($this->hOGRSFDriver))
            printf("Driver null\n");
        printf("driver = %d\n", $this->hOGRSFDriver);
        $this->assertNotNull($this->hOGRSFDriver, "hOGRSFDriver is NULL");
        OGR_DS_Destroy($result);
    }
}
class OGRSFDriverPathSetBadhOGRSFDriverSetToNULLTest extends PHPUnit_TestCase {
    var $strPathToData;
    var $bUpdate;
    var $hOGRSFDriver;
    var $strFilename;

    // constructor of the test suite
    function OGRSFDriverPathSetBadhOGRSFDriverSetToNULLTest($name) {
        printf("in constructor of OGRSFDriverPathSetBadhOGRSFDriverSetToNULLTest\n");
        $this->PHPUnit_TestCase($name);
    }
    // called before the test functions will be executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here
    function setUp() {
        $this->strPathToData = "./dataBad/mif";
        $this->strFilename = "road.tab";
        $this->bUpdate = 0;
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
    function testOGROpen1() {
        printf("in OGRSFDriverPathSetBadhOGRSFDriverSetToNULLTest\n");
        $result = NULL;
        $result = OGROpen($this->strPathToData, $this->bUpdate, 
                          $this->hOGRSFDriver);
        printf("result = %d\n", $result);
        $this->assertNull($result, "OGRDataSourceH is not NULL");
        $this->assertNull($this->hOGRSFDriver, "hOGRSFDriver is not NULL");
    }
    function testOGROpen2() {
        OGRRegisterAll();
        $result = NULL;
        $result = OGROpen($this->strPathToData, $this->bUpdate, 
                          $this->hOGRSFDriver);
        printf("result = %d\n", $result);
        $this->assertNull($result, "OGRDataSourceH is not NULL");
        $this->assertNull($this->hOGRSFDriver, "hOGRSFDriver is not NULL");
    }
}
class OGRSFDriverPathSetOkhOGRSFDriverSetToNULLTest extends PHPUnit_TestCase {
    var $strPathToData;
    var $strBadPathToData;
    var $bUpdate;
    var $hOGRSFDriver;
    var $strFilename;

    // constructor of the test suite
    function OGRSFDriverPathSetOkhOGRSFDriverSetToNULLTest($name) {
        printf("in constructor of OGRSFDriverPathSetOkhOGRSFDriverSetToNULLTest\n");
        $this->PHPUnit_TestCase($name);
    }
    // called before the test functions will be executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here
    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strFilename = "road.tab";
        $this->bUpdate = 0;
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
    function testOGROpen1() {
        printf("in OGRSFDriverPathSetOkhOGRSFDriverSetToNULLTest\n");
        $result = NULL;
        $result = OGROpen($this->strPathToData, $this->bUpdate, 
                          $this->hOGRSFDriver);
        printf("result = %d\n", $result);
        /*Drivers are already registered in a preceeding test.*/
        printf("Drivers already registered = %d\n", OGRGetDrivercount());
        $this->assertNotNull($result, "OGRDataSourceH is not NULL");
        /*hOGRSFDriver is NULL.*/
        $this->assertNull($this->hOGRSFDriver, "hOGRSFDriver is not NULL");
    }
    function testOGROpen2() {
        OGRRegisterAll();
        $result = NULL;
        $result = OGROpen($this->strPathToData, $this->bUpdate, 
                          $this->hOGRSFDriver);
        printf("result = %d\n", $result);
        $this->assertNotNull($result, "OGRDataSourceH is NULL");
        $this->assertNull($this->hOGRSFDriver, "hOGRSFDriver is not NULL");
        OGR_DS_Destroy($result);
    }

}

?> 






