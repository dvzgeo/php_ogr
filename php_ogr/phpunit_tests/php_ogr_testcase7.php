<?php
require_once 'phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRFeatureTest0 extends PHPUnit_TestCase {
    var $strPathToData;
    var $strPathToStandardData;
    var $strPathToOutputData;
    var $strPathToDumpData;
    var $strTmpDumpFile;
    var $bUpdate;
    var $bForce;
    var $hOGRSFDriver;
    var $strFilename;
    var $strOutputFilename;
    var $strCapability;
    var $strLayerName;
    var $hSRS;
    var $eGeometryType;
    var $strDialect;
    var $strFormat;
    var $strDestDataSource;
    var $strLayerOutput;

    // constructor of the test suite
    function OGRFeatureTest0($name){
        $this->PHPUnit_TestCase($name);
    }
    // called before the test functions will be executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here
    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase/";
        $this->strPathToOutputData = "../../ogrtests/testcase/";
        $this->strPathToDumpData = "../../ogrtests/testcase/";
        $this->strFilename = "NewDataSource";
        $this->strOutputFilename = "";
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->bUpdate = FALSE;
        $this->bForce = TRUE;
        $this->iSpatialFilter[0] = 3350000;  /*xmin*/
        $this->iSpatialFilter[1] = 4210400;  /*ymin*/
        $this->iSpatialFilter[2] = 3580000;  /*xmax*/
        $this->iSpatialFilter[3] = 4280000;  /*ymax*/
        $this->strCapability = "OLCFastGetExtent";
        $this->strLayerName = "LayerPoint";
        $this->hSRS = null;
        $this->eGeometryType = wkbUnknown;
        $this->strDialect = ""; /*"Generic SQL"*/
        $this->strFormat = "MapInfo File";
        $this->strDestDataSource = "DSOutput";
        $this->strLayerOutput = "LayerOutput";
    }
    // called after the test functions are executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here    
    function tearDown() {
        // delete your instance
        unset($this->strPathToData);
        unset($this->strPathToStandardData);
        unset($this->strPathToDumpData);
        unset($this->strPathToOutputData);
        unset($this->strFilename);
        unset($this->strTmpDumpFile);
        unset($this->strOutputFilename);
        unset($this->bUpdate);
        unset($this->bForce);
        unset($this->strCapability);
        unset($this->strLayerName);
        unset($this->hSRS);
        unset($this->eGeometryType);
        unset($this->strFormat);
        unset($this->strDestDataSource);
        unset($this->strLayerOutput);
    }


/***********************************************************************
*                         testOGR_F_CreateDestroy0()                    
*                       
************************************************************************/
    function testOGR_F_CreateDestroy0() {

        OGRRegisterAll();

        $strStandardFile = "testOGR_F_CreateDestroy0.std";

        $hDriver = OGRGetDriver(5);

        $hSpatialRef = null;

        $hODS = OGR_Dr_CreateDataSource($hDriver, $this->strPathToOutputData.
                                    $this->strDestDataSource, 
                                        null /*Options*/);

        $hLayer = OGR_DS_CreateLayer($hODS, $this->strLayerOutput, 
                                     $hSpatialRef,
                                     $this->eGeometryType,
                                     null /*Options*/);

        $hFeature = OGR_F_Create( OGR_L_GetLayerDefn($hLayer));
        
        $this->assertNotNull($hFeature, "Feature handle is not supposed ".
                             "to be NULL.");
        
        OGR_F_Destroy($hFeature);

        $this->assertNull($hFeature, "Feature handle is supposed ".
                             "to be NULL.");

        OGR_DS_Destroy($hODS);

        system( "rm -R ".$this->strPathToOutputData.$this->strDestDataSource);
        
    }

/***********************************************************************
*                         testOGR_F_GetDefnRef0()                    
*                       
************************************************************************/
    function testOGR_F_GetDefnRef0() {

        OGRRegisterAll();

        $nFeatureId = 10;

        $strStandardFile = "testOGR_F_GetDefnRef0.std";

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                            $this->strPathToData,
                                            $this->bUpdate);

        $fpOut = fopen($this->strPathToDumpData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 5);

        $hFeatureDefn = OGR_L_GetLayerDefn( $hLayer );

        OGRDumpLayerDefn ($fpOut, $hFeatureDefn);

        $hFeature = OGR_L_GetFeature($hLayer, $nFeatureId);

        $hSameFeatureDefn = OGR_F_GetDefnRef($hFeature);

        $this->assertNotNull($hSameFeatureDefn, "Feature handle is not ".
                             "supposed to be NULL.");

        OGRDumpLayerDefn ($fpOut, $hSameFeatureDefn);

        printf("hfeature=%s,hsamefeature=%s\n", $hFeature, $hSameFeature);

        OGR_F_Destroy($hFeature);

        OGR_DS_Destroy($hExistingDataSource);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToDumpData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);

        printf("retval = %d\n", $iRetval);

        $this->assertFalse($iRetval, "Files have changed.\n");


//        system( "rm -R ".$this->strPathToOutputData.$this->strDestDataSource);
        
    }


}
?> 





