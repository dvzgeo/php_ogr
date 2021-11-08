<?php

use \PHPUnit\Framework\TestCase;

class OGRFeatureTest1 extends TestCase
{
    public $strPathToDumpData;
    public $strTmpDumpFile;
    public $strPathToOutputData;
    public $strPathToData;
    public $bUpdate;
    public $hDS;
    public $hLayer;
    public $hOGRSFDriver;
    public $strOutputLayer;
    public $eGeometryType;
    public $strDestDataSource;

    public static function setUpBeforeClass()
    {
        OGRRegisterAll();
    }


    public function setUp()
    {
        $this->strPathToData = test_data_path("andorra", "shp");
        $this->strPathToOutputData = create_temp_directory(__CLASS__);
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->bUpdate = false;
        $this->hOGRSFDriver = null;
        $this->strOutputLayer = "LayerOutput";
        $this->eGeometryType = wkbLineString;
        $this->strDestDataSource = "OutputDS";

        $this->hDS = OGROpen(
            $this->strPathToData,
            $this->bUpdate,
            $this->hOGRSFDriver
        );
        $this->assertNotNull(
            $this->hDS,
            "Could not open datastore in " . $this->strPathToData
        );
        $iLayer = "gis_osm_places_free_1";
        $this->hLayer = OGR_DS_GetLayerByName($this->hDS, $iLayer);
        $this->assertNotNull(
            $this->hLayer,
            "Could not retrieve layer " . $iLayer
        );
    }

    public function tearDown()
    {
        OGR_DS_Destroy($this->hDS);

        delete_directory($this->strPathToOutputData);

        unset($this->strPathToData);
        unset($this->strPathToOutputData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->hDS);
        unset($this->hLayer);
        unset($this->hOGRSFDriver);
        unset($this->strOutputLayer);
        unset($this->eGeometryType);
        unset($this->strDestDataSource);
    }

    /***********************************************************************
     *                       testOGR_F_SetGetGeometry()
     ************************************************************************/
    public function testOGR_F_SetGetGeometry()
    {
        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        $iSrcFID = 2;
        $hSrcF = OGR_L_GetFeature($this->hLayer, $iSrcFID);
        $hSrcGeom = OGR_F_GetGeometryRef($hSrcF);

        $hDriver = OGRGetDriverByName("ESRI Shapefile");

        $this->assertNotNull($hDriver, "Could not get driver");

        $hSpatialRef = null;

        $hDestDS = OGR_Dr_CreateDataSource(
            $hDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            null /*Options*/
        );

        $this->assertNotNull(
            $hDestDS,
            "Could not create datasource in " . $this->strPathToOutputData . $this->strDestDataSource
        );

        $hDestLayer = OGR_DS_CreateLayer(
            $hDestDS,
            $this->strOutputLayer,
            $hSpatialRef,
            $this->eGeometryType,
            null /*Options*/
        );

        $hDestFeature = OGR_F_Create(OGR_L_GetLayerDefn($hDestLayer));

        CPLErrorReset();
        $eErr = OGR_F_SetGeometry($hDestFeature, $hSrcGeom);
        $strMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;
        $this->AssertEquals($expected, $eErr, $strMsg);

        $fpOut = fopen($this->strPathToOutputData . $this->strTmpDumpFile, "w");

        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_F_DumpReadable($hDestFeature, $fpOut);

        OGR_F_Destroy($hDestFeature);
        OGR_F_Destroy($hSrcF);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_F_SetGeometry() or OGR_F_GetGeometryRef(): Files comparison did not matched."
        );

        OGR_DS_Destroy($hDestDS);
    }

    /***********************************************************************
     *                            testOGR_F_Clone()
     ************************************************************************/

    public function testOGR_F_Clone()
    {
        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");
        $iFID1 = 2;
        $hF1 = OGR_L_GetFeature($this->hLayer, $iFID1);

        $hF2 = OGR_F_Clone($hF1);

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_F_DumpReadable($hF2, $fpOut);

        OGR_F_Destroy($hF1);
        OGR_F_Destroy($hF2);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_F_Clone() : Files comparison did not matched."
        );
    }

    /***********************************************************************
     *                            testOGR_F_Equal0()
     ************************************************************************/

    public function testOGR_F_Equal0()
    {
        $iFID1 = 2;
        $hF1 = OGR_L_GetFeature($this->hLayer, $iFID1);

        $iFID2 = 5;
        $hF2 = OGR_L_GetFeature($this->hLayer, $iFID2);

        $bEqual = OGR_F_Equal($hF1, $hF2);
        $this->AssertFalse($bEqual, "Problem with OGR_F_Equal().");

        OGR_F_Destroy($hF1);
        OGR_F_Destroy($hF2);
    }

    /***********************************************************************
     *                            testOGR_F_Equal1()
     ************************************************************************/

    public function testOGR_F_Equal1()
    {
        $iFID = 2;
        $hF1 = OGR_L_GetFeature($this->hLayer, $iFID);

        $hF2 = OGR_F_Clone($hF1);

        $bEqual = OGR_F_Equal($hF1, $hF2);
        $this->AssertTrue($bEqual, "Problem with OGR_F_Equals().");

        OGR_F_Destroy($hF1);
        OGR_F_Destroy($hF2);
    }

    /***********************************************************************
     *                            testOGR_F_GetFieldCount()
     ************************************************************************/

    public function testOGR_F_GetFieldCount()
    {
        $iFID = 2;
        $hF = OGR_L_GetFeature($this->hLayer, $iFID);

        $nFieldCount = OGR_F_GetFieldCount($hF);
        $expected = 5;
        $this->AssertEquals(
            $expected,
            $nFieldCount,
            "Problem with  OGR_F_GetFieldCount()."
        );
        OGR_F_Destroy($hF);
    }

    /***********************************************************************
     *                            testOGR_F_GetFieldDefnRef()
     ************************************************************************/

    public function testOGR_F_GetFieldDefnRef()
    {
        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");
        $iFID = 2;
        $hF = OGR_L_GetFeature($this->hLayer, $iFID);
        $iField = 2;
        $hFieldDefn = OGR_F_GetFieldDefnRef($hF, $iField);

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGRFieldDefnDump($fpOut, $hFieldDefn);

        OGR_F_Destroy($hF);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_F_GetFieldDefnRef() : Files comparison did not matched."
        );
    }

    /***********************************************************************
     *                            testOGR_F_GetFieldIndex0()
     ************************************************************************/

    public function testOGR_F_GetFieldIndex0()
    {
        $iFID = 5;
        $hF = OGR_L_GetFeature($this->hLayer, $iFID);
        $strFieldName = "population";
        $iField = OGR_F_GetFieldIndex($hF, $strFieldName);
        $expected = 3;
        $this->AssertEquals(
            $expected,
            $iField,
            "Problem with OGR_F_GetFieldIndex()."
        );
    }

    /***********************************************************************
     *                            testOGR_F_GetFieldIndex1()
     ************************************************************************/

    public function testOGR_F_GetFieldIndex1()
    {
        $iFID = 5;
        $hF = OGR_L_GetFeature($this->hLayer, $iFID);
        $strFieldName = "foobar";
        $iField = OGR_F_GetFieldIndex($hF, $strFieldName);
        $expected = -1;
        $this->AssertEquals(
            $expected,
            $iField,
            "Problem with OGR_F_GetFieldIndex()."
        );
    }
}
