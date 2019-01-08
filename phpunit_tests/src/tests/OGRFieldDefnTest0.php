<?php

class OGRFieldDefnTest0 extends PHPUnit_Framework_TestCase {

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
        $this->AssertNotNull($hFieldDefn, "Problem with OGR_Fld_Create(): ".
                             "handle is not supposed to be NULL.");

        OGR_Fld_Destroy($hFieldDefn);

        $expected = "Unknown";

        $actual = get_resource_type($hFieldDefn);

        $this->assertEquals($expected, $actual, "Problem with ".
                          "OGR_Fld_Destroy():  ".
                          "Field definition resource is supposed to be freed ".
                          "after OGR_Fld_Destroy().\n");
    }
/***********************************************************************
*                            testOGR_Fld_SetGetName()
************************************************************************/

    function testOGR_Fld_SetGetName() {
        $strFieldName = "name";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTString);

        $strFieldNameOut = OGR_Fld_GetNameRef($hFieldDefn);
        $expected = $strFieldName;

        $this->AssertEquals($expected, $strFieldNameOut, "Problem with ".
                            "OGR_Fld_GetNameRef().");

        $strFieldNameIn = "area";
        OGR_Fld_SetName($hFieldDefn, $strFieldNameIn);

        $strFieldNameOut = OGR_Fld_GetNameRef($hFieldDefn);

        $expected = $strFieldNameIn;
        $this->AssertEquals($expected, $strFieldNameOut, "Problem with ".
                            "OGR_Fld_SetName() or OGR_Fld_GetNameRef().");

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
        $this->AssertEquals($expected, $eFieldTypeOut, "Problem with ".
                            "OGR_Fld_GetType()");

        $eFieldTypeIn = OFTReal;
        OGR_Fld_SetType($hFieldDefn, $eFieldTypeIn);

        $eFieldTypeOut = OGR_Fld_GetType($hFieldDefn);
        $expected = $eFieldTypeIn;
        $this->AssertEquals($expected, $eFieldTypeOut, "Problem with ".
                            "OGR_Fld_SetType() or OGR_Fld_GetType().");

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
        $this->AssertEquals($expected, $eJustifyOut, "Problem with ".
                         "OGR_Fld_GetJustify().");

        $eJustifyIn = OJRight;
        OGR_Fld_SetJustify($hFieldDefn, $eJustifyIn);

        $eJustifyOut = OGR_Fld_GetJustify($hFieldDefn);
        $expected = $eJustifyIn;
        $this->AssertEquals($expected, $eJustifyOut, "Problem with ".
                            "OGR_Fld_SetJustify() or OGR_Fld_GetJustify().");

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
        $this->AssertEquals($expected, $nWidthOut, "Problem with ".
                            "OGR_Fld_GetWidth().");

        $nWidthIn = 10;
        OGR_Fld_SetWidth($hFieldDefn, $nWidthIn);

        $nWidthOut = OGR_Fld_GetWidth($hFieldDefn);
        $expected = $nWidthIn;
        $this->AssertEquals($expected, $nWidthOut, "Problem with ".
                            "OGR_Fld_SetWidth() or OGR_Fld_GetWidth().");

        OGR_Fld_Destroy($hFieldDefn);
    }
/***********************************************************************
*                            testOGR_Fld_SetGetPrecision()
************************************************************************/

    function testOGR_Fld_SetGetPrecision() {
        $strFieldName = "area";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTReal);

        $nPrecisionOut = OGR_Fld_GetPrecision($hFieldDefn);
        $expected = 0;
        $this->AssertEquals($expected, $nPrecisionOut, "Problem with ".
                            "OGR_Fld_GetPrecision().");

        $nPrecisionIn = 1;
        OGR_Fld_SetPrecision($hFieldDefn, $nPrecisionIn);

        $nPrecisionOut = OGR_Fld_GetPrecision($hFieldDefn);
        $expected = $nPrecisionIn;
        $this->AssertEquals($expected, $nPrecisionOut, "Problem with ".
                            "OGR_Fld_SetPrecision() or OGR_Fld_GetPrecision().");

        OGR_Fld_Destroy($hFieldDefn);
    }
/***********************************************************************
*                            testOGR_Fld_Set()
************************************************************************/

    function testOGR_Fld_Set() {
        $strFieldName = "area";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTReal);

        $strFieldNameIn = "perimeter";
        $eFieldTypeIn = OFTReal;
        $nWidthIn = 5;
        $nPrecisionIn = 2;
        $eJustifyIn = OJLeft;

        OGR_Fld_Set($hFieldDefn, $strFieldNameIn, $eFieldTypeIn, $nWidthIn, 
                    $nPrecisionIn, $eJustifyIn);


        $strFieldNameOut = OGR_Fld_GetNameRef($hFieldDefn);
        $expected = $strFieldNameIn;
        $this->AssertEquals($expected, $strFieldNameOut, "Problem with ".
                            "OGR_Fld_Set() on Name.");

        $eFieldTypeOut = OGR_Fld_GetType($hFieldDefn);
        $expected = $eFieldTypeIn;
        $this->AssertEquals($expected, $eFieldTypeOut, "Problem with ".
                            "OGR_Fld_Set() on Type.");

        $nWidthOut = OGR_Fld_GetWidth($hFieldDefn);
        $expected = $nWidthIn;
        $this->AssertEquals($expected, $nWidthOut, "Problem with ".
                            "OGR_Fld_Set() on Width.");

        $nPrecisionOut = OGR_Fld_GetPrecision($hFieldDefn);
        $expected = 2;
        $this->AssertEquals($expected, $nPrecisionOut, "Problem with ".
                            "OGR_Fld_Set() on Precision.");


        $eJustifyOut = OGR_Fld_GetJustify($hFieldDefn);
        $expected = $eJustifyIn;
        $this->AssertEquals($expected, $eJustifyOut, "Problem with ".
                            "OGR_Fld_Set() on Justification.");


        OGR_Fld_Destroy($hFieldDefn);
    }
/***********************************************************************
*                            testOGR_GetFieldTypeName()
************************************************************************/

    function testOGR_GetFieldTypeName() {
        $strFieldTypeName = OGR_GetFieldTypeName(OFTReal);

        $expected = "Real";
        $this->AssertEquals($expected, $strFieldTypeName, "Problem with ".
                            "OGR_GetFieldTypeName().");

    }
}
?>
