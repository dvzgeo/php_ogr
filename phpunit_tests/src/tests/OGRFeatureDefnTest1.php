<?php

use \PHPUnit\Framework\TestCase;

class OGRFeatureDefnTest1 extends TestCase
{
    public $hFieldDefn;
    public $hFeatureDefn;

    public function setUp()
    {
        $strName = "Lake";
        $this->hFeatureDefn = OGR_FD_Create($strName);

        $strFieldName = "name";
        $this->hFieldDefn = OGR_Fld_Create($strFieldName, OFTString);

        OGR_FD_AddFieldDefn($this->hFeatureDefn, $this->hFieldDefn);

        $strFieldName = "area";
        $this->hFieldDefn = OGR_Fld_Create($strFieldName, OFTReal);

        OGR_FD_AddFieldDefn($this->hFeatureDefn, $this->hFieldDefn);
    }

    public function tearDown()
    {
        OGR_Fld_Destroy($this->hFieldDefn);
        OGR_FD_Destroy($this->hFeatureDefn);
        unset($this->hFieldDefn);
        unset($this->hFeatureDefn);
    }

    /***********************************************************************
     *                            testOGR_FD_GetFieldCount()
     ************************************************************************/

    public function testOGR_FD_GetFieldCount()
    {
        $nFieldCount = OGR_FD_GetFieldCount($this->hFeatureDefn);

        $expected = 2;
        $this->AssertEquals(
            $expected,
            $nFieldCount,
            "Problem with OGR_FD_GetFieldCount()."
        );
    }

    /***********************************************************************
     *                            testOGR_FD_GetFieldIndex()
     ************************************************************************/

    public function testOGR_FD_GetFieldIndex()
    {
        $strFieldName = "area";

        $iField = OGR_FD_GetFieldIndex($this->hFeatureDefn, $strFieldName);
        $expected = 1;
        $this->AssertEquals(
            $expected,
            $iField,
            "Problem with OGR_FD_GetFieldIndex()."
        );
    }

    /***********************************************************************
     *                            testOGR_FD_SetGetGeomType()
     ************************************************************************/

    public function testOGR_FD_SetGetGeomType()
    {
        $eTypeIn = wkbLineString;
        OGR_FD_SetGeomType($this->hFeatureDefn, $eTypeIn);

        $eType = OGR_FD_GetGeomType($this->hFeatureDefn);
        $expected = wkbLineString;
        $this->AssertEquals(
            $expected,
            $eType,
            "Problem with OGR_FD_SetGeomType() or OGR_FD_GetGeomType()."
        );
    }

    /***********************************************************************
     *                            testOGR_FD_GetReferenceCount()
     ************************************************************************/

    public function testOGR_FD_GetReferenceCount()
    {
        $nFeatureCount = OGR_FD_GetReferenceCount($this->hFeatureDefn);
        $expected = 0;
        $this->AssertEquals(
            $expected,
            $nFeatureCount,
            "Problem with OGR_FD_GetReferenceCount(), expected no element."
        );

        $hFeature1 = OGR_F_Create($this->hFeatureDefn);
        $nFeatureCount = OGR_FD_GetReferenceCount($this->hFeatureDefn);
        $expected = 1;
        $this->AssertEquals(
            $expected,
            $nFeatureCount,
            "Problem with OGR_FD_GetReferenceCount(), expected one element."
        );


        $hFeature2 = OGR_F_Create($this->hFeatureDefn);
        $nFeatureCount = OGR_FD_GetReferenceCount($this->hFeatureDefn);
        $expected = 2;
        $this->AssertEquals(
            $expected,
            $nFeatureCount,
            "Problem with OGR_FD_GetReferenceCount(), expected two elements."
        );

        OGR_F_Destroy($hFeature1);
        $nFeatureCount = OGR_FD_GetReferenceCount($this->hFeatureDefn);
        $expected = 1;
        $this->AssertEquals(
            $expected,
            $nFeatureCount,
            "Problem with OGR_FD_GetReferenceCount(), expected one element."
        );

        OGR_F_Destroy($hFeature2);
        $nFeatureCount = OGR_FD_GetReferenceCount($this->hFeatureDefn);
        $expected = 0;
        $this->AssertEquals(
            $expected,
            $nFeatureCount,
            "Problem with OGR_FD_GetReferenceCount(), expected no element."
        );
    }

    /***********************************************************************
     *                            testOGR_FD_GetReference()
     ************************************************************************/

    public function testOGR_FD_GetReference()
    {
        $nFeatureCount = OGR_FD_GetReferenceCount($this->hFeatureDefn);
        $expected = 0;
        $this->AssertEquals(
            $expected,
            $nFeatureCount,
            "Problem with OGR_FD_GetReference(): expected no element."
        );

        $nFeatureCount = OGR_FD_Reference($this->hFeatureDefn);
        $expected = 1;
        $this->AssertEquals(
            $expected,
            $nFeatureCount,
            "Problem with OGR_FD_Reference(): expected one element."
        );

        $nFeatureCount = OGR_FD_GetReferenceCount($this->hFeatureDefn);
        $expected = 1;
        $this->AssertEquals(
            $expected,
            $nFeatureCount,
            "Problem with OGR_FD_GetReferenceCount():  expected one element."
        );

        $nFeatureCount = OGR_FD_Reference($this->hFeatureDefn);
        $expected = 2;
        $this->AssertEquals(
            $expected,
            $nFeatureCount,
            "Problem with OGR_FD_Reference():  expected two elements."
        );

        $nFeatureCount = OGR_FD_Dereference($this->hFeatureDefn);
        $expected = 1;
        $this->AssertEquals(
            $expected,
            $nFeatureCount,
            "Problem with OGR_FD_Dereference():  expected one element."
        );
    }
}
