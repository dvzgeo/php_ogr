<?php
require_once 'phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRLayerTest2 extends PHPUnit_TestCase {
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
    function OGRLayerTest2($name){
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
*                         testOGR_L_GetFeature0()                    
*                         
************************************************************************/

    function testOGR_L_GetFeature0() {

        $strStandardFile = "testOGR_L_GetFeature0.std";

        $nFeatureId = 12;

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                            $this->strPathToData,
                                            $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 5);

        $hFeature = OGR_L_GetFeature($hLayer, $nFeatureId);

        $this->assertNotNull($hFeature, "Feature handle ".
                       "is not supposed to be NULL.\n");

        $fpOut = fopen($this->strPathToDumpData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }

        OGR_F_DumpReadable($fpOut, $hFeature);

        fclose($fpOut);


        system("diff --brief ".$this->strPathToDumpData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);

        printf("retval = %d\n", $iRetval);

        $this->assertFalse($iRetval, "Files have changed.\n");

        OGR_DS_Destroy($hExistingDataSource);

    }
/***********************************************************************
*                         testOGR_L_GetNextFeature0()                    
*                         
************************************************************************/

    function testOGR_L_GetNextFeature0() {

        $strStandardFile = "testOGR_L_GetNextFeature0.std";

        $nFeatureId = 12;

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                            $this->strPathToData,
                                            $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 5);

        OGR_L_ResetReading($hLayer);

        for($i=0; $i<$nFeatureId; $i++)
        {
            $hFeature = OGR_L_GetNextFeature($hLayer);
            $this->assertNotNull($hFeature, "Feature handle got from ".
                   "OGR_L_GetNextFeature() is not supposed to be NULL.\n");
        }

        $fpOut = fopen($this->strPathToDumpData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }

        OGR_F_DumpReadable($fpOut, $hFeature);

        fclose($fpOut);


        system("diff --brief ".$this->strPathToDumpData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);

        printf("retval = %d\n", $iRetval);

        $this->assertFalse($iRetval, "Files have changed.\n");

        OGR_DS_Destroy($hExistingDataSource);

    }
/***********************************************************************
*                         testOGR_L_GetSpatialRef0()                    
*                         
************************************************************************/
    function testOGR_L_GetSpatialRef0() {

        $strStandardFile = "testOGR_L_GetSpatialRef0.std";

        system( "rm -R ".$this->strPathToOutputData.$this->strDestDataSource);

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                            $this->strPathToData,
                                            $this->bUpdate);

        $hExistingLayer = OGR_DS_GetLayer($hExistingDataSource, 6);

        $hSpatialRef = OGR_L_GetSpatialRef($hExistingLayer);

        $this->assertNotNull($hSpatialRef, "Spatial reference ".
                       "is not supposed to be NULL.\n");

        $hODS = OGR_Dr_CreateDataSource($hDriver, $this->strPathToOutputData.
                                    $this->strDestDataSource, 
                                        null /*Options*/);

        $hLayer = OGR_DS_CreateLayer($hODS, $this->strLayerOutput, 
                                     $hSpatialRef,
                                     $this->eGeometryType,
                                     null /*Options*/);

        $hFDefn = OGR_L_GetLayerDefn($hExistingLayer);

        if( OGR_L_CreateField( $hLayer, OGR_FD_GetFieldDefn( $hFDefn, 0),
                               0 /*bApproOK*/ ) != OGRERR_NONE ){
            return(FALSE);
        }

        OGR_DS_Destroy($hODS);

        system("ogrinfo -al ".$this->strPathToOutputData.
               $this->strDestDataSource." >".
               $this->strPathToDumpData.
               $this->strTmpDumpFile);

        system("diff --brief ".$this->strPathToDumpData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);

        printf("retval = %d\n", $iRetval);

        $this->assertFalse($iRetval, "Files have changed.\n");


        OGR_DS_Destroy($hExistingDataSource);


    }
/***********************************************************************
*                         testOGR_L_ResetReading0()                    
*                         
************************************************************************/

    function testOGR_L_ResetReading0() {

        $strStandardFile = "testOGR_L_ResetReading0.std";

        $nFeatureId = 12;

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                            $this->strPathToData,
                                            $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 5);

        $fpOut = fopen($this->strPathToDumpData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }

        OGR_L_ResetReading($hLayer);

        $hFeature = OGR_L_GetNextFeature($hLayer);

        OGR_F_DumpReadable($fpOut, $hFeature);

        for($i=0; $i<$nFeatureId; $i++)
        {
            $hFeature = OGR_L_GetNextFeature($hLayer);
        }

        OGR_L_ResetReading($hLayer);

        $hFeature = OGR_L_GetNextFeature($hLayer);

        OGR_F_DumpReadable($fpOut, $hFeature);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToDumpData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);

        printf("retval = %d\n", $iRetval);

        $this->assertFalse($iRetval, "Files have changed.\n");

        OGR_DS_Destroy($hExistingDataSource);

    }
/***********************************************************************
*                         testOGR_L_GetExtent0()                    
*                         
************************************************************************/
    function testOGR_L_GetExtent() {

        $strStandardFile = "testOGR_L_GetExtent0.std";

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                            $this->strPathToData,
                                            $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 7);

        CPLErrorReset();

        $eErr = OGR_L_GetExtent($hLayer, $hEnvelope, $bForce /*bForce*/);

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;

        $this->assertEquals($expected, $eErr, $eErrMsg);

        $strEnvelope = serialize(&$hEnvelope);
        printf("env = %s\n",$strEnvelope);

        $expected = "O:8:\"stdClass\":4:{s:4:\"minx\";d:-2340603.72;s:4:".
         "\"maxx\";d:3009430.5;s:4:\"miny\";d:-719746.05;s:4:".
         "\"maxy\";d:3836605.245;}";

        printf("expected = %s\n",$expected);

        $this->assertEquals($expected, $strEnvelope, 
                            "Extent is not corresponding.", 0 /*Delta*/);

        OGR_DS_Destroy($hExistingDataSource);

    }

/***********************************************************************
*                         testOGR_L_GetFeatureCount0()                    
*                         
************************************************************************/
    function testOGR_L_GetFeatureCount0() {

        $strStandardFile = "testOGR_L_GetFeatureCount0.std";

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                            $this->strPathToData,
                                            $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 7);

        $nFeatureCount = OGR_L_GetFeatureCount($hLayer, $bForce /*bForce*/);

        $expected = 1068;

        $this->assertEquals($expected, $nFeatureCount, "Feature Count is ".
                            "not corresponding");

        OGR_DS_Destroy($hExistingDataSource);

    }
/***********************************************************************
*                         testOGR_L_CreateFeature0()                    
*                        Randow write not supported for mif. 
************************************************************************/

/*    function testOGR_L_CreateFeature0() {

        $strStandardFile = "testOGR_L_CreateFeature0.std";

        $this->bUpdate = TRUE;

        $nFeatureId = 10;

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                            $this->strPathToData,
                                            $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 5);

        $fpOut = fopen($this->strPathToDumpData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }

        $hFeature = OGR_L_GetFeature($hLayer, $nFeatureId);

        OGR_F_DumpReadable($fpOut, $hFeature);

        CPLErrorReset();

        $eErr = OGR_L_CreateFeature($hLayer, $hFeature);

        $eErrMsg = CPLGetLastErrorMsg();
        printf("msg=%s\n", $eErrMsg);

        $expected = OGRERR_NONE;

        $this->assertEquals($expected, $eErr, $eErrMsg);

        $nFeatureCount = OGR_L_GetFeatureCount($hLayer, $bForce );

        $hFeature = OGR_L_GetFeature($hLayer, $nFeatureCount + 1);

        OGR_F_DumpReadable($fpOut, $hFeature);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToDumpData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);

        printf("retval = %d\n", $iRetval);

        $this->assertFalse($iRetval, "Files have changed.\n");

        OGR_DS_Destroy($hExistingDataSource);

    }
*/

/***********************************************************************
*                         testOGR_L_CreateField0()                    
*                       
************************************************************************/
    function testOGR_L_CreateField0() {

        $strStandardFile = "testOGR_L_CreateField0.std";

        system( "rm -R ".$this->strPathToOutputData.$this->strDestDataSource);

        $hDriver = OGRGetDriver(5);

        $hSpatialRef = null;

        $hODS = OGR_Dr_CreateDataSource($hDriver, $this->strPathToOutputData.
                                    $this->strDestDataSource, 
                                        null /*Options*/);

        $hLayer = OGR_DS_CreateLayer($hODS, $this->strLayerOutput, 
                                     $hSpatialRef,
                                     $this->eGeometryType,
                                     null /*Options*/);

        if( OGR_L_CreateField( $hLayer, OGR_Fld_Create( "NewField", 
                                                        OFTInteger),
                               0 /*bApproOK*/ ) != OGRERR_NONE ){
            return(FALSE);
        }

        OGR_DS_Destroy($hODS);

        system("ogrinfo -al ".$this->strPathToOutputData.
               $this->strDestDataSource." >".
               $this->strPathToDumpData.
               $this->strTmpDumpFile);

        system("diff --brief ".$this->strPathToDumpData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);

        printf("retval = %d\n", $iRetval);

        $this->assertFalse($iRetval, "Files have changed.\n");

    }



}
?> 





