<?php

$testSuites_list[] = "OGRLayerTest2";                             

class OGRLayerTest2 extends PHPUnit_TestCase {
    var $strDirName;
    var $strPathToOutputData;
    var $strTmpDumpFile;
    var $strPathToData;
    var $strPathToStandardData;
    var $bUpdate;
    var $bForce;
    var $hOGRSFDriver;
    var $eGeometryType;
    var $hSrcDataSource;
    var $strOutputLayer;
    var $strDestDataSource;

    // called before the test functions will be executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here
    function setUp() {
        $this->strDirName = "testcase2/";
        $this->strPathToOutputData = "../../ogrtests/".$this->strDirName;
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase/";
        $this->bUpdate = FALSE;
        $this->bForce = TRUE;
        $this->iSpatialFilter[0] = 3350000;  /*xmin*/
        $this->iSpatialFilter[1] = 4210400;  /*ymin*/
        $this->iSpatialFilter[2] = 3580000;  /*xmax*/
        $this->iSpatialFilter[3] = 4280000;  /*ymax*/
        $this->eGeometryType = wkbUnknown;
        $this->strOutputLayer = "OutputLayer";
        $this->strDestDataSource = "OutputDS";

        if (file_exists($this->strPathToOutputData)) {
            system( "rm -R ".$this->strPathToOutputData);
        }

        mkdir($this->strPathToOutputData, 0777);

        OGRRegisterAll();

        $this->hOGRSFDriver = OGRGetDriver(5);

        $this->hSrcDataSource =  OGR_Dr_Open($this->hOGRSFDriver,
                                            $this->strPathToData,
                                            $this->bUpdate);

    }
    // called after the test functions are executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here    
    function tearDown() {
        // delete your instance
        OGR_DS_Destroy($this->hSrcDataSource);

        unset($this->strPathToData);
        unset($this->strPathToStandardData);
        unset($this->strDirName);
        unset($this->strPathToOutputData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->bForce);
        unset($this->hOGRSFDriver);
        unset($this->eGeometryType);
        unset($this->hSrcDataSource);
        unset($this->strOutputLayer);
        unset($this->strDestDataSource);
    }
/***********************************************************************
*                         testOGR_L_GetFeature0()                    
*                         
************************************************************************/

    function testOGR_L_GetFeature0() {

        $strStandardFile = "testOGR_L_GetFeature0.std";

        $nFeatureId = 12;

        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 5);

        $hFeature = OGR_L_GetFeature($hSrcLayer, $nFeatureId);

        $this->assertNotNull($hFeature, "Problem with ".
                             "OGR_L_GetFeature():  Feature handle ".
                             "is not supposed to be NULL.\n");

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }

        OGR_F_DumpReadable($fpOut, $hFeature);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToOutputData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                           "OGR_L_GetFeature() ".
                           "Files comparison did not matched.\n");
    }
/***********************************************************************
*                         testOGR_L_GetNextFeature0()                    
*                         
************************************************************************/

    function testOGR_L_GetNextFeature0() {

        $strStandardFile = "testOGR_L_GetNextFeature0.std";

        $nFeatureId = 12;

        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 5);

        OGR_L_ResetReading($hSrcLayer);

        for($i=0; $i<$nFeatureId; $i++)
        {
            $hFeature = OGR_L_GetNextFeature($hSrcLayer);
            $this->assertNotNull($hFeature, "Problem   with ".
                                 "OGR_L_GetNextFeature():  ".
                                 "Feature handle is not supposed ".
                                 "to be NULL.\n");
        }

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }

        OGR_F_DumpReadable($fpOut, $hFeature);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToOutputData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                           "OGR_L_GetNextFeature() ".
                           "Files comparison did not matched.\n");

    }
/***********************************************************************
*                         testOGR_L_GetSpatialRef0()                    
*                         
************************************************************************/
    function testOGR_L_GetSpatialRef0() {

        $strStandardFile = "testOGR_L_GetSpatialRef0.std";

        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 6);

        $hSpatialRef = OGR_L_GetSpatialRef($hSrcLayer);

        $this->assertNotNull($hSpatialRef, "Problem with ".
                             "OGR_L_GetSpatialRef():  Spatial reference ".
                             "handle is not supposed to be NULL.\n");

        $hDestDS = OGR_Dr_CreateDataSource($this->hOGRSFDriver, 
                                           $this->strPathToOutputData.
                                           $this->strDestDataSource, 
                                           null /*Options*/);

        $hDestLayer = OGR_DS_CreateLayer($hDestDS, 
                                         $this->strOutputLayer, 
                                         $hSpatialRef,
                                         $this->eGeometryType,
                                         null /*Options*/);

        $hFDefn = OGR_L_GetLayerDefn($hSrcLayer);

        if( OGR_L_CreateField( $hDestLayer, OGR_FD_GetFieldDefn( $hFDefn, 0),
                               0 /*bApproOK*/ ) != OGRERR_NONE ){
            return(FALSE);
        }

        OGR_DS_Destroy($hDestDS);

        system("/usr1/local/bin/ogrinfo -al ".$this->strPathToOutputData.
               $this->strDestDataSource." > ".
               $this->strPathToOutputData.
               $this->strTmpDumpFile);

        system("diff --brief --ignore-matching-lines=\"INFO:\" ".
               $this->strPathToOutputData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.
               $strStandardFile,
               $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                           "OGR_L_GetSpatialRef() ".
                           "Files comparison did not matched.\n");
    }
/***********************************************************************
*                         testOGR_L_ResetReading0()                    
*                         
************************************************************************/

    function testOGR_L_ResetReading0() {

        $strStandardFile = "testOGR_L_ResetReading0.std";

        $nFeatureId = 12;

        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 5);

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }

        OGR_L_ResetReading($hSrcLayer);

        $hFeature = OGR_L_GetNextFeature($hSrcLayer);

        OGR_F_DumpReadable($fpOut, $hFeature);

        for($i=0; $i<$nFeatureId; $i++)
        {
            $hFeature = OGR_L_GetNextFeature($hSrcLayer);
        }

        OGR_L_ResetReading($hSrcLayer);

        $hFeature = OGR_L_GetNextFeature($hSrcLayer);

        OGR_F_DumpReadable($fpOut, $hFeature);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToOutputData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                           "OGR_L_ResetReading() ".
                           "Files comparison did not matched.\n");

    }
/***********************************************************************
*                         testOGR_L_GetExtent0()                    
*                         
************************************************************************/
    function testOGR_L_GetExtent0() {

        $strStandardFile = "testOGR_L_GetExtent0.std";

        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 7);

        CPLErrorReset();

        $eErr = OGR_L_GetExtent($hSrcLayer, $hEnvelope, 
                                $this->bForce /*bForce*/);

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;

        $this->assertEquals($expected, $eErr, "Problem with ".
                            "OGR_L_GetExtent():  ".$eErrMsg);

        $strEnvelope = serialize(&$hEnvelope);

        $expected = "O:8:\"stdClass\":4:{s:4:\"minx\";d:-2340603.72;s:4:".
         "\"maxx\";d:3009430.5;s:4:\"miny\";d:-719746.05;s:4:".
         "\"maxy\";d:3836605.245;}";

        $this->assertEquals($expected, $strEnvelope, 
                            "Problem with OGR_L_GetExten():  ".
                            "Extent is not corresponding.", 0 /*Delta*/);
    }
/***********************************************************************
*                         testOGR_L_GetFeatureCount0()                    
*                         
************************************************************************/
    function testOGR_L_GetFeatureCount0() {

        $strStandardFile = "testOGR_L_GetFeatureCount0.std";

        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 7);

        $nFeatureCount = OGR_L_GetFeatureCount($hSrcLayer, 
                                               $this->bForce /*bForce*/);

        $expected = 1068;

        $this->assertEquals($expected, $nFeatureCount, "Problem with ".
                            "OGR_L_GetFeatureCount():  Features count is ".
                            "not corresponding");
    }
/***********************************************************************
*                         testOGR_L_CreateField0()                    
*                       
************************************************************************/
    function testOGR_L_CreateField0() {

        $strStandardFile = "testOGR_L_CreateField0.std";

        $hDestDS = OGR_Dr_CreateDataSource($this->hOGRSFDriver, 
                                           $this->strPathToOutputData.
                                           $this->strDestDataSource, 
                                           null /*Options*/);

        $hSpatialRef = null;

        $hDestLayer = OGR_DS_CreateLayer($hDestDS, 
                                         $this->strOutputLayer, 
                                         $hSpatialRef,
                                         $this->eGeometryType,
                                         null /*Options*/);

        if( OGR_L_CreateField( $hDestLayer, 
                               OGR_Fld_Create( "NewField", OFTInteger),
                               0 /*bApproOK*/ ) != OGRERR_NONE ){
            return(FALSE);
        }

        OGR_DS_Destroy($hDestDS);


        system("/usr1/local/bin/ogrinfo -al ".$this->strPathToOutputData.
               $this->strDestDataSource." >".
               $this->strPathToOutputData.
               $this->strTmpDumpFile);



        system("diff --brief --ignore-matching-lines=\"INFO:\" ".
               $this->strPathToOutputData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.
               $strStandardFile,
               $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                           "OGR_L_CreateField() ".
                           "Files comparison did not matched.\n");


    }
/***********************************************************************
*                         testOGR_L_CreateFeature0()                    
*                        To use with other format.
*                        Randow write not supported for mif. 
************************************************************************/

/*    function testOGR_L_CreateFeature0() {

        $strStandardFile = "testOGR_L_CreateFeature0.std";

        $this->bUpdate = TRUE;

        $nFeatureId = 10;

        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, 5);

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }

        $hFeature = OGR_L_GetFeature($hSrcLayer, $nFeatureId);

        OGR_F_DumpReadable($fpOut, $hFeature);

        CPLErrorReset();

        $eErr = OGR_L_CreateFeature($hSrcLayer, $hFeature);

        $eErrMsg = CPLGetLastErrorMsg();
        printf("msg=%s\n", $eErrMsg);

        $expected = OGRERR_NONE;

        $this->assertEquals($expected, $eErr, "Problem with ".
                            "OGR_L_CreateFeature():  ".$eErrMsg);

        $nFeatureCount = OGR_L_GetFeatureCount($hSrcLayer, $this->bForce );

        $hFeature = OGR_L_GetFeature($hSrcLayer, $nFeatureCount + 1);

        OGR_F_DumpReadable($fpOut, $hFeature);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToOutputData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                           "OGR_L_CreateFeature() ".
                           "Files comparison did not matched.\n");
    }
*/
/***********************************************************************
*                         testOGR_L_CreateFeature0()                    
*                        Randow write not supported for mif. 
************************************************************************/
    function testOGR_L_CreateFeature0() {

        $strStandardFile = "testOGR_L_CreateFeature0.std";

        $hDestDS = OGR_Dr_CreateDataSource($this->hOGRSFDriver, 
                                           $this->strPathToOutputData.
                                           $this->strDestDataSource, 
                                           null /*Options*/);

        $hSpatialRef = null;

        $hDestLayer = OGR_DS_CreateLayer($hDestDS, 
                                         $this->strOutputLayer, 
                                         $hSpatialRef,
                                         $this->eGeometryType,
                                         null /*Options*/);

        if( OGR_L_CreateField( $hDestLayer, 
                               OGR_Fld_Create( "NewField", OFTInteger),
                               0 /*bApproOK*/ ) != OGRERR_NONE ){
            return(FALSE);
        }

        $nFeatureId = 12;
        $iLayer = 5;

        $hSrcLayer = OGR_DS_GetLayer($this->hSrcDataSource, $iLayer);

        $hFeature = OGR_L_GetFeature($hSrcLayer, $nFeatureId);

        CPLErrorReset();

        $eErr = OGR_L_CreateFeature($hDestLayer, $hFeature);

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;

        $this->assertEquals($expected, $eErr, "Problem with ".
                            "OGR_L_CreateFeature():  ".$eErrMsg);

        $expected = 1;

        $nFeatureCount = OGR_L_GetFeatureCount($hDestLayer, $this->bForce );

        $this->assertEquals($expected, $nFeatureCount, "Problem with ".
                            "OGR_L_CreateFeature():  ".
                            "supposed to have at least one feature.");

        OGR_DS_Destroy($hDestDS);

        system("/usr1/local/bin/ogrinfo -al ".$this->strPathToOutputData.
               $this->strDestDataSource." >".
               $this->strPathToOutputData.
               $this->strTmpDumpFile);

        system("diff --brief --ignore-matching-lines=\"INFO:\" ".
               $this->strPathToOutputData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                           "OGR_L_CreateFeature() ".
                           "Files comparison did not matched.\n");
    }
}
?> 
