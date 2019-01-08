<?php

$testSuites_list[] = "OGRDataSourceTest0";                             

class OGRDataSourceTest0 extends PHPUnit_Framework_TestCase {
    var $strPathToData;
    var $strPathToOutputData;
    var $strPathToStandardData;
    var $strTmpDumpFile;
    var $bUpdate;
    var $bForce;
    var $hOGRSFDriver;
    var $strCapability;
    var $strLayerName;
    var $hSRS;
    var $eGeometryType;
    var $strDialect;
    var $strFormat;
    var $strDestDataSource;
    var $nLayerCount;
    var $iDriver;
    var $astrOptions;


    // called before the test functions will be executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten 
    // here
    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strPathToOutputData = "../../ogrtests/testcase/";
        $this->strPathToStandardData = "./data/testcase/";
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->bUpdate = FALSE;
        $this->bForce = TRUE;
        $this->strCapability = ODsCCreateLayer;
        $this->strLayerName = "LayerPoint";
        $this->hSRS = null;
        $this->eGeometryType = wkbPoint;
        $this->strDialect = ""; /*"Generic SQL"*/
        $this->strFormat = "MapInfo File";
        $this->strDestDataSource = "OutputDS";
        $this->nLayerCount = 10;
        $this->hOGRSFDriver = null;
        $this->iDriver = 5;
        $this->astrOptions[0] = "FORMAT=MIF";

        if (file_exists($this->strPathToOutputData)) {
            system( "rm -R ".$this->strPathToOutputData);
        }
        mkdir($this->strPathToOutputData, 0777);


        OGRRegisterAll();

    }
    // called after the test functions are executed    
    // this function is defined in PHPUnit_Framework_TestCase and overwritten 
    // here    
    function tearDown() {
        // delete your instance
        unset($this->strPathToData);
        unset($this->strPathToOutputData);
        unset($this->strPathToStandardData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->bForce);
        unset($this->hOGRSFDriver);
        unset($this->strCapability);
        unset($this->strLayerName);
        unset($this->hSRS);
        unset($this->eGeometryType);
        unset($this->strDialect);
        unset($this->strFormat);
        unset($this->strDestDataSource);
        unset($this->nLayerCount);
        unset($this->iDriver);
        unset($this->astrOptions);
    }
/***********************************************************************
*                       testOGR_DS_TestCapability0()
************************************************************************/

    function testOGR_DS_TestCapability0() {

        $this->hOGRSFDriver = OGRGetDriver($this->iDriver);
        $hSrcDataSource =  OGR_Dr_Open($this->hOGRSFDriver,
                                               $this->strPathToData,
                                               $this->bUpdate);

        $iCapability = OGR_DS_TestCapability($hSrcDataSource,
                                             $this->strCapability);
        $this->assertTrue($iCapability,"Problem with ".
                          "OGR_DS_TestCapability():  ".$this->strCapability.
                          " is supposed to be supported." );

        OGR_DS_Destroy($hSrcDataSource);
    }

/***********************************************************************
*                       testOGR_DS_GetName0()
************************************************************************/

    function testOGR_DS_GetName0(){

        $hSrcDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        $strName = OGR_DS_GetName($hSrcDataSource);
        $expected = $this->strPathToData;
        $this->assertEquals($expected, $strName, "Problem with ".
                            "OGR_DS_GetName():  Data source name is ".
                            "supposed to be ".$this->strPathToData.".");
        OGR_DS_Destroy($hSrcDataSource);

    }
/***********************************************************************
*                       testOGR_DS_GetLayerCount0()
************************************************************************/

    function testOGR_DS_GetLayerCount0(){
        $hSrcDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);

        $nLayerCount = OGR_DS_GetLayerCount($hSrcDataSource);
        $expected = $this->nLayerCount;
        $this->assertEquals($expected, $nLayerCount, "Problem with ".
                            "OGR_DS_GetLayerCount():  Data source layers ".
                            "number is supposed to be ".$this->nLayerCount.
                            ".");
        OGR_DS_Destroy($hSrcDataSource);

    }

/***********************************************************************
*                       testOGR_DS_GetLayer0()
*                      Getting a layer by index.
************************************************************************/

    function testOGR_DS_GetLayer0(){
        $hSrcDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);

        $iLayer = 2;
        $hLayer = OGR_DS_GetLayer($hSrcDataSource, $iLayer);
        $this->assertNotNull($hLayer, "Problem with OGR_DS_GetLayer():  ".
                             "Data source layer handle ".
                             "is not supposed to be NULL.\n");
        OGR_DS_Destroy($hSrcDataSource);

    }

/***********************************************************************
*                       testOGR_DS_GetLayer1()
*               Getting a layer with an index out of range.
************************************************************************/

    function testOGR_DS_GetLayer1(){
        $hSrcDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);

        $iLayer = 500;
        $hLayer = OGR_DS_GetLayer($hSrcDataSource, $iLayer);
        $this->assertNull($hLayer, "Problem with OGR_DS_GetLayer():  ".
                                   "Data source layer handle ". 
                                   "is supposed to be NULL.\n");
        OGR_DS_Destroy($hSrcDataSource);

    }

/***********************************************************************
*                       testOGR_DS_ExecuteSQL0()
*Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
*     VERIFY DATA.
************************************************************************/
    function testOGR_DS_ExecuteSQL0(){

        $strStandardFile = "testOGR_DS_ExecuteSQL0.std";


        $hSrcDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver($this->idriver); 

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT * FROM fedlimit";

        CPLErrorReset();

        $hLayer = OGR_DS_ExecuteSQL($hSrcDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $eErrType = CPLGetLastErrorType(); 

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;
        $this->assertEquals($expected, $eErrType, "Problem with ".
                            "OGR_DS_ExecuteSQL():  ".$eErrMsg);

        $this->assertNotNull($hLayer, "Problem with OGR_DS_ExecuteSQL():  ".
                             "Data source layer is not supposed to be NULL.");

        if (!hLayer) {
            return FALSE;
        }

        $fpOut = fopen($this->strPathToOutputData.
          $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }
        OGRDumpSingleLayer($fpOut, $hLayer, $this->bForce);

        fclose($fpOut);


        OGR_DS_ReleaseResultSet($hSrcDataSource, $hLayer);

        $expected = "Unknown";

        $actual = get_resource_type($hLayer);


        $this->assertEquals($expected, $actual, "Problem with ".
                          "OGR_DS_ReleaseResultSet():  ".
                          "Layer resource is supposed to be freed ".
                          "after OGR_DS_ReleaseResultSet().\n");


        OGR_DS_Destroy($hSrcDataSource);


        system("diff --brief ".$this->strPathToOutputData.
                          $this->strTmpDumpFile.
                          " ".$this->strPathToStandardData.$strStandardFile,
                             $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                           "OGR_DS_ExecuteSQL(): ".
                           "Files comparison did not matched, ".
                           "after execution of:  ".$strSQLCommand.".");

    }

/***********************************************************************
*                       testOGR_DS_ExecuteSQL1()
*Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
*     VERIFY DATA.
************************************************************************/

    function testOGR_DS_ExecuteSQL1(){

        $strStandardFile = "testOGR_DS_ExecuteSQL1.std";

        $hSrcDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);

        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver($this->idriver); 

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT PARK_ID, REG_CODE FROM park";

        CPLErrorReset();

        $hLayer = OGR_DS_ExecuteSQL($hSrcDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $eErrType = CPLGetLastErrorType(); 

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;
        $this->assertEquals($expected, $eErrType, "Problem with ".
                            "OGR_DS_ExecuteSQL():  ".$eErrMsg);

        $this->assertNotNull($hLayer, "Problem with OGR_DS_ExecuteSQL():  ".
                             "Data source layer is not supposed to be NULL.");

        if (!hLayer) {
            return FALSE;
        }

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }
        OGRDumpSingleLayer($fpOut, $hLayer, $this->bForce);

        fclose($fpOut);

        OGR_DS_ReleaseResultSet($hSrcDataSource, $hLayer);

        OGR_DS_Destroy($hSrcDataSource);

        system("diff --brief ".$this->strPathToOutputData.
                          $this->strTmpDumpFile.
                          " ".$this->strPathToStandardData.$strStandardFile,
                          $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                           "OGR_DS_ExecuteSQL(): ".
                           "Files comparison did not matched, ".
                           "after execution of:  ".$strSQLCommand.".");

    }
/***********************************************************************
*                       testOGR_DS_ExecuteSQL2()
*Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
*     VERIFY DATA.
************************************************************************/

    function testOGR_DS_ExecuteSQL2(){

        $strStandardFile = "testOGR_DS_ExecuteSQL2.std";

        $hSrcDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver($this->idriver); 

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT * from drainage WHERE DRAINAGE_ < ".
            "10 ORDER BY DRAINAGE_ DESC";

        CPLErrorReset();

        $hLayer = OGR_DS_ExecuteSQL($hSrcDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $eErrType = CPLGetLastErrorType(); 

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;
        $this->assertEquals($expected, $eErrType, "Problem with ".
                            "OGR_DS_ExecuteSQL():  ".$eErrMsg);

        $this->assertNotNull($hLayer, "Problem with OGR_DS_ExecuteSQL():  ".
                             "Data source layer is not supposed to be NULL.");

        if (!hLayer) {
            return FALSE;
        }

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }
        OGRDumpSingleLayer($fpOut, $hLayer, $this->bForce);

        fclose($fpOut);

        OGR_DS_ReleaseResultSet($hSrcDataSource, $hLayer);

        OGR_DS_Destroy($hSrcDataSource);

        system("diff --brief ".$this->strPathToOutputData.
                          $this->strTmpDumpFile.
                          " ".$this->strPathToStandardData.$strStandardFile,
                          $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                           "OGR_DS_ExecuteSQL(): ".
                           "Files comparison did not matched, ".
                           "after execution of:  ".$strSQLCommand.".");

    }

/***********************************************************************
*                       testOGR_DS_ExecuteSQL3()
*Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
*     VERIFY DATA.
************************************************************************/

    function testOGR_DS_ExecuteSQL3(){

        $strStandardFile = "testOGR_DS_ExecuteSQL3.std";

        $hSrcDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver($this->idriver); 

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT COUNT(DISTINCT POP_RANGE) FROM popplace";

        CPLErrorReset();

        $hLayer = OGR_DS_ExecuteSQL($hSrcDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $eErrType = CPLGetLastErrorType(); 

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;
        $this->assertEquals($expected, $eErrType, "Problem with ".
                            "OGR_DS_ExecuteSQL():  ".$eErrMsg);

        $this->assertNotNull($hLayer, "Problem with OGR_DS_ExecuteSQL():  ".
                             "Data source layer is not supposed to be NULL.");

        if (!hLayer) {
            return FALSE;
        }

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }
        OGRDumpSingleLayer($fpOut, $hLayer, $this->bForce);

        fclose($fpOut);
        
        OGR_DS_ReleaseResultSet($hSrcDataSource, $hLayer);

        OGR_DS_Destroy($hSrcDataSource);

        system("diff --brief ".$this->strPathToOutputData.
                          $this->strTmpDumpFile.
                          " ".$this->strPathToStandardData.$strStandardFile,
                             $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                           "OGR_DS_ExecuteSQL(): ".
                           "Files comparison did not matched, ".
                           "after execution of:  ".$strSQLCommand.".");

    }

/***********************************************************************
*                       testOGR_DS_ExecuteSQL4()
*Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
*     VERIFY DATA.
************************************************************************/

    function testOGR_DS_ExecuteSQL4(){
        $hSrcDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver($this->idriver); 

        $hSpatialFilter = null;

        $strSQLCommand = "CREATE INDEX ON popplace USING REG_CODE";

        CPLErrorReset();

        $hLayer = @OGR_DS_ExecuteSQL($hSrcDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $eErrType = CPLGetLastErrorType(); 

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_FAILURE;
        $this->assertEquals($expected, $eErrType, "Problem with ".
                            "OGR_DS_ExecuteSQL():  Bad error code or "
                            .$eErrMsg);

        if (hLayer) {
            return FALSE;
        }

        OGR_DS_ReleaseResultSet($hSrcDataSource, $hLayer);

        OGR_DS_Destroy($hSrcDataSource);
    }

/***********************************************************************
*                       testOGR_DS_CreateLayer0()
************************************************************************/

    function testOGR_DS_CreateLayer0() {
        $this->hOGRSFDriver = OGRGetDriver($this->iDriver);

        $hDataSource = OGR_Dr_CreateDataSource($this->hOGRSFDriver, 
                                               $this->strPathToOutputData.
                                               $this->strDestDataSource,
                                               $this->astrOptions );

        $hLayer = OGR_DS_CreateLayer($hDataSource, 
                                     $this->strLayerName,
                                     $this->hSRS,
                                     $this->eGeometryType,
                                     $this->astrOptions);

        $this->assertNotNull($hLayer,"Problem with OGR_DS_CreateLayer():  ".
                             "Not able to create layer." );

        OGR_DS_Destroy($hDataSource);
    }

}
?> 
