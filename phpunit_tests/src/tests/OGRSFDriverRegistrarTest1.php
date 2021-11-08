<?php

use \PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class OGRSFDriverRegistrarTest1 extends TestCase
{
    public $strPathToData;
    public $bUpdate;
    public $hOGRSFDriver;

    // called before the test functions will be executed
    // this function is defined in TestCase and overwritten
    // here
    public function setUp() : void
    {
        $this->strPathToData = create_temp_directory(__CLASS__);
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
            "Problem with OGROpen():  handle is supposed to be NULL when a bad path is entered."
        );

        $this->assertNull(
            $this->hOGRSFDriver,
            "Problem with OGROpen():  hOGRSFDriver is supposed to be NULL when a bad path is specified."
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

        $this->assertNull(
            $hDS,
            "Problem with OGROpen():  handle is supposed to be NULL when a bad path is entered eventhough, all drivers are registered."
        );

        $this->assertNull(
            $this->hOGRSFDriver,
            "Problem with OGROpen():  hOGRSFDriver is supposed to be NULL when a bad path is specified, eventhough all drivers are registered."
        );
    }
}

?> 
