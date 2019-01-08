<?php

class OGRSFDriverTest0 extends PHPUnit_Framework_TestCase
{
    public $strDirName;
    public $strPathToData;
    public $strPathToOutputData;
    public $strDestDataSource;
    public $bUpdate;
    public $hOGRSFDriver;
    public $strCapability;

    // called before the test functions will be executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    public function setUp()
    {
        $this->strDirName = "testcase/";
        $this->strPathToData = "./data/mif";
        $this->strPathToOutputData = "../../ogrtests/" . $this->strDirName;
        $this->strDestDataSource = "OutputDS";
        $this->bUpdate = false;
        $this->strCapability = ODrCCreateDataSource;


        if (file_exists($this->strPathToOutputData)) {
            system("rm -R " . $this->strPathToOutputData);
        }

        mkdir($this->strPathToOutputData, 0777);
    }
    // called after the test functions are executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    public function tearDown()
    {
        // delete your instance
        unset($this->strDirName);
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
        OGRRegisterAll();
        -

        $hDriver = OGRGetDriver(7);
        $strDriverName = OGR_Dr_GetName($hDriver);

        $expected = "GML";
        $this->assertEquals(
            $expected,
            $strDriverName,
            "Problem with OGR_Dr_GetName():  Driver name is notcorresponding to what is expected.\n"
        );
    }

    /***********************************************************************
     *               testOGR_Dr_CreateDataSource0()
     *       Creating a data source with MapInfo File driver.
     ************************************************************************/

    public function testOGR_Dr_CreateDataSource0()
    {
        OGRRegisterAll();

        $hDriver = OGRGetDriver(5);
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
     *       Opening an existing data source with MapInfo File driver.
     ************************************************************************/

    public function testOGR_Dr_Open0()
    {
        OGRRegisterAll();

        $this->hOGRSFDriver = OGRGetDriver(5);
        $astrOptions[0] = "FORMAT=MIF";

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
        OGRRegisterAll();

        $this->hOGRSFDriver = OGRGetDriver(5);
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
