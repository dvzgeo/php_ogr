require_once `phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRFeatureTest1 extends PHPUnit_TestCase {
    var $strPathToDumpData;
    var $strTmpDumpFile;
    var $strPathToStandardData;
    var $strPathToData;
    var $bUpdate;
    var $hDS;
    var $hLayer;
 
    function OGRFeatureTest1($name){
        $this->PHPUnit_TestCase($name);	
    }

    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase";
	$this->strPathToDumpData = "../../ogrtests/testcase/"
	$this->strTmpDumpFile = "DumpFile.tmp";
	$this->bUpdate = FALSE;

        $strStandardFile = "testOGR_F_SetGetGeometry";

        $hDS = OGROpen($this->strPathToData, $this->bUpdate);

	$hLayer = OGR_DS_GetLayer($hDS, 3);


    }

    function tearDown() {
        unset($this->strPathToData);
        unset($this->strPathToStandardData);
        unset($this->strPathToDumpData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->hDS);
        unset($this->hLayer);
    }
/***********************************************************************
*                       testOGR_F_SetGetGeometry()   
************************************************************************/
    function testOGR_F_SetGetGeometry() {

        $iFID1 =2;
        $hF1 = OGR_L_GetFeature($hLayer, $iFID1);
        $iFID2 =5;
        $hF2 = OGR_L_GetFeature($hLayer, $iFID2);

        $hGeometry = OGR_F_GetGeometryRef($hF2);
        CPLErrorReset();
        $eErr = OGR_F_SetGeometry($hF1, $hGeometry);
        $strMsg = CPLGetLastErrorMsg();
        $expected = OGRERR_NONE;
        $this->AssertEquals($expected, $eErr, $strMsg);

        $fpOut = fopen($this->strPathToDumpData.
                       $this->strTmpDumpFile, "w");
	
        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
	}
        OGRFeatureDump($fpOut, $hF1);

        OGR_F_Destroy($hF1);
        OGR_F_Destroy($hF2);
        OGR_DS_Destroy($hDS);
        fclose($fpOut);

        system("diff --brief ".$this->strPathToDumpData.
                $this->strTmpDumpFile.
                " ".$this->strPathToStandardData.$strStandardFile,
                $iReval);

        $this->assertFalse($iRetval, "Files have changed\n");

    }
/***********************************************************************
*                            testOGR_F_Clone()                                
************************************************************************/

    function testOGR_F_Clone() {
        $iFID1 =2;
        $hF1 = OGR_L_GetFeature($hLayer, $iFID1);

        $hF2 = OGR_F_Clone($hF1);

        imprimer $hF2
        system diff
        $this->AssertNull($iRetval);

}
/***********************************************************************
*                            testOGR_F_Equal0()      
************************************************************************/

    function testOGR_F_Equal1() {
        $iFID1 =2;
        $hF1 = OGR_L_GetFeature($hLayer, $iFID1);
        $iFID2 =5;

        $hF2 = OGR_L_GetFeature();

        $bEqual = OGR_F_Equal($hF1, $hF2);
        $this->AssertFalse($bEqual, "");
}
/***********************************************************************
*                            testOGR_F_Equal1()                               
************************************************************************/

    function testOGR_F_Equal2() {
        $iFID =2;
        $hF1 = OGR_L_GetFeature($hLayer, $iFID);

        $hF2 = OGR_F_Clone($hF1);

        $bEqual = OGR_F_Equal($hF1, $hF2);
        $this->AssertTrue($bEqual, "");
}
/***********************************************************************
*                            testOGR_F_GetFieldCount()                        
************************************************************************/

    function testOGR_GetFieldCount() {
        $iFID =2;
        $hF = OGR_L_GetFeature($hLayer, $iFID);

        $nFieldCount = OGR_F_GetFieldCount($hF);
        $expected = TO DETERMINE;
        $this->AssertEquals($expected, $nFieldCount);
}
/***********************************************************************
*                            testOGR_F_GetFieldDefnRef()                      
************************************************************************/

    function testOGR_F_GetFieldDefnRef() {
        $iFID =2;
        $hF = OGR_L_GetFeature($hLayer, $iFID);
        $iField = 2;
        $hFieldDefn = OGR_F_GetFieldDefnRef($hF, $iField);

        print field
        system diff
        $this->AssertNull($iRetval);
}
/***********************************************************************
*                            testOGR_F_GetFieldIndex0()  
************************************************************************/

    function testOGR_F_GetFieldIndex0() {
       $hF = OGR_L_GetFeature($this->hLayer, $iFID);   
       $strFieldName = "";  GOOD
       $iField = OGR_F_GetFieldIndex($hF, $strFieldName);
       $expected = ;
       $this->AssertEquals($expected, $iField, "");
    }
/***********************************************************************
*                            testOGR_F_GetFieldIndex1()  
************************************************************************/

    function testOGR_F_GetFieldIndex1() {
       $hF = OGR_L_GetFeature($this->hLayer, $iFID);   
       $strFieldName = "";   BAD
       $iField = OGR_F_GetFieldIndex($hF, $strFieldName);
       $expected = ;
       $this->AssertEquals($expected, $iField, "");
    }
}
