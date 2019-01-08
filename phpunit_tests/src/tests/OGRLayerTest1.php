<?php

class OGRLayerTest1 extends PHPUnit_Framework_TestCase {
    var $strDirName;
    var $strPathToOutputData;
    var $strTmpDumpFile;
    var $strPathToData;
    var $strPathToStandardData;
    var $bUpdate;
    var $hOGRSFDriver;
    var $hLayer;
    var $hSrcDataSource;
    var $iSpatialFilter;

    // called before the test functions will be executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten 
    // here
    function setUp() {
        $this->strDirName = "testcase/";
	$this->strPathToOutputData = "../../ogrtests/".$this->strDirName;
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase/";
        $this->bUpdate = FALSE;
        $this->iSpatialFilter[0] = 3350000;  /*xmin*/
        $this->iSpatialFilter[1] = 4210400;  /*ymin*/
        $this->iSpatialFilter[2] = 3580000;  /*xmax*/
        $this->iSpatialFilter[3] = 4280000;  /*ymax*/

        if (file_exists($this->strPathToOutputData)) {
            system( "rm -R ".$this->strPathToOutputData);
        }
        mkdir($this->strPathToOutputData, 0777);

        OGRRegisterAll();

        $this->hOGRSFDriver = OGRGetDriver(5);

        $this->hSrcDataSource =  OGR_Dr_Open($this->hOGRSFDriver,
                                               $this->strPathToData,
                                               $this->bUpdate);

        $this->hLayer = OGR_DS_GetLayer($this->hSrcDataSource, 4);

    }
    // called after the test functions are executed    
    // this function is defined in PHPUnit_Framework_TestCase and overwritten 
    // here    
    function tearDown() {
        // delete your instance
        OGR_DS_Destroy($this->hSrcDataSource);
        unset($this->strDirname);
        unset($this->strPathToOutputData);
        unset($this->strTmpDumpFile);
        unset($this->strPathToData);
        unset($this->strPathToStandardData);
        unset($this->bUpdate);
        unset($this->hOGRSFDriver);
        unset($this->hLayer);
        unset($this->iSpatialFilter);
        unset($this->hSrcDataSource);
    }
/***********************************************************************
*                         testOGR_L_SetGetSpatialFilter0()                    
*                         
************************************************************************/

    function testOGR_L_SetGetSpatialFilter0() {
            $strStandardFile = "testOGR_L_SetGetSpatialFilter0.std";

            $hSpatialFilter = OGR_G_CreateGeometry(wkbLinearRing);


            OGR_G_AddPoint($hSpatialFilter,$this->iSpatialFilter[0],
                           $this->iSpatialFilter[1] , 0.0 );
            OGR_G_AddPoint($hSpatialFilter,$this->iSpatialFilter[0],
                           $this->iSpatialFilter[3] , 0.0 );
            OGR_G_AddPoint($hSpatialFilter,$this->iSpatialFilter[2],
                           $this->iSpatialFilter[3] , 0.0 );
            OGR_G_AddPoint($hSpatialFilter,$this->iSpatialFilter[2],
                           $this->iSpatialFilter[1] , 0.0 );
            OGR_G_AddPoint($hSpatialFilter,$this->iSpatialFilter[0],
                           $this->iSpatialFilter[1] , 0.0 );

        OGR_L_SetSpatialFilter($this->hLayer, $hSpatialFilter);

        $hSpatialOut = OGR_L_GetSpatialFilter($this->hLayer);

        $this->assertNotNull($hSpatialOut, "Problem with ".
                             "OGR_L_SetSpatialFilter():   Spatial filter ".
                            "is not supposed to be NULL.\n");

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }

        OGR_G_DumpReadable($fpOut, $hSpatialOut);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToOutputData.
                               $this->strTmpDumpFile.
                             " ".$this->strPathToStandardData.
                             $strStandardFile,
                             $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                  "OGR_L_SetSpatialFilter() or OGR_L_GetSpatialFilter(): ".
                  "Files comparison did not matched.\n");
    }
/***********************************************************************
*                         testOGR_L_SetAttributeFilter0()                    
*                         
************************************************************************/

    function testOGR_L_SetAttributeFilter0() {
        $strStandardFile = "testOGR_L_SetAttributeFilter0.std";

        $hSpatialFilter = null;

        $strAttributeFilter = "(PERIMETER <= 100000) AND (LAND_FN_ID > 640)";

        $eErr = OGR_L_SetAttributeFilter($this->hLayer, $strAttributeFilter);

        $this->assertEquals(OGRERR_NONE, $eErr, "Attribute filter 
                            is not supposed to returned an error.\n");

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }
        OGRDumpSingleLayer($fpOut, $this->hLayer, TRUE /*bForce*/);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToOutputData.
                          $this->strTmpDumpFile.
                          " ".$this->strPathToStandardData.$strStandardFile,
                          $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                  "OGR_L_SetAttributeFilter(): ".
                  "Files comparison did not matched.\n");
    }
}
?> 
