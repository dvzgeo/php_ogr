<?php

use \PHPUnit\Framework\TestCase;

/**
 * Tests for validation in OSR
 *
 * @author Edward Nash <e.nash@dvz-mv.de>
 *
 * @copyright ©2019 DVZ Datenverarbeitungszentrum M-V GmbH
 */
class OSR_0_ValidationTest0 extends TestCase
{

    /**
     * Test OSR_Validate() with a failure
     *
     * @depends OSR_0_MemoryManagementTest0::testOSR_NewSpatialReference
     */
    public function testOSR_Validate0()
    {
        $hRef = OSR_NewSpatialReference();
        $this->assertNotSame(
            OGRERR_NONE,
            OSR_Validate($hRef),
            "New spatial reference should not validate"
        );
    }
}
