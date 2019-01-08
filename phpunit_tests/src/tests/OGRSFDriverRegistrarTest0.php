<?php

class OGRSFDriverRegistrarTest0 extends PHPUnit_Framework_TestCase
{
    public $strPathToData;
    public $bUpdate;
    public $hOGRSFDriver;
    public $strFilename;

    // called before the test functions will be executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    public function setUp()
    {
        $this->strPathToData = "./data/mif";
        $this->strFilename = "road.tab";
        $this->bUpdate = false;
    }
    // called after the test functions are executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    public function tearDown()
    {
        // delete your instance
        unset($this->strPathToData);
        unset($this->strFilename);
        unset($this->bUpdate);
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
    }

    /***********************************************************************
     *                       testOGROpen1()
     *
     ************************************************************************/
    public function testOGROpen1()
    {
        OGRRegisterAll();

        $hDS = OGROpen(
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
