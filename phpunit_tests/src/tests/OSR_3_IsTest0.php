<?php

/**
 * Tests for is*-functions in OSR
 *
 * @author Edward Nash <e.nash@dvz-mv.de>
 *
 * @copyright ©2019 DVZ Datenverarbeitungszentrum M-V GmbH
 */
class OSR_3_IsTest0 extends PHPUnit_Framework_TestCase
{
        /**
     * Test candidate EPSG:31467
     *
     * @var resource
     */
    protected static $srs31467;

    /**
     * Test candidate EPSG:31468
     *
     * @var resource
     */
    protected static $srs31468;

    /**
     * Test candidate EPSG:4326
     *
     * @var resource
     */
    protected static $srs4326;

    /**
     * Test candidate EPSG:4326
     *
     * @var resource
     */
    protected static $srs4328;

    /**
     * @depends OSR_1_ImportTest0::testOSR_ImportFromEPSG0
     */
    public static function setUpBeforeClass()
    {
        foreach (array(4326, 31467, 31468, 4328) as $epsg) {
            $var = sprintf('srs%d', $epsg);
            static::$$var = OSR_NewSpatialReference();
            OSR_ImportFromEPSG(static::$$var, $epsg);
        }
    }

    /**
     * Test is_osr() with an OSR reference
     */
    public function testIs_OSR0()
    {
        $actual = is_osr(static::$srs4326);
        $this->assertTrue(
            $actual,
            "Result of is_osr with a spatial reference should be TRUE"
        );
    }

    /**
     * Test is_osr() with NULL
     */
    public function testIs_OSR1()
    {
        $actual = is_osr(null);
        $this->assertFalse(
            $actual,
            "Result of is_osr with NULL should be FALSE"
        );
    }

    /**
     * Test is_osr() with NULL
     */
    public function testIs_OSR2()
    {
        $actual = is_osr(123);
        $this->assertFalse(
            $actual,
            "Result of is_osr with an integer should be FALSE"
        );
    }

    /**
     * Test is_osr() with an arbitrary resource
     */
    public function testIs_OSR3()
    {
        $stream = fopen("php://memory", "w");
        $this->assertNotFalse($stream, "Could not open memory stream");
        $actual = is_osr($stream);
        fclose($stream);
        $this->assertFalse(
            $actual,
            "Result of is_osr with a stream resource should be FALSE"
        );
    }

    /**
     * Test OSR_IsGeographic() with a geographic reference system
     */
    public function testOSR_IsGeographic0()
    {
        $actual = OSR_IsGeographic(static::$srs4326);
        $this->assertTrue(
            $actual,
            "Result of OSR_IsGeographic should be TRUE for EPSG:4326"
        );
    }

    /**
     * Test OSR_IsGeographic() with a projected reference system
     */
    public function testOSR_IsGeographic1()
    {
        $actual = OSR_IsGeographic(static::$srs31468);
        $this->assertFalse(
            $actual,
            "Result of OSR_IsGeographic should be FALSE for EPSG:31468"
        );
    }

    /**
     * Test OSR_IsGeographic() with a local reference system
     *
     * @depends OSR_1_ImportTest0::testOSR_SetFromUserInput2
     */
    public function testOSR_IsLocal0()
    {
        $hRef = OSR_NewSpatialReference();
        $wktFile = test_data_path("osr", "local.wkt");
        $eErr = OSR_SetFromUserInput($hRef, $wktFile);
        $this->assertEquals(OGRERR_NONE, $eErr, "Could not load " . $wktFile);
        $actual = OSR_IsLocal($hRef);
        $this->assertTrue(
            $actual,
            "Result of OSR_IsLocal should be TRUE for a local reference system"
        );
    }

    /**
     * Test OSR_IsGeographic() with a geographic reference system
     */
    public function testOSR_IsLocal1()
    {
        $actual = OSR_IsLocal(static::$srs4326);
        $this->assertFalse(
            $actual,
            "Result of OSR_IsLocal should be FALSE for EPSG:4326"
        );
    }

    /**
     * Test OSR_IsProjected() with a geographic reference system
     */
    public function testOSR_IsProjected0()
    {
        $actual = OSR_IsProjected(static::$srs4326);
        $this->assertFalse(
            $actual,
            "Result of OSR_IsProjected should be FALSE for EPSG:4326"
        );
    }

    /**
     * Test OSR_IsProjected() with a projected reference system
     */
    public function testOSR_IsProjected1()
    {
        $actual = OSR_IsProjected(static::$srs31468);
        $this->assertTrue(
            $actual,
            "Result of OSR_IsProjected should be TRUE for EPSG:31468"
        );
    }

    /**
     * Test OSR_IsGeocentric() with a geographic reference system
     */
    public function testOSR_IsGeocentric0()
    {
        $actual = OSR_IsGeocentric(static::$srs4326);
        $this->assertFalse(
            $actual,
            "Result of OSR_IsGeocentric should be TRUE for EPSG:4326"
        );
    }

    /**
     * Test OSR_IsGeocentric() with a projected reference system
     */
    public function testOSR_IsGeocentric1()
    {
        $actual = OSR_IsGeocentric(static::$srs31468);
        $this->assertFalse(
            $actual,
            "Result of OSR_IsGeocentric should be FALSE for EPSG:31468"
        );
    }

    /**
     * Test OSR_IsGeocentric() with a geocentric reference system
     */
    public function testOSR_IsGeocentric2()
    {
        $actual = OSR_IsGeocentric(static::$srs4328);
        $this->assertTrue(
            $actual,
            "Result of OSR_IsGeocentric should be FALSE for EPSG:31468"
        );
    }

    /**
     * Test OSR_IsVertical() with a geographic reference system
     */
    public function testOSR_IsVertical0()
    {
        $actual = OSR_IsVertical(static::$srs4326);
        $this->assertFalse(
            $actual,
            "Result of OSR_IsVertical should be FALSE for EPSG:4326"
        );
    }

    /**
     * Test OSR_IsVertical() with a vertical reference system
     *
     * @depends OSR_1_ImportTest0::testOSR_SetFromUserInput2
     */
    public function testOSR_IsVertical1()
    {
        $hRef = OSR_NewSpatialReference();
        $wktFile = test_data_path("osr", "epsg5867.wkt");
        $eErr = OSR_SetFromUserInput($hRef, $wktFile);
        $this->assertSame(OGRERR_NONE, $eErr, "Could not load " . $wktFile);
        $actual = OSR_IsVertical($hRef);
        $this->assertTrue(
            $actual,
            "Result of OSR_IsVertical should be TRUE for EPSG:5867"
        );
    }

    /**
     * Test OSR_IsSameGeogCS() with 2 WGS84-based coordinate systems
     */
    public function testOSR_IsSameGeogCS0()
    {
        $actual = OSR_IsSameGeogCS(static::$srs31467, static::$srs31468);
        $this->assertTrue(
            $actual,
            "OSR_IsSameGeogCS should be TRUE for EPSG:31467 und EPSG:31468"
        );
    }

    /**
     * Test OSR_IsSame() with coordinate systems with different spheroids
     */
    public function testOSR_IsSameGeogCS1()
    {
        $actual = OSR_ISSameGeogCS(static::$srs4326, static::$srs31468);
        $this->assertFalse(
            $actual,
            "OSR_IsSameGeogCS should be FALSE for EPSG:4326 und EPSG:31468"
        );
    }

    /**
     * Test OSR_IsSame() with differing coordinate systems
     */
    public function testOSR_IsSame0()
    {
        $actual = OSR_ISSame(static::$srs4326, static::$srs4328);
        $this->assertFalse(
            $actual,
            "OSR_IsSame should be FALSE for EPSG:4326 und EPSG:4328"
        );
    }

    /**
     * Test OSR_IsSame() with identical coordinate systems
     *
     * @depends OSR_1_ImportTest0::testOSR_ImportFromEPSG0
     */
    public function testOSR_IsSame1()
    {
        $hRef = OSR_NewSpatialReference();
        OSR_ImportFromEPSG($hRef, 4326);
        $actual = OSR_IsSame($hRef, static::$srs4326);
        $this->assertTrue(
            $actual,
            "Result of OSR_IsSame should be TRUE for two references to EPSG:4326"
        );
    }
}
