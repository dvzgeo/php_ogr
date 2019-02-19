<?php

class OGRLayerTest2 extends PHPUnit_Framework_TestCase
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
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->strPathToData = test_data_path("andorra", "mif", "gis_osm_places_free_1.mif");
        $this->bUpdate = false;
        $this->bForce = true;
        $this->eGeometryType = wkbUnknown;
        $this->strOutputLayer = "OutputLayer";
        $this->strDestDataSource = "OutputDS";

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
        $this->assertNotFalse(
            $this->hSrcDataSource,
            "Could not open test data " . $this->strPathToData
        );
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
     *                         testOGR_L_GetFeature0()
     *
     ************************************************************************/

    public function testOGR_L_GetFeature0()
    {
        $strStandardFile = test_data_path("reference", __CLASS__, __FUNCTION__ . ".std");

        $nFeatureId = 12;

        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 0);

        $this->assertNotNull($hSrcLayer, "Could not retrieve layer");

        $hFeature = OGR_L_GetFeature($hSrcLayer, $nFeatureId);

        $this->assertNotNull(
            $hFeature,
            "Problem with OGR_L_GetFeature():  Feature handle is not supposed to be NULL.\n"
        );

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_F_DumpReadable($hFeature, $fpOut);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_L_GetFeature() Files comparison did not matched."
        );
    }

    /***********************************************************************
     *                         testOGR_L_GetNextFeature0()
     *
     ************************************************************************/

    public function testOGR_L_GetNextFeature0()
    {
        $strStandardFile = test_data_path("reference", __CLASS__, __FUNCTION__ . ".std");
        ;

        $nFeatureId = 12;

        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 0);

        OGR_L_ResetReading($hSrcLayer);

        for ($i = 0; $i < $nFeatureId; $i++) {
            $hFeature = OGR_L_GetNextFeature($hSrcLayer);
            $this->assertNotNull(
                $hFeature,
                "Problem   with OGR_L_GetNextFeature():  Feature handle is not supposed to be NULL.\n"
            );
        }

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_F_DumpReadable($hFeature, $fpOut);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_L_GetNextFeature() Files comparison did not matched."
        );
    }

    /***********************************************************************
     *                         testOGR_L_GetSpatialRef0()
     *
     ************************************************************************/
    public function testOGR_L_GetSpatialRef0()
    {
        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 0);

        $hSpatialRef = OGR_L_GetSpatialRef($hSrcLayer);

        $this->assertNotNull(
            $hSpatialRef,
            "Problem with OGR_L_GetSpatialRef():  Spatial reference handle is not supposed to be NULL."
        );

        $expected = 'GEOGCS["unnamed",DATUM["WGS_1984",SPHEROID["WGS 84",6378137,298.257223563],TOWGS84[0,0,0,-0,-0,-0,0]],PRIMEM["Greenwich",0],UNIT["degree",0.0174532925199433]]';
        $actual = OSR_ExportToWKT($hSpatialRef);
        $this->assertEquals(
            $expected,
            $actual,
            "Problem with OGR_L_GetSpatialRef: Unexpected result"
        );
    }

    /***********************************************************************
     *                         testOGR_L_ResetReading0()
     *
     ************************************************************************/

    public function testOGR_L_ResetReading0()
    {
        $strStandardFile = test_data_path("reference", __CLASS__, __FUNCTION__ . ".std");
        ;

        $nFeatureId = 12;

        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 0);

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_L_ResetReading($hSrcLayer);

        $hFeature = OGR_L_GetNextFeature($hSrcLayer);

        OGR_F_DumpReadable($hFeature, $fpOut);

        for ($i = 0; $i < $nFeatureId; $i++) {
            $hFeature = OGR_L_GetNextFeature($hSrcLayer);
        }

        OGR_L_ResetReading($hSrcLayer);

        $hFeature = OGR_L_GetNextFeature($hSrcLayer);

        OGR_F_DumpReadable($hFeature, $fpOut);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_L_ResetReading() Files comparison did not matched.\n"
        );
    }

    /***********************************************************************
     *                         testOGR_L_GetExtent0()
     *
     ************************************************************************/
    public function testOGR_L_GetExtent0()
    {
        $strStandardFile = "testOGR_L_GetExtent0.std";

        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 0);

        CPLErrorReset();

        $eErr = OGR_L_GetExtent(
            $hSrcLayer,
            $hEnvelope,
            $this->bForce /*bForce*/
        );

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;

        $this->assertEquals(
            $expected,
            $eErr,
            "Problem with OGR_L_GetExtent():  " . $eErrMsg
        );

        $expected = unserialize('O:8:"stdClass":4:{s:4:"minx";d:1.418893;s:4:"maxx";d:1.7746355;s:4:"miny";d:42.4322803;s:4:"maxy";d:42.6532059;}');

        $this->assertEquals(
            $expected,
            $hEnvelope,
            "Problem with OGR_L_GetExten():  Extent is not corresponding.",
            0 /*Delta*/
        );
    }

    /***********************************************************************
     *                         testOGR_L_GetFeatureCount0()
     *
     ************************************************************************/
    public function testOGR_L_GetFeatureCount0()
    {
        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 0);

        $nFeatureCount = OGR_L_GetFeatureCount(
            $hSrcLayer,
            $this->bForce /*bForce*/
        );

        $expected = 118;

        $this->assertEquals(
            $expected,
            $nFeatureCount,
            "Problem with OGR_L_GetFeatureCount():  Features count is not corresponding"
        );
    }
}
