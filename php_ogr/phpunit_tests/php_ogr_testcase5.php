<?php
require_once 'phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRLayerTest1 extends PHPUnit_TestCase {
    var $strPathToData;
    var $strPathToStandardData;
    var $strPathToOutputData;
    var $strPathToDumpData;
    var $strTmpDumpFile;
    var $bUpdate;
    var $hOGRSFDriver;
    var $strFilename;
    var $strOutputFilename;
    var $strCapability;
    var $strLayerName;
    var $hSRS;
    var $eGeometryType;
    var $strDialect;
    var $strFormat;
    var $strDestDataSource;


    // constructor of the test suite
    function OGRLayerTest1($name){
        $this->PHPUnit_TestCase($name);
    }
    // called before the test functions will be executed    
    // this function is defined in PHPUnit_TestCase and overwritten 
    // here
    function setUp() {
        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase/";
        $this->strPathToDumpData = "../../ogrtests/testcase/";
        $this->strFilename = "NewDataSource";
        $this->strOutputFilename = "";
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->bUpdate = FALSE;
        $this->iSpatialFilter[0] = 3350000;  /*xmin*/
        $this->iSpatialFilter[1] = 4210400;  /*ymin*/
        $this->iSpatialFilter[2] = 3580000;  /*xmax*/
        $this->iSpatialFilter[3] = 4280000;  /*ymax*/
        $this->strCapability = "OLCFastGetExtent";
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
        unset($this->strPathToStandardData);
        unset($this->strPathToDumpData);
        unset($this->strPathToOutputData);
        unset($this->strFilename);
        unset($this->strTmpDumpFile);
        unset($this->strOutputFilename);
        unset($this->bUpdate);
        unset($this->strCapability);
        unset($this->strLayerName);
        unset($this->hSRS);
        unset($this->eGeometryType);
        unset($this->strFormat);
        unset($this->strDestDataSource);
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

            printf("Xmin = %s Ymin = %s Xmax = %s Ymax = %s\n", 
                   $this->iSpatialFilter[0], $this->iSpatialFilter[1],
                   $this->iSpatialFilter[2], $this->iSpatialFilter[3]);

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource =  OGR_Dr_Open($hDriver,
                                               $this->strPathToData,
                                               $this->bUpdate);

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 4);

        OGR_L_SetSpatialFilter($hLayer, $hSpatialFilter);

        $hSpatialOut = OGR_L_GetSpatialFilter($hLayer);

        $this->assertNotNull($hSpatialOut, "Spatial filter 
                            is not supposed to be NULL.\n");

        $fpOut = fopen($this->strPathToDumpData.
                       $this->strTmpDumpFile, "w");

        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
        }
        OGR_G_DumpReadable($fpOut, $hSpatialOut);

        fclose($fpOut);

        OGR_DS_Destroy($hExistingDataSource);

        printf("diff --brief %s%s %s%s\n",
               $this->strPathToDumpData,
               $this->strTmpDumpFile,
               $this->strPathToStandardData,
               $strStandardFile);

        system("diff --brief ".$this->strPathToDumpData.
                          $this->strTmpDumpFile.
                          " ".$this->strPathToStandardData.$strStandardFile,
                             $iRetval);

        printf("retval = %d\n", $iRetval);

        $this->assertFalse($iRetval, "Files have changed.\n");
    }



}
?> 
