<?php

use \PHPUnit\Framework\TestCase;

class OGRDataSourceTest0 extends TestCase
{
    public $strPathToData;
    public $strPathToOutputData;
    public $strTmpDumpFile;
    public $bUpdate;
    public $bForce;
    public $hOGRSFDriver;
    public $strCapability;
    public $strLayerName;
    public $hSRS;
    public $eGeometryType;
    public $strDialect;
    public $strFormat;
    public $strDestDataSource;
    public $nLayerCount;
    public $iDriver;
    public $astrOptions;

    public static function setUpBeforeClass() : void
    {
        OGRRegisterAll();
    }

    // called before the test functions will be executed
    // this function is defined in TestCase and overwritten
    // here
    public function setUp() : void
    {
        $this->strPathToData = test_data_path('andorra', 'shp');
        $this->strPathToOutputData = create_temp_directory(__CLASS__);
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->bUpdate = false;
        $this->bForce = true;
        $this->strCapability = ODsCCreateLayer;
        $this->strLayerName = "gis_osm_places_free_1";
        $this->hSRS = null;
        $this->eGeometryType = wkbPoint;
        $this->strDialect = ""; /*"Generic SQL"*/
        $this->strFormat = "ESRI Shapefile";
        $this->strDestDataSource = "OutputDS";
        $this->nLayerCount = 18;
        $this->hOGRSFDriver = null;
        $this->iDriver = "ESRI Shapefile";
        $this->astrOptions = array();
    }
    // called after the test functions are executed
    // this function is defined in TestCase and overwritten
    // here
    public function tearDown() : void
    {
        delete_directory($this->strPathToOutputData);
        // delete your instance
        unset($this->strPathToData);
        unset($this->strPathToOutputData);
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

    public function testOGR_DS_TestCapability0()
    {
        $this->hOGRSFDriver = OGRGetDriverByName($this->iDriver);
        $hSrcDataSource = OGR_Dr_Open(
            $this->hOGRSFDriver,
            $this->strPathToData,
            true
        );

        $iCapability = OGR_DS_TestCapability(
            $hSrcDataSource,
            $this->strCapability
        );
        $this->assertTrue(
            $iCapability,
            "Problem with OGR_DS_TestCapability():  " . $this->strCapability . " is supposed to be supported."
        );

        OGR_DS_Destroy($hSrcDataSource);
    }

    /***********************************************************************
     *                       testOGR_DS_GetName0()
     ************************************************************************/

    public function testOGR_DS_GetName0()
    {
        $hSrcDataSource = OGROpen(
            $this->strPathToData,
            $this->bUpdate,
            $this->hOGRSFDriver
        );
        $strName = OGR_DS_GetName($hSrcDataSource);
        $expected = $this->strPathToData;
        $this->assertEquals(
            $expected,
            $strName,
            "Problem with OGR_DS_GetName():  Data source name is supposed to be " . $this->strPathToData . "."
        );
        OGR_DS_Destroy($hSrcDataSource);
    }

    /***********************************************************************
     *                       testOGR_DS_GetLayerCount0()
     ************************************************************************/

    public function testOGR_DS_GetLayerCount0()
    {
        $hSrcDataSource = OGROpen(
            $this->strPathToData,
            $this->bUpdate,
            $this->hOGRSFDriver
        );

        $nLayerCount = OGR_DS_GetLayerCount($hSrcDataSource);
        $expected = $this->nLayerCount;
        $this->assertEquals(
            $expected,
            $nLayerCount,
            "Problem with OGR_DS_GetLayerCount():  Data source layers number is supposed to be " . $this->nLayerCount . "."
        );
        OGR_DS_Destroy($hSrcDataSource);
    }

    /***********************************************************************
     *                       testOGR_DS_GetLayer0()
     *                      Getting a layer by index.
     ************************************************************************/

    public function testOGR_DS_GetLayer0()
    {
        $hSrcDataSource = OGROpen(
            $this->strPathToData,
            $this->bUpdate,
            $this->hOGRSFDriver
        );

        $iLayer = 2;
        $hLayer = OGR_DS_GetLayer($hSrcDataSource, $iLayer);
        $this->assertNotNull(
            $hLayer,
            "Problem with OGR_DS_GetLayer():  Data source layer handle is not supposed to be NULL.\n"
        );
        OGR_DS_Destroy($hSrcDataSource);
    }

    /***********************************************************************
     *                       testOGR_DS_GetLayer1()
     *               Getting a layer with an index out of range.
     ************************************************************************/

    public function testOGR_DS_GetLayer1()
    {
        $hSrcDataSource = OGROpen(
            $this->strPathToData,
            $this->bUpdate,
            $this->hOGRSFDriver
        );

        $iLayer = 500;
        $hLayer = OGR_DS_GetLayer($hSrcDataSource, $iLayer);
        $this->assertNull(
            $hLayer,
            "Problem with OGR_DS_GetLayer():  Data source layer handle is supposed to be NULL.\n"
        );
        OGR_DS_Destroy($hSrcDataSource);
    }

    /***********************************************************************
     *                       testOGR_DS_ExecuteSQL0()
     *Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
     *     VERIFY DATA.
     ************************************************************************/
    public function testOGR_DS_ExecuteSQL0()
    {
        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");


        $hSrcDataSource = OGROpen(
            $this->strPathToData,
            $this->bUpdate,
            $this->hOGRSFDriver
        );

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT * FROM gis_osm_places_free_1";

        CPLErrorReset();

        $hLayer = OGR_DS_ExecuteSQL(
            $hSrcDataSource,
            $strSQLCommand,
            $hSpatialFilter,
            $this->strDialect
        );

        $eErrType = CPLGetLastErrorType();

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;
        $this->assertEquals(
            $expected,
            $eErrType,
            "Problem with OGR_DS_ExecuteSQL():  " . $eErrMsg
        );

        $this->assertNotNull(
            $hLayer,
            "Problem with OGR_DS_ExecuteSQL():  Data source layer is not supposed to be NULL."
        );

        if (!$hLayer) {
            return false;
        }

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        if ($fpOut == false) {
            printf("Dump file creation error\n");
            return false;
        }
        OGRDumpSingleLayer($fpOut, $hLayer, $this->bForce);

        fclose($fpOut);


        OGR_DS_ReleaseResultSet($hSrcDataSource, $hLayer);

        $expected = "Unknown";

        $actual = get_resource_type($hLayer);


        $this->assertEquals(
            $expected,
            $actual,
            "Problem with OGR_DS_ReleaseResultSet():  Layer resource is supposed to be freed after OGR_DS_ReleaseResultSet().\n"
        );


        OGR_DS_Destroy($hSrcDataSource);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_DS_ExecuteSQL(): Files comparison did not matched, after execution of:  " . $strSQLCommand . "."
        );
    }

    /***********************************************************************
     *                       testOGR_DS_ExecuteSQL1()
     *Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
     *     VERIFY DATA.
     ************************************************************************/

    public function testOGR_DS_ExecuteSQL1()
    {
        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        $hSrcDataSource = OGROpen(
            $this->strPathToData,
            $this->bUpdate,
            $this->hOGRSFDriver
        );

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT fclass,name FROM gis_osm_places_free_1";

        CPLErrorReset();

        $hLayer = OGR_DS_ExecuteSQL(
            $hSrcDataSource,
            $strSQLCommand,
            $hSpatialFilter,
            $this->strDialect
        );

        $eErrType = CPLGetLastErrorType();

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;
        $this->assertEquals(
            $expected,
            $eErrType,
            "Problem with OGR_DS_ExecuteSQL():  " . $eErrMsg
        );

        $this->assertNotNull(
            $hLayer,
            "Problem with OGR_DS_ExecuteSQL():  Data source layer is not supposed to be NULL."
        );

        if (!$hLayer) {
            return false;
        }

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        if ($fpOut == false) {
            printf("Dump file creation error\n");
            return false;
        }
        OGRDumpSingleLayer($fpOut, $hLayer, $this->bForce);

        fclose($fpOut);

        OGR_DS_ReleaseResultSet($hSrcDataSource, $hLayer);

        OGR_DS_Destroy($hSrcDataSource);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_DS_ExecuteSQL(): Files comparison did not matched, after execution of:  " . $strSQLCommand . "."
        );
    }

    /***********************************************************************
     *                       testOGR_DS_ExecuteSQL2()
     *Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
     *     VERIFY DATA.
     ************************************************************************/

    public function testOGR_DS_ExecuteSQL2()
    {
        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        $hSrcDataSource = OGROpen(
            $this->strPathToData,
            $this->bUpdate,
            $this->hOGRSFDriver
        );

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT * FROM gis_osm_places_free_1 WHERE code < 1004 ORDER BY code DESC, name ASC";

        CPLErrorReset();

        $hLayer = OGR_DS_ExecuteSQL(
            $hSrcDataSource,
            $strSQLCommand,
            $hSpatialFilter,
            $this->strDialect
        );

        $eErrType = CPLGetLastErrorType();

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;
        $this->assertEquals(
            $expected,
            $eErrType,
            "Problem with OGR_DS_ExecuteSQL():  " . $eErrMsg
        );

        $this->assertNotNull(
            $hLayer,
            "Problem with OGR_DS_ExecuteSQL():  Data source layer is not supposed to be NULL."
        );

        if (!$hLayer) {
            return false;
        }

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        if ($fpOut == false) {
            printf("Dump file creation error\n");
            return false;
        }
        OGRDumpSingleLayer($fpOut, $hLayer, $this->bForce);

        fclose($fpOut);

        OGR_DS_ReleaseResultSet($hSrcDataSource, $hLayer);

        OGR_DS_Destroy($hSrcDataSource);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_DS_ExecuteSQL(): Files comparison did not matched, after execution of:  " . $strSQLCommand . "."
        );
    }

    /***********************************************************************
     *                       testOGR_DS_ExecuteSQL3()
     *Getting a layer by a SQL request.  TO COME BACK TO.  FIND A WAY TO
     *     VERIFY DATA.
     ************************************************************************/

    public function testOGR_DS_ExecuteSQL3()
    {
        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        $hSrcDataSource = OGROpen(
            $this->strPathToData,
            $this->bUpdate,
            $this->hOGRSFDriver
        );

        $hSpatialFilter = null;

        $strSQLCommand = "SELECT COUNT(DISTINCT fclass) FROM gis_osm_places_free_1";

        CPLErrorReset();

        $hLayer = OGR_DS_ExecuteSQL(
            $hSrcDataSource,
            $strSQLCommand,
            $hSpatialFilter,
            $this->strDialect
        );

        $eErrType = CPLGetLastErrorType();

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;
        $this->assertEquals(
            $expected,
            $eErrType,
            "Problem with OGR_DS_ExecuteSQL():  " . $eErrMsg
        );

        $this->assertNotNull(
            $hLayer,
            "Problem with OGR_DS_ExecuteSQL():  Data source layer is not supposed to be NULL."
        );

        if (!$hLayer) {
            return false;
        }

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        if ($fpOut == false) {
            printf("Dump file creation error\n");
            return false;
        }
        OGRDumpSingleLayer($fpOut, $hLayer, $this->bForce);

        fclose($fpOut);

        OGR_DS_ReleaseResultSet($hSrcDataSource, $hLayer);

        OGR_DS_Destroy($hSrcDataSource);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_DS_ExecuteSQL(): Files comparison did not matched, after execution of:  " . $strSQLCommand . "."
        );
    }

    /***********************************************************************
     *                       testOGR_DS_CreateLayer0()
     ************************************************************************/

    public function testOGR_DS_CreateLayer0()
    {
        $this->hOGRSFDriver = OGRGetDriverByName($this->iDriver);
        $hDataSource = OGR_Dr_CreateDataSource(
            $this->hOGRSFDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            $this->astrOptions
        );

        $hLayer = OGR_DS_CreateLayer(
            $hDataSource,
            $this->strLayerName,
            $this->hSRS,
            $this->eGeometryType,
            $this->astrOptions
        );

        $this->assertNotNull(
            $hLayer,
            "Problem with OGR_DS_CreateLayer():  Not able to create layer."
        );

        OGR_DS_Destroy($hDataSource);
    }
}
