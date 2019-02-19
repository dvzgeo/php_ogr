<?php

class OGRFeatureTest2 extends PHPUnit_Framework_TestCase
{
    public $strPathToOutputData;
    public $strTmpDumpFile;
    public $strPathToData;
    public $bUpdate;
    public $hDS;
    public $hLayer;
    public $strDestDataSource;
    public $hOGRSFDriver;
    public $strOutputLayer;

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
        $this->strDestDataSource = "OutputDS";
        $this->strOutputLayer = "OutputLayer";
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
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->strDestDataSource);
        unset($this->hDS);
        unset($this->hLayer);
        unset($this->hOGRSFDriver);
        unset($this->strOutputLayer);
    }

    /***********************************************************************
     *                            testOGR_F_IsFieldSet()
     ************************************************************************/

    public function testOGR_F_IsFieldSet()
    {
        $iFID = 7;
        $hF = OGR_L_GetFeature($this->hLayer, $iFID);
        $iField = 1;
        $bFieldSet = OGR_F_IsFieldSet($hF, $iField);

        $this->AssertTrue(
            $bFieldSet,
            "Problem with OGR_F_IsFieldSet(): Field is supposed to be set"
        );
    }

    /***********************************************************************
     *                            testOGR_F_UnsetField0()
     ************************************************************************/

    public function testOGR_F_UnsetField0()
    {
        $iFID = 7;
        $hF = OGR_L_GetFeature($this->hLayer, $iFID);
        $iField = 1;
        OGR_F_UnsetField($hF, $iField);
        $bFieldSet = OGR_F_IsFieldSet($hF, $iField);

        $this->AssertFalse(
            $bFieldSet,
            "Problem with OGR_F_UnsetField(): Field is not supposed to be set"
        );
    }

    /***********************************************************************
     *                            testOGR_F_UnsetField1()
     ************************************************************************/

    public function testOGR_F_GetUnsetField1()
    {
        $strStandardFile = test_data_path("reference", __CLASS__, __FUNCTION__ . ".std");

        $iDriver = "ESRI Shapefile";
        $hDriver = OGRGetDriverByName($iDriver);

        $astrOptions = null;
        $hDestDS = OGR_Dr_CreateDataSource(
            $hDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            $astrOptions
        );

        $this->assertNotNull($hDestDS, "Unable to create destination data source");

        $hDestLayer = OGR_DS_CreateLayer(
            $hDestDS,
            $this->strOutputLayer,
            $hSpatialRef,
            $this->eGeometryType,
            null /*Options*/
        );

        $hFieldDefn = OGR_Fld_Create("id", OFTInteger);
        $eErr = OGR_L_CreateField($hDestLayer, $hFieldDefn, 0 /*bApproxOK*/);

        $hFeatureDefn = OGR_L_GetLayerDefn($hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);
        $iField = 0;
        $iValue = 25;
        OGR_F_SetFieldInteger($hF, $iField, $iValue);

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );
        $this->assertNotFalse($fpOut, "Dump file creation error");
        OGR_F_DumpReadable($hF, $fpOut);

        OGR_F_UnsetField($hF, $iField);
        $bFieldSet = OGR_F_IsFieldSet($hF, $iField);

        OGR_F_DumpReadable($hF, $fpOut);

        OGR_F_Destroy($hF);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_F_UnsetField() Files comparison did not matched."
        );

        OGR_DS_Destroy($hDestDS);
    }

    /***********************************************************************
     *                            testOGR_F_GetSetFieldRaw()
     ************************************************************************/

    public function testOGR_F_GetSetFieldRaw()
    {
        $strStandardFile = test_data_path("reference", __CLASS__, __FUNCTION__ . ".std");

        $iDriver = 'ESRI Shapefile';
        $hDriver = OGRGetDriverByName($iDriver);

        $astrOptions = null;
        $hDestDS = OGR_Dr_CreateDataSource(
            $hDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            $astrOptions
        );

        $this->assertNotNull($hDestDS, "Unable to create destination data source");

        $hDestLayer = OGR_DS_CreateLayer(
            $hDestDS,
            $this->strOutputLayer,
            $hSpatialRef,
            $this->eGeometryType,
            null /*Options*/
        );

        $hFieldDefn = OGR_Fld_Create("LPOLY_", OFTInteger);
        $eErr = OGR_L_CreateField($hDestLayer, $hFieldDefn, 0 /*bApproxOK*/);

        $hFeatureDefn = OGR_L_GetLayerDefn($hDestLayer);
        $hSrcF = OGR_F_Create($hFeatureDefn);
        $iField = 0;
        OGR_F_SetFieldInteger($hSrcF, $iField, 42);
        $hField = OGR_F_GetRawFieldRef($hSrcF, $iField);
        $this->AssertNotNull(
            $hField,
            "Problem with OGR_F_GetRawFieldRef(): handle should not be NULL."
        );

        $hDestF = OGR_F_Create($hFeatureDefn);
        OGR_F_SetFieldRaw($hDestF, $iField, $hField);

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        $this->assertNotFalse($fpOut, "Dump file creation error");
        OGR_F_DumpReadable($hDestF, $fpOut);

        OGR_F_Destroy($hSrcF);
        OGR_F_Destroy($hDestF);

        fclose($fpOut);

        OGR_DS_Destroy($hDestDS);
        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_F_SetFieldRaw() or OGR_F_GetRawFieldRef(): Files comparison did not matched.\n"
        );
    }
}
