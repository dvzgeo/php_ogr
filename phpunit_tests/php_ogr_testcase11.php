<?php

$testSuites_list[] = "OGRFeatureTest4";          

class OGRFeatureTest4 extends PHPUnit_Framework_TestCase {
    var $strPathToOutputData;
    var $strTmpDumpFile;
    var $strPathToStandardData;
    var $strPathToData;
    var $bUpdate;
    var $hDS;
    var $hLayer;
    var $strDestDataSource;
    var $strDirName;

    function setUp() {
        $this->strDirName = "testcase/";
        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase/";
	$this->strPathToOutputData = "../../ogrtests/".$this->strDirName;
	$this->strTmpDumpFile = "DumpFile.tmp";
	$this->bUpdate = FALSE;
        $this->strDestDataSource = "OutputDS.tab";

        if (file_exists($this->strPathToOutputData)) {
            system( "rm -R ".$this->strPathToOutputData);
        }
        mkdir($this->strPathToOutputData, 0777);

    }

    function tearDown() {
        unset($this->strPathToData);
        unset($this->strPathToStandardData);
        unset($this->strPathToDumpData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->strDestDataSource);
        unset($this->hDS);
        unset($this->hLayer);
    }
/***********************************************************************
*                            testOGR_F_SetGetStyleString()                      
************************************************************************/

    function testOGR_F_SetGetStyleString() {
        $hDriver = null;
        $hSrcDS = OGROpen($this->strPathToData, $this->bUpdate, $hDriver);

	$hSrcLayer = OGR_DS_GetLayer($hSrcDS, 3);

        $iFID = 2;
        $hSrcF = OGR_L_GetFeature($hSrcLayer, $iFID);

        $strStyleString = OGR_F_GetStyleString($hSrcF);

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
        $iLayer = 0;
        $hLayerDest = OGR_DS_GetLayer($hDestDS, $iLayer);

        $hFieldDefn = OGR_Fld_Create("id", OFTInteger);
        $eErr = OGR_L_CreateField($hLayerDest, $hFieldDefn, 0 /*bApproxOK*/);

        $hFeatureDefn = OGR_L_GetLayerDefn($hLayerDest);
        $hDestF = OGR_F_Create($hFeatureDefn);

        OGR_F_SetStyleString($hDestF, $strStyleString);

        $strStyleStringOut = OGR_F_GetStyleString($hDestF);

        $expected = $strStyleString;
        $this->AssertEquals($expected, $strStyleStringOut, "Problem with ".
                            "OGR_F_SetStyleString() or OGR_F_GetStyleString().");

        OGR_F_Destroy($hSrcF);
        OGR_F_Destroy($hDestF);
        OGR_DS_Destroy($hDestDS);
        OGR_DS_Destroy($hSrcDS);
    }
}
?>
