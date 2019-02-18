<?php

class OGRLayerTest3 extends PHPUnit_Framework_TestCase
{
    public $strPathToOutputData;
    public $strTmpDumpFile;
    public $strPathToData;
    public $bUpdate;
    public $bForce;
    public $hOGRSFDriver;
    public $eGeometryType;
    public $hSrcDataSource;
    public $strOutputLayer;
    public $strDestDataSource;

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
        $sourceData = test_data_path("andorra", "shp", "gis_osm_places_free_1.*");
        $this->strPathToData = $this->strPathToOutputData . "InputDS";
        $this->assertNotFalse(
            mkdir($this->strPathToData),
            "Could not create directory " . $this->strPathToData
        );
        foreach (glob($sourceData) as $file) {
            $target = $this->strPathToData . DIRECTORY_SEPARATOR . basename($file);
            $this->assertNotFalse(
                copy($file, $target),
                "Could not copy " . $file . " to " . $target
            );
        }
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->bUpdate = true;
        $this->bForce = true;
        $this->eGeometryType = wkbUnknown;
        $this->strOutputLayer = "OutputLayer";
        $this->strDestDataSource = "OutputDS";

        $this->hOGRSFDriver = OGRGetDriverByName("ESRI Shapefile");
        $this->assertNotNull($this->hOGRSFDriver, "Could not get ESRI Shapefile driver");

        $this->hSrcDataSource = OGR_Dr_Open(
            $this->hOGRSFDriver,
            $this->strPathToData,
            $this->bUpdate
        );
        $this->assertNotNull($this->hSrcDataSource, "Could not open datasource " . $this->strPathToData);
    }
    // called after the test functions are executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    public function tearDown()
    {
        // delete your instance
        OGR_DS_Destroy($this->hSrcDataSource);

        delete_directory($this->strPathToOutputData);

        unset($this->strPathToData);
        unset($this->strPathToOutputData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->bForce);
        unset($this->hOGRSFDriver);
        unset($this->eGeometryType);
        unset($this->hSrcDataSource);
        unset($this->strOutputLayer);
        unset($this->strDestDataSource);
    }

    /***********************************************************************
     *                         testOGR_L_CreateField0()
     *
     ************************************************************************/
    public function testOGR_L_CreateField0()
    {
        $hDestDS = OGR_Dr_CreateDataSource(
            $this->hOGRSFDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            null /*Options*/
        );
        $this->assertNotNull($hDestDS, "Could not create new datasource");

        $hSpatialRef = null;

        $hDestLayer = OGR_DS_CreateLayer(
            $hDestDS,
            $this->strOutputLayer,
            $hSpatialRef,
            $this->eGeometryType,
            null /*Options*/
        );
        $this->assertNotNull($hDestLayer, "Could not create new layer");

        $eErr = OGR_L_CreateField(
            $hDestLayer,
            OGR_Fld_Create("NewField", OFTInteger),
            0 /*bApproOK*/
        );
        $this->assertEquals(OGRERR_NONE, $eErr, "Could not create new field");

        OGR_DS_Destroy($hDestDS);

        $hDestDS = OGR_Dr_Open(
            $this->hOGRSFDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            false /* update */
        );
        $this->assertNotNull($hDestDS, "Could not open new datasource");

        $hNewLayer = OGR_DS_GetLayer($hDestDS, 0);
        $this->assertNotNull($hNewLayer, "Could not open new layer");

        $hLayerDefn = OGR_L_GetLayerDefn($hNewLayer);
        $this->assertNotNull($hLayerDefn, "Could not get new layer definition");

        $hFieldDefn = OGR_FD_GetFieldDefn($hLayerDefn, 0);
        $this->assertNotNull($hFieldDefn, "Could not get new field definition");

        $this->assertEquals(
            "NewField",
            OGR_FLD_GetNameRef($hFieldDefn),
            "New field name does not match"
        );

        $this->assertEquals(
            OFTInteger,
            OGR_FLD_GetType($hFieldDefn),
            "New field type does not match"
        );
    }

    /***********************************************************************
     *                         testOGR_L_CreateFeature0()
     ************************************************************************/

    public function testOGR_L_CreateFeature0()
    {
        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        $nFeatureId = 10;

        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 0);

        $this->assertNotNull($hSrcLayer, "Could not get source layer");

        $oldFeatureCount = OGR_L_GetFeatureCount($hSrcLayer, $this->bForce);

        $this->assertGreaterThan(
            $nFeatureId,
            $oldFeatureCount,
            "Too few features in source layer"
        );

        $fpOut = fopen($this->strPathToOutputData. $this->strTmpDumpFile, "w");

        $this->assertNotFalse($fpOut, "Dump file creation error");

        $hFeature = OGR_L_GetFeature($hSrcLayer, $nFeatureId);

        OGR_F_DumpReadable($hFeature, $fpOut);

        CPLErrorReset();

        $eErr = OGR_L_CreateFeature($hSrcLayer, $hFeature);

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;

        $this->assertEquals(
            $expected,
            $eErr,
            "Problem with OGR_L_CreateFeature():  " . $eErrMsg
        );

        $nFeatureCount = OGR_L_GetFeatureCount($hSrcLayer, $this->bForce);
        $this->assertEquals(
            $oldFeatureCount + 1,
            $nFeatureCount,
            "Problem with OGR_L_CreateFeature: Unexpected feature count"
        );

        $hFeature = OGR_L_GetFeature($hSrcLayer, $nFeatureCount - 1);

        OGR_F_DumpReadable($hFeature, $fpOut);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_L_CreateFeature() Files comparison did not matched."
        );
    }
}
