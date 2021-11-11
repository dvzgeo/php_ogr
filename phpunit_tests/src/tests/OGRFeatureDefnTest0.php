<?php

use \PHPUnit\Framework\TestCase;

class OGRFeatureDefnTest0 extends TestCase
{
    public $hContainer;

    public function setUp() : void
    {
    }

    public function tearDown() : void
    {
        unset($this->hContainer);
    }

    /***********************************************************************
     *                            testOGR_FD_CreateDestroy()
     ************************************************************************/

    public function testOGR_FD_CreateDestroy()
    {
        $strNameIn = "Lake";
        $hFeatureDefn = OGR_FD_Create($strNameIn);
        $this->AssertNotNull(
            $hFeatureDefn,
            "Problem with OGR_FD_Create(): handle should not be NULL."
        );

        OGR_FD_Destroy($hFeatureDefn);

        $expected = "Unknown";

        $actual = get_resource_type($hFeatureDefn);

        $this->assertEquals(
            $expected,
            $actual,
            "Problem with OGR_FD_Destroy():  Feature definition resource is supposed to be freed after OGR_FD_Destroy().\n"
        );
    }

    /***********************************************************************
     *                            testOGR_FD_GetName()
     ************************************************************************/

    public function testOGR_FD_GetName()
    {
        $strNameIn = "Lake";
        $hFeatureDefn = OGR_FD_Create($strNameIn);

        $strNameOut = OGR_FD_GetName($hFeatureDefn);
        $expected = $strNameIn;

        $this->AssertEquals(
            $expected,
            $strNameOut,
            "Problem with OGR_FD_GetName()."
        );

        OGR_FD_Destroy($hFeatureDefn);
    }

    /***********************************************************************
     *                            testOGR_FD_AddGetFieldDefn()
     ************************************************************************/

    public function testOGR_FD_AddGetFieldDefn()
    {
        $strName = "Lake";
        $hFeatureDefn = OGR_FD_Create($strName);

        $strFieldName = "name";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTString);

        OGR_FD_AddFieldDefn($hFeatureDefn, $hFieldDefn);
        OGR_Fld_Destroy($hFieldDefn);

        $strName = "area";
        $hFieldDefn = OGR_Fld_Create($strFieldName, OFTReal);

        OGR_FD_AddFieldDefn($hFeatureDefn, $hFieldDefn);
        OGR_Fld_Destroy($hFieldDefn);

        $iField = 0;
        $hFieldDefn = OGR_FD_GetFieldDefn($hFeatureDefn, $iField);
        $strFieldName = OGR_Fld_GetNameRef($hFieldDefn);

        $expected = $strFieldName;
        $this->AssertEquals(
            $expected,
            $strFieldName,
            "Problem with OGR_FD_AddFieldDefn() or OGR_FD_GetFieldDefn()."
        );

        OGR_Fld_Destroy($hFieldDefn);

        OGR_FD_Destroy($hFeatureDefn);
    }
}
