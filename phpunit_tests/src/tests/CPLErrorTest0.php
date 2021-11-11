<?php

use \PHPUnit\Framework\TestCase;

/**
 * Tests for CPL error handling functions
 *
 * @author Edward Nash
 */
class CPLErrorTest0 extends TestCase
{
    /**
     * @var resource
     */
    protected $hGeometry;

    /**
     * {@inheritdoc}
     */
    public function setUp() : void
    {
        $this->hGeometry = OGR_G_CreateGeometry(wkbPolygon);
        $hRing = OGR_G_CreateGeometry(wkbLinearRing);
        OGR_G_AddPoint($hRing, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($hRing, 12.34, 456.78, 0.0);
        OGR_G_AddPoint($hRing, 12.34, 45.67, 0.0);
        OGR_G_AddPoint($hRing, 123.45, 45.67, 0.0);
        OGR_G_AddPoint($hRing, 123.45, 456.78, 0.0);
        OGR_G_AddGeometry($this->hGeometry, $hRing);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown() : void
    {
        $this->hGeometry = null;
    }

    /**
     * Test CPLErrorReset
     */
    public function testCPLErrorResetGetLastErrorNo()
    {
        if (OGR_VERSION_NUM >= 2030000) {
            $this->markTestSkipped('CPL errors cannot easily be provoked in GDAL 2.3+');
            return;
        }
        @OGR_G_RemoveGeometry($this->hGeometry, 0, true);
        $actual = CPLGetLastErrorNo();
        $this->assertIsInt(
            $actual,
            "CPLGetLastErrorNo should return an integer when there was an error"
        );
        $this->assertNotSame(
            OGRERR_NONE,
            $actual,
            "CPLGetLastErrorNo should not return OGRERR_NONE when there was an error"
        );
        CPLErrorReset();
        $actual = CPLGetLastErrorNo();
        $this->assertSame(
            OGRERR_NONE,
            $actual,
            "CPLErrorReset had no effect or CPLGetLastErrorNo did not return OGRERR_NONE when there was no error."
        );
    }

    /**
     * Test CPLGetLastErrorType for no error
     *
     * @depends testCPLErrorResetGetLastErrorNo
     */
    public function testCPLGetLastErrorType0()
    {
        CPLErrorReset();
        $actual = CPLGetLastErrorType();
        $this->assertSame(
            0,
            $actual,
            "CPLGetLastErrorType should return 0 when there was no error"
        );
    }

    /**
     * Test CPLGetLastErrorType for an error
     */
    public function testCPLGetLastErrorType1()
    {
        if (OGR_VERSION_NUM >= 2030000) {
            $this->markTestSkipped('CPL errors cannot easily be provoked in GDAL 2.3+');
            return;
        }
        @OGR_G_RemoveGeometry($this->hGeometry, 0, true);
        $actual = CPLGetLastErrorType();
        $this->assertIsInt(
            $actual,
            "CPLGetLastErrorType should return an integer when there was an error"
        );
        $this->assertSame(
            3,
            $actual,
            "CPLGetLastErrorType should have returned CE_Failure (3)"
        );
    }

    /**
     * Test CPLGetLastErrorMsg for no error
     *
     * @depends testCPLErrorResetGetLastErrorNo
     */
    public function testCPLGetLastErrorMsg0()
    {
        CPLErrorReset();
        $actual = CPLGetLastErrorMsg();
        $this->assertSame(
            "",
            $actual,
            "CPLGetLastErrorMsg should return an empty string when there was no error"
        );
    }

    /**
     * Test CPLGetLastErrorMsg for an error
     */
    public function testCPLGetLastErrorMsg1()
    {
        if (OGR_VERSION_NUM >= 2030000) {
            $this->markTestSkipped('CPL errors cannot easily be provoked in GDAL 2.3+');
            return;
        }
        @OGR_G_RemoveGeometry($this->hGeometry, 0, true);
        $actual = CPLGetLastErrorMsg();
        $this->assertIsString(
            $actual,
            "CPLGetLastErrorMsg should return a string when there was an error"
        );
        $this->assertSame(
            "OGR_G_RemoveGeometry() not supported on polygons yet.",
            $actual,
            "CPLGetLastErrorMsg should not return an empty string when there was an error"
        );
    }
}
