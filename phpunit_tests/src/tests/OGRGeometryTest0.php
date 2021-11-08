<?php

use \PHPUnit\Framework\TestCase;

class OGRGeometryTest0 extends TestCase
{
    public function setUp()
    {
    }

    public function tearDown()
    {
    }

    /***********************************************************************
     *                            testOGR_G_CreateDestroyGeometry()
     ************************************************************************/

    public function testOGR_G_CreateDestroyGeometry()
    {
        $eType = wkbPoint;
        $hGeometry = OGR_G_CreateGeometry($eType);
        $this->AssertNotNull(
            $hGeometry,
            "Problem with OGR_G_CreateGeometry(): handle is not supposed to be NULL."
        );

        OGR_G_DestroyGeometry($hGeometry);


        $expected = "Unknown";

        $actual = get_resource_type($hGeometry);


        $this->assertEquals(
            $expected,
            $actual,
            "Problem with OGR_G_DestroyGeometry():  Geometry resource is supposed to be freed after OGR_G_DestroyGeometry().\n"
        );
    }

    /***********************************************************************
     *                            testOGR_G_GetDimension()
     ************************************************************************/

    public function testOGR_G_GetDimension()
    {
        $eType = wkbPoint;
        $hGeometry = OGR_G_CreateGeometry($eType);
        $expected = 0;
        $nDimension = OGR_G_GetDimension($hGeometry);
        $this->AssertEquals(
            $expected,
            $nDimension,
            "Problem with OGR_G_GetDimension(): type is wkbPoint."
        );
        OGR_G_DestroyGeometry($hGeometry);

        $eType = wkbLineString;
        $hGeometry = OGR_G_CreateGeometry($eType);
        $expected = 1;
        $nDimension = OGR_G_GetDimension($hGeometry);
        $this->AssertEquals(
            $expected,
            $nDimension,
            "Problem with OGR_G_GetDimension(): type is wkbLineString."
        );
        OGR_G_DestroyGeometry($hGeometry);

        $eType = wkbPolygon;
        $hGeometry = OGR_G_CreateGeometry($eType);
        $expected = 2;
        $nDimension = OGR_G_GetDimension($hGeometry);
        $this->AssertEquals(
            $expected,
            $nDimension,
            "Problem with OGR_G_GetDimension(): type is wkbPolygon."
        );
        OGR_G_DestroyGeometry($hGeometry);
    }


    /***********************************************************************
     *                            testOGR_G_GetGeometryType()
     ************************************************************************/

    public function testOGR_G_GetGeometryType()
    {
        $eType = wkbGeometryCollection;
        $hGeometry = OGR_G_CreateGeometry($eType);

        $expected = 7;
        $eCurrentType = OGR_G_GetGeometryType($hGeometry);
        $this->AssertEquals(
            $expected,
            $eCurrentType,
            "Problem with OGR_G_GetGeometryType()."
        );

        OGR_G_DestroyGeometry($hGeometry);
    }

    /***********************************************************************
     *                            testOGR_G_GetGeometryName()
     ************************************************************************/

    public function testOGR_G_GetGeometryName()
    {
        $eType = wkbMultiPoint;
        $hGeometry = OGR_G_CreateGeometry($eType);

        $expected = "MULTIPOINT";
        $strType = OGR_G_GetGeometryName($hGeometry);
        $this->AssertEquals(
            $expected,
            $strType,
            "Problem with OGR_G_GetGeometryName()."
        );

        OGR_G_DestroyGeometry($hGeometry);
    }

    /***********************************************************************
     *                            testOGR_G_SetGetPoint()
     ************************************************************************/

    public function testOGR_G_SetGetPoint()
    {
        $eType = wkbPoint;
        $hGeometry = OGR_G_CreateGeometry($eType);

        $iPoint = 0;
        $dfXIn = 123.45;
        $dfYIn = 456.78;
        $dfZIn = 0.0;

        OGR_G_SetPoint($hGeometry, $iPoint, $dfXIn, $dfYIn, $dfZIn);

        OGR_G_GetPoint($hGeometry, $iPoint, $dfXOut, $dfYOut, $dfZOut);

        $this->AssertEquals(
            $dfXIn,
            $dfXOut,
            "Problem with OGR_G_SetPoint() or OGR_G_GetPoint():  x coordinate."
        );
        $this->AssertEquals(
            $dfYIn,
            $dfYOut,
            "Problem with OGR_G_SetPoint() or OGR_G_GetPoint():  y coordinate."
        );
        $this->AssertEquals(
            $dfZIn,
            $dfZOut,
            "Problem with OGR_G_SetPoint() or OGR_G_GetPoint():  z coordinate."
        );

        OGR_G_DestroyGeometry($hGeometry);
    }

    /***********************************************************************
     *                            testOGR_G_GetCoordinateDimension()
     ************************************************************************/

    public function testOGR_G_GetCoordinateDimension()
    {
        $eType = wkbPoint;
        $hGeometry = OGR_G_CreateGeometry($eType);

        $iPoint = 0;
        $dfXIn = 123.45;
        $dfYIn = 456.78;
        $dfZIn = 5.0;

        OGR_G_SetPoint($hGeometry, $iPoint, $dfXIn, $dfYIn, $dfZIn);

        $expected = 3;
        $nCoordinateDimension = OGR_G_GetCoordinateDimension($hGeometry);
        $this->AssertEquals(
            $expected,
            $nCoordinateDimension,
            "Problem with OGR_G_GetCoordinateDimension(): supposed to be a two dimensions space."
        );
        OGR_G_DestroyGeometry($hGeometry);
    }

    /***********************************************************************
     *                            testOGR_G_AddGetxyz()
     ************************************************************************/

    public function testOGR_G_AddGetxyz()
    {
        $eType = wkbLineString;
        $hGeometry = OGR_G_CreateGeometry($eType);

        OGR_G_AddPoint($hGeometry, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($hGeometry, 12.34, 45.67, 6.8);

        $iPoint = 1;
        $expected = 12.34;
        $dfX = OGR_G_GetX($hGeometry, $iPoint);
        $this->AssertEquals(
            $expected,
            $dfX,
            "Problem with OGR_G_AddPoint() or OGR_G_GetX()."
        );

        $iPoint = 0;
        $expected = 456.78;
        $dfY = OGR_G_GetY($hGeometry, $iPoint);
        $this->AssertEquals(
            $expected,
            $dfY,
            "Problem with OGR_G_AddPoint() or OGR_G_GetY()."
        );


        $iPoint = 1;
        $expected = 6.8;
        $dfZ = OGR_G_GetZ($hGeometry, $iPoint);
        $this->AssertEquals(
            $expected,
            $dfZ,
            "Problem with OGR_G_AddPoint() or OGR_G_GetZ()."
        );

        OGR_G_DestroyGeometry($hGeometry);
    }

    /***********************************************************************
     *                            testOGR_G_GetPointCount()
     ************************************************************************/

    public function testOGR_G_GetPointCount()
    {
        $eType = wkbLineString;
        $hGeometry = OGR_G_CreateGeometry($eType);

        OGR_G_AddPoint($hGeometry, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($hGeometry, 12.34, 45.67, 6.8);

        $expected = 2;
        $nPointCount = OGR_G_GetPointCount($hGeometry);
        $this->AssertEquals(
            $expected,
            $nPointCount,
            "Problem with OGR_G_GetPointCount()."
        );

        OGR_G_DestroyGeometry($hGeometry);
    }

    /***********************************************************************
     *                            testOGR_G_AddCountGeometry()
     ************************************************************************/

    public function testOGR_G_AddCountGeometry()
    {
        $eType = wkbMultiPoint;
        $hContainer = OGR_G_CreateGeometry($eType);

        $eType = wkbPoint;
        $hGeometry1 = OGR_G_CreateGeometry($eType);
        OGR_G_AddPoint($hGeometry1, 123.45, 456.78, 0.0);

        $hGeometry2 = OGR_G_CreateGeometry($eType);
        OGR_G_AddPoint($hGeometry2, 12.34, 45.67, 6.8);

        $eErr = OGR_G_AddGeometry($hContainer, $hGeometry1);
        $expected = 1;
        $nGeometryCount = OGR_G_GetGeometryCount($hContainer);
        $this->AssertEquals(
            $expected,
            $nGeometryCount,
            "Problem with OGR_G_AddGeometry() or OGR_G_GetGeometryCount()."
        );

        $eErr = OGR_G_AddGeometry($hContainer, $hGeometry2);
        $expected = 2;
        $nGeometryCount = OGR_G_GetGeometryCount($hContainer);
        $this->AssertEquals(
            $expected,
            $nGeometryCount,
            "Problem with OGR_G_AddGeometry() or OGR_G_GetGeometryCount()."
        );

        OGR_G_DestroyGeometry($hGeometry1);
        OGR_G_DestroyGeometry($hGeometry2);
        OGR_G_DestroyGeometry($hContainer);
    }

    /***********************************************************************
     *                            testOGR_G_FlattenTo2D()
     ************************************************************************/

    public function testOGR_G_FlattenTo2D()
    {
        $eType = wkbLineString;
        $hGeometry = OGR_G_CreateGeometry($eType);

        OGR_G_AddPoint($hGeometry, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($hGeometry, 12.34, 45.67, 6.8);

        $expected = 3;
        $nCoordinateDimension = OGR_G_GetCoordinateDimension($hGeometry);
        $this->AssertEquals(
            $expected,
            $nCoordinateDimension,
            "Problem with OGR_G_GetCoordinateDimension(): supposed to be a three dimensions space."
        );

        OGR_G_FlattenTo2D($hGeometry);

        $expected = 2;
        $nCoordinateDimension = OGR_G_GetCoordinateDimension($hGeometry);
        $this->AssertEquals(
            $expected,
            $nCoordinateDimension,
            "Problem with OGR_G_GetCoordinateDimension(): supposed to be a two dimensions space."
        );

        OGR_G_DestroyGeometry($hGeometry);
    }
}
