<?php

/**
 * Tests for special EPSG functions in OSR
 *
 * @author Edward Nash <e.nash@dvz-mv.de>
 *
 * @copyright ©2019 DVZ Datenverarbeitungszentrum M-V GmbH
 */
class OSR_3_EPSGTest0 extends PHPUnit_Framework_TestCase
{
    /**
     * Test OSR_AutoIdentifyEPSG() with success
     *
     * @depends OSR_1_ImportTest0::testOSR_SetFromUserInput2
     * @depends OSR_3_AccessTest0::testOSR_GetAuthorityName0
     * @depends OSR_3_AccessTest0::testOSR_GetAuthorityName1
     * @depends OSR_3_AccessTest0::testOSR_GetAuthorityCode0
     * @depends OSR_3_AccessTest0::testOSR_GetAuthorityCode1
     */
    public function testOSR_AutoIdentifyEPSG0()
    {
        $hRef = OSR_NewSpatialReference();
        $projFile = test_data_path("osr", "wgs84.prj");
        $eErr = OSR_SetFromUserInput($hRef, $projFile);
        $this->assertSame(OGRERR_NONE, $eErr, "Could not load " . $projFile);
        $code = OSR_GetAuthorityCode($hRef, null);
        $this->assertNull($code, "Authority code should initially be unset");
        $authority = OSR_GetAuthorityName($hRef, null);
        $this->assertNull($authority, "Authority name should initially be unset");
        $eErr = OSR_AutoIdentifyEPSG($hRef);
        $this->assertSame(
            OGRERR_NONE,
            $eErr,
            "OSR_AutoIdentifyEPSG should return OGRERR_NONE for WGS84"
        );
        $code = OSR_GetAuthorityCode($hRef, null);
        $this->assertSame("4326", $code, "Authority code be identified as 4326");
        $authority = OSR_GetAuthorityName($hRef, null);
        $this->assertEquals("EPSG", $authority, "Authority name should be identifed as EPSG");
    }

    /**
     * Test OSR_AutoIdentifyEPSG() with success
     *
     * @depends OSR_1_ImportTest0::testOSR_SetFromUserInput2
     * @depends OSR_2_ExportTest0::testOSR_ExportToWKT0
     */
    public function testOSR_AutoIdentifyEPSG1()
    {
        $hRef = OSR_NewSpatialReference();
        $wktFile = test_data_path("osr", "local.wkt");
        $eErr = OSR_SetFromUserInput($hRef, $wktFile);
        $this->assertSame(OGRERR_NONE, $eErr, "Could not load " . $wktFile);
        $eErr = OSR_AutoIdentifyEPSG($hRef);
        $this->assertSame(
            OGRERR_UNSUPPORTED_SRS,
            $eErr,
            "OSR_AutoIdentifyEPSG should return OGRERR_UNSUPPORTED_SRS for a local reference system"
        );
    }

    /**
     * Tests OSR_EPSGTreatsAsLatLong() with expected TRUE
     *
     * @depends OSR_1_ImportTest0::testOSR_ImportFromEPSGA0
     */
    public function testOSR_EPSGTreatsAsLatLong0()
    {
        $hRef = OSR_NewSpatialReference();
        OSR_ImportFromEPSGA($hRef, 4326);
        $actual = OSR_EPSGTreatsAsLatLong($hRef);
        $this->assertTrue(
            $actual,
            "OSR_EPSGTreatsAsLatLong should be TRUE for strict EPSG:4326"
        );
    }

    /**
     * Tests OSR_EPSGTreatsAsLatLong() with expected FALSE
     *
     * @depends OSR_1_ImportTest0::testOSR_ImportFromEPSG0
     */
    public function testOSR_EPSGTreatsAsLatLong1()
    {
        $hRef = OSR_NewSpatialReference();
        OSR_ImportFromEPSG($hRef, 4326);
        $actual = OSR_EPSGTreatsAsLatLong($hRef);
        $this->assertFalse(
            $actual,
            "OSR_EPSGTreatsAsLatLong should be FALSE for non-strict EPSG:4326"
        );
    }

    /**
     * Tests OSR_EPSGTreatsAsLatLong() with expected FALSE
     *
     * @depends OSR_1_ImportTest0::testOSR_ImportFromEPSGA0
     */
    public function testOSR_EPSGTreatsAsLatLong2()
    {
        $hRef = OSR_NewSpatialReference();
        OSR_ImportFromEPSGA($hRef, 25833);
        $actual = OSR_EPSGTreatsAsLatLong($hRef);
        $this->assertFalse(
            $actual,
            "OSR_EPSGTreatsAsLatLong should be FALSE for strict EPSG:25833"
        );
    }
}
