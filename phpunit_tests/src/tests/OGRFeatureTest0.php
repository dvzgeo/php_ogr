<?php

use \PHPUnit\Framework\TestCase;

class OGRFeatureTest0 extends TestCase
{
    public $strPathToData;
    public $strPathToOutputData;
    public $strTmpDumpFile;
    public $bUpdate;
    public $eGeometryType;
    public $strDestDataSource;
    public $strOutputLayer;

    public static function setUpBeforeClass() : void
    {
        OGRRegisterAll();
    }


    // called before the test functions will be executed
    // this function is defined in TestCase and overwritten
    // here
    public function setUp() : void
    {
        $this->strPathToData = test_data_path("andorra", "shp");
        $this->strPathToOutputData = create_temp_directory(__CLASS__);
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->bUpdate = false;
        $this->eGeometryType = wkbUnknown;
        $this->strDestDataSource = "DSOutput";
        $this->strOutputLayer = "OutputLayer";
    }
    // called after the test functions are executed
    // this function is defined in TestCase and overwritten
    // here
    public function tearDown() : void
    {
        delete_directory($this->strPathToOutputData);
        // delete your instance
        unset($this->strPathToData);
        unset($this->strPathToOutputData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->eGeometryType);
        unset($this->strDestDataSource);
        unset($this->strOutputLayer);
    }

    /***********************************************************************
     *                         testOGR_F_CreateDestroy0()
     *
     ************************************************************************/
    public function testOGR_F_CreateDestroy0()
    {
        $hDriver = OGRGetDriverByName('ESRI Shapefile');

        $hSpatialRef = null;

        $hODS = OGR_Dr_CreateDataSource(
            $hDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            null /*Options*/
        );

        $hLayer = OGR_DS_CreateLayer(
            $hODS,
            $this->strOutputLayer,
            $hSpatialRef,
            $this->eGeometryType,
            null /*Options*/
        );

        if (OGR_L_CreateField(
                $hLayer,
                OGR_Fld_Create("NewField", OFTInteger),
                0 /*bApproOK*/
            ) != OGRERR_NONE) {
            return (false);
        }

        $hFeature = OGR_F_Create(OGR_L_GetLayerDefn($hLayer));


        $this->assertNotNull(
            $hFeature,
            "OGR_F_Create(): Feature handle is not supposed to be NULL."
        );


        OGR_F_Destroy($hFeature);

        $expected = "Unknown";

        $actual = get_resource_type($hFeature);


        $this->assertEquals(
            $expected,
            $actual,
            "Problem with OGR_F_Destroy():  Feature resource is supposed to be freed after OGR_F_Destroy().\n"
        );


        OGR_DS_Destroy($hODS);
    }

    /***********************************************************************
     *                         testOGR_F_GetDefnRef0()
     *
     ************************************************************************/
    public function testOGR_F_GetDefnRef0()
    {
        $nFeatureId = 10;

        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        $hDriver = OGRGetDriverByName('ESRI Shapefile');

        $hExistingDataSource = OGR_Dr_Open(
            $hDriver,
            $this->strPathToData,
            $this->bUpdate
        );

        $this->assertNotNull(
            $hExistingDataSource,
            "Problem opening existing data from " . $this->strPathToData
        );

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        if ($fpOut == false) {
            printf("Dump file creation error\n");
            return false;
        }

        $hLayer = OGR_DS_GetLayerByName($hExistingDataSource, "gis_osm_places_free_1");

        $hFeatureDefn = OGR_L_GetLayerDefn($hLayer);

        OGRDumpLayerDefn($fpOut, $hFeatureDefn);

        $hFeature = OGR_L_GetFeature($hLayer, $nFeatureId);

        $hSameFeatureDefn = OGR_F_GetDefnRef($hFeature);

        $this->assertNotNull(
            $hSameFeatureDefn,
            "OGR_F_GetDefnRef Feature handle is not supposed to be NULL."
        );

        OGRDumpLayerDefn($fpOut, $hSameFeatureDefn);

        OGR_F_Destroy($hFeature);

        OGR_DS_Destroy($hExistingDataSource);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_L_GetLayerDefn(), or OGR_F_GetDefnRef(): files comparison did not match.\n"
        );
    }
}
