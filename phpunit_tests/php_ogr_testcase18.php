<?php

$testSuites_list[] = "OGRFeatureTest6";                             

class OGRFeatureTest6 extends PHPUnit_TestCase {
    var $strPathToOutputData;
    var $strTmpDumpFile;
    var $strPathToStandardData;
    var $strPathToData;
    var $bUpdate;
    var $hDestDS;
    var $hDestLayer;
    var $strDestDataSource;
    var $strDirName;
    var $hOGRSFDriver;
    var $astrOptions;
    var $hDestLayer;
    
 
    function OGRFeatureTest6($name){
        $this->PHPUnit_TestCase($name);	
    }

    function setUp() {
        $this->strDirName = "testcase/";
        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase/";
	$this->strPathToOutputData = "../../ogrtests/".$this->strDirName;
	$this->strTmpDumpFile = "DumpFile.tmp";
	$this->bUpdate = FALSE;
        $this->strDestDataSource = "OutputDS";

        if (file_exists($this->strPathToOutputData)) {
            system( "rm -R ".$this->strPathToOutputData);
        }

        mkdir($this->strPathToOutputData, 0777);

        $iDriver = 1;  /*Other then MapInfo File.*/
        $this->hOGRSFDriver = OGRGetDriver($iDriver);
        $this->astrOptions = null;
        $this->hDestDS = OGR_Dr_CreateDataSource($this->hOGRSFDriver, 
                                               $this->strPathToOutputData.
                                               $this->strDestDataSource,
                                               $this->astrOptions );

        if ($this->hDestDS == null) {
            printf("Unable to create destination data source\n");
            return FALSE;
        }
        $iLayer = 0;

        $this->hDestLayer = OGR_DS_GetLayer($this->hDestDS, $iLayer);

    }

    function tearDown() {
        if (file_exists($this->strPathToOutputData)) {
            system( "rm -R ".$this->strPathToOutputData);
        }
        unset($this->strPathToData);
        unset($this->strPathToStandardData);
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
*                            testOGR_F_SetGetFieldIntegerList()
************************************************************************/

    function testOGR_F_SetGetFieldIntegerList() {
        $iListValueIn[0] = 31;
        $iListValueIn[1] = 25;
        $iListValueIn[2] = 12;
        $numInteger = 3;

        $hFieldDefn = @OGR_Fld_Create("age", OFTIntegerList);
        $eErr = @OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);

        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return FALSE;
        }

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);

        $iFieldIndex = 0;
        OGR_F_SetFieldIntegerList($hF, $iFieldIndex, $numInteger, 
                                  $iListValueIn);

        $iListValueOut[] = OGR_F_GetFieldAsIntegerList($hF, $iFieldIndex, 
                                                       $nCount);
        $expected = "";
        $actual = serialize($iListValueOut);
        $this->AssertEquals($expected, $actual, "Problem with ".
                       "OGR_F_SetFieldIntegerList() or ".
                       "OGR_F_GetFieldAsIntegerList().");
        $expected = 3;
        $this->AssertEquals($expected, $nCount, "Wrong integer count in ".
                               "OGR_F_GetAsIntegerList().");
        OGR_F_Destroy($hF);

    }
/***********************************************************************
*                            testOGR_F_SetGetFieldDoubleList()               
************************************************************************/

    function testOGR_F_SetGetFieldDoubleList() {
        $dfListValueIn[0] = 1234.73;
        $dfListValueIn[1] = 4813.25;
        $dfListValueIn[2] = 5634.12;
        $dfListValueIn[3] = 44.5;
        $numDouble = 4;

        $hFieldDefn = OGR_Fld_Create("perimeter", OFTRealList);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);

        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return FALSE;
        }

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);

        $iFieldIndex = 0;
        OGR_F_SetFieldDoubleList($hF, $iFieldIndex, $numDouble, 
                                  $dfListValueIn);

        $dfListValueOut[] = OGR_F_GetFieldAsDoubleList($hF, $iFieldIndex, 
                                                       $nCount);
        $expected = "";
        $actual = serialize($dfListValueOut);
        $this->AssertEquals($expected, $actual, "Problem with ".
                       "OGR_F_SetFieldDoubleList() or ".
                       "OGR_F_GetFieldAsDoubleList().");

        $expected = 4;
        $this->AssertEquals($expected, $nCount, "Wrong double count in ".
                               "OGR_F_GetAsDoubleList().");

        OGR_F_Destroy($hF);

    }
/***********************************************************************
*                            testOGR_F_SetGetFieldStringList()               
************************************************************************/

    function testOGR_F_SetGetFieldStringList() {
        $strListValueIn[0] = "Tom Sylto";
        $strListValueIn[1] = "Judith Helm";
        $strListValueIn[2] = null;

        $hFieldDefn = OGR_Fld_Create("first-last name", OFTStringList);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);

        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return FALSE;
        }

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);

        $iFieldIndex = 0;
        OGR_F_SetFieldStringList($hF, $iFieldIndex, $strListValueIn);

        $strListValueOut[] = OGR_F_GetFieldAsStringList($hF, $iFieldIndex);

        $expected = "";
        $actual = serialize($strListValueOut);
        $this->AssertEquals($expected, $actual, "Problem with ".
                       "OGR_F_SetFieldStringList() or ".
                       "OGR_F_GetFieldAsStringList().");

        OGR_F_Destroy($hF);

    }
/***********************************************************************
*                            testOGR_F_SetGetFID()                    
************************************************************************/

    function testOGR_F_SetGetFID() {
        $iValueIn = 4312;
        $hFieldDefn = OGR_Fld_Create("id", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);

        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return FALSE;
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

    function testOGR_F_SetFrom() {
        $strStandardFile = "testOGR_F_SetFrom";
        $hFieldDefn = OGR_Fld_Create("FNODE_", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);

        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return FALSE;
        }

        $hFieldDefn = OGR_Fld_Create("INODE_", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return FALSE;
        }

        $hFieldDefn = OGR_Fld_Create("LPOLY_", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return FALSE;
        }

        $hFieldDefn = OGR_Fld_Create("TPOLY_", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return FALSE;
        }

        $hFieldDefn = OGR_Fld_Create("LENGTH", OFTReal);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return FALSE;
        }

        $hFieldDefn = OGR_Fld_Create("GRID_", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return FALSE;
        }

        $hFieldDefn = OGR_Fld_Create("GRID_ID", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return FALSE;
        }

        $hFieldDefn = OGR_Fld_Create("FCODE", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return FALSE;
        }

        $hFieldDefn = OGR_Fld_Create("F_TYPE", OFTString);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        if ($eErr != OGRERR_NONE) {
            printf("Error creating field.\n");
            return FALSE;
        }

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hDestF = OGR_F_Create($hFeatureDefn);

        $hDriver = null;
        $hSrcDS = OGROpen($this->strPathToData, $this->bUpdate, $hDriver);

        $iLayer = 3;
	$hSrcLayer = OGR_DS_GetLayer($hSrcDS, $iLayer);
        $nFID = 5;
        $hSrcF = OGR_L_GetFeature($hSrcLayer, $nFID);

        $bForgiving = TRUE;
        $eErr = OGR_F_SetFrom($hDestF, $hSrcF, $bForgiving);

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");
	
        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
	}

        OGR_F_DumpReadable($fpOut, $hDestF);

        OGR_F_Destroy($hSrcF);
        OGR_F_Destroy($hDestF);

        OGR_DS_Destroy($hSrcDS);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToOutputData.
                $this->strTmpDumpFile.
                " ".$this->strPathToStandardData.$strStandardFile,
                $iReval);

        $this->assertFalse($iRetval, "Problem with OGR_F_SetFrom() ".
                             "Files comparison did not matched.\n");



    }

}
?>
	




