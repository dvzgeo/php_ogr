<?php
require_once 'phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRLayerTest0 extends PHPUnit_TestCase {
    var $strPathToData;
    var $strPathToOutputData;
    var $bUpdate;
    var $hOGRSFDriver;
    var $strFilename;
    var $strCapability;
    var $strLayerName;
    var $hSRS;
    var $eGeometryType;
    var $strDialect;
    var $strFormat;
    var $strDestDataSource;


    // constructor of the test suite
    function OGRLayerTest0($name){
        $this->PHPUnit_TestCase($name);
    }
    // called before the test functions will be executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here
    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strPathToOutputData = "../../ogrtests/testcase/";
        $this->strFilename = "NewDataSource";
        $this->bUpdate = FALSE;
        $this->strCapability[0] = "OLCRandomRead";
        $this->strCapability[1] = "OLCSequentialWrite";
        $this->strCapability[2] = "OLCRandomWrite";
        $this->strCapability[3] = "OLCFastSpatialFilter";
        $this->strCapability[4] = "OLCFastFeatureCount";
        $this->strCapability[5] = "OLCFastGetExtent";
        $this->strLayerName = "LayerPoint";
        $this->hSRS = null;
        $this->eGeometryType = wkbPoint;
        $this->strDialect = ""; /*"Generic SQL"*/
        $this->strFormat = "MapInfo File";
        $this->strDestDataSource = "Output";
    }
    // called after the test functions are executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here    
    function tearDown() {
        // delete your instance
        unset($this->strPathToData);
        unset($this->strPathToOutputData);
        unset($this->strFilename);
        unset($this->bUpdate);
        unset($this->strCapability);
        unset($this->strLayerName);
        unset($this->hSRS);
        unset($this->eGeometryType);
        unset($this->strFormat);
        unset($this->strDestDataSource);
    }

/***********************************************************************
*                         testOGR_L_GetLayerDefn0()                    
*                      
************************************************************************/

    function testOGR_L_GetLayerDefn1() {
        OGRRegisterAll();
        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                               $this->strPathToData,
                                               $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 1);

        $hFeatureDefn = OGR_L_GetLayerDefn($hLayer);

        $this->assertNotNull($hFeatureDefn, "Layer definition
                            is not supposed to be NULL.\n");

        OGR_DS_Destroy($hExistingDataSource);
    }

/***********************************************************************
*                         testOGR_L_TestCapability0()                    
*                         OLCRandomRead
************************************************************************/

    function testOGR_L_TestCapability0() {

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                               $this->strPathToData,
                                               $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 1);

        $iCapability = OGR_L_TestCapability($hLayer, $this->strCapability[0]);

        $this->assertTrue($iCapability,$this->strCapability[0]." capability".
                          " is supposed to be supported" );

        OGR_DS_Destroy($hExistingDataSource);
    }

/***********************************************************************
*                         testOGR_L_TestCapability1()                    
*                         OLCSequentialWrite
************************************************************************/

    function testOGR_L_TestCapability1() {

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                               $this->strPathToData,
                                               $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 1);

        $iCapability = OGR_L_TestCapability($hLayer, $this->strCapability[1]);

        $this->assertFalse($iCapability,$this->strCapability[1]." capability".
                          " is not supposed to be supported since".
                          "bUpdate is FALSE" );

        OGR_DS_Destroy($hExistingDataSource);
    }
/***********************************************************************
*                         testOGR_L_TestCapability2()                    
*                         OLCRandowWrite
************************************************************************/

    function testOGR_L_TestCapability2() {

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                               $this->strPathToData,
                                               $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 1);

        $iCapability = OGR_L_TestCapability($hLayer, $this->strCapability[2]);

        $this->assertFalse($iCapability,$this->strCapability[2]." capability".
                          " is supposed to be supported" );

        OGR_DS_Destroy($hExistingDataSource);
    }
/***********************************************************************
*                         testOGR_L_TestCapability3()                    
*                         OLCFastSpatialFilter
************************************************************************/

    function testOGR_L_TestCapability3() {

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                               $this->strPathToData,
                                               $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 1);
        OGR_L_SetSpatialFilter($hLayer, null);
        OGR_L_SetAttributeFilter($hLayer, null);

        $iCapability = OGR_L_TestCapability($hLayer, $this->strCapability[3]);

        $this->assertTrue($iCapability,$this->strCapability[3]." capability".
                          " is supposed to be supported" );

        OGR_DS_Destroy($hExistingDataSource);
    }
/***********************************************************************
*                         testOGR_L_TestCapability4()                    
*                          OLCFastFeatureCount
************************************************************************/

    function testOGR_L_TestCapability4() {

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                               $this->strPathToData,
                                               $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 1);

        $iCapability = OGR_L_TestCapability($hLayer, $this->strCapability[4]);

        $this->assertTrue($iCapability,$this->strCapability[4]." capability".
                          " is supposed to be supported" );

        OGR_DS_Destroy($hExistingDataSource);
    }

/***********************************************************************
*                         testOGR_L_TestCapability5()                    
*                         OLCFastGetExtent
************************************************************************/

    function testOGR_L_TestCapability5() {

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                               $this->strPathToData,
                                               $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 1);

        $iCapability = OGR_L_TestCapability($hLayer, $this->strCapability[5]);

        $this->assertTrue($iCapability,$this->strCapability[5]." capability".
                          " is supposed to be supported" );

        OGR_DS_Destroy($hExistingDataSource);
    }


}
?> 
