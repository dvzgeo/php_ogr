<?php

use \PHPUnit\Framework\TestCase;

/**
 * Tests for export in OSR
 *
 * @author Edward Nash <e.nash@dvz-mv.de>
 *
 * @copyright ©2019 DVZ Datenverarbeitungszentrum M-V GmbH
 */
class OSR_2_ExportTest0 extends TestCase
{

    /**
     * Test OSRExportToWKT() with success
     *
     * @depends OSR_1_ImportTest0::testOSR_ImportFromEPSG0
     */
    public function testOSR_ExportToWKT0()
    {
        $hRef = OSR_NewSpatialReference();
        OSR_ImportFromEPSG($hRef, 4326);
        $wkt = OSR_ExportToWKT($hRef);
        $this->assertIsString(
            $wkt,
            "Successful WKT export for EPSG:4326 should be a string"
        );
        $expected = reference_data_path(__CLASS__, __FUNCTION__ . ".std");
        $this->assertStringEqualsFile(
            $expected,
            $wkt,
            "WKT export result mismatch"
        );
    }

    /**
     * Test OSR_ExportToWKT() with a bad result
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     */
    public function testOSR_ExportToWKT1()
    {
        $hRef = OSR_NewSpatialReference();
        $wkt = OSR_ExportToWKT($hRef);
        $this->assertSame(
            "",
            $wkt,
            "WKT export of an empty spatial reference should result in an empty string"
        );
    }

    /**
     * Test OSRExportToPrettyWKT() without simplifying with success
     *
     * @depends OSR_1_ImportTest0::testOSR_SetFromUserInput2
     */
    public function testOSR_ExportToPrettyWKT0()
    {
        $hRef = OSR_NewSpatialReference();
        $testFile = test_data_path('osr', 'epsg4326.wkt');
        OSR_SetFromUserInput($hRef, $testFile);
        $wkt = OSR_ExportToPrettyWKT($hRef, false);
        $this->assertIsString(
            $wkt,
            "Successful pretty WKT export for EPSG:4326 should be a string"
        );
        $expected = reference_data_path(__CLASS__, __FUNCTION__ . ".std");
        $this->assertStringEqualsFile(
            $expected,
            $wkt,
            "Pretty WKT export result mismatch"
        );
    }

    /**
     * Test OSRExportToPrettyWKT() with simplification with success
     *
     * @depends OSR_1_ImportTest0::testOSR_SetFromUserInput2
     */
    public function testOSR_ExportToPrettyWKT1()
    {
        $hRef = OSR_NewSpatialReference();
        $testFile = test_data_path('osr', 'epsg4326.wkt');
        OSR_SetFromUserInput($hRef, $testFile);
        $wkt = OSR_ExportToPrettyWKT($hRef, true);
        $this->assertIsString(
            $wkt,
            "Successful pretty WKT export for EPSG:4326 should be a string"
        );
        $expected = reference_data_path(__CLASS__, __FUNCTION__ . ".std");
        $this->assertStringEqualsFile(
            $expected,
            $wkt,
            "Pretty WKT export result mismatch"
        );
    }

    /**
     * Test OSR_ExportToPrettyWKT() with a bad result
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     */
    public function testOSR_ExportToPrettyWKT2()
    {
        $hRef = OSR_NewSpatialReference();
        $wkt = OSR_ExportToPrettyWKT($hRef, false);
        $this->assertSame(
            "",
            $wkt,
            "Pretty WKT export of an empty spatial reference should result in an empty string"
        );
    }

    /**
     * Test OSRExportToProj4() with success
     *
     * @depends OSR_1_ImportTest0::testOSR_ImportFromEPSG0
     */
    public function testOSR_ExportToProj40()
    {
        $hRef = OSR_NewSpatialReference();
        OSR_ImportFromEPSG($hRef, 4326);
        $proj = OSR_ExportToProj4($hRef);
        $this->assertIsString(
            $proj,
            "Successful Proj4 export for EPSG:4326 should be a string"
        );
        $expected = reference_data_path(__CLASS__, __FUNCTION__ . ".std");
        $this->assertStringEqualsFile(
            $expected,
            $proj,
            "Proj4 export result mismatch"
        );
    }

    /**
     * Test OSR_ExportToProj4() with a bad result
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     */
    public function testOSR_ExportToProj41()
    {
        $hRef = OSR_NewSpatialReference();
        $proj = OSR_ExportToProj4($hRef);
        $this->assertSame(
            "",
            $proj,
            "Proj4 export of an empty spatial reference should result in an empty string"
        );
    }
}
