<?php
require_once 'phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRDataSourceTest1 extends PHPUnit_TestCase {
    var $strPathToData;
    var $strPathToOutputData;
    var $strPathToStandardData;
    var $strPathToDumpData;
    var $strTmpDumpFile;
    var $bUpdate;
    var $bForce;
    var $hOGRSFDriver;
    var $strFilename;
    var $strCapability;
    var $strLayerName;
    var $hSRS;
    var $eGeometryType;
    var $strDialect;
    var $strFormat;
    var $strDestDataSource;

    // constructor of the test suite
    function OGRDataSourceTest1($name){
        $this->PHPUnit_TestCase($name);
    }
    // called before the test functions will be executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here
    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strPathToOutputData = "../../ogrtests/testcase/";
        $this->strPathToStandardData = "./data/testcase/";
        $this->strPathToDumpData = "../../ogrtests/testcase/";
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->strFilename = "NewDataSource";
        $this->bUpdate = FALSE;
        $this->bForce = TRUE;
        $this->strCapability = ODsCCreateLayer;
        $this->strLayerName = "LayerPoint";
        $this->hSRS = null;
        $this->eGeometryType = wkbPoint;
        $this->strDialect = ""; /*"Generic SQL"*/
        $this->strFormat = "MapInfo File";
        $this->strDestDataSource = "Output";
    }
    // called after the test functions are executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here    
    function tearDown() {
        // delete your instance
        unset($this->strPathToData);
        unset($this->strPathToOutputData);
        unset($this->strPathToStandardData);
        unset($this->strPathToDumpData);
        unset($this->strTmpDumpFile);
        unset($this->strFilename);
        unset($this->bUpdate);
        unset($this->bForce);
        unset($this->strCapability);
        unset($this->strLayerName);
        unset($this->hSRS);
        unset($this->eGeometryType);
        unset($this->strFormat);
        unset($this->strDestDataSource);
    }

    /*Testing data source capability*/
    function testOGR_DS_TestCapability1() {
        OGRRegisterAll();
        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                               $this->strPathToData,
                                               $this->bUpdate);
        $iCapability = OGR_DS_TestCapability($hExistingDataSource,
                                             $this->strCapability);
        $this->assertTrue($iCapability,"Capability is supposed to be".
                          " supported" );

        OGR_DS_Destroy($hExistingDataSource);
    }


    /*Getting data source name*/
    function testOGR_DS_GetName1(){

        $hExistingDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $hOGRSFDriver);
        $strName = OGR_DS_GetName($hExistingDataSource);
        $expected = "./data/mif";
        $this->assertEquals($strName, $expected, "Data source name is not".
                            " what is expected\n" );
        OGR_DS_Destroy($hExistingDataSource);

    }

    /*Getting data source layers number.*/
    function testOGR_DS_GetLayerCount1(){
        $hExistingDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $hOGRSFDriver);
        $nLayerCount = OGR_DS_GetLayerCount($hExistingDataSource);
        $expected = 10;
        $this->assertEquals($nLayerCount, $expected, "Data source layers 
                            number is to be ten\n");
        OGR_DS_Destroy($hExistingDataSource);

    }

    /*Getting a layer by index.*/
    function testOGR_DS_GetLayer1(){
        $hExistingDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $hOGRSFDriver);
        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 2);
        $this->assertNotNull($hLayer, "Data source layer 
                            is not supposed to be NULL.\n");
        OGR_DS_Destroy($hExistingDataSource);

    }

    /*Getting a layer with an index out of range.*/
    function testOGR_DS_GetLayer2(){
        $hExistingDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $hOGRSFDriver);
        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 500);
        $this->assertNull($hLayer, "Data source layer 
                            is supposed to be NULL.\n");
        OGR_DS_Destroy($hExistingDataSource);

    }

    /*Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
     VERIFY DATA.*/
    function testOGR_DS_ExecuteSQL1(){

        $strStandardFile = "testOGR_DS_ExecuteSQL1.std";


        $hExistingDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver(5); /*MapInfo File driver.*/
        $drivername = OGR_dr_GetName($this->hOGRSFDriver);

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT * FROM fedlimit";

        CPLErrorReset();

        $hLayer = OGR_DS_ExecuteSQL($hExistingDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $eErrType = CPLGetLastErrorType(); 

        $eErrMsg = CPLGetLastErrorMsg();


        $this->assertEquals($OGRERR_NONE, $eErrType, $eErrMsg);

        $this->assertNotNull($hLayer, "Data source layer 
                            is not supposed to be NULL.\n");

        if (!hLayer) {
            return FALSE;
        }


        $fpOut = fopen($this->strPathToDumpData.
          $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }
        OGRDumpSingleLayer($fpOut, $hLayer, $this->bForce);

        fclose($fpOut);

        OGR_DS_ReleaseResultSet($hExistingDataSource, $hLayer);

        $this->assertNull($hLayer, "layer is supposed to be NULL ".
                          "after OGR_DS_ReleaseResultSet().\n");

        OGR_DS_Destroy($hExistingDataSource);

        system("diff --brief ".$this->strPathToDumpData.
                          $this->strTmpDumpFile.
                          " ".$this->strPathToStandardData.$strStandardFile,
                             $iRetval);

        printf("retval = %d\n", $iRetval);

        $this->assertFalse($iRetval, "Files have changed.\n");

    }

    /*Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
     VERIFY DATA.*/
    function testOGR_DS_ExecuteSQL2(){

        $strStandardFile = "testOGR_DS_ExecuteSQL2.std";

        $hExistingDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver(5); /*MapInfo File driver.*/
        $drivername = OGR_dr_GetName($this->hOGRSFDriver);

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT PARK_ID, REG_CODE FROM park";

        CPLErrorReset();

        $hLayer = OGR_DS_ExecuteSQL($hExistingDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $eErrType = CPLGetLastErrorType(); 

        $eErrMsg = CPLGetLastErrorMsg();


        $this->assertEquals($OGRERR_NONE, $eErrType, $eErrMsg);

        $this->assertNotNull($hLayer, "Data source layer 
                            is not supposed to be NULL.\n");

        if (!hLayer) {
            return FALSE;
        }

        $fpOut = fopen($this->strPathToDumpData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }
        OGRDumpSingleLayer($fpOut, $hLayer, $this->bForce);

        fclose($fpOut);

        OGR_DS_ReleaseResultSet($hExistingDataSource, $hLayer);

        OGR_DS_Destroy($hExistingDataSource);

        system("diff --brief ".$this->strPathToDumpData.
                          $this->strTmpDumpFile.
                          " ".$this->strPathToStandardData.$strStandardFile,
                             $iRetval);

        printf("retval = %d\n", $iRetval);

        $this->assertFalse($iRetval, "Files have changed.\n");

    }

    /*Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
     VERIFY DATA.*/
    function testOGR_DS_ExecuteSQL3(){

        $strStandardFile = "testOGR_DS_ExecuteSQL3.std";

        $hExistingDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver(5); /*MapInfo File driver.*/
        $drivername = OGR_dr_GetName($this->hOGRSFDriver);

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT * from drainage WHERE DRAINAGE_ < ".
            "10 ORDER BY DRAINAGE_ DESC";

        CPLErrorReset();

        $hLayer = OGR_DS_ExecuteSQL($hExistingDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $eErrType = CPLGetLastErrorType(); 

        $eErrMsg = CPLGetLastErrorMsg();

        $this->assertEquals($OGRERR_NONE, $eErrType, $eErrMsg);

        $this->assertNotNull($hLayer, "Data source layer 
                            is not supposed to be NULL.\n");


        if (!hLayer) {
            return FALSE;
        }

        $fpOut = fopen($this->strPathToDumpData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }
        OGRDumpSingleLayer($fpOut, $hLayer, $this->bForce);

        fclose($fpOut);

        OGR_DS_ReleaseResultSet($hExistingDataSource, $hLayer);

        OGR_DS_Destroy($hExistingDataSource);

        system("diff --brief ".$this->strPathToDumpData.
                          $this->strTmpDumpFile.
                          " ".$this->strPathToStandardData.$strStandardFile,
                             $iRetval);

        printf("retval = %d\n", $iRetval);

        $this->assertFalse($iRetval, "Files have changed.\n");

    }

    /*Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
     VERIFY DATA.*/
    function testOGR_DS_ExecuteSQL4(){

        $strStandardFile = "testOGR_DS_ExecuteSQL4.std";

        $hExistingDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver(5); /*MapInfo File driver.*/
        $drivername = OGR_dr_GetName($this->hOGRSFDriver);

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT COUNT(DISTINCT POP_RANGE) FROM popplace";

        CPLErrorReset();

        $hLayer = OGR_DS_ExecuteSQL($hExistingDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $eErrType = CPLGetLastErrorType(); 
        printf("errtype=%d\n",$eErrType);
        $eErrMsg = CPLGetLastErrorMsg();
        printf("errmsg=%s\n",$eErrMsg);

        $this->assertEquals($OGRERR_NONE, $eErrType, $eErrMsg);

        $this->assertNotNull($hLayer, "Data source layer 
                            is not supposed to be NULL.\n");

        if (!hLayer) {
            return FALSE;
        }

        $fpOut = fopen($this->strPathToDumpData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }
        OGRDumpSingleLayer($fpOut, $hLayer, $this->bForce);

        fclose($fpOut);
        
        OGR_DS_ReleaseResultSet($hExistingDataSource, $hLayer);

        OGR_DS_Destroy($hExistingDataSource);

        system("diff --brief ".$this->strPathToDumpData.
                          $this->strTmpDumpFile.
                          " ".$this->strPathToStandardData.$strStandardFile,
                             $iRetval);

        printf("retval = %d\n", $iRetval);

        $this->assertFalse($iRetval, "Files have changed.\n");

    }

    /*Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
     VERIFY DATA.*/
    function testOGR_DS_ExecuteSQL5(){
        $hExistingDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver(5); /*MapInfo File driver.*/
        $drivername = OGR_dr_GetName($this->hOGRSFDriver);

        $hSpatialFilter = null;

        $strSQLCommand = "CREATE INDEX ON popplace USING REG_CODE";

        CPLErrorReset();

        $hLayer = @OGR_DS_ExecuteSQL($hExistingDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $eErrType = CPLGetLastErrorType(); 

        $eErrMsg = CPLGetLastErrorMsg();
 
        $expected = 3;

        $this->assertEquals($expected, $eErrType, $eErrMsg);

        $this->assertNull($hLayer, "Statement command 
                            is not supported by this driver.\n");

        if (hLayer) {
            return FALSE;
        }

        OGR_DS_ReleaseResultSet($hExistingDataSource, $hLayer);

        OGR_DS_Destroy($hExistingDataSource);
    }

    /*Creating data source layer.*/
    function testOGR_DS_CreateLayer1() {
        system( "rm -R ".$this->strPathToOutputData.$this->strFilename);
        $hDriver = OGRGetDriver(5);
        $astrOptions[0] = "FORMAT=MIF";
        $hDataSource = OGR_Dr_CreateDataSource($hDriver, 
                                               $this->strPathToOutputData.
                                               $this->strFilename,
                                               $astrOptions );

        $hLayer = OGR_DS_CreateLayer($hDataSource, 
                                     $this->strLayerName,
                                     $this->hSRS,
                                     $this->eGeometryType,
                                     $astrOptions);

        $this->assertNotNull($hLayer,"Not able to create layer\n" );

        OGR_DS_Destroy($hDataSource);
    }

}
?> 
