require_once `phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRFeatureDefnTest0 extends PHPUnit_TestCase {
    var $hFieldDefn;
    var $hFeatureDefn;
 
    function OGRFeatureDefnTest0($name){
        $this->PHPUnit_TestCase($name);	
    }

    function setUp() {
        $strName = "Lake";
        $hFeatureDefn = OGR_FD_Create($strName);

        $strFieldName = "name";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTString);

        OGR_FD_AddFieldDefn($hFeatureDefn, $hFieldDefn);

        $strName = "area";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTReal);

        OGR_FD_AddFieldDefn($hFeatureDefn, $hFieldDefn);

    }

    function tearDown() {
        unset($this->hFieldDefn);
        unset($this->hFeatureDefn);
        OGR_FD_Destroy($hFieldDefn);
        OGR_FD_Destroy($hFeatureDefn);

    }

/***********************************************************************
*                            testOGR_FD_GetFieldCount()
************************************************************************/

    function testOGR_FD_GetFieldCount() {
        $nFieldCount = OGR_FD_GetFieldCount($this->hFeatureDefn);
        $expected = 2;
        $this->AssertEquals($expected, $nFieldCount, "");

    }
/***********************************************************************
*                            testOGR_FD_GetFieldIndex()
************************************************************************/

    function testOGR_FD_GetFieldIndex() {
        $strFieldName = "area";
        $iField = OGR_FD_GetFieldIndex($this->hFeatureDefn, $strFieldName);
        $expected = 2;
        $this->AssertEquals($expected, $iField, "");

    }
/***********************************************************************
*                            testOGR_FD_SetGetGeomType()
************************************************************************/

    function testOGR_FD_SetGetGeomType() {
        $eTypeIn = wkbLineString;
        OGR_FD_SetGeomType($this->hFeatureDefn, $eTypeIn);

        $eType = OGR_FD_GetGeomType($this->hFeatureDefn);
        $expected = wkbLineString;
        $this->AssertEquals($expected, $eType, "");

    }
/***********************************************************************
*                            testOGR_FD_GetReferenceCount()
************************************************************************/

    function testOGR_FD_GetReferenceCount() {
        $nFeatureCount = OGR_FD_GetReferenceCount($this->hFeatureDefn);
        $expected = 0;
        $this->AssertEquals($expected, $nFeatureCount, "");
        
        $hFeature = OGR_F_Create($this->hFeatureDefn);
        $expected = 1;
        $this->AssertEquals($expected, $nFeatureCount, "");
        OGR_F_Destroy($hFeature);

        $hFeature = OGR_F_Create($this->hFeatureDefn);
        $expected = 2;
        $this->AssertEquals($expected, $nFeatureCount, "");
        OGR_F_Destroy($hFeature);
    }
/***********************************************************************
*                            testOGR_FD_GetReference()
************************************************************************/

    function testOGR_FD_GetReference() {
        $nFeatureCount = OGR_FD_GetReferenceCount($this->hFeatureDefn);
        $expected = 0;
        $this->AssertEquals($expected, $nFeatureCount, "");
        
        $nFeatureCount = OGR_FD_Reference($hFeatureDefn);
        $expected = 1;
        $this->AssertEquals($expected, $nFeatureCount, "");

        $nFeatureCount = OGR_FD_GetReferenceCount($this->hFeatureDefn);
        $expected = 1;
        $this->AssertEquals($expected, $nFeatureCount, "");

        $nFeatureCount = OGR_FD_Reference($hFeatureDefn);
        $expected = 2;
        $this->AssertEquals($expected, $nFeatureCount, "");

        $nFeatureCount = OGR_FD_Dereference($hFeatureDefn);
        $expected = 1;
        $this->AssertEquals($expected, $nFeatureCount, "");

    }

}








