require_once `phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRGeometryTest0 extends PHPUnit_TestCase {
    var $strPathToDumpData;
    var $strTmpDumpFile;
    var $strPathToStandardData;
    var $strPathToData;
    var $bUpdate;
    var $hDS;
    var $hLayer;
    var $strDestDataSource;
 
    function OGRGeometryTest0($name){
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
*                            testOGR_G_CreateGeometry()                       
************************************************************************/

    function testOGR_G_CreateGeometry() {
        $eType = wkbPoint;
        $hGeometry = OGR_G_CreateGeometry($eType);
        $this->AssertNotNull($hGeometry, "");
        OGR_G_DestroyGeometry($hGeometry);
        $this->AssertNull($hGeometry, "");
    }
/***********************************************************************
*                            testOGR_G_GetDimension()
************************************************************************/

    function testOGR_G_GetDimension() {
        $eType = wkbPoint;
        $hGeometry = OGR_G_CreateGeometry($eType);
        $expected = 0;
        $nDimension = OGR_G_GetDimension($hGeometry);
        $this->AssertEquals($expected, $nDimension, "");
        OGR_G_DestroyGeometry($hGeometry);
 
        $eType = wkbLineString;
        $hGeometry = OGR_G_CreateGeometry($eType);
        $expected = 1;
        $nDimension = OGR_G_GetDimension($hGeometry);
        $this->AssertEquals($expected, $nDimension, "");
        OGR_G_DestroyGeometry($hGeometry);

        $eType = wkbPolygon;
        $hGeometry = OGR_G_CreateGeometry($eType);
        $expected = 2;
        $nDimension = OGR_G_GetDimension($hGeometry);
        $this->AssertEquals($expected, $nDimension, "");
        OGR_G_DestroyGeometry($hGeometry);
       
    }

/***********************************************************************
*                            testOGR_G_GetCoordinateDimension()
************************************************************************/

    function testOGR_G_GetCoodinateDimension() {
        $eType = wkbMultiPolygon;
        $hGeometry = OGR_G_CreateGeometry($eType);
        $expected = 2;
        $nCoordinateDimension = OGR_G_GetCoordinateDimension($hGeometry);
        $this->AssertEquals($expected, $nCoordinateDimension, "");
        OGR_G_DestroyGeometry($hGeometry);
    }
/***********************************************************************
*                            testOGR_G_GetGeometryType()
************************************************************************/

    function testOGR_G_GetGeometryType() {
        $eType = wkbGeometryCollection;
        $hGeometry = OGR_G_CreateGeometry($eType);
        $expected = 7;
        $eCurrentType = OGR_G_GetGeometryType($hGeometry);
        $this->AssertEquals($expected, $eCurrentType, "");
        OGR_G_DestroyGeometry($hGeometry);
    }
/***********************************************************************
*                            testOGR_G_GetGeometryName()
************************************************************************/

    function testOGR_G_GetGeometryName() {
        $eType = wkbMultiPoint;
        $hGeometry = OGR_G_CreateGeometry($eType);
        $expected = "wkbMultiPoint";
        $strType = OGR_G_GetGeometryName($hGeometry);
        $this->AssertEquals($expected, $strType, "");
        OGR_G_DestroyGeometry($hGeometry);
    }
/***********************************************************************
*                            testOGR_G_SetGetPoint()
************************************************************************/

    function testOGR_G_SetGetPoint() {
        $eType = wkbPoint;
        $hGeometry = OGR_G_CreateGeometry($eType);
        $iPoint =0;
        $dfXIn = 123.45;
        $dfYIn = 456.78;
        $dfZIn = 0.0;
        OGR_G_SetPoint($hGeometry, $iPoint, $dfXIn, $dfYIn, $dfZIn);
        OGR_G_GetPoint($hGeometry, $iPoint, &$dfXOut, &$dfYOut, &$dfZOut);
        $this->AssertEquals($dfXIn, $dfXOut, "");
        $this->AssertEquals($dfYIn, $dfYOut, "");
        $this->AssertEquals($dfZIn, $dfZOut, "");
        OGR_G_DestroyGeometry($hGeometry);
    }
/***********************************************************************
*                            testOGR_G_AddGetxyz()
************************************************************************/

    function testOGR_G_AddGetxyz() {
        $eType = wkbLineString;
        $hGeometry = OGR_G_CreateGeometry($eType);
        OGR_G_AddPoint($hGeometry, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($hGeometry, 12.34, 45.67, 6.8);

        $iPoint =1;
        $expected = 12.34;
        $dfX = OGR_G_GetX($hGeometry, $iPoint);
        $this->AssertEquals($expected, $dfX, "");

        $iPoint =0;
        $expected = 456.78;
        $dfY = OGR_G_GetY($hGeometry, $iPoint);
        $this->AssertEquals($expected, $dfY, "");


        $iPoint =1;
        $expected = 6.8;
        $dfX = OGR_G_GetZ($hGeometry, $iPoint);
        $this->AssertEquals($expected, $dfZ, "");

        OGR_G_DestroyGeometry($hGeometry);
    }

/***********************************************************************
*                            testOGR_G_GetPointCount()
************************************************************************/

    function testOGR_G_GetPointCount() {
        $eType = wkbLineString;
        $hGeometry = OGR_G_CreateGeometry($eType);
        OGR_G_AddPoint($hGeometry, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($hGeometry, 12.34, 45.67, 6.8);

        $expected = 2;
        $nPointCount = OGR_G_GetPointCount($hGeometry);
        $this->AssertEquals($expected, $nPointCount, "");

        OGR_G_DestroyGeometry($hGeometry);
    }
/***********************************************************************
*                            testOGR_G_AddCountGeometry()
************************************************************************/

    function testOGR_G_CountGeometry() {
        $eType = wkbMultiPoint;
        $hContainer = OGR_G_CreateGeometry($eType);

        $eType = wkbPoint;
        $hGeometry1 = OGR_G_CreateGeometry($eType);
        OGR_G_AddPoint($hGeometry, 123.45, 456.78, 0.0);

        $hGeometry2 = OGR_G_CreateGeometry($eType);
        OGR_G_AddPoint($hGeometry, 12.34, 45.67, 6.8);

        $eErr = OGR_G_AddGeometry($hContainer, $hGeometry1);
        $expected = 1;
        $nGeometryCount = OGR_G_GetGeometryCount($hContainer);
        $this->AssertEquals($expected, $nGeometryCount, "");

        $eErr = OGR_G_AddGeometry($hContainer, $hGeometry2);
        $expected = 2;
        $nGeometryCount = OGR_G_GetGeometryCount($hContainer);
        $this->AssertEquals($expected, $nGeometryCount, "");

        OGR_G_DestroyGeometry($hGeometry1);
        OGR_G_DestroyGeometry($hGeometry2);
        OGR_G_DestroyGeometry($hContainer);
    }

/***********************************************************************
*                            testOGR_()
************************************************************************/

    function testOGR_() {

    }

/***********************************************************************
*                            testOGR_()
************************************************************************/

    function testOGR_() {

    }

/***********************************************************************
*                            testOGR_()
************************************************************************/

    function testOGR_() {

    }

/***********************************************************************
*                            testOGR_()
************************************************************************/

    function testOGR_() {

    }

/***********************************************************************
*                            testOGR_()
************************************************************************/

    function testOGR_() {

    }




