require_once `phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRGeometryTest1 extends PHPUnit_TestCase {
    var $hContainer;
    var $hRing1;
    var $hRing2;
 
    function OGRGeometryTest1($name){
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


    }

    function tearDown() {
        OGR_G_DestroyGeometry($this->hRing1);
        OGR_G_DestroyGeometry($this->hRing2);
        OGR_G_DestroyGeometry($this->hContainer);

        unset($this->hRing1);
        unset($this->hring2);
        unset($this->hContainer);
    }
/***********************************************************************
*                            testOGR_G_GetGeometryRef()
************************************************************************/

    function testOGR_G_GetGeometryRef() {

        $nRingCount = OGR_G_GetGeometryCount($hContainer);
        $expected = 2;
        $this->AssertEquals($expected, $nRingCount, "");

        $iGeometry = 2;
        $hGeometry = OGR_G_GetGemetryRef($this->hContainer, $iGeometry);
        
        $expected = 5;
        $nPointCount = OGR_G_GetPointCount($hGeometry);
        $this->AssertEquals($expected, $nPointCount, "");

        print hGeometry
        system diff
        $this->AssertNull($iRetValue);

        $eErr = OGR_G_AddGeometry($hContainer, $hGeometry2);
        $expected = 2;
        $nGeometryCount = OGR_G_GetGeometryCount($hContainer);
        $this->AssertEquals($expected, $nGeometryCount, "");

        OGR_G_DestroyGeometry($hGeometry);
    }
/***********************************************************************
*                            testOGR_G_RemoveGeometry()
************************************************************************/

    function testOGR_G_RemoveGeometry() {

        $bDelete = TRUE;
        $iGeometry = 1;

        $eErr = OGR_G_RemoveGeometry($this->hContainer, $iGeometry, $bDelete);

        $nRingCount = OGR_G_GetGeometryCount($hContainer);
        $expected = 1;
        $this->AssertEquals($expected, $nRingCount, "");

        print $hContainer
        system diff
        $this->AssertNull($iRetValue);

    }
/***********************************************************************
*                            testOGR_G_Equals()
************************************************************************/

    function testOGR_G_Equals() {
        $bEqual = OGR_G_Equal($this->hRing1, $this->hRing2);
        $this->AssertFalse($bEqual, "");
    }
/***********************************************************************
*                            testOGR_G_Intersect()
************************************************************************/

    function testOGR_G_Intersect() {
        $bIntersect = OGR_G_Intersect($this->hRing1, $this->hRing2);
        $this->AssertTrue($bIntersect, "");
    }
/***********************************************************************
*                            testOGR_G_Empty()
************************************************************************/

    function testOGR_G_Empty() {
        OGR_G_Empty($this->hRing2);

        print $hContainer
        system diff
        $this->AssertNull($iRetVal, "");
    }
/***********************************************************************
*                            testOGR_G_Clone()
************************************************************************/

    function testOGR_G_Clone() {
        $hGeometry = OGR_G_Clone($this->hRing1);
        bEqual = OGR_G_Equal($this->hRing1, $hGeometry);
        $this->AssertTrue($bEqual, "");

        OGR_G_DestroyGeometry($hGeometry);
    }
/***********************************************************************
*                            testOGR_G_GetEnvelope()
************************************************************************/

    function testOGR_G_GetEnvelope() {
        OGR_G_GetEnvelope($this->hContainer, $hEnvelope);

        $expected = "";
        $actual = serialize($hEnvelope);

        $this->AssertEquals($expected, $actual, "");

    }
/***********************************************************************
*                            testOGR_G_WkbSize()
************************************************************************/

    function testOGR_G_WkbSize() {
        $nSize = OGR_G_WkbSize($this->hContainer);
        $expected = 21;

        $this->AssertEquals($expected, $nSize, "");

    }

}


