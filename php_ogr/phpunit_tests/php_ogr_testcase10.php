require_once `phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRFeatureTest3 extends PHPUnit_TestCase {
    var $strPathToDumpData;
    var $strTmpDumpFile;
    var $strPathToStandardData;
    var $strPathToData;
    var $bUpdate;
    var $hDestDS;
    var $hDestLayer;
    var $strDestDataSource;
 
    function OGRFeatureTest3($name){
        $this->PHPUnit_TestCase($name);	
    }

    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase";
	$this->strPathToDumpData = "../../ogrtests/testcase/"
	$this->strTmpDumpFile = "DumpFile.tmp";
	$this->bUpdate = FALSE;
        $this->strDestDataSource = "NewDataSource";

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
        $hDestlayer = OGR_DS_GeLayer($hDestDS, $iLayer);

    }

    function tearDown() {
        unset($this->strPathToData);
        unset($this->strPathToStandardData);
        unset($this->strPathToDumpData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->strDestDataSource);
        unset($this->hDestDS);
        unset($this->hDestLayer);
    }
/***********************************************************************
*                            testOGR_F_SetGetFieldInteger()                    
************************************************************************/

    function testOGR_F_SetGetFieldInteger() {
        $iValueIn = 4312;
        $hFieldDefn = OGR_Fld_Create("id", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);
        $iFieldIndex = 0;
        OGR_F_SetFieldInteger($hF, $iFieldIndex, $iValueIn);
        $iValueOut = OGR_F_GetFieldAsInteger($hF, $iFieldIndex);
        $expected = $iValueIn;
        $this->AssertEquals($expected, $iValueOut, "");
        OGR_F_Destroy($hF);
        OGR_DS_Destroy($this->hDestDS);
    }
/***********************************************************************
*                            testOGR_F_SetGetFieldDouble()                    
************************************************************************/

    function testOGR_F_SetGetFieldDouble() {
        $dfValueIn = 6533.58;
        $hFieldDefn = OGR_Fld_Create("area", OFTReal);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);
        $iFieldIndex = 0;
        OGR_F_SetFieldDouble($hF, $iFieldIndex, $dfValueIn);
        $dfValueOut = OGR_F_GetFieldAsInteger($hF, $iFieldIndex);
        $expected = $dfValueIn;
        $this->AssertEquals($expected, $dfValueOut, "");
        OGR_F_Destroy($hF);
        OGR_DS_Destroy($this->hDestDS);
    }
/***********************************************************************
*                            testOGR_F_SetGetFieldString()                    
************************************************************************/

    function testOGR_F_SetGetFieldString() {
        $strValueIn = "Liberty";
        $hFieldDefn = OGR_Fld_Create("name", OFTString);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);
        $iFieldIndex = 0;
        OGR_F_SetFieldString($hF, $iFieldIndex, $strValueIn);
        $strValueOut = OGR_F_GetFieldAsInteger($hF, $iFieldIndex);
        $expected = strcpy($strValueIn);
        $this->AssertEquals($expected, $strValueOut, "");
        OGR_F_Destroy($hF);
        OGR_DS_Destroy($this->hDestDS);
    }
/***********************************************************************
*                            testOGR_F_SetGetFieldIntegerList()               
************************************************************************/

    function testOGR_F_SetGetFieldIntegerList() {
        $iListValueIn[0] = 31;
        $iListValueIn[1] = 25;
        $iListValueIn[2] = 12;
        $numInteger = 3;

        $hFieldDefn = OGR_Fld_Create("age", OFTIntegerList);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);
        $iFieldIndex = 0;
        OGR_F_SetFieldIntegerList($hF, $iFieldIndex, $numInteger, 
                                  $iListValueIn);
        $iListValueOut[] = OGR_F_GetFieldAsIntegerList($hF, $iFieldIndex, 
                                                       $nCount);
        $expected = "";
        $actual = serialize($iListValueOut);
        $this->AssertEquals($expected, $actual, "");
        $expected = 3;
        $this->AssertEquals($expected, $nCount, "");
        OGR_F_Destroy($hF);
        OGR_DS_Destroy($this->hDestDS);
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
        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);
        $iFieldIndex = 0;
        OGR_F_SetFieldDoubleList($hF, $iFieldIndex, $numDouble, 
                                  $dfListValueIn);
        $dfListValueOut[] = OGR_F_GetFieldAsDoubleList($hF, $iFieldIndex, 
                                                       $nCount);
        $expected = "";
        $actual = serialize($dfListValueOut);
        $this->AssertEquals($expected, $actual, "");
        $expected = 4;
        $this->AssertEquals($expected, $nCount, "");
        OGR_F_Destroy($hF);
        OGR_DS_Destroy($this->hDestDS);
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
        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);
        $iFieldIndex = 0;
        OGR_F_SetFieldStringList($hF, $iFieldIndex, $strListValueIn);
        $strListValueOut[] = OGR_F_GetFieldAsStringList($hF, $iFieldIndex);
        $expected = "";
        $actual = serialize($strListValueOut);
        $this->AssertEquals($expected, $actual, "");
        OGR_F_Destroy($hF);
        OGR_DS_Destroy($this->hDestDS);
    }
/***********************************************************************
*                            testOGR_F_SetGetFID()                    
************************************************************************/

    function testOGR_F_SetGetFieldInteger() {
        $iValueIn = 4312;
        $hFieldDefn = OGR_Fld_Create("id", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hF = OGR_F_Create($hFeatureDefn);
        $nFID = OGR_F_GetFID($hF);
        $expected = 0;
        $this->AssertEquals($expected, $nFID, "");
        $nFID = 2;
        $eErr = OGR_F_SetFID($hF, $nFID);
        $nFID = OGR_F_GetFID($hF);
        $expected = 2;
        $this->AssertEquals($expected, $nFID, "");
        OGR_F_Destroy($hF);
        OGR_DS_Destroy($this->hDestDS);
    }

/***********************************************************************
*                            testOGR_F_SetFrom()                              
************************************************************************/

    function testOGR_F_SetFrom() {
        $hFieldDefn = OGR_Fld_Create("FNODE_", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFieldDefn = OGR_Fld_Create("INODE_", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFieldDefn = OGR_Fld_Create("LPOLY_", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFieldDefn = OGR_Fld_Create("TPOLY_", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFieldDefn = OGR_Fld_Create("LENGTH", OFTReal);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFieldDefn = OGR_Fld_Create("GRID_", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFieldDefn = OGR_Fld_Create("GRID_ID", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFieldDefn = OGR_Fld_Create("FCODE", OFTInteger);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFieldDefn = OGR_Fld_Create("F_TYPE", OFTString);
        $eErr = OGR_L_CreateField($this->hDestLayer,$hFieldDefn, 
                                  0 /*bApproxOk*/);
        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $hDestF = OGR_F_Create($hFeatureDefn);

        $hDriver = null;
        $hSrcDS = OGROpen($this->strPathToData, $this->bUpdate, $hDriver);

        $iLayer = 3;
	$hSrcLayer = OGR_DS_GetLayer($hSrcDS, $iLayer);
        $nFID = 5;
        $hSrcF = OGR_L_GetFeature($hSrcLayer, nFID);

        $bForgiving = TRUE;
        $eErr = OGR_F_SetFrom($hDestF, $hSrcF, $bForgiving);

        print $hDestF
        system diff
        $this->AssertNull($iRetVal);
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

	




