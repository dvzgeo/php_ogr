require_once `phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRFieldDefnTest0 extends PHPUnit_TestCase {

    function OGRFieldDefnTest0($name){
        $this->PHPUnit_TestCase($name);	
    }

    function setUp() {

    }

    function tearDown() {
    }
/***********************************************************************
*                            testOGR_Fld_CreateDestroy()
************************************************************************/

    function testOGR_Fld_CreateDestroy() {
        $strFieldName = "name";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTString);
        $this->AssertNotNull($hFieldDefn, "");

        OGR_Fld_Destroy($hFieldDefn);
        $this->AssertNull($hFieldDefn, "");
    }
/***********************************************************************
*                            testOGR_Fld_SetGetName()
************************************************************************/

    function testOGR_Fld_SetGetName() {
        $strFieldName = "name";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTString);
        $strFieldNameOut = OGR_Fld_GetNameRef($hFieldDefn);
        $expected = strcpy($strFieldName);
        $this->AssertEquals($expected, $strFieldNameOut, "");

        $strFieldNameIn = "area";
        OGR_Fld_SetName($hFieldDefn, $strFieldNameIn);
        $strFieldNameOut = OGR_Fld_GetNameRef($hFieldDefn);
        $expected = strcpy($strFieldNameIn);
        $this->AssertEquals($expected, $strFieldNameOut, "");


        OGR_Fld_Destroy($hFieldDefn);
    }
/***********************************************************************
*                            testOGR_Fld_SetGetType()
************************************************************************/

    function testOGR_Fld_SetGetType() {
        $strFieldName = "name";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTString);
        $eFieldTypeOut = OGR_Fld_GetType($hFieldDefn);
        $expected = OFTString;
        $this->AssertEquals($expected, $eFieldTypeOut, "");

        $eFieldTypeIn = OFTReal;
        OGR_Fld_SetType($hFieldDefn, $eFieldTypeIn);
        $eFieldTypeOut = OGR_Fld_GetType($hFieldDefn);
        $expected = $eFieldTypeIn;
        $this->AssertEquals($expected, $eFieldTypeOut, "");


        OGR_Fld_Destroy($hFieldDefn);
    }
/***********************************************************************
*                            testOGR_Fld_SetGetJustify()
************************************************************************/

    function testOGR_Fld_SetGetJustify() {
        $strFieldName = "name";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTString);
        $eJustifyOut = OGR_Fld_GetJustify($hFieldDefn);
        $expected = OJUndefined;
        $this->AssertEquals($expected, $eJustifyOut, "");

        $eJustifyIn = OJRight;
        OGR_Fld_SetJustify($hFieldDefn, $eJustifyIn);
        $eJustifyOut = OGR_Fld_GetJustify($hFieldDefn);
        $expected = $eJustifyIn;
        $this->AssertEquals($expected, $eJustifyOut, "");


        OGR_Fld_Destroy($hFieldDefn);
    }
/***********************************************************************
*                            testOGR_Fld_SetGetWidth()
************************************************************************/

    function testOGR_Fld_SetGetWidth() {
        $strFieldName = "name";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTString);
        $nWidthOut = OGR_Fld_GetWidth($hFieldDefn);
        $expected = 0;
        $this->AssertEquals($expected, $nWidthOut, "");

        $nWidthIn = 10;
        OGR_Fld_SetWidth($hFieldDefn, $nWidthIn);
        $nWidthOut = OGR_Fld_GetWidth($hFieldDefn);
        $expected = $nWidthIn;
        $this->AssertEquals($expected, $nWidthOut, "");


        OGR_Fld_Destroy($hFieldDefn);
    }
/***********************************************************************
*                            testOGR_Fld_SetGetPrecision()
************************************************************************/

    function testOGR_Fld_SetGetPrecision() {
        $strFieldName = "area";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTReal);
        $nPrecisionOut = OGR_Fld_GetPrecision($hFieldDefn);
        $expected = 2;
        $this->AssertEquals($expected, $nPrecisionOut, "");

        $nPrecisionIn = 1;
        OGR_Fld_SetPrecision($hFieldDefn, $nPrecisionIn);
        $nPrecisionOut = OGR_Fld_GetPrecision($hFieldDefn);
        $expected = $nPrecisionIn;
        $this->AssertEquals($expected, $nPrecisionOut, "");


        OGR_Fld_Destroy($hFieldDefn);
    }
/***********************************************************************
*                            testOGR_Fld_Set()
************************************************************************/

    function testOGR_Fld_SetGetPrecision() {
        $strFieldName = "area";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTReal);

        $strFieldNameIn = "perimeter";
        $eFieldTypeIn = OFTReal;
        $nWidthIn = 5;
        $nPrecisionIn = 2;
        $eJustifyIn = OJLeft;

        OGR_Fld_Set($hFieldDefn, $strNameIn, eTypeIn, nWidhtIn, 
                    nPrecisionIn, eJustifyIn);


        $strFieldNameOut = OGR_Fld_GetNameRef($hFieldDefn);
        $expected = strcpy($strFieldNameIn);
        $this->AssertEquals($expected, $strFieldNameOut, "");

        $eFieldTypeOut = OGR_Fld_GetType($hFieldDefn);
        $expected = $eFieldTypeIn;
        $this->AssertEquals($expected, $eFieldTypeOut, "");

        $nWidthOut = OGR_Fld_GetWidth($hFieldDefn);
        $expected = $nWidthIn;
        $this->AssertEquals($expected, $nWidthOut, "");

        $nPrecisionOut = OGR_Fld_GetPrecision($hFieldDefn);
        $expected = 2;
        $this->AssertEquals($expected, $nPrecisionOut, "");

        $eJustifyOut = OGR_Fld_GetJustify($hFieldDefn);
        $expected = $eJustifyIn;
        $this->AssertEquals($expected, $eJustifyOut, "");

        OGR_Fld_Destroy($hFieldDefn);
    }
/***********************************************************************
*                            testOGR_GetFieldTypeName()
************************************************************************/

    function testOGR_GetFieldTypeName() {
        $strFieldTypeName = OGR_GetFieldTypeName(OFTReal);
        $expected = "OFTReal";
        $this->AssertEquals($expected, $strFieldTypeName, "");
    }
/***********************************************************************
*                            testOGR_Fld_()
************************************************************************/

    function testOGR_Fld_() {


    }
/***********************************************************************
*                            testOGR_Fld_()
************************************************************************/

    function testOGR_Fld_() {


    }
/***********************************************************************
*                            testOGR_Fld_()
************************************************************************/

    function testOGR_Fld_() {


    }

}


