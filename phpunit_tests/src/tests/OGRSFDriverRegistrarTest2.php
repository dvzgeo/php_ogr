<?php

use \PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class OGRSFDriverRegistrarTest2 extends TestCase
{
    public $strPathToData;
    public $bUpdate;
    public $hOGRSFDriver;

    // called before the test functions will be executed
    // this function is defined in TestCase and overwritten
    // here
    public function setUp() : void
    {
        $this->strPathToData = test_data_path("andorra", "shp");
        $this->bUpdate = false;
        $this->hOGRSFDriver = null;
    }
    // called after the test functions are executed
    // this function is defined in TestCase and overwritten
    // here
    public function tearDown() : void
    {
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
    public function testOGROpen0()
    {
        $hDS = @OGROpen(
            $this->strPathToData,
            $this->bUpdate,
            $this->hOGRSFDriver
        );

        $this->assertNull(
            $hDS,
            "Problem with OGROpen():  handle is supposed to be NULL when no driver is registered."
        );

        $this->assertNull(
            $this->hOGRSFDriver,
            "Problem with OGROpen():  hOGRSFDriver is supposed to be NULL when no driver is registered."
        );
    }

    /***********************************************************************
     *                       testOGROpen1()
     *
     ************************************************************************/
    public function testOGROpen1()
    {
        OGRRegisterAll();

        $hDS = @OGROpen(
            $this->strPathToData,
            $this->bUpdate,
            $this->hOGRSFDriver
        );


        $this->assertNotNull(
            $hDS,
            "Problem with OGROpen():  handle is not supposed to be NULL when all drivers are registered."
        );

        $this->assertNotNull(
            $this->hOGRSFDriver,
            "Problem with OGROpen():  hOGRSFDriver is not supposed to be NULL when all drivers are registered."
        );

        OGR_DS_Destroy($hDS);
    }
}

?> 
