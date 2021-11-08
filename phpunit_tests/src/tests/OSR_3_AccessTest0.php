<?php

use \PHPUnit\Framework\TestCase;

/**
 * Tests for accessor functions in OSR
 *
 * @author Edward Nash <e.nash@dvz-mv.de>
 *
 * @copyright ©2019 DVZ Datenverarbeitungszentrum M-V GmbH
 */
class OSR_3_AccessTest0 extends TestCase
{
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
     * @depends OSR_1_ImportTest0::testOSR_SetFromUserInput2
     */
    public static function setUpBeforeClass() : void
    {
        foreach (array(4326, 31468) as $epsg) {
            $var = sprintf('srs%d', $epsg);
            $file = test_data_path('osr', sprintf('epsg%d.wkt', $epsg));
            static::$$var = OSR_NewSpatialReference();
            OSR_SetFromUserInput(static::$$var, $file);
        }
    }

    /**
     * Test OSR_GetAttrValue() with success
     */
    public function testOSR_GetAttrValue0()
    {
        $actual = OSR_GetAttrValue(static::$srs31468, "SPHEROID", 0);
        $expected = "Bessel 1841";
        $this->assertEquals(
            $expected,
            $actual,
            "Result of OSR_GetAttrValue with valid node name does not match expected"
        );
    }

    /**
     * Test OSR_GetAttrValue() with failure
     */
    public function testOSR_GetAttrValue1()
    {
        $actual = OSR_GetAttrValue(static::$srs31468, "FOOBAR", 0);
        $this->assertNull(
            $actual,
            "Result of OSR_GetAttrValue with invalid node name does not match expected"
        );
    }

    /**
     * Test OSR_GetAngularUnits() with success
     */
    public function testOSR_GetAngularUnits1()
    {
        $actual = OSR_GetAngularUnits(static::$srs31468);
        $this->assertEquals(
            array(
                "multiplier" => 0.0174532925199433,
                "name" => "degree"
            ),
            $actual,
            "Result of OSR_GetAngularUnits does not match expected"
        );
    }

    /**
     * Test OSR_GetLinearUnits() with success
     */
    public function testOSR_GetLinearUnits0()
    {
        $actual = OSR_GetLinearUnits(static::$srs31468);
        $this->assertEquals(
            array(
                "multiplier" => 1.0,
                "name" => "metre"
            ),
            $actual,
            "Result of OSR_GetLinearUnits does not match expected"
        );
    }

    /**
     * Test OSR_GetPrimeMeridian() with success
     */
    public function testOSR_GetPrimeMeridian0()
    {
        $actual = OSR_GetPrimeMeridian(static::$srs31468);
        $this->assertEquals(
            array(
                "offset" => 0.0,
                "name" => "Greenwich",
            ),
            $actual,
            "Result of OSR_GetPrimeMeridian does not match expected"
        );
    }

    /**
     * Test OSR_GetToWGS84() with success
     */
    public function testOSR_GetToWGS840()
    {
        $actual = OSR_GetToWGS84(static::$srs31468);
        $this->assertEquals(
            array(
                "Dx_BF" => 598.1,
                "Dy_BF" => 73.7,
                "Dz_BF" => 418.2,
                "Rx_BF" => 0.202,
                "Ry_BF" => 0.045,
                "Rz_BF" => - 2.455,
                "M_BF" => 6.7
            ),
            $actual,
            "Result of OSR_GetToWGS84 does not match expected"
        );
    }

    /**
     * Test OSR_GetToWGS84() with no values
     */
    public function testOSR_GetToWGS841()
    {
        $actual = OSR_GetToWGS84(static::$srs4326);
        $this->assertNull(
            $actual,
            "Result of OSR_GetToWGS84 should be NULL when no transformation present"
        );
    }

    /**
     * Test OSR_GetSemiMajor() with success
     */
    public function testOSR_GetSemiMajor0()
    {
        $actual = OSR_GetSemiMajor(static::$srs31468);
        $this->assertEquals(
            6377397.155,
            $actual,
            "Result of OSR_GetSemiMajor does not match expected"
        );
    }

    /**
     * Test OSR_GetSemiMinor() with success
     */
    public function testOSR_GetSemiMinor0()
    {
        $actual = OSR_GetSemiMinor(static::$srs31468);
        $expected = 6377397.155 * (1 - (1 / 299.1528128));
        $this->assertEquals(
            $expected,
            $actual,
            "Result of OSR_GetSemiMinor does not match expected"
        );
    }

    /**
     * Test OSR_GetInvFlattening() with success
     */
    public function testOSR_GetInvFlattening0()
    {
        $actual = OSR_GetInvFlattening(static::$srs31468);
        $this->assertEquals(
            299.1528128,
            $actual,
            "Result of OSR_GetInvFlattening does not match expected"
        );
    }

    /**
     * Test OSR_GetAuthorityCode() for the SRS
     */
    public function testOSR_GetAuthorityCode0()
    {
        $actual = OSR_GetAuthorityCode(static::$srs31468, null);
        $this->assertSame(
            "31468",
            $actual,
            "Result of OSR_GetAuthorityCode does not match for spatial reference system"
        );
    }

    /**
     * Test OSR_GetAuthorityCode() for an existing node
     */
    public function testOSR_GetAuthorityCode1()
    {
        $actual = OSR_GetAuthorityCode(static::$srs31468, "SPHEROID");
        $this->assertSame(
            "7004",
            $actual,
            "Result of OSR_GetAuthorityCode does not match for SPHEROID node"
        );
    }
    /**
     * Test OSR_GetAuthorityCode() for a non-existant node
     */
    public function testOSR_GetAuthorityCode2()
    {
        $actual = OSR_GetAuthorityCode(static::$srs31468, "FOOBAR");
        $this->assertNull(
            $actual,
            "Result of OSR_GetAuthorityCode should be NULL for a non-existant node"
        );
    }

    /**
     * Test OSR_GetAuthorityName() for the SRS
     */
    public function testOSR_GetAuthorityName0()
    {
        $actual = OSR_GetAuthorityName(static::$srs31468, null);
        $this->assertEquals(
            "EPSG",
            $actual,
            "Result of OSR_GetAuthorityName does not match for spatial reference system"
        );
    }

    /**
     * Test OSR_GetAuthorityName() for an existant node
     */
    public function testOSR_GetAuthorityName1()
    {
        $actual = OSR_GetAuthorityName(static::$srs31468, "SPHEROID");
        $this->assertEquals(
            "EPSG",
            $actual,
            "Result of OSR_GetAuthorityName does not match for SPHEROID node"
        );
    }

    /**
     * Test OSR_GetAuthorityName() for an non-existant node
     */
    public function testOSR_GetAuthorityName2()
    {
        $actual = OSR_GetAuthorityName(static::$srs31468, "FOOBAR");
        $this->assertNull(
            $actual,
            "Result of OSR_GetAuthorityName should be NULL for a non-existant node"
        );
    }

    /**
     * Test OSR_GetProjParm() with an existing parameter
     */
    public function testOSR_GetProjParm0()
    {
        $actual = OSR_GetProjParm(static::$srs31468, "central_meridian", 0.0);
        $this->assertSame(
            12.0,
            $actual,
            "Result of OSR_GetProjParm does not match for central_meridian"
        );
    }

    /**
     * Test OSR_GetProjParm() with a non-existing parameter and no default
     */
    public function testOSR_GetProjParm1()
    {
        $actual = OSR_GetProjParm(static::$srs31468, "foobar");
        $this->assertNull(
            $actual,
            "Result of OSR_GetProjParm should be NULL for a non-existant parameter with no default"
        );
    }

    /**
     * Test OSR_GetProjParm() with a non-existing parameter and default value
     */
    public function testOSR_GetProjParm2()
    {
        $actual = OSR_GetProjParm(static::$srs31468, "foobar", -1);
        $this->assertSame(
            -1.0,
            $actual,
            "Result of OSR_GetProjParm should match default value for a non-existant parameter"
        );
    }

    /**
     * Test OSR_GetNormProjParm() with an existing parameter
     */
    public function testOSR_GetNormProjParm0()
    {
        $actual = OSR_GetNormProjParm(static::$srs31468, "central_meridian", 0.0);
        $this->assertSame(
            12.0,
            $actual,
            "Result of OSR_GetNormProjParm does not match for central_meridian"
        );
    }

    /**
     * Test OSR_GetNormProjParm() with a non-existing parameter and no default
     */
    public function testOSR_GetNormProjParm1()
    {
        $actual = OSR_GetNormProjParm(static::$srs31468, "foobar");
        $this->assertNull(
            $actual,
            "Result of OSR_GetNormProjParm should be NULL for a non-existant parameter with no default"
        );
    }

    /**
     * Test OSR_GetNormProjParm() with a non-existing parameter and default value
     */
    public function testOSR_GetNormProjParm2()
    {
        $actual = OSR_GetNormProjParm(static::$srs31468, "foobar", -1);
        $this->assertSame(
            -1.0,
            $actual,
            "Result of OSR_GetNormProjParm should match default value for a non-existant parameter"
        );
    }

    /**
     * Test OSR_GetUTMZone() with a non-UTM reference system
     */
    public function testOSR_GetUTMZone0()
    {
        $actual = OSR_GetUTMZone(static::$srs31468);
        $this->assertNull(
            $actual,
            "Result of OSR_GetUTMZone should be NULL for a non-UTM spatial reference system"
        );
    }

    /**
     * Test OSR_GetUTMZone() with a northen hemisphere UTM reference system
     *
     * @depends OSR_1_ImportTest0::testOSR_SetFromUserInput2
     */
    public function testOSR_GetUTMZone1()
    {
        $hRef = OSR_NewSpatialReference();
        $wktFile = test_data_path("osr", "epsg25833.wkt");
        OSR_SetFromUserInput($hRef, $wktFile);
        $actual = OSR_GetUTMZone($hRef);
        $this->assertSame(
            33,
            $actual,
            "Result of OSR_GetUTMZone should be 33 for EPSG:25833"
        );
    }

    /**
     * Test OSR_GetUTMZone() with a southern hemisphere UTM reference system
     *
     * @depends OSR_1_ImportTest0::testOSR_SetFromUserInput2
     */
    public function testOSR_GetUTMZone2()
    {
        $hRef = OSR_NewSpatialReference();
        $wktFile = test_data_path("osr", "epsg32733.wkt");
        OSR_SetFromUserInput($hRef, $wktFile);
        $actual = OSR_GetUTMZone($hRef);
        $this->assertSame(
            -33,
            $actual,
            "Result of OSR_GetUTMZone should be -33 for EPSG:32733"
        );
    }

    /**
     * Test OSR_GetAxis() with a non-existant axis
     */
    public function testOSR_GetAxis0()
    {
        $actual = OSR_GetAxis(static::$srs4326, "PROJCS", 0);
        $this->assertNull(
            $actual,
            "Result of OSR_GetAxis should be NULL for an invalid query"
        );
    }

    /**
     * Test OSR_GetAxis() with no explicit values
     */
    public function testOSR_GetAxis1()
    {
        $actual = OSR_GetAxis(static::$srs31468, "PROJCS", 0);
        $this->assertNull(
            $actual,
            "Result of OSR_GetAxis should be NULL when no explicit definition in PROJCS"
        );
        $actual = OSR_GetAxis(static::$srs31468, "GEOGCS", 0);
        $this->assertNull(
            $actual,
            "Result of OSR_GetAxis should be NULL when no explicit definition in GEOGCS"
        );
    }

    /**
     * Test OSR_GetAxis() with explicit values
     *
     * @depends OSR_1_ImportTest0::testOSR_SetFromUserInput2
     */
    public function testOSR_GetAxis2()
    {
        $hRef = OSR_NewSpatialReference();
        $wktFile = test_data_path("osr", "epsg5678.wkt");
        OSR_SetFromUserInput($hRef, $wktFile);
        $actual = OSR_GetAxis($hRef, "PROJCS", 0);
        $this->assertEquals(
            array(
                "name" => "Easting",
                "orientation" => "EAST"
            ),
            $actual,
            "Result of OSR_GetAxis does not match for 1st axis of EPSG:5678"
        );
        $actual = OSR_GetAxis($hRef, "PROJCS", 1);
        $this->assertEquals(
            array(
                "name" => "Northing",
                "orientation" => "NORTH"
            ),
            $actual,
            "Result of OSR_GetAxis does not match for 2nd axis of EPSG:5678"
        );
    }
}
