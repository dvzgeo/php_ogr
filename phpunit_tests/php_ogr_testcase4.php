<?php

$testSuites_list[] = "OGRLayerTest0";                             

class OGRLayerTest0 extends PHPUnit_TestCase {
    var $strPathToData;
    var $strDirName;
    var $strPathToOutputData;
    var $bUpdate;
    var $hOGRSFDriver;
    var $strCapability;
    var $hLayer;
    var $hSrcDataSource;

    // called before the test functions will be executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here
    function setUp() {
        $this->strDirName = "testcase/";
	$this->strPathToOutputData = "../../ogrtests/".$this->strDirName;
        $this->strPathToData = "./data/mif";
        $this->bUpdate = FALSE;
        $this->strCapability[0] = OLCRandomRead;
        $this->strCapability[1] = OLCSequentialWrite;
        $this->strCapability[2] = OLCRandomWrite;
        $this->strCapability[3] = OLCFastSpatialFilter;
        $this->strCapability[4] = OLCFastFeatureCount;
        $this->strCapability[5] = OLCFastGetExtent;

        if (file_exists($this->strPathToOutputData)) {
            system( "rm -R ".$this->strPathToOutputData);
        }
        mkdir($this->strPathToOutputData, 0777);


        OGRRegisterAll();
        $this->hOGRSFDriver = OGRGetDriver(5);

        $this->hSrcDataSource =  OGR_Dr_Open($this->hOGRSFDriver,
                                               $this->strPathToData,
                                               $this->bUpdate);

        $this->hLayer = OGR_DS_GetLayer($this->hSrcDataSource, 1);

    }
    // called after the test functions are executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here    
    function tearDown() {
        // delete your instance
        OGR_DS_Destroy($this->hSrcDataSource);
        $this->strDirName = "testcase/";
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
    function testOGR_L_GetLayerDefn0() {

        $hFeatureDefn = OGR_L_GetLayerDefn($this->hLayer);

        $this->assertNotNull($hFeatureDefn, "Problem with ".
                             "OGR_L_GetLayerDefn():  Layer definition ".
                             "is not supposed to be NULL.\n");

    }
/***********************************************************************
*                         testOGR_L_TestCapability0()                    
*                         OLCRandomRead
************************************************************************/
    function testOGR_L_TestCapability0() {

        $bCapability = OGR_L_TestCapability($this->hLayer, 
                                            $this->strCapability[0]);

        $this->assertTrue($bCapability, "Problem with ".
                          "OGR_L_TestCapability(): ".$this->strCapability[0].
                          " capability is supposed to be supported." );

    }
/***********************************************************************
*                         testOGR_L_TestCapability1()                    
*                         OLCSequentialWrite
************************************************************************/
    function testOGR_L_TestCapability1() {

        $bCapability = OGR_L_TestCapability($this->hLayer, 
                                            $this->strCapability[1]);

        $this->assertFalse($bCapability, "Problem with ".
                          "OGR_L_TestCapability(): ".$this->strCapability[1].
                          " capability is not supposed to be supported ".
                           "since bUpdate is FALSE." );
    }
/***********************************************************************
*                         testOGR_L_TestCapability2()                    
*                         OLCRandowWrite
************************************************************************/
    function testOGR_L_TestCapability2() {

        $bCapability = OGR_L_TestCapability($this->hLayer, 
                                            $this->strCapability[2]);

        $this->assertFalse($bCapability, "Problem with ".
                          "OGR_L_TestCapability(): ".$this->strCapability[2].
                          " capability is not supposed to be supported." );
    }
/***********************************************************************
*                         testOGR_L_TestCapability3()                    
*                         OLCFastSpatialFilter
************************************************************************/
    function testOGR_L_TestCapability3() {

        OGR_L_SetSpatialFilter($this->hLayer, null);
        OGR_L_SetAttributeFilter($this->hLayer, null);

        $bCapability = OGR_L_TestCapability($this->hLayer, 
                                            $this->strCapability[3]);

        $this->assertTrue($bCapability, "Problem with ".
                          "OGR_L_TestCapability(): ".$this->strCapability[3].
                          " capability is supposed to be supported." );

    }
/***********************************************************************
*                         testOGR_L_TestCapability4()                    
*                          OLCFastFeatureCount
************************************************************************/
    function testOGR_L_TestCapability4() {

        $bCapability = OGR_L_TestCapability($this->hLayer, 
                                            $this->strCapability[4]);

        $this->assertTrue($bCapability, "Problem with ".
                          "OGR_L_TestCapability(): ".$this->strCapability[4].
                          " capability is supposed to be supported." );
    }
/***********************************************************************
*                         testOGR_L_TestCapability5()                    
*                         OLCFastGetExtent
************************************************************************/
    function testOGR_L_TestCapability5() {

        $bCapability = OGR_L_TestCapability($this->hLayer, 
                                            $this->strCapability[5]);

        $this->assertTrue($bCapability, "Problem with ".
                          "OGR_L_TestCapability(): ".$this->strCapability[5].
                          " capability is supposed to be supported." );

    }
}
?> 
