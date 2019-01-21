<?php

/**
 * Tests for WKB and WKT import/export functions
 *
 * @author Edward Nash
 */
class OGRGeometryTest3 extends PHPUnit_Framework_TestCase
{
    /**
     * WKT representation of test geometry
     */
    protected static $WKT;

    /**
     * WKB representation of test geometry with little-endian byte order
     */
    protected static $WKB_NDR;

    /**
     * WKB representation of test geometry with big-endian byte order
     */
    protected static $WKB_XDR;

    /**
     * @var reference
     */
    protected static $hRefGeometry;

    /**
     * @var string
     */
    protected $dataDir;

    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass()
    {
        static::$hRefGeometry = OGR_G_CreateGeometry(wkbPoint25D);
        OGR_G_AddPoint(static::$hRefGeometry, 10, 20, 0.0);
        static::$WKT = "POINT (10 20 0)";
        // assume double is 64-bit IEEE 754
        /* support for e and E pack specifiers introduced in 7.0.15 / 7.1.1
        static::$WKB_NDR = pack("CVeee", 0, 1, 10, 20, 0);
        static::$WKB_XDR = pack("CNEEE", 0, 1, 10, 20, 0);
        */
        static::$WKB_NDR = "\x01\x01\x00\x00\x80\x00\x00\x00\x00\x00\x00\x24\x40\x00\x00\x00\x00\x00\x00\x34\x40\x00\x00\x00\x00\x00\x00\x00\x00";
        static::$WKB_XDR = "\x00\x80\x00\x00\x01\x40\x24\x00\x00\x00\x00\x00\x00\x40\x34\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00";
    }

    /**
     * Test OGR_G_ExportToWKB little endian
     */
    public function testOGR_G_ExportToWKBNDR()
    {
        $actual = null;
        $eErr = OGR_G_ExportToWKB(static::$hRefGeometry, wkbNDR, $actual);
        $this->assertSame(
            OGRERR_NONE,
            $eErr,
            "OGR_G_ExportToWKB should return OGRERR_NONE on success"
        );
        $this->assertSame(
            self::$WKB_NDR,
            $actual,
            "Result for OGR_G_ExportToWKB not as expected for NDR"
        );
    }

    /**
     * Test OGR_G_ExportToWKB big endian
     */
    public function testOGR_G_ExportToWKBXDR()
    {
        $actual = null;
        $eErr = OGR_G_ExportToWKB(static::$hRefGeometry, wkbXDR, $actual);
        $this->assertSame(
            OGRERR_NONE,
            $eErr,
            "OGR_G_ExportToWKB should return OGRERR_NONE on success"
        );
        $this->assertSame(
            self::$WKB_XDR,
            $actual,
            "Result for OGR_G_ExportToWKB not as expected for XDR"
        );
    }

    /**
     * Test OGR_G_ExportToWKT
     */
    public function testOGR_G_ExportToWKT()
    {
        $eErr = OGR_G_ExportToWKT(static::$hRefGeometry, $actual);
        $this->assertSame(
            OGRERR_NONE,
            $eErr,
            "OGR_G_ExportToWKT should return OGRERR_NONE on success"
        );
        $this->assertSame(
            self::$WKT,
            $actual,
            "Result for OGR_G_ExportToWKT not as expected"
        );
    }

    /**
     * Test OGR_G_CreateFromWKB with success
     */
    public function testOGR_G_CreateFromWKB0()
    {
        $hGeometry = null;
        $eErr = OGR_G_CreateFromWKB(self::$WKB_NDR, null, $hGeometry);
        $this->assertSame(
            OGRERR_NONE,
            $eErr,
            "OGR_G_CreateFromWKB should return OGRERR_NONE on success"
        );
        $this->validateImport($hGeometry, __FUNCTION__, $eErr);
    }

    /**
     * Test OGR_G_CreateFromWKB with failure
     */
    public function testOGR_G_CreateFromWKB1()
    {
        $hGeometry = "foo";
        $eErr = OGR_G_CreateFromWKB("bar", null, $hGeometry);
        $this->assertNotSame(
            OGRERR_NONE,
            $eErr,
            "OGR_G_CreateFromWKB should not return OGRERR_NONE on failure"
        );
        $this->assertEquals(
            "foo",
            $hGeometry,
            "OGR_G_CreateFromWKB should not alter the geometry reference on failure"
        );
    }

    /**
     * Test OGR_G_CreateFromWKT with success
     */
    public function testOGR_G_CreateFromWKT0()
    {
        $hGeometry = null;
        $eErr = OGR_G_CreateFromWKT(self::$WKT, null, $hGeometry);
        $this->validateImport($hGeometry, __FUNCTION__, $eErr);
    }

    /**
     * Test OGR_G_CreateFromWKT with failure
     */
    public function testOGR_CreateFromWKT1()
    {
        $hGeometry = "foo";
        $eErr = OGR_G_CreateFromWKT("bar", null, $hGeometry);
        $this->assertNotSame(
            OGRERR_NONE,
            $eErr,
            "OGR_G_CreateFromWKT should not return OGRERR_NONE on failure"
        );
        $this->assertEquals(
            "foo",
            $hGeometry,
            "OGR_G_CreateFromWKT should not alter the geometry reference on failure"
        );
    }

    /**
     * Test OGR_G_ImportFromWKB with success
     */
    public function testOGR_G_ImportFromWKB0()
    {
        $hGeometry = OGR_G_CreateGeometry(wkbPoint25D);
        $eErr = OGR_G_ImportFromWKB($hGeometry, self::$WKB_NDR);
        $this->validateImport($hGeometry, __FUNCTION__, $eErr);
    }

    /**
     * Test OGR_G_ImportFromWKB with failure
     */
    public function testOGR_G_ImportFromWKB1()
    {
        $hGeometry = OGR_G_CreateGeometry(wkbPoint25D);
        $eErr = OGR_G_ImportFromWKB($hGeometry, "foo");
        $this->assertNotSame(
            OGRERR_NONE,
            $eErr,
            "OGR_G_ImportFromWKB should not return OGRERR_NONE on failure"
        );
    }

    /**
     * Test OGR_G_ImportFromWKT with success
     */
    public function testOGR_G_ImportFromWKT0()
    {
        $hGeometry = OGR_G_CreateGeometry(wkbPoint25D);
        $eErr = OGR_G_ImportFromWKT($hGeometry, self::$WKT);
        $this->validateImport($hGeometry, __FUNCTION__, $eErr);
    }

    /**
     * Test OGR_G_ImportFromWKT with failure
     */
    public function testOGR_G_ImportFromWKT1()
    {
        $hGeometry = OGR_G_CreateGeometry(wkbPoint25D);
        $eErr = OGR_G_ImportFromWKT($hGeometry, "foo");
        $this->assertNotSame(
            OGRERR_NONE,
            $eErr,
            "OGR_G_ImportFromWKT should not return OGRERR_NONE on failure"
        );
    }

    /**
     * Validate an imported geometry for equality with reference geometry
     *
     * @param resource $hGeometry Geometry to validate
     * @param string $function Calling test function
     * @param integer $eErr Error code from import function if it returns one
     */
    protected function validateImport($hGeometry, $function, $eErr)
    {
        $ogrFn = preg_replace('/^test(.*?)\\d/', '$1', $function);
        if (func_num_args() > 2) {
            $this->assertSame(
                OGRERR_NONE,
                $eErr,
                $ogrFn . " should return OGRERR_NONE on success"
            );
        }
        $type = OGR_G_GetGeometryType($hGeometry);
        $this->assertSame(
            wkbPoint25D,
            $type,
            "Resulting geometry from " . $ogrFn . " is expected to be a 2.5D Point (wkbPoint25D)"
        );
        $equals = OGR_G_Equal(static::$hRefGeometry, $hGeometry);
        $this->assertTrue(
            $equals,
            "Created geometry from " . $ogrFn . " should equal reference geometry"
        );
    }
}
