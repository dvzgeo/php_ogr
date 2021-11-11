<?php

use \PHPUnit\Framework\TestCase;

/**
 * Tests for import functions in OSR
 *
 * @author Edward Nash <e.nash@dvz-mv.de>
 *
 * @copyright ©2019 DVZ Datenverarbeitungszentrum M-V GmbH
 */
class OSR_1_ImportTest0 extends TestCase
{

    /**
     * Test OSR_ImportFromEPSG() with success
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     * @depends OSR_0_ValidationTest0::testOSR_Validate0
     */
    public function testOSR_ImportFromEPSG0()
    {
        $hRef = OSR_NewSpatialReference();
        $eErr = OSR_ImportFromEPSG($hRef, 4326);
        $this->assertSame(
            OGRERR_NONE,
            $eErr,
            "Importing EPSG:4326 should return OGRERR_NONE"
        );
        $this->assertSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "Validation should be successful after successful EPSG import"
        );
    }

    /**
     * Test OSR_ImportFromEPSG() with failure
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     * @depends OSR_0_ValidationTest0::testOSR_Validate0
     */
    public function testOSR_ImportFromEPSG1()
    {
        $hRef = OSR_NewSpatialReference();
        $eErr = OSR_ImportFromEPSG($hRef, 0);
        $this->assertNotSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "Validation should fail after unsuccessful EPSG import"
        );
        /* TODO */
        if ($eErr === OGRERR_NONE) {
            $this->markTestSkipped(
                "OGR raises an error but returns OGRERR_NONE when importing an invalid EPSG code"
            );
        }
        $this->assertNotSame(
            OGRERR_NONE,
            $eErr,
            "Importing EPSG:0 should not return OGRERR_NONE"
        );
    }

    /**
     * Test OSR_ImportFromEPSGA() with success
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     * @depends OSR_0_ValidationTest0::testOSR_Validate0
     */
    public function testOSR_ImportFromEPSGA0()
    {
        $hRef = OSR_NewSpatialReference();
        $eErr = OSR_ImportFromEPSGA($hRef, 4326);
        $this->assertSame(
            OGRERR_NONE,
            $eErr,
            "Importing EPSG:4326 should return OGRERR_NONE"
        );
        $this->assertSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "Validation should be successful after successful EPSGA import"
        );
    }

    /**
     * Test OSR_ImportFromEPSG() with failure
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     * @depends OSR_0_ValidationTest0::testOSR_Validate0
     */
    public function testOSR_ImportFromEPSGA1()
    {
        $hRef = OSR_NewSpatialReference();
        $eErr = OSR_ImportFromEPSGA($hRef, 0);
        $this->assertNotSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "Validation should fail after unsuccessful EPSGA import"
        );
        /* TODO */
        if ($eErr === OGRERR_NONE) {
            $this->markTestSkipped(
                "OGR raises an error but returns OGRERR_NONE when importing an invalid EPSG code"
            );
        }
        $this->assertNotSame(
            OGRERR_NONE,
            $eErr,
            "Importing EPSG:0 should not return OGRERR_NONE"
        );
    }

    /**
     * Test OSR_ImportFromWKT() with success
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     * @depends OSR_0_ValidationTest0::testOSR_Validate0
     */
    public function testOSR_ImportFromWKT0()
    {
        $hRef = OSR_NewSpatialReference();
        $wktFile = test_data_path("osr", "epsg4326.wkt");
        $wkt = file_get_contents($wktFile);
        $this->assertNotFalse($wkt, "Could not read test data from " . $wktFile);
        $eErr = OSR_ImportFromWKT($hRef, $wkt);
        $this->assertSame(
            OGRERR_NONE,
            $eErr,
            "Importing valid WKT should return OGRERR_NONE"
        );
        $this->assertSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "Validation should be successful after successful WKT import"
        );
    }

    /**
     * Test OSR_ImportFromWKT() with failure
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     * @depends OSR_0_ValidationTest0::testOSR_Validate0
     */
    public function testOSR_ImportFromWKT1()
    {
        $hRef = OSR_NewSpatialReference();
        $eErr = OSR_ImportFromWKT($hRef, "foobar");
        $this->assertNotSame(
            OGRERR_NONE,
            $eErr,
            "Importing invalid WKT should not return OGRERR_NONE"
        );
        $this->assertNotSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "Validation should fail after unsuccessful WKT import"
        );
    }

    /**
     * Test OSR_ImportFromProj4() with success
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     * @depends OSR_0_ValidationTest0::testOSR_Validate0
     */
    public function testOSR_ImportFromProj40()
    {
        $hRef = OSR_NewSpatialReference();
        $projFile = test_data_path("osr", "wgs84.proj");
        $proj = file_get_contents($projFile);
        $this->assertNotFalse($proj, "Could not read test data from " . $projFile);
        $eErr = OSR_ImportFromProj4($hRef, $proj);
        $this->assertSame(
            OGRERR_NONE,
            $eErr,
            "Importing valid WKT should return OGRERR_NONE"
        );
        $this->assertSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "Validation should be successful after successful WKT import"
        );
    }

    /**
     * Test OSR_ImportFromProj4() with failure
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     * @depends OSR_0_ValidationTest0::testOSR_Validate0
     */
    public function testOSR_ImportFromProj41()
    {
        $hRef = OSR_NewSpatialReference();
        $eErr = OSR_ImportFromProj4($hRef, "foobar");
        $this->assertNotSame(
            OGRERR_NONE,
            $eErr,
            "Importing invalid WKT should not return OGRERR_NONE"
        );
        $this->assertNotSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "Validation should fail after unsuccessful Proj4 import"
        );
    }

    /**
     * Test OSR_ImportFromESRI() with success
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     * @depends OSR_0_ValidationTest0::testOSR_Validate0
     */
    public function testOSR_ImportFromESRI0()
    {
        $hRef = OSR_NewSpatialReference();
        $prjFile = test_data_path("osr", "wgs84.prj");
        $prj = file($prjFile);
        $this->assertNotFalse($prj, "Could not read test data from " . $prjFile);
        $eErr = OSR_ImportFromESRI($hRef, $prj);
        $this->assertSame(
            OGRERR_NONE,
            $eErr,
            "Importing valid ESRI .prj should return OGRERR_NONE"
        );
        $this->assertSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "Validation should be successful after successful ESRI .prj import"
        );
    }

    /**
     * Test OSR_ImportFromESRI() with failure
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     * @depends OSR_0_ValidationTest0::testOSR_Validate0
     */
    public function testOSR_ImportFromESRI1()
    {
        $hRef = OSR_NewSpatialReference();
        $eErr = OSR_ImportFromESRI($hRef, array("foobar"));
        $this->assertNotSame(
            OGRERR_NONE,
            $eErr,
            "Importing invalid ESRI .prj should not return OGRERR_NONE"
        );
        $this->assertNotSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "Validation should fail after unsuccessful ESRI .prj import"
        );
    }

    /**
     * Test OSR_SetFromUserInput() with a valid string
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     * @depends OSR_0_ValidationTest0::testOSR_Validate0
     */
    public function testOSR_SetFromUserInput0()
    {
        $hRef = OSR_NewSpatialReference();
        $wktFile = test_data_path("osr", "epsg4326.wkt");
        $wkt = file_get_contents($wktFile);
        $this->assertNotFalse($wkt, "Could not read test data from " . $wktFile);
        $eErr = OSR_SetFromUserInput($hRef, $wkt);
        $this->assertSame(
            OGRERR_NONE,
            $eErr,
            "Importing valid WKT with OSR_SetFromUserInput should return OGRERR_NONE"
        );
        $this->assertSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "Validation should be successful after successful OSR_SetFromUserInput"
        );
    }

    /**
     * Test OSR_SetFromUserInput() with an invalid string
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     * @depends OSR_0_ValidationTest0::testOSR_Validate0
     */
    public function testOSR_SetFromUserInput1()
    {
        $hRef = OSR_NewSpatialReference();
        $eErr = OSR_SetFromUserInput($hRef, 'foobar');
        $this->assertNotSame(
            OGRERR_NONE,
            $eErr,
            "OSR_SetFromUserInput with invalid input should not return OGRERR_NONE"
        );
        $this->assertNotSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "Validation should fail after unsuccessful OSR_SetFromUserInput"
        );
    }

    /**
     * Test OSR_SetFromUserInput() with a valid file path
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     * @depends OSR_0_ValidationTest0::testOSR_Validate0
     */
    public function testOSR_SetFromUserInput2()
    {
        $hRef = OSR_NewSpatialReference();
        $prjFile = test_data_path("osr", "wgs84.prj");
        $eErr = OSR_SetFromUserInput($hRef, $prjFile);
        $this->assertSame(
            OGRERR_NONE,
            $eErr,
            "Importing a valid file with OSR_SetFromUserInput should return OGRERR_NONE"
        );
        $this->assertSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "Validation should be successful after successful OSR_SetFromUserInput"
        );
    }
}
