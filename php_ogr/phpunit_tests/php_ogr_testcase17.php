require_once `phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRGeometryTest2 extends PHPUnit_TestCase {
    var $hContainer;
    var $hRing1;
    var $hRing2;

    var $strPathToDumpData;
    var $strTmpDumpFile;
    var $strPathToStandardData;
    var $strPathToData;
    var $bUpdate;
    var $hDS;
    var $hLayer;
    var $strDestDataSource;
 
    function OGRGeometryTest2($name){
        $this->PHPUnit_TestCase($name);	
    }

    function setUp() {
        $eType = wkbPolygon;
        $hContainer = OGR_G_CreateGeometry($eType);

        $eType = wkbLinearRing;
        $hRing1 = OGR_G_CreateGeometry($eType);
        OGR_G_AddPoint($hRing1, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($hRing1, 12.34, 456.78, 0.0);
        OGR_G_AddPoint($hRing1, 12.34, 45.67, 0.0);
        OGR_G_AddPoint($hRing1, 123.45, 45.67, 0.0);
        OGR_G_AddPoint($hRing1, 123.45, 456.78, 0.0);
        $eErr = OGR_G_AddGeometry($hContainer, $hRing1);

        $eType = wkbLinearRing;
        $hRing2 = OGR_G_CreateGeometry($eType);
        OGR_G_AddPoint($hRing2, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($hRing2, 100.0, 456.78, 0.0);
        OGR_G_AddPoint($hRing2, 100.0, 355.25, 0.0);
        OGR_G_AddPoint($hRing2, 123.45, 355.25, 0.0);
        OGR_G_AddPoint($hRing2, 123.45, 456.78, 0.0);
        $eErr = OGR_G_AddGeometry($hContainer, $hRing2);


        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase";
	$this->strPathToDumpData = "../../ogrtests/testcase/"
	$this->strTmpDumpFile = "DumpFile.tmp";
	$this->bUpdate = FALSE;
        $this->strDestDataSource = "NewDataSource";
    }

    function tearDown() {
        OGR_G_DestroyGeometry($this->hRing1);
        OGR_G_DestroyGeometry($this->hRing2);
        OGR_G_DestroyGeometry($this->hContainer);

        unset($this->hRing1);
        unset($this->hring2);
        unset($this->hContainer);

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
*                            testOGR_G_GetAssignSpatialRef()                  
************************************************************************/

    function testOGR_G_GetAssignSpatialRef() {
        $hDriver = null;
        $hDS = OGROpen($this->strPathToData, $this->bUpdate, $hDriver);

	$hLayer = OGR_DS_GetLayer($hDS, 2);

        $iFID = 4;
        $hF = OGR_L_GetFeature($hLayer, $iFID);
        $hSrcGeometry = OGR_G_GetGeometryRef($hF);

        $hSRS = OGR_G_GetSpatialReference($hSrcGeometry);
        $this->AssertNotNull($hSRS, "");

        $iGeometry = 1;
        $hDestGeometry = OGR_G_GetGeometryRef($this->hContainer, $iGeometry);
        OGR_G_AssignSpatialReference($hDestGeometry, $hSRS);

        system OGRInfo
        system diff

        $this->AssertFalse($iRetValue, "");
    }
/***********************************************************************
*                            testOGR_G_TransformTo()                  
************************************************************************/

    function testOGR_G_TransformTo() {
        $hDriver = null;
        $hDS = OGROpen($this->strPathToData, $this->bUpdate, $hDriver);

	$hLayer = OGR_DS_GetLayer($hDS, 0);

        $hSRS = OGR_L_GetSpatialRef($hLayer);

        $iGeometry = 0;
        $hDestGeometry = OGR_G_GetGeometryRef($this->hContainer, $iGeometry);


        $eErr = OGR_G_TransformTo($hDestGeometry, $hSRS);

        system OGRInfo
        system diff

        $this->AssertFalse($iRetValue, "");
    }

}
