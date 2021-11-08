<?php

use \PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class OGRSFDriverRegistrarTest3 extends TestCase
{

    /***********************************************************************
     *                       testOGRGetDriverCount0()
     *               Registered drivers supposed to be zero.
     ************************************************************************/

    public function testOGRGetDriverCount0()
    {
        $nDriverCount = OGRGetDriverCount();

        $expected = 0;
        $this->assertEquals(
            $expected,
            $nDriverCount,
            "Problem with OGRGetDriverCount():  Driver count is supposed to be 0",
            0 /*$delta*/
        );
    }

    /***********************************************************************
     *                       testOGRGetDriverCount2()
     *    Verify driver count with all drivers registered.
     *
     ************************************************************************/
    public function testOGRGetDriverCount2()
    {
        OGRRegisterAll();

        $nDriverCount = OGRGetDriverCount();
        $expected = 0;

        $this->assertGreaterThan(
            $expected,
            $nDriverCount,
            "Problem with OGRGetDriverCount():  Driver count is supposed to be >0 after drivers are registered.",
            0 /*$delta*/
        );
    }

    /***********************************************************************
     *                       testOGRGetDriver0()
     *       Get a driver handle after execution OGRRegisterAll().
     ************************************************************************/
    public function testOGRGetDriver0()
    {
        OGRRegisterAll();

        $hDriver = OGRGetDriver(0);

        $this->assertNotNull(
            $hDriver,
            "Problem with OGRGetDriver():Driver is not supposed to be NULL"
        );
    }

    /***********************************************************************
     *                       testOGRGetDriver1()
     *               Getting a driver with an id out of range.
     ************************************************************************/

    public function testOGRGetDriver1()
    {
        OGRRegisterAll();

        $hDriver = @OGRGetDriver(OGRGetDriverCount() + 10);

        $this->assertNull(
            $hDriver,
            "Problem with OGRGetDriver():  driver handle is supposed to be NULL since requested driver is out of range."
        );
    }
}

?> 
