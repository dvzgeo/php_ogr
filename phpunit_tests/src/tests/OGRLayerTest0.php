<?php

class OGRLayerTest0 extends PHPUnit_Framework_TestCase
{
    public $strPathToData;
    public $strPathToOutputData;
    public $bUpdate;
    public $hOGRSFDriver;
    public $strCapability;
    public $hLayer;
    public $hSrcDataSource;

    // called before the test functions will be executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    public function setUp()
    {
        $this->strPathToOutputData = create_temp_directory(__CLASS__);
        $this->strPathToData = "./data/mif";
        $this->bUpdate = false;
        $this->strCapability[0] = OLCRandomRead;
        $this->strCapability[1] = OLCSequentialWrite;
        $this->strCapability[2] = OLCRandomWrite;
        $this->strCapability[3] = OLCFastSpatialFilter;
        $this->strCapability[4] = OLCFastFeatureCount;
        $this->strCapability[5] = OLCFastGetExtent;

        OGRRegisterAll();
        $this->hOGRSFDriver = OGRGetDriver(5);

        $this->hSrcDataSource = OGR_Dr_Open(
            $this->hOGRSFDriver,
            $this->strPathToData,
            $this->bUpdate
        );

        $this->hLayer = OGR_DS_GetLayer($this->hSrcDataSource, 1);
    }
    // called after the test functions are executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    public function tearDown()
    {
        // delete your instance
        OGR_DS_Destroy($this->hSrcDataSource);
        delete_directory($this->strPathToOutputData);
        unset($this->strPathToOutputData);
        unset($this->strPathToData);
        unset($this->bUpdate);
        unset($this->hOGRSFDriver);
        unset($this->strCapability);
        unset($this->hLayer);
        unset($this->hSrcDataSource);
    }

    /***********************************************************************
     *                         testOGR_L_GetLayerDefn0()
     *
     ************************************************************************/
    public function testOGR_L_GetLayerDefn0()
    {
        $hFeatureDefn = OGR_L_GetLayerDefn($this->hLayer);

        $this->assertNotNull(
            $hFeatureDefn,
            "Problem with OGR_L_GetLayerDefn():  Layer definition is not supposed to be NULL.\n"
        );
    }

    /***********************************************************************
     *                         testOGR_L_TestCapability0()
     *                         OLCRandomRead
     ************************************************************************/
    public function testOGR_L_TestCapability0()
    {
        $bCapability = OGR_L_TestCapability(
            $this->hLayer,
            $this->strCapability[0]
        );

        $this->assertTrue(
            $bCapability,
            "Problem with OGR_L_TestCapability(): " . $this->strCapability[0] . " capability is supposed to be supported."
        );
    }

    /***********************************************************************
     *                         testOGR_L_TestCapability1()
     *                         OLCSequentialWrite
     ************************************************************************/
    public function testOGR_L_TestCapability1()
    {
        $bCapability = OGR_L_TestCapability(
            $this->hLayer,
            $this->strCapability[1]
        );

        $this->assertFalse(
            $bCapability,
            "Problem with OGR_L_TestCapability(): " . $this->strCapability[1] . " capability is not supposed to be supported since bUpdate is FALSE."
        );
    }

    /***********************************************************************
     *                         testOGR_L_TestCapability2()
     *                         OLCRandowWrite
     ************************************************************************/
    public function testOGR_L_TestCapability2()
    {
        $bCapability = OGR_L_TestCapability(
            $this->hLayer,
            $this->strCapability[2]
        );

        $this->assertFalse(
            $bCapability,
            "Problem with OGR_L_TestCapability(): " . $this->strCapability[2] . " capability is not supposed to be supported."
        );
    }

    /***********************************************************************
     *                         testOGR_L_TestCapability3()
     *                         OLCFastSpatialFilter
     ************************************************************************/
    public function testOGR_L_TestCapability3()
    {
        OGR_L_SetSpatialFilter($this->hLayer, null);
        OGR_L_SetAttributeFilter($this->hLayer, null);

        $bCapability = OGR_L_TestCapability(
            $this->hLayer,
            $this->strCapability[3]
        );

        $this->assertTrue(
            $bCapability,
            "Problem with OGR_L_TestCapability(): " . $this->strCapability[3] . " capability is supposed to be supported."
        );
    }

    /***********************************************************************
     *                         testOGR_L_TestCapability4()
     *                          OLCFastFeatureCount
     ************************************************************************/
    public function testOGR_L_TestCapability4()
    {
        $bCapability = OGR_L_TestCapability(
            $this->hLayer,
            $this->strCapability[4]
        );

        $this->assertTrue(
            $bCapability,
            "Problem with OGR_L_TestCapability(): " . $this->strCapability[4] . " capability is supposed to be supported."
        );
    }

    /***********************************************************************
     *                         testOGR_L_TestCapability5()
     *                         OLCFastGetExtent
     ************************************************************************/
    public function testOGR_L_TestCapability5()
    {
        $bCapability = OGR_L_TestCapability(
            $this->hLayer,
            $this->strCapability[5]
        );

        $this->assertTrue(
            $bCapability,
            "Problem with OGR_L_TestCapability(): " . $this->strCapability[5] . " capability is supposed to be supported."
        );
    }
}
