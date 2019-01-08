<?php

class OGRFeatureTest0 extends PHPUnit_Framework_TestCase
{
    public $strPathToData;
    public $strPathToStandardData;
    public $strPathToOutputData;
    public $strTmpDumpFile;
    public $bUpdate;
    public $eGeometryType;
    public $strDestDataSource;
    public $strOutputLayer;

    // called before the test functions will be executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    public function setUp()
    {
        $this->strPathToData = "./data/mif";
        $this->strPathToStandardData = "./data/testcase/";
        $this->strPathToOutputData = "../../ogrtests/testcase/";
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->bUpdate = false;
        $this->eGeometryType = wkbUnknown;
        $this->strDestDataSource = "DSOutput";
        $this->strOutputLayer = "OutputLayer";

        if (file_exists($this->strPathToOutputData)) {
            system("rm -R " . $this->strPathToOutputData);
        }

        mkdir($this->strPathToOutputData, 0777);

        OGRRegisterAll();
    }
    // called after the test functions are executed
    // this function is defined in PHPUnit_Framework_TestCase and overwritten
    // here
    public function tearDown()
    {
        // delete your instance
        unset($this->strPathToData);
        unset($this->strPathToStandardData);
        unset($this->strPathToOutputData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->eGeometryType);
        unset($this->strDestDataSource);
        unset($this->strOutputLayer);
    }

    /***********************************************************************
     *                         testOGR_F_CreateDestroy0()
     *
     ************************************************************************/
    public function testOGR_F_CreateDestroy0()
    {
        $strStandardFile = "testOGR_F_CreateDestroy0.std";

        $hDriver = OGRGetDriver(5);

        $hSpatialRef = null;

        $hODS = OGR_Dr_CreateDataSource(
            $hDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            null /*Options*/
        );

        $hLayer = OGR_DS_CreateLayer(
            $hODS,
            $this->strOutputLayer,
            $hSpatialRef,
            $this->eGeometryType,
            null /*Options*/
        );

        if (OGR_L_CreateField(
                $hLayer,
                OGR_Fld_Create("NewField", OFTInteger),
                0 /*bApproOK*/
            ) != OGRERR_NONE) {
            return (false);
        }

        $hFeature = OGR_F_Create(OGR_L_GetLayerDefn($hLayer));


        $this->assertNotNull(
            $hFeature,
            "OGR_F_Create(): Feature handle is not supposed to be NULL."
        );


        OGR_F_Destroy($hFeature);

        $expected = "Unknown";

        $actual = get_resource_type($hFeature);


        $this->assertEquals(
            $expected,
            $actual,
            "Problem with OGR_F_Destroy():  Feature resource is supposed to be freed after OGR_F_Destroy().\n"
        );


        OGR_DS_Destroy($hODS);
    }

    /***********************************************************************
     *                         testOGR_F_GetDefnRef0()
     *
     ************************************************************************/
    public function testOGR_F_GetDefnRef0()
    {
        OGRRegisterAll();

        $nFeatureId = 10;

        $strStandardFile = "testOGR_F_GetDefnRef0.std";

        $hDriver = OGRGetDriver(5);

        $hExistingDataSource = OGR_Dr_Open(
            $hDriver,
            $this->strPathToData,
            $this->bUpdate
        );

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        if ($fpOut == false) {
            printf("Dump file creation error\n");
            return false;
        }

        $hLayer = OGR_DS_GetLayer($hExistingDataSource, 5);

        $hFeatureDefn = OGR_L_GetLayerDefn($hLayer);

        OGRDumpLayerDefn($fpOut, $hFeatureDefn);

        $hFeature = OGR_L_GetFeature($hLayer, $nFeatureId);

        $hSameFeatureDefn = OGR_F_GetDefnRef($hFeature);

        $this->assertNotNull(
            $hSameFeatureDefn,
            "OGR_F_GetDefnRef Feature handle is not supposed to be NULL."
        );

        OGRDumpLayerDefn($fpOut, $hSameFeatureDefn);

        OGR_F_Destroy($hFeature);

        OGR_DS_Destroy($hExistingDataSource);

        fclose($fpOut);

        system(
            "diff --brief " . $this->strPathToOutputData . $this->strTmpDumpFile . " " . $this->strPathToStandardData . $strStandardFile,
            $iRetval
        );

        $this->assertFalse(
            $iRetval,
            "Problem with OGR_L_GetLayerDefn(), or OGR_F_GetDefnRef(): files comparison did not match.\n"
        );
    }
}
