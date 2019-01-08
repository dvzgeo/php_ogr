<?php

class OGRFeatureTest1 extends PHPUnit_Framework_TestCase
{
    public $strPathToDumpData;
    public $strTmpOutputFile;
    public $strPathToStandardData;
    public $strPathToData;
    public $bUpdate;
    public $hDS;
    public $hLayer;
    public $hOGRSFDriver;
    public $strOutputLayer;
    public $eGeometryType;
    public $strDestDataSource;

    public function setUp()
    {
        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase/";
        $this->strPathToOutputData = "../../ogrtests/testcase/";
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
        $iLayer = 3;
        $this->hLayer = OGR_DS_GetLayer($this->hDS, $iLayer);
    }

    public function tearDown()
    {
        OGR_DS_Destroy($this->hDS);

        if (file_exists($this->strPathToOutputData . $this->strDestDataSource)) {
            system("rm -R " . $this->strPathToOutputData . $this->strDestDataSource);
        }

        if (file_exists($this->strPathToOutputData . $this->strTmpDumpFile)) {
            system("rm " . $this->strPathToOutputData . $this->strTmpDumpFile);
        }
        unset($this->strPathToData);
        unset($this->strPathToStandardData);
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
        $strStandardFile = "testOGR_F_SetGetGeometry";

        $iSrcFID = 2;
        $hSrcF = OGR_L_GetFeature($this->hLayer, $iSrcFID);
        $hSrcGeom = OGR_F_GetGeometryRef($hSrcF);

        $hDriver = OGRGetDriver(5);

        $hSpatialRef = null;

        $hDestDS = OGR_Dr_CreateDataSource(
            $hDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            null /*Options*/
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

        if ($fpOut == false) {
            printf("Dump file creation error\n");
            return false;
        }
        OGR_F_DumpReadable($fpOut, $hDestFeature);

        OGR_F_Destroy($hDestFeature);
        OGR_F_Destroy($hSrcF);

        fclose($fpOut);

        system(
            "diff --brief " . $this->strPathToOutputData . $this->strTmpDumpFile . " " . $this->strPathToStandardData . $strStandardFile,
            $iReval
        );

        $this->assertFalse(
            $iRetval,
            "Problem with OGR_F_SetGeometry() or OGR_F_GetGeometryRef(): Files comparison did not matched.\n"
        );

        OGR_DS_Destroy($hDestDS);
    }

    /***********************************************************************
     *                            testOGR_F_Clone()
     ************************************************************************/

    public function testOGR_F_Clone()
    {
        $strStandardFile = "testOGR_F_Clone";
        $iFID1 = 2;
        $hF1 = OGR_L_GetFeature($this->hLayer, $iFID1);

        $hF2 = OGR_F_Clone($hF1);

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        if ($fpOut == false) {
            printf("Dump file creation error\n");
            return false;
        }
        OGR_F_DumpReadable($fpOut, $hF2);

        OGR_F_Destroy($hF1);
        OGR_F_Destroy($hF2);

        fclose($fpOut);

        system(
            "diff --brief " . $this->strPathToOutputData . $this->strTmpDumpFile . " " . $this->strPathToStandardData . $strStandardFile,
            $iReval
        );

        $this->assertFalse(
            $iRetval, "Problem with OGR_F_Clone() : Files comparison did not matched.\n"
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
        $expected = 9;
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
        $strStandardFile = "testOGR_F_GetFieldDefnRef";
        $iFID = 2;
        $hF = OGR_L_GetFeature($this->hLayer, $iFID);
        $iField = 2;
        $hFieldDefn = OGR_F_GetFieldDefnRef($hF, $iField);

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        if ($fpOut == false) {
            printf("Dump file creation error\n");
            return false;
        }
        OGRFieldDefnDump($fpOut, $hFieldDefn);

        OGR_F_Destroy($hF);

        fclose($fpOut);

        system(
            "diff --brief " . $this->strPathToOutputData . $this->strTmpDumpFile . " " . $this->strPathToStandardData . $strStandardFile,
            $iReval
        );

        $this->assertFalse(
            $iRetval,
            "Problem with OGR_F_GetFieldDefnRef() : Files comparison did not matched.\n"
        );
    }

    /***********************************************************************
     *                            testOGR_F_GetFieldIndex0()
     ************************************************************************/

    public function testOGR_F_GetFieldIndex0()
    {
        $iFID = 5;
        $hF = OGR_L_GetFeature($this->hLayer, $iFID);
        $strFieldName = "GRID_ID";
        $iField = OGR_F_GetFieldIndex($hF, $strFieldName);
        $expected = 6;
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
        $strFieldName = "GRID";
        $iField = OGR_F_GetFieldIndex($hF, $strFieldName);
        $expected = -1;
        $this->AssertEquals(
            $expected,
            $iField,
            "Problem with OGR_F_GetFieldIndex()."
        );
    }
}
