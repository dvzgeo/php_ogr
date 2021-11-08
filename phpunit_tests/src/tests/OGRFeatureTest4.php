<?php

use \PHPUnit\Framework\TestCase;

class OGRFeatureTest4 extends TestCase
{
    public $strPathToOutputData;
    public $strTmpDumpFile;
    public $strPathToData;
    public $bUpdate;
    public $hDS;
    public $hLayer;
    public $strDestDataSource;

    public static function setUpBeforeClass()
    {
        OGRRegisterAll();
    }

    public function setUp()
    {
        $this->strPathToData = test_data_path("andorra", "mif", "gis_osm_buildings_a_free_1.mif");
        $this->strPathToOutputData = create_temp_directory(__CLASS__);
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->bUpdate = false;
        $this->strDestDataSource = "OutputDS";
    }

    public function tearDown()
    {
        delete_directory($this->strPathToOutputData);
        unset($this->strPathToData);
        unset($this->strPathToDumpData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->strDestDataSource);
        unset($this->hDS);
        unset($this->hLayer);
    }

    /***********************************************************************
     *                            testOGR_F_SetGetStyleString()
     ************************************************************************/

    public function testOGR_F_SetGetStyleString()
    {
        $hDriver = null;
        $hSrcDS = OGROpen($this->strPathToData, $this->bUpdate, $hDriver);

        $hSrcLayer = OGR_DS_GetLayerByName($hSrcDS, "gis_osm_buildings_a_free_1");

        $iFID = 2;
        $hSrcF = OGR_L_GetFeature($hSrcLayer, $iFID);

        $strStyleString = OGR_F_GetStyleString($hSrcF);
        $this->assertNotEmpty($strStyleString, "Existing style string should not be empty");

        $iDriver = "ESRI Shapefile";
        $hDriver = OGRGetDriverByName($iDriver);
        $astrOptions = null;
        $hDestDS = OGR_Dr_CreateDataSource(
            $hDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            $astrOptions
        );

        $this->assertNotNull($hDestDS, "Unable to create destination data source");
        $iLayer = 0;
        $hLayerDest = OGR_DS_CreateLayer($hDestDS, $this->strDestDataSource, null, wkbPolygon, null);

        $hFieldDefn = OGR_Fld_Create("id", OFTInteger);
        $eErr = OGR_L_CreateField($hLayerDest, $hFieldDefn, 0 /*bApproxOK*/);

        $hFeatureDefn = OGR_L_GetLayerDefn($hLayerDest);
        $hDestF = OGR_F_Create($hFeatureDefn);

        OGR_F_SetStyleString($hDestF, $strStyleString);

        $strStyleStringOut = OGR_F_GetStyleString($hDestF);

        $expected = $strStyleString;
        $this->AssertEquals(
            $expected,
            $strStyleStringOut,
            "Problem with OGR_F_SetStyleString() or OGR_F_GetStyleString()."
        );

        OGR_F_Destroy($hSrcF);
        OGR_F_Destroy($hDestF);
        OGR_DS_Destroy($hDestDS);
        OGR_DS_Destroy($hSrcDS);
    }
}
