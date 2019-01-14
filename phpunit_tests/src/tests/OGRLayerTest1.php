<?php

class OGRLayerTest1 extends PHPUnit_Framework_TestCase
{
    public $strPathToOutputData;
    public $strTmpDumpFile;
    public $strPathToData;
    public $strPathToStandardData;
    public $bUpdate;
    public $hOGRSFDriver;
    public $hLayer;
    public $hSrcDataSource;
    public $iSpatialFilter;

    public static function setUpBeforeClass()
    {
        OGRRegisterAll();
    }

    // called before the test functions will be executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    public function setUp()
    {
        $this->strPathToOutputData = create_temp_directory(__CLASS__);
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->strPathToData = test_data_path("andorra", "mif", "gis_osm_places_free_1.mif");
        $this->strPathToStandardData = "./data/testcase/";
        $this->bUpdate = false;
        $this->iSpatialFilter[0] = 1.4;  /*xmin*/
        $this->iSpatialFilter[1] = 42.4;  /*ymin*/
        $this->iSpatialFilter[2] = 1.6;  /*xmax*/
        $this->iSpatialFilter[3] = 42.6;  /*ymax*/

        OGRRegisterAll();

        $this->hOGRSFDriver = OGRGetDriverByName("MapInfo File");
        $this->assertNotNull(
            $this->hOGRSFDriver,
            "Could not get MapInfo File driver"
        );

        $this->hSrcDataSource = OGR_Dr_Open(
            $this->hOGRSFDriver,
            $this->strPathToData,
            $this->bUpdate
        );
        $this->assertNotNull(
            $this->hSrcDataSource,
            "Could not open datasource " . $this->strPathToData
        );

        $this->hLayer = OGR_DS_GetLayer($this->hSrcDataSource, 0);
        $this->assertNotNull($this->hLayer, "Could not open source layer");
    }
    // called after the test functions are executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    public function tearDown()
    {
        // delete your instance
        OGR_DS_Destroy($this->hSrcDataSource);

        delete_directory($this->strPathToOutputData);

        unset($this->strPathToOutputData);
        unset($this->strTmpDumpFile);
        unset($this->strPathToData);
        unset($this->strPathToStandardData);
        unset($this->bUpdate);
        unset($this->hOGRSFDriver);
        unset($this->hLayer);
        unset($this->iSpatialFilter);
        unset($this->hSrcDataSource);
    }

    /***********************************************************************
     *                         testOGR_L_SetGetSpatialFilter0()
     *
     ************************************************************************/

    public function testOGR_L_SetGetSpatialFilter0()
    {
        $strStandardFile = test_data_path("reference", __CLASS__, __FUNCTION__ . ".std");

        $hSpatialFilter = OGR_G_CreateGeometry(wkbLinearRing);


        OGR_G_AddPoint(
            $hSpatialFilter,
            $this->iSpatialFilter[0],
            $this->iSpatialFilter[1],
            0.0
        );
        OGR_G_AddPoint(
            $hSpatialFilter,
            $this->iSpatialFilter[0],
            $this->iSpatialFilter[3],
            0.0
        );
        OGR_G_AddPoint(
            $hSpatialFilter,
            $this->iSpatialFilter[2],
            $this->iSpatialFilter[3],
            0.0
        );
        OGR_G_AddPoint(
            $hSpatialFilter,
            $this->iSpatialFilter[2],
            $this->iSpatialFilter[1],
            0.0
        );
        OGR_G_AddPoint(
            $hSpatialFilter,
            $this->iSpatialFilter[0],
            $this->iSpatialFilter[1],
            0.0
        );

        $filter = OGR_L_GetSpatialFilter($this->hLayer);
        $this->assertNull(
            $filter,
            "Spatial filter is supposed to be NULL initially"
        );

        OGR_L_SetSpatialFilter($this->hLayer, $hSpatialFilter);

        $hSpatialOut = OGR_L_GetSpatialFilter($this->hLayer);

        $this->assertNotNull(
            $hSpatialOut,
            "Problem with OGR_L_SetSpatialFilter(): Spatial filter is not supposed to be NULL."
        );

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_G_DumpReadable($fpOut, $hSpatialOut);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_L_SetSpatialFilter() or OGR_L_GetSpatialFilter(): Files comparison did not matched."
        );
    }

    /***********************************************************************
     *                         testOGR_L_SetAttributeFilter0()
     *
     ************************************************************************/

    public function testOGR_L_SetAttributeFilter0()
    {
        $strStandardFile = test_data_path("reference", __CLASS__, __FUNCTION__ . ".std");

        $hSpatialFilter = null;

        $strAttributeFilter = "(code <= 1003) AND (population > 10000)";

        $eErr = OGR_L_SetAttributeFilter($this->hLayer, $strAttributeFilter);

        $this->assertEquals(
            OGRERR_NONE,
            $eErr,
            "Attribute filter is not supposed to returned an error."
        );

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );
        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGRDumpSingleLayer($fpOut, $this->hLayer, true /*bForce*/);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_L_SetAttributeFilter(): Files comparison did not matched."
        );
    }
}
