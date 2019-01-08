<?php

class OGRFeatureTest6 extends PHPUnit_Framework_TestCase
{
    public $strPathToOutputData;
    public $strTmpDumpFile;
    public $strPathToStandardData;
    public $strPathToData;
    public $bUpdate;
    public $hDestDS;
    public $hDestLayer;
    public $strDestDataSource;
    public $hOGRSFDriver;
    public $astrOptions;


    public function setUp()
    {
        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase/";
        $this->strPathToOutputData = create_temp_directory(__CLASS__);
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->bUpdate = false;
        $this->strDestDataSource = "OutputDS";

        $iDriver = 1;  /*Other then MapInfo File.*/
        $this->hOGRSFDriver = OGRGetDriver($iDriver);
        $this->astrOptions = null;
        $this->hDestDS = OGR_Dr_CreateDataSource(
            $this->hOGRSFDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            $this->astrOptions
        );

        if ($this->hDestDS == null) {
            printf("Unable to create destination data source\n");
            return false;
        }
        $iLayer = 0;

        $this->hDestLayer = OGR_DS_GetLayer($this->hDestDS, $iLayer);
    }

    public function tearDown()
    {
        delete_directory($this->strPathToOutputData);
        unset($this->strPathToData);
        unset($this->strPathToStandardData);
        unset($this->strPathToOutputData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->strDestDataSource);
        unset($this->hDestLayer);
        unset($this->hDestDS);
        unset($this->OGRSFDriver);
        unset($this->astrOptions);
    }

    /***********************************************************************
     *                            testOGR_F_SetGetFieldIntegerList()
     ************************************************************************/

    public function testOGR_F_SetGetFieldIntegerList()
    {
        $iListValueIn[0] = 31;
        $iListValueIn[1] = 25;
        $iListValueIn[2] = 12;
        $numInteger = 3;

        $hFieldDefn = @OGR_Fld_Create("age", OFTIntegerList);
        $eErr = @OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );

        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return false;
        }

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);

        $iFieldIndex = 0;
        OGR_F_SetFieldIntegerList(
            $hF,
            $iFieldIndex,
            $numInteger,
            $iListValueIn
        );

        $iListValueOut[] = OGR_F_GetFieldAsIntegerList(
            $hF,
            $iFieldIndex,
            $nCount
        );
        $expected = "";
        $actual = serialize($iListValueOut);
        $this->AssertEquals(
            $expected,
            $actual,
            "Problem with OGR_F_SetFieldIntegerList() or OGR_F_GetFieldAsIntegerList()."
        );
        $expected = 3;
        $this->AssertEquals(
            $expected,
            $nCount,
            "Wrong integer count in OGR_F_GetAsIntegerList()."
        );
        OGR_F_Destroy($hF);
    }

    /***********************************************************************
     *                            testOGR_F_SetGetFieldDoubleList()
     ************************************************************************/

    public function testOGR_F_SetGetFieldDoubleList()
    {
        $dfListValueIn[0] = 1234.73;
        $dfListValueIn[1] = 4813.25;
        $dfListValueIn[2] = 5634.12;
        $dfListValueIn[3] = 44.5;
        $numDouble = 4;

        $hFieldDefn = OGR_Fld_Create("perimeter", OFTRealList);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );

        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return false;
        }

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);

        $iFieldIndex = 0;
        OGR_F_SetFieldDoubleList(
            $hF,
            $iFieldIndex,
            $numDouble,
            $dfListValueIn
        );

        $dfListValueOut[] = OGR_F_GetFieldAsDoubleList(
            $hF,
            $iFieldIndex,
            $nCount
        );
        $expected = "";
        $actual = serialize($dfListValueOut);
        $this->AssertEquals(
            $expected,
            $actual,
            "Problem with OGR_F_SetFieldDoubleList() or OGR_F_GetFieldAsDoubleList()."
        );

        $expected = 4;
        $this->AssertEquals(
            $expected,
            $nCount,
            "Wrong double count in OGR_F_GetAsDoubleList()."
        );

        OGR_F_Destroy($hF);
    }

    /***********************************************************************
     *                            testOGR_F_SetGetFieldStringList()
     ************************************************************************/

    public function testOGR_F_SetGetFieldStringList()
    {
        $strListValueIn[0] = "Tom Sylto";
        $strListValueIn[1] = "Judith Helm";
        $strListValueIn[2] = null;

        $hFieldDefn = OGR_Fld_Create("first-last name", OFTStringList);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );

        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return false;
        }

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);

        $iFieldIndex = 0;
        OGR_F_SetFieldStringList($hF, $iFieldIndex, $strListValueIn);

        $strListValueOut[] = OGR_F_GetFieldAsStringList($hF, $iFieldIndex);

        $expected = "";
        $actual = serialize($strListValueOut);
        $this->AssertEquals(
            $expected,
            $actual,
            "Problem with OGR_F_SetFieldStringList() or OGR_F_GetFieldAsStringList()."
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

        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return false;
        }

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);

        $nFID = OGR_F_GetFID($hF);
        $expected = 0;
        $this->AssertEquals($expected, $nFID, "Problem with OGR_F_GetFID().");

        $nFID = 2;
        $eErr = OGR_F_SetFID($hF, $nFID);
        $nFID = OGR_F_GetFID($hF);
        $expected = 2;
        $this->AssertEquals($expected, $nFID, "Problem with OGR_F_GetFID().");

        OGR_F_Destroy($hF);
    }

    /***********************************************************************
     *                            testOGR_F_SetFrom()
     ************************************************************************/

    public function testOGR_F_SetFrom()
    {
        $strStandardFile = "testOGR_F_SetFrom";
        $hFieldDefn = OGR_Fld_Create("FNODE_", OFTInteger);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );

        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return false;
        }

        $hFieldDefn = OGR_Fld_Create("INODE_", OFTInteger);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return false;
        }

        $hFieldDefn = OGR_Fld_Create("LPOLY_", OFTInteger);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return false;
        }

        $hFieldDefn = OGR_Fld_Create("TPOLY_", OFTInteger);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return false;
        }

        $hFieldDefn = OGR_Fld_Create("LENGTH", OFTReal);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return false;
        }

        $hFieldDefn = OGR_Fld_Create("GRID_", OFTInteger);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return false;
        }

        $hFieldDefn = OGR_Fld_Create("GRID_ID", OFTInteger);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return false;
        }

        $hFieldDefn = OGR_Fld_Create("FCODE", OFTInteger);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return false;
        }

        $hFieldDefn = OGR_Fld_Create("F_TYPE", OFTString);
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return false;
        }

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hDestF = OGR_F_Create($hFeatureDefn);

        $hDriver = null;
        $hSrcDS = OGROpen($this->strPathToData, $this->bUpdate, $hDriver);

        $iLayer = 3;
        $hSrcLayer = OGR_DS_GetLayer($hSrcDS, $iLayer);
        $nFID = 5;
        $hSrcF = OGR_L_GetFeature($hSrcLayer, $nFID);

        $bForgiving = true;
        $eErr = OGR_F_SetFrom($hDestF, $hSrcF, $bForgiving);

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        if ($fpOut == false) {
            printf("Dump file creation error\n");
            return false;
        }

        OGR_F_DumpReadable($fpOut, $hDestF);

        OGR_F_Destroy($hSrcF);
        OGR_F_Destroy($hDestF);

        OGR_DS_Destroy($hSrcDS);

        fclose($fpOut);

        system(
            "diff --brief " . $this->strPathToOutputData . $this->strTmpDumpFile . " " . $this->strPathToStandardData . $strStandardFile,
            $iReval
        );

        $this->assertFalse(
            $iRetval,
            "Problem with OGR_F_SetFrom() Files comparison did not matched.\n"
        );
    }
}

?>
	




