<?php
require_once 'phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRDataSourceTest1 extends PHPUnit_TestCase {
    var $strPathToData;
    var $strPathToOutputData;
    var $bUpdate;
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
        $this->strFilename = "NewDataSource";
        $this->bUpdate = FALSE;
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
        unset($this->strFilename);
        unset($this->bUpdate);
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
        $hExistingDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver(5); /*MapInfo File driver.*/
        $drivername = OGR_dr_GetName($this->hOGRSFDriver);
        printf("driver =%s, drivername=%s\n", 
               $this->hOGRSFDriver, $drivername);

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT * FROM fedlimit";

        $hLayer = OGR_DS_ExecuteSQL($hExistingDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);
        $this->assertNotNull($hLayer, "Data source layer 
                            is not supposed to be NULL.\n");

/*        $hFDefn = OGR_L_GetLayerDefn($hLayer);

        printf("ogr2ogr ".OGR_DS_GetName($hExistingDataSource). 
                " ".OGR_FD_GetName($hFDefn).
               " > ./data/mif/SQLRequests/tmpOutput\n");

        system("ogrinfo -al ".OGR_DS_GetName($hExistingDataSource). 
                " ".OGR_FD_GetName($hFDefn).
               " > ./data/mif/SQLRequests/tmpOutput");

        system("ogr2ogr  ".OGR_DS_GetName($hExistingDataSource). 
                " ".OGR_FD_GetName($hFDefn).
               " > ./data/mif/SQLRequests/tmpOutput");

        OGR_DS_Destroy($hODS);
*/    
        OGR_DS_ReleaseResultSet($hExistingDataSource, $hLayer);
        $this->assertNull($hLayer, "layer 
                            is supposed to be NULL.\n");
        OGR_DS_Destroy($hExistingDataSource);
    }

    /*Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
     VERIFY DATA.*/
    function testOGR_DS_ExecuteSQL2(){
        $hExistingDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver(5); /*MapInfo File driver.*/
        $drivername = OGR_dr_GetName($this->hOGRSFDriver);
        printf("driver =%s, drivername=%s\n", 
               $this->hOGRSFDriver, $drivername);

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT AREA, DRAINAGE_ FROM drainage";

        $hLayer = OGR_DS_ExecuteSQL($hExistingDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $this->assertNotNull($hLayer, "Data source layer 
                            is not supposed to be NULL.\n");

        OGR_DS_ReleaseResultSet($hExistingDataSource, $hLayer);

        $this->assertNull($hLayer, "layer 
                            is supposed to be NULL.\n");

        OGR_DS_Destroy($hExistingDataSource);
    }

    /*Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
     VERIFY DATA.*/
    function testOGR_DS_ExecuteSQL3(){
        $hExistingDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver(5); /*MapInfo File driver.*/
        $drivername = OGR_dr_GetName($this->hOGRSFDriver);
        printf("driver =%s, drivername=%s\n", 
               $this->hOGRSFDriver, $drivername);

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT * from drainage WHERE DRAINAGE_ < ".
            "10 ORDER BY DRAINAGE_ DESC";

        $hLayer = OGR_DS_ExecuteSQL($hExistingDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $this->assertNotNull($hLayer, "Data source layer 
                            is not supposed to be NULL.\n");

        OGR_DS_ReleaseResultSet($hExistingDataSource, $hLayer);

        $this->assertNull($hLayer, "layer 
                            is supposed to be NULL.\n");

        OGR_DS_Destroy($hExistingDataSource);
    }

    /*Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
     VERIFY DATA.*/
    function testOGR_DS_ExecuteSQL4(){
        $hExistingDataSource = OGROpen($this->strPathToData, $this->bUpdate,
                                       $this->hOGRSFDriver);
        /*Temporary access to driver, bug with OGROpen() not 
          returning driver.*/
        $this->hOGRSFDriver = OGRGetDriver(5); /*MapInfo File driver.*/
        $drivername = OGR_dr_GetName($this->hOGRSFDriver);
        printf("driver =%s, drivername=%s\n", 
               $this->hOGRSFDriver, $drivername);

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT COUNT(DISTINCT POP_RANGE) FROM popplace";

        $hLayer = OGR_DS_ExecuteSQL($hExistingDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $this->assertNotNull($hLayer, "Data source layer 
                            is not supposed to be NULL.\n");

        OGR_DS_ReleaseResultSet($hExistingDataSource, $hLayer);

        $this->assertNull($hLayer, "layer 
                            is supposed to be NULL.\n");

        OGR_DS_Destroy($hExistingDataSource);
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
        printf("driver =%s, drivername=%s\n", 
               $this->hOGRSFDriver, $drivername);

        $hSpatialFilter = null;

        $strSQLCommand = "CREATE INDEX ON popplace USING REG_CODE";

        $hLayer = OGR_DS_ExecuteSQL($hExistingDataSource, $strSQLCommand,
                                    $hSpatialFilter, $this->strDialect);

        $this->assertNotNull($hLayer, "Data source layer 
                            is not supposed to be NULL.\n");

        OGR_DS_ReleaseResultSet($hExistingDataSource, $hLayer);

        $this->assertNull($hLayer, "layer 
                            is supposed to be NULL.\n");

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








