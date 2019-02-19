<?php

/**
 * Tests for morph to/from ESRI functions in OSR
 *
 * @author Edward Nash <e.nash@dvz-mv.de>
 *
 * @copyright ©2019 DVZ Datenverarbeitungszentrum M-V GmbH
 */
class OSR_3_MorphTest0 extends PHPUnit_Framework_TestCase
{

    /**
     * Test OSR_MorphToESRI() with success
     *
     * @depends OSR_1_ImportTest0::testOSR_SetFromUserInput2
     * @depends OSR_2_ExportTest0::testOSR_ExportToWKT0
     */
    public function testOSR_MorphToESRI0()
    {
        $hRef = OSR_NewSpatialReference();
        $wktFile = test_data_path("osr", "epsg4326.wkt");
        OSR_SetFromUserInput($hRef, $wktFile);
        $eErr = OSR_MorphToESRI($hRef);
        $this->assertEquals(
            OGRERR_NONE,
            $eErr,
            "OSR_MorphToESRI should return OGRERR_NONE"
        );
        $esri = OSR_ExportToWKT($hRef);
        $expected = reference_data_path(__CLASS__, __FUNCTION__ . ".std");
        $this->assertStringEqualsFile(
            $expected,
            $esri,
            "Result of OSR_MorphToESRI does not match expected"
        );
    }

    /**
     * Test OSR_MorphToESRI() with success
     *
     * @depends OSR_1_ImportTest0::testOSR_SetFromUserInput2
     * @depends OSR_2_ExportTest0::testOSR_ExportToWKT0
     */
    public function testOSR_MorphFromESRI0()
    {
        $hRef = OSR_NewSpatialReference();
        $esriFile = test_data_path("osr", "wgs84.prj");
        OSR_SetFromUserInput($hRef, $esriFile);
        $eErr = OSR_MorphFromESRI($hRef);
        $this->assertEquals(
            OGRERR_NONE,
            $eErr,
            "OSR_MorphFromESRI should return OGRERR_NONE"
        );
        $wkt = OSR_ExportToWKT($hRef);
        $expected = reference_data_path(__CLASS__, __FUNCTION__ . ".std");
        $this->assertStringEqualsFile(
            $expected,
            $wkt,
            "Result of OSR_MorphToESRI does not match expected"
        );
    }
}
