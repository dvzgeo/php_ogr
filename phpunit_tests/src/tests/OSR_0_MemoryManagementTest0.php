<?php

use \PHPUnit\Framework\TestCase;

/**
 * Tests for basic memory management in OSR
 *
 * @author Edward Nash <e.nash@dvz-mv.de>
 *
 * @copyright ©2019 DVZ Datenverarbeitungszentrum M-V GmbH
 */
class OSR_0_MemoryManagementTest0 extends TestCase
{

    /**
     * Test OSR_NewSpatialReference()
     */
    public function testOSR_NewSpatialReference()
    {
        $hRef = OSR_NewSpatialReference();
        $this->assertNotNull($hRef, "New spatial reference should not be NULL");
        $this->assertInternalType(
            "resource",
            $hRef,
            "New spatial reference should be a resource"
        );
        $this->assertEquals(
            "OGRSpatialReference",
            get_resource_type($hRef),
            "New spatial reference resource type should be OGRSpatialReference"
        );
    }

    /**
     * Test OSR_DestroySpatialReference()
     *
     * @depends testOSR_NewSpatialReference
     */
    public function testOSR_DestroySpatialReference()
    {
        $hRef = OSR_NewSpatialReference();
        OSR_DestroySpatialReference($hRef);
        $this->assertInternalType(
            "resource",
            $hRef,
            "Destroyed spatial reference is still a resource"
        );
        $this->assertEquals(
            "Unknown",
            get_resource_type($hRef),
            "Destroyed spatial reference resource type should be Unkown"
        );
    }

    /**
     * Test OSR_Reference()
     *
     * @depends testOSR_NewSpatialReference
     */
    public function testOSR_Reference()
    {
        $hRef = OSR_NewSpatialReference();
        $this->assertEquals(
            2,
            OSR_Reference($hRef),
            "First explicit call to OSR_Reference should yield 2"
        );
        $this->assertEquals(
            3,
            OSR_Reference($hRef),
            "Second explicit call to OSR_Reference should yield 3"
        );
    }

    /**
     * Test OSR_Dereference()
     *
     * @depends testOSR_Reference
     */
    public function testOSR_Dereference()
    {
        $hRef = OSR_NewSpatialReference();
        OSR_Reference($hRef);
        $this->assertEquals(
            1,
            OSR_Dereference($hRef),
            "Should be 1 remaining reference after OSR_Reference + OSR_Dereference"
        );
        $this->assertEquals(
            0,
            OSR_Dereference($hRef),
            "Should be 0 remaining references after further OSR_Dereference"
        );
        $this->assertEquals(
            "OGRSpatialReference",
            get_resource_type($hRef),
            "Spatial reference resource type should still be OGRSpatialReference"
        );
        $this->assertEquals(
            -1,
            OSR_Dereference($hRef),
            "Should now be -1 explicit reference"
        );
        $this->assertEquals(
            "OGRSpatialReference",
            get_resource_type($hRef),
            "Spatial reference resource type should still be OGRSpatialReference"
        );
    }

    /**
     * Test OSR_Release()
     *
     * @depends testOSR_Reference
     */
    public function testOSR_Release()
    {
        $hRef = OSR_NewSpatialReference();
        OSR_Reference($hRef);
        OSR_Reference($hRef);
        OSR_Release($hRef);
        $this->assertEquals(
            "OGRSpatialReference",
            get_resource_type($hRef),
            "Spatial reference resource type should still be OGRSpatialReference as there is still an explicit reference"
        );
        OSR_Release($hRef);
        $this->assertEquals(
            "OGRSpatialReference",
            get_resource_type($hRef),
            "Spatial reference resource type should be Unknown once reference count reaches 0"
        );
    }
}
