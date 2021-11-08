<?php

use \PHPUnit\Framework\TestCase;

class OGRFeatureTest3 extends TestCase
{
    public $strPathToOutputData;
    public $strTmpDumpFile;
    public $strPathToData;
    public $bUpdate;
    public $hDestDS;
    public $hDestLayer;
    public $strDestDataSource;
    public $hOGRSFDriver;
    public $astrOptions;

    public static function setUpBeforeClass() : void
    {
        OGRRegisterAll();
    }


    public function setUp() : void
    {
        $this->strPathToData = test_data_path("andorra", "shp");
        $this->strPathToOutputData = create_temp_directory(__CLASS__);
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->bUpdate = false;
        $this->strDestDataSource = "OutputDS.json";

        $iDriver = "GeoJSON";
        $this->hOGRSFDriver = OGRGetDriverByName($iDriver);
        $this->assertNotNull($this->hOGRSFDriver, "Could not get driver for " . $iDriver);
        $this->astrOptions = null;
        $this->hDestDS = OGR_Dr_CreateDataSource(
            $this->hOGRSFDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            $this->astrOptions
        );

        $this->assertNotNull($this->hDestDS, "Unable to create destination data source");
        $iLayer = "OutputDS";

        $this->hDestLayer = OGR_DS_CreateLayer($this->hDestDS, $iLayer, null, wkbPoint, null);
        $this->assertNotNull($this->hDestLayer);
    }

    public function tearDown() : void
    {
        delete_directory($this->strPathToOutputData);
        OGR_DS_Destroy($this->hDestDS);
        unset($this->strPathToData);
        unset($this->strPathToOutputData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->strDestDataSource);
        unset($this->hDestLayer);
        unset($this->hDestDS);
        unset($this->strDirName);
        unset($this->OGRSFDriver);
        unset($this->astrOptions);
    }

    /***********************************************************************
     *                            testOGR_F_SetGetFieldInteger()
     ************************************************************************/

    public function testOGR_F_SetGetFieldInteger()
    {
        $iValueIn = 4312;
        $hFieldDefn = OGR_Fld_Create("id", OFTInteger);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );

        $this->assertEquals(OGRERR_NONE, $eErr, "Error creating field.");

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);

        $iFieldIndex = 0;
        OGR_F_SetFieldInteger($hF, $iFieldIndex, $iValueIn);

        $iValueOut = OGR_F_GetFieldAsInteger($hF, $iFieldIndex);
        $expected = $iValueIn;
        $this->AssertEquals(
            $expected,
            $iValueOut,
            "Problem with OGR_F_SetFieldInteger() or OGR_F_GetFieldAsInteger()."
        );

        OGR_F_Destroy($hF);
    }

    /***********************************************************************
     *                            testOGR_F_SetGetFieldDouble()
     ************************************************************************/

    public function testOGR_F_SetGetFieldDouble()
    {
        $dfValueIn = 6533.58;
        $hFieldDefn = OGR_Fld_Create("area", OFTReal);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );

        $this->assertEquals(OGRERR_NONE, $eErr, "Error creating field.");

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);

        $iFieldIndex = 0;
        OGR_F_SetFieldDouble($hF, $iFieldIndex, $dfValueIn);

        $dfValueOut = OGR_F_GetFieldAsDouble($hF, $iFieldIndex);
        $expected = $dfValueIn;
        $this->AssertEquals(
            $expected,
            $dfValueOut,
            "Problem with OGR_F_SetFieldDouble() or OGR_F_GetFieldAsDouble()."
        );

        OGR_F_Destroy($hF);
    }

    /***********************************************************************
     *                            testOGR_F_SetGetFieldString()
     ************************************************************************/

    public function testOGR_F_SetGetFieldString()
    {
        $strValueIn = "Liberty";
        $hFieldDefn = OGR_Fld_Create("name", OFTString);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );

        $this->assertEquals(OGRERR_NONE, $eErr, "Error creating field.");

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);

        $iFieldIndex = 0;
        OGR_F_SetFieldString($hF, $iFieldIndex, $strValueIn);

        $strValueOut = OGR_F_GetFieldAsString($hF, $iFieldIndex);
        $expected = $strValueIn;

        $this->AssertEquals(
            $expected,
            $strValueOut,
            "Problem with OGR_F_SetFieldString() or OGR_F_GetFieldAsString()."
        );

        OGR_F_Destroy($hF);
    }

    /***********************************************************************
     *                            testOGR_F_SetGetFieldDateTime0()
     ************************************************************************/

    public function testOGR_F_SetGetFieldDateTimeß()
    {
        $yearIn = 2017;
        $monthIn = 2;
        $dayIn = 14;
        $hourIn = 17;
        $minuteIn = 35;
        $secondIn = 12;
        $tzIn = 1;
        $hFieldDefn = OGR_Fld_Create("date", OFTDateTime);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );

        $this->assertEquals(OGRERR_NONE, $eErr, "Error creating field.");

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);

        $iFieldIndex = 0;
        OGR_F_SetFieldDateTime(
            $hF,
            $iFieldIndex,
            $yearIn,
            $monthIn,
            $dayIn,
            $hourIn,
            $minuteIn,
            $secondIn,
            $tzIn
        );

        $dateValueOut = OGR_F_GetFieldAsDateTime($hF, $iFieldIndex);
        $expected = array(
            "year" => $yearIn,
            "month" => $monthIn,
            "day" => $dayIn,
            "hour" => $hourIn,
            "minute" => $minuteIn,
            "second" => $secondIn,
            "tzflag" => $tzIn
        );

        $this->assertEquals(
            $expected,
            $dateValueOut,
            "Problem with OGR_F_SetFieldDateTime() or OGR_F_GetFieldAsDateTime()."
        );

        OGR_F_Destroy($hF);
    }

    /***********************************************************************
     *                            testOGR_F_SetGetFieldDateTime0()
     ************************************************************************/

    public function testOGR_F_SetGetFieldDateTime1()
    {
        $yearIn = 2017;
        $hFieldDefn = OGR_Fld_Create("date", OFTDateTime);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );

        $this->assertEquals(OGRERR_NONE, $eErr, "Error creating field.");

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);

        $iFieldIndex = 0;
        OGR_F_SetFieldDateTime($hF, $iFieldIndex, $yearIn);

        $dateValueOut = OGR_F_GetFieldAsDateTime($hF, $iFieldIndex);
        // everything should have the default values
        $expected = array(
            "year" => $yearIn,
            "month" => 1,
            "day" => 1,
            "hour" => 0,
            "minute" => 0,
            "second" => 0,
            "tzflag" => 0
        );

        $this->assertEquals(
            $expected,
            $dateValueOut,
            "Problem with OGR_F_SetFieldDateTime() or OGR_F_GetFieldAsDateTime()."
        );

        OGR_F_Destroy($hF);
    }

    /***********************************************************************
     *                            testOGR_F_SetGetFID()
     ************************************************************************/

    public function testOGR_F_SetGetFID()
    {
        $iValueIn = 4312;
        $hFieldDefn = OGR_Fld_Create("id", OFTInteger);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );

        $this->assertEquals(OGRERR_NONE, $eErr, "Error creating field.");

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);

        $nFID = OGR_F_GetFID($hF);
        $expected = -1; /*Now equals -1 when DS not closed.*/
        $this->AssertEquals($expected, $nFID, "OGR_F_GetFID() should give -1 for new feature");

        $nFID = 2;
        $eErr = OGR_F_SetFID($hF, $nFID);
        $this->assertEquals($eErr, OGRERR_NONE, "Error setting FID");
        $nFID = OGR_F_GetFID($hF);
        $expected = $nFID;
        $this->AssertEquals(
            $expected,
            $nFID,
            "Problem with OGR_F_SetFID() OGR_F_GetFID()."
        );


        OGR_F_Destroy($hF);
    }

    /***********************************************************************
     *                            testOGR_F_SetFrom()
     ************************************************************************/

    public function testOGR_F_SetFrom()
    {
        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        $hFieldDefn = OGR_Fld_Create("osm_id", OFTString);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );

        $this->assertEquals(OGRERR_NONE, $eErr, "Error creating field.");

        $hFieldDefn = OGR_Fld_Create("code", OFTInteger);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        $this->assertEquals(OGRERR_NONE, $eErr, "Error creating field.");

        $hFieldDefn = OGR_Fld_Create("fclass", OFTInteger);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        $this->assertEquals(OGRERR_NONE, $eErr, "Error creating field.");

        $hFieldDefn = OGR_Fld_Create("name", OFTInteger);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        $this->assertEquals(OGRERR_NONE, $eErr, "Error creating field.");

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hDestF = OGR_F_Create($hFeatureDefn);

        $hDriver = null;
        $hSrcDS = OGROpen($this->strPathToData, $this->bUpdate, $hDriver);

        $iLayer = "";
        $hSrcLayer = OGR_DS_ExecuteSQL(
            $hSrcDS,
            "SELECT * FROM gis_osm_railways_free_1 WHERE osm_id = '135585747'",
            null,
            ""
        );
        $nFID = 0;
        $hSrcF = OGR_L_GetFeature($hSrcLayer, $nFID);

        $bForgiving = true;
        $eErr = OGR_F_SetFrom($hDestF, $hSrcF, $bForgiving);

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_F_DumpReadable($hDestF, $fpOut);

        OGR_F_Destroy($hSrcF);
        OGR_F_Destroy($hDestF);

        OGR_DS_Destroy($hSrcDS);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_F_SetFrom() Files comparison did not matched."
        );
    }
}
