require_once `phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRFeatureTest4 extends PHPUnit_TestCase {
    var $strPathToDumpData;
    var $strTmpDumpFile;
    var $strPathToStandardData;
    var $strPathToData;
    var $bUpdate;
    var $hDS;
    var $hLayer;
    var $strDestDataSource;
 
    function OGRFeatureTest4($name){
        $this->PHPUnit_TestCase($name);	
    }

    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase";
	$this->strPathToDumpData = "../../ogrtests/testcase/"
	$this->strTmpDumpFile = "DumpFile.tmp";
	$this->bUpdate = FALSE;
        $this->strDestDataSource = "NewDataSource";



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
*                            testOGR_SetGetStyleString()                      
************************************************************************/

    function testOGR_SetGetStyleString() {
        $hDriver = null;
        $hSrcDS = OGROpen($this->strPathToData, $this->bUpdate, $hDriver);

	$hSrcLayer = OGR_DS_GetLayer($hSrcDS, 3);

        $iFID = 2;
        $hFSrc = OGR_L_GetFeature($this->hLayer, $iFID);
        $strStyleString = OGR_F_GetStyleString($hFSrc);
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
        $hDestF = OGR_F_Create($hFeatureDefn);
        OGR_F_SetStyleString($hDestF, $strStyleString);
        $strStyleStringOut = OGR_F_GetStyleString($hDestF);

        $expected = strcpy($strStyleString);
        $this->AssertEquals($expected, $strStyleStringOut);
        OGR_DS_Destroy($hDestDS);
        OGR_DS_Destroy($hDS);
    }
}

