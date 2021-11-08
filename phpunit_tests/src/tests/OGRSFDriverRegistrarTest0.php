<?php

use \PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class OGRSFDriverRegistrarTest0 extends TestCase
{
    public $strPathToData;
    public $bUpdate;
    public $hOGRSFDriver;
    public $strFilename;

    // called before the test functions will be executed
    // this function is defined in TestCase and overwritten
    // here
    public function setUp() : void
    {
        $this->strPathToData = test_data_path("andorra", "shp");
        $this->bUpdate = false;
    }
    // called after the test functions are executed
    // this function is defined in TestCase and overwritten
    // here
    public function tearDown() : void
    {
        // delete your instance
        unset($this->strPathToData);
        unset($this->bUpdate);
    }

    /***********************************************************************
     *                       testOGRRegisterAll0()
     *
     ************************************************************************/
    public function testOGRRegisterAll0()
    {
        $this->assertEquals(0, OGRGetDriverCount(), "Driver count should be 0 before registration");
        OGRRegisterAll();
        $this->assertGreaterThan(0, OGRGetDriverCount(), "Driver count should be >0 after driver registration");
    }
}

?> 
