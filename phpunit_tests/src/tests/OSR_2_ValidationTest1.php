<?php

/**
 * Tests for successful validation in OSR
 *
 * @author Edward Nash <e.nash@dvz-mv.de>
 *
 * @copyright ©2019 DVZ Datenverarbeitungszentrum M-V GmbH
 */
class OSR_2_ValidationTest1 extends PHPUnit_Framework_TestCase
{

    /**
     * Test OSR_Validate() with success
     *
     * @depends OSR_1_ImportTest0::testOSR_ImportFromEPSG0
     */
    public function testOSR_Validate1()
    {
        $hRef = OSR_NewSpatialReference();
        OSR_ImportFromEPSG($hRef, 4326);
        $this->assertSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "EPSG:4326 should validate"
        );
    }
}
