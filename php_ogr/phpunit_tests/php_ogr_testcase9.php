<?php
//require_once `phpunit-0.5/phpunit.php';
require_once 'util.php';

$testSuites_list[] = "OGRFeatureTest2";                             

class OGRFeatureTest2 extends PHPUnit_TestCase {
    var $strPathToOutputData;
    var $strTmpDumpFile;
    var $strPathToStandardData;
    var $strPathToData;
    var $bUpdate;
    var $hDS;
    var $hLayer;
    var $strDestDataSource;
    var $hOGRSFDriver;
    var $strOutputLayer;

    function OGRFeatureTest2($name){
        $this->PHPUnit_TestCase($name);	
    }
    function setUp() {

        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase/";
	$this->strPathToOutputData = "../../ogrtests/testcase/";
	$this->strTmpDumpFile = "DumpFile.tmp";
	$this->bUpdate = FALSE;
        $this->hOGRSFDriver = null;
        $this->strDestDataSource = "OutputDS";
        $this->strOutputLayer = "OutputLayer";
        $this->hDS = OGROpen($this->strPathToData, $this->bUpdate, 
                             $this->hOGRSFDriver);

        $iLayer = 3;
	$this->hLayer = OGR_DS_GetLayer($this->hDS, $iLayer);


    }

    function tearDown() {
        OGR_DS_Destroy($this->hDS);
        if (file_exists($this->strPathToOutputData.$this->strDestDataSource)) {
            system( "rm -R ".$this->strPathToOutputData.$this->strDestDataSource);
        }

        if (file_exists($this->strPathToOutputData.$this->strTmpDumpFile)) {     
            system( "rm ".$this->strPathToOutputData.$this->strTmpDumpFile);
        }

        unset($this->strPathToData);
        unset($this->strPathToStandardData);
        unset($this->strPathToDumpData);
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

    function testOGR_F_IsFieldSet() {
        $iFID = 7;
        $hF = OGR_L_GetFeature($this->hLayer, $iFID);
        $iField = 1;
        $bFieldSet = OGR_F_IsFieldSet($hF, $iField);

        $this->AssertTrue($bFieldSet, "Problem with OGR_F_IsFieldSet(): ".
                           "Field is supposed to be set");

    }

/***********************************************************************
*                            testOGR_F_UnsetField0()                           
************************************************************************/

    function testOGR_F_UnsetField0() {
        $iFID = 7;
        $hF = OGR_L_GetFeature($this->hLayer, $iFID);
        $iField =1;
        OGR_F_UnsetField($hF, $iField);
        $bFieldSet = OGR_F_IsFieldSet($hF, $iField);

        $this->AssertFalse($bFieldSet, "Problem with OGR_F_UnsetField(): ".
                                        "Field is not supposed to be set");
   
    }

/***********************************************************************
*                            testOGR_F_UnsetField1()                             
************************************************************************/

    function testOGR_F_GetUnsetField1() {
        $strStandardFile = "testOGR_F_UnsetField1";

        $iDriver = 5;
        $hDriver = OGRGetDriver($iDriver);

        $astrOptions = null;
        $hDestDS = OGR_Dr_CreateDataSource($hDriver, 
                                               $this->strPathToOutputData.
                                               $this->strDestDataSource,
                                               $astrOptions );

        if ($hDestDS == null) {
            printf("Unable to create destination data source\n");
            return FALSE;
        }

        $hDestLayer = OGR_DS_CreateLayer($hDestDS, $this->strOutputLayer, 
                                     $hSpatialRef,
                                     $this->eGeometryType,
                                     null /*Options*/);

        $hFieldDefn = OGR_Fld_Create("id", OFTInteger);
        $eErr = OGR_L_CreateField($hDestLayer, $hFieldDefn, 0 /*bApproxOK*/);

        $hFeatureDefn = OGR_L_GetLayerDefn($hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);
        $iField = 0;
        $iValue = 25;
        OGR_F_SetFieldInteger($hF, $iField, $iValue);

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");
	
        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
	}
        OGR_F_DumpReadable($fpOut, $hF);

        OGR_F_UnsetField($hF, $iField);
        $bFieldSet = OGR_F_IsFieldSet($hF, $iField);

        OGR_F_DumpReadable($fpOut, $hF);

        OGR_F_Destroy($hF);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToOutputData.
                $this->strTmpDumpFile.
                " ".$this->strPathToStandardData.$strStandardFile,
                $iReval);

        $this->assertFalse($iRetval, "Problem with OGR_F_UnsetField() ".
                             "Files comparison did not matched.\n");

        OGR_DS_Destroy($hDestDS);

    }

/***********************************************************************
*                            testOGR_F_GetSetFieldRaw()                             
************************************************************************/

    function testOGR_F_GetSetFieldRaw() {
        $strStandardFile = "testOGR_F_GetSetFieldRaw";

        $iFID = 2;
        $hSrcF = OGR_L_GetFeature($this->hLayer, $iFID);
        $iField =2;
        $hField = OGR_F_GetRawFieldRef($hSrcF, $iField);
        $this->AssertNotNull($hField, "Problem with OGR_F_GetRawFieldRef(): ".
                                        "handle should not be NULL.");
        $iDriver = 5;
        $hDriver = OGRGetDriver($iDriver);

        $astrOptions = null;
        $hDestDS = OGR_Dr_CreateDataSource($hDriver, 
                                               $this->strPathToOutputData.
                                               $this->strDestDataSource,
                                               $astrOptions );

        if ($hDestDS == null) {
            printf("Unable to create destination data source\n");
            return FALSE;
        }

        $hDestLayer = OGR_DS_CreateLayer($hDestDS, $this->strOutputLayer, 
                                     $hSpatialRef,
                                     $this->eGeometryType,
                                     null /*Options*/);

        $iLayer = 0;
        $hDestLayer = OGR_DS_GetLayer($hDestDS, $iLayer);

        $hFieldDefn = OGR_Fld_Create("LPOLY_", OFTInteger);
        $eErr = OGR_L_CreateField($hDestLayer, $hFieldDefn, 0 /*bApproxOK*/);

        $hFeatureDefn = OGR_L_GetLayerDefn($hDestLayer);
        $hDestF = OGR_F_Create($hFeatureDefn);
        $iField = 0;
        OGR_F_SetFieldRaw($hDestF, $iField, $hField);

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");
	
        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
	}
        OGR_F_DumpReadable($fpOut, $hDestF);

        OGR_F_Destroy($hSrcF);
        OGR_F_Destroy($hDestF);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToOutputData.
                $this->strTmpDumpFile.
                " ".$this->strPathToStandardData.$strStandardFile,
                $iReval);

        $this->assertFalse($iRetval, "Problem with OGR_F_SetFieldRaw() ".
                            "or OGR_F_GetRawFieldRef(): ".
                             "Files comparison did not matched.\n");

        OGR_DS_Destroy($hDestDS);

    }

}

?>
