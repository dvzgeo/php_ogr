require_once `phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRFeatureDefnTest0 extends PHPUnit_TestCase {
    var $hContainer;
 
    function OGRFeatureDefnTest0($name){
        $this->PHPUnit_TestCase($name);	
    }

    function setUp() {


    }

    function tearDown() {
        unset($this->hContainer);
    }
/***********************************************************************
*                            testOGR_FD_CreateDestroy()
************************************************************************/

    function testOGR_FD_CreateDestroy() {
        $strNameIn = "Lake";
        $hFeatureDefn = OGR_FD_Create($strNameIn);
        $this->AssertNotNull($hFeatureDefn, "");

        OGR_FD_Destroy($hFeatureDefn);
        $this->AssertNull($hFeatureDefn, "");
    }
/***********************************************************************
*                            testOGR_FD_GetName()
************************************************************************/

    function testOGR_FD_GetName() {
        $strNameIn = "Lake";
        $hFeatureDefn = OGR_FD_Create($strNameIn);
        $strNameOut = OGR_FD_GetName($hFeatureDefn);
        $expected = strcpy($strNameIn);
        $this->AssertEquals($expected, $strNameOut, "");

        OGR_FD_Destroy($hFeatureDefn);
    }

/***********************************************************************
*                            testOGR_FD_GetName()
************************************************************************/

    function testOGR_FD_GetName() {
        $strName = "Lake";
        $hFeatureDefn = OGR_FD_Create($strName);

        $strFieldName = "name";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTString);

        OGR_FD_AddFieldDefn($hFeatureDefn, $hFieldDefn);

        $strName = "area";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTReal);

        OGR_FD_AddFieldDefn($hFeatureDefn, $hFieldDefn);

        $iField = 0;
        hFieldDefn = OGR_FD_GetFieldDefn($hFeaatureDefn, $iField);
        $strFieldName = OGR_Fld_GetNameRef(hFieldDefn);

        $expected = strcpy($strFieldName);
        $this->AssertEquals($expected, $strFieldName, "");

        OGR_FD_Destroy($hFieldDefn);
        OGR_FD_Destroy($hFeatureDefn);
    }
}









