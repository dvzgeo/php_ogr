<?php

use \PHPUnit\Framework\TestCase;

class OGRSFDriverTest0 extends TestCase
{
    public $strPathToData;
    public $strPathToOutputData;
    public $strDestDataSource;
    public $bUpdate;
    public $hOGRSFDriver;
    public $strCapability;

    public static function setUpBeforeClass()
    {
        OGRRegisterAll();
    }

    // called before the test functions will be executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    public function setUp()
    {
        $this->strPathToData = test_data_path("andorra", "shp");
        $this->strPathToOutputData = create_temp_directory(__CLASS__);
        $this->strDestDataSource = "OutputDS";
        $this->bUpdate = false;
        $this->strCapability = ODrCCreateDataSource;
    }
    // called after the test functions are executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    public function tearDown()
    {
        // delete your instance
        delete_directory($this->strPathToOutputData);
        unset($this->strPathToData);
        unset($this->strPathToOutputData);
        unset($this->strDestDataSource);
        unset($this->bUpdate);
        unset($this->strCapability);
        unset($this->hOGRSFDriver);
    }

    /***********************************************************************
     *                       testOGR_Dr_GetName0()
     *                       Getting driver name.
     ************************************************************************/

    public function testOGR_Dr_GetName0()
    {
        $hDriver = OGRGetDriver(1);
        $this->assertNotNull($hDriver, "Could not open driver");
        $strDriverName = OGR_Dr_GetName($hDriver);

        $expected = "GML";
        $this->assertNotEmpty(
            $strDriverName,
            "Problem with OGR_Dr_GetName():  Driver name should not be empty"
        );
    }

    /***********************************************************************
     *               testOGR_Dr_CreateDataSource0()
     *       Creating a data source with MapInfo File driver.
     ************************************************************************/

    public function testOGR_Dr_CreateDataSource0()
    {
        $hDriver = OGRGetDriverByName("MapInfo File");
        $astrOptions[0] = "FORMAT=MIF";

        $hDataSource = OGR_Dr_CreateDataSource(
            $hDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            $astrOptions
        );

        $this->assertNotNull(
            $hDataSource,
            "Problem with OGR_Dr_CreateDataSource():  New data source is not supposed to be NULL."
        );

        OGR_DS_Destroy($hDataSource);

        $expected = "Unknown";

        $actual = get_resource_type($hDataSource);


        $this->assertEquals(
            $expected,
            $actual,
            "Problem with OGR_DS_Destroy():  Data source resource is supposed to be freed after OGR_DS_Destroy()."
        );
    }

    /***********************************************************************
     *                        testOGR_Dr_Open0()
     *       Opening an existing data source with ESRI Shapefile driver.
     ************************************************************************/

    public function testOGR_Dr_Open0()
    {
        $this->hOGRSFDriver = OGRGetDriverByName("ESRI Shapefile");

        $hSrcDataSource = OGR_Dr_Open(
            $this->hOGRSFDriver,
            $this->strPathToData,
            $this->bUpdate
        );

        $this->assertNotNull(
            $hSrcDataSource,
            "Problem with OGR_Dr_Open():  handle to existing data source is not supposed to be NULL."
        );
        OGR_DS_Destroy($hSrcDataSource);
    }

    /***********************************************************************
     *                        testOGR_Dr_TestCapability0()
     ************************************************************************/

    public function testOGR_Dr_TestCapability0()
    {
        $this->hOGRSFDriver = OGRGetDriverByName("ESRI Shapefile");
        $bCapability = OGR_Dr_TestCapability(
            $this->hOGRSFDriver,
            $this->strCapability
        );
        $this->assertTrue(
            $bCapability,
            "Problem with OGR_Dr_TestCapability():  " . $this->strCapability . " is supposed to be supported."
        );
    }
}
