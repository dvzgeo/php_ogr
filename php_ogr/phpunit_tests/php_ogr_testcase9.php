require_once `phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRFeatureTest2 extends PHPUnit_TestCase {
    var $strPathToDumpData;
    var $strTmpDumpFile;
    var $strPathToStandardData;
    var $strPathToData;
    var $bUpdate;
    var $hDS;
    var $hLayer;
    var $strDestDataSource;
 
    function OGRFeatureTest2($name){
        $this->PHPUnit_TestCase($name);	
    }

    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase";
	$this->strPathToDumpData = "../../ogrtests/testcase/"
	$this->strTmpDumpFile = "DumpFile.tmp";
	$this->bUpdate = FALSE;
        $this->strDestDataSource = "NewDataSource";

        $hDriver = null;
        $hDS = OGROpen($this->strPathToData, $this->bUpdate, $hDriver);

	$hLayer = OGR_DS_GetLayer($hDS, 3);


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
*                            testOGR_F_IsFieldSet()
************************************************************************/

    function testOGR_F_IsFieldSet() {
        $iFID = 2;
        $hF = OGR_L_GetFeature($this->hLayer, $iFID);
        $iField = 1;
        $bFieldSet = OGR_F_IsFieldSet($hF, $iField);
        $this->AssertTrue($bFieldSet, "");
}
/***********************************************************************
*                            testOGR_F_UnsetField()                           
************************************************************************/

    function testOGR_F_UnsetField() {
        $iFID = 2;
        $hf = OGR_L_GetFeature($this->hLayer, $iFID);
        $iField =1;
        OGR_F_UnsetField($hf, $iField);
        $bFieldSet = OGR_F_IsFieldSet($hF, $iField);
        $this->AssertFalse($bFieldSet, "");
    
}
/***********************************************************************
*                            testOGR_SetFieldRaw()                             
************************************************************************/

    function testOGR_SetFieldRaw() {
        $iFID = 2;
        $hFSrc = OGR_L_GetFeature($this->hLayer, $iFID);
        $iField =2;
        $hField = OGR_F_GetRawFieldRef($hFSrc, $iField);
        $iDriver = 5;
        $hDriver = OGR_GetDriver($iDriver);
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
        $hlayerDest = OGR_DS_GeLayer($hDestDS, $iLayer);
        $hFieldDefn = OGR_Fld_Create("id", OFTInteger);
        $eErr = OGR_L_CreateField($hLayerDest, $hFieldDefn, 0 /*bApproxOK*/);
        $hFeatureDefn = OGR_L_GetLayerDefn($hLayerDest);
        $hFDest = OGR_F_Create($hFeatureDefn);
        OGR_F_SetFieldRaw($hFDest, $iField, $hField);

        print hFDest
        system diff
        $this->AssertNull($iRetVal);
        OGR_DS_Destroy($hDestDS);
        OGR_DS_Destroy($hDS);
}
/***********************************************************************
*                            test()                                           
************************************************************************/

    function testOGR_() {

}
/***********************************************************************
*                            test()                                           
************************************************************************/

    function testOGR_() {

}
/***********************************************************************
*                            test()                                           
************************************************************************/

    function testOGR_() {

}
/***********************************************************************
*                            test()                                           
************************************************************************/

    function testOGR_() {

}
/***********************************************************************
*                            test()                                           
************************************************************************/

    function testOGR_() {

}
/***********************************************************************
*                            test()                                           
************************************************************************/

    function testOGR_() {

}
/***********************************************************************
*                            test()                                           
************************************************************************/

    function testOGR_() {

}
/***********************************************************************
*                            test()                                           
************************************************************************/

    function testOGR_() {

}
/***********************************************************************
*                            test()                                           
************************************************************************/

    function testOGR_() {

}
/***********************************************************************
*                            test()                                           
************************************************************************/

    function testOGR_() {

}
/***********************************************************************
*                            test()                                           
************************************************************************/

    function testOGR_() {

}

	




