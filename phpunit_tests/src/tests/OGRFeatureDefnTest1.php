<?php

use \PHPUnit\Framework\TestCase;

class OGRFeatureDefnTest1 extends TestCase
{
    public $hFieldDefn;
    public $hFeatureDefn;

    public function setUp() : void
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

    public function tearDown() : void
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
        $nFeatureCount0 = OGR_FD_GetReferenceCount($this->hFeatureDefn);

        $hFeature1 = OGR_F_Create($this->hFeatureDefn);
        $nFeatureCount1 = OGR_FD_GetReferenceCount($this->hFeatureDefn);
        $expected = $nFeatureCount0 + 1;
        $this->AssertEquals(
            $expected,
            $nFeatureCount1,
            "Problem with OGR_FD_GetReferenceCount(), expected one more element."
        );

        $hFeature2 = OGR_F_Create($this->hFeatureDefn);
        $nFeatureCount2 = OGR_FD_GetReferenceCount($this->hFeatureDefn);
        $expected = $nFeatureCount0 + 2;
        $this->AssertEquals(
            $expected,
            $nFeatureCount2,
            "Problem with OGR_FD_GetReferenceCount(), expected two more elements."
        );

        OGR_F_Destroy($hFeature1);
        $nFeatureCount3 = OGR_FD_GetReferenceCount($this->hFeatureDefn);
        $expected = $nFeatureCount0 + 1;
        $this->AssertEquals(
            $expected,
            $nFeatureCount3,
            "Problem with OGR_FD_GetReferenceCount(), expected one more element."
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
