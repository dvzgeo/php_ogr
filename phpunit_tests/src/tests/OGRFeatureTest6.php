<?php

use \PHPUnit\Framework\TestCase;

class OGRFeatureTest6 extends TestCase
{
    public $strPathToOutputData;
    public $strTmpDumpFile;
    public $strPathToData;
    public $bUpdate;
    public $hDestDS;
    public $hDestLayer;
    public $strDestDataSource;
    public $hOGRSFDriver;
    public $astrOptions;

    public static function setUpBeforeClass()
    {
        OGRRegisterAll();
    }

    public function setUp()
    {
        $this->strPathToData = test_data_path("andorra", "shp");
        $this->strPathToOutputData = create_temp_directory(__CLASS__);
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->bUpdate = false;
        $this->strDestDataSource = "OutputDS.gml";

        $iDriver = "GML";  /*Must support list datatypes.*/
        $this->hOGRSFDriver = OGRGetDriverByName($iDriver);
        $this->astrOptions = array("XSISCHEMA=OFF");
        $this->hDestDS = OGR_Dr_CreateDataSource(
            $this->hOGRSFDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            $this->astrOptions
        );

        $this->assertNotNull(
            $this->hDestDS,
            "Unable to create destination data source"
        );

        $this->hDestLayer = OGR_DS_CreateLayer(
            $this->hDestDS,
            $this->strDestDataSource,
            null,
            wkbPoint,
            array("XSISCHEMA=OFF")
        );
        $this->assertNotNull($this->hDestLayer, "Unable to create layer");
    }

    public function tearDown()
    {
        delete_directory($this->strPathToOutputData);
        OGR_DS_Destroy($this->hDestDS);
        unset($this->strPathToData);
        unset($this->strPathToOutputData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->strDestDataSource);
        unset($this->hDestLayer);
        unset($this->hDestDS);
        unset($this->OGRSFDriver);
        unset($this->astrOptions);
    }

    /***********************************************************************
     *                            testOGR_F_SetGetFieldIntegerList()
     ************************************************************************/

    public function testOGR_F_SetGetFieldIntegerList()
    {
        $iListValueIn[0] = 31;
        $iListValueIn[1] = 25;
        $iListValueIn[2] = 12;
        $numInteger = 3;

        $hFieldDefn = OGR_Fld_Create("age", OFTIntegerList);
        $this->assertNotNull($hFieldDefn, "Could not create field definition");
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        $this->assertEquals(OGRERR_NONE, $eErr, "Error creating field.");
        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $this->assertNotNull($hFeatureDefn, "Could not retrieve feature definition");
        OGR_FD_AddFieldDefn($hFeatureDefn, $hFieldDefn);
        $hF = OGR_F_Create($hFeatureDefn);
        $this->assertNotNull($hF, "Could not create feature");
        $iFieldIndex = 0;
        OGR_F_SetFieldIntegerList(
            $hF,
            $iFieldIndex,
            $numInteger,
            $iListValueIn
        );
        $iListValueOut = OGR_F_GetFieldAsIntegerList(
            $hF,
            $iFieldIndex,
            $nCount
        );
        $expected = serialize($iListValueIn);
        $actual = serialize($iListValueOut);
        $this->AssertEquals(
            $expected,
            $actual,
            "Problem with OGR_F_SetFieldIntegerList() or OGR_F_GetFieldAsIntegerList()."
        );
        $this->AssertEquals(
            $numInteger,
            $nCount,
            "Wrong integer count in OGR_F_GetAsIntegerList()."
        );
        OGR_F_Destroy($hF);
    }

    /***********************************************************************
     *                            testOGR_F_SetGetFieldDoubleList()
     ************************************************************************/

    public function testOGR_F_SetGetFieldDoubleList()
    {
        $dfListValueIn[0] = 1234.73;
        $dfListValueIn[1] = 4813.25;
        $dfListValueIn[2] = 5634.12;
        $dfListValueIn[3] = 44.5;
        $numDouble = 4;

        $hFieldDefn = OGR_Fld_Create("perimeter", OFTRealList);
        $this->assertNotNull($hFieldDefn, "Could not create field definition");
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        $this->assertEquals(OGRERR_NONE, $eErr, "Error creating field.");
        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $this->assertNotNull($hFeatureDefn, "Could not retrieve feature definition");
        $hF = OGR_F_Create($hFeatureDefn);
        $this->assertNotNull($hF, "Could not create feature");

        $iFieldIndex = 0;
        OGR_F_SetFieldDoubleList(
            $hF,
            $iFieldIndex,
            $numDouble,
            $dfListValueIn
        );

        $dfListValueOut = OGR_F_GetFieldAsDoubleList(
            $hF,
            $iFieldIndex,
            $nCount
        );
        $expected = serialize($dfListValueIn);
        $actual = serialize($dfListValueOut);
        $this->AssertEquals(
            $expected,
            $actual,
            "Problem with OGR_F_SetFieldDoubleList() or OGR_F_GetFieldAsDoubleList()."
        );
        $this->AssertEquals(
            $numDouble,
            $nCount,
            "Wrong double count in OGR_F_GetAsDoubleList()."
        );

        OGR_F_Destroy($hF);
    }

    /***********************************************************************
     *                            testOGR_F_SetGetFieldStringList()
     ************************************************************************/

    public function testOGR_F_SetGetFieldStringList()
    {
        $strListValueIn[0] = "Tom Sylto";
        $strListValueIn[1] = "Judith Helm";
        $strListValueIn[2] = "";
        $nString = 3;

        $hFieldDefn = OGR_Fld_Create("firstname_lastname", OFTStringList);
        $this->assertNotNull($hFieldDefn, "Could not create field definition");
        $eErr = OGR_L_CreateField(
            $this->hDestLayer,
            $hFieldDefn,
            0 /*bApproxOk*/
        );
        $this->assertEquals(OGRERR_NONE, $eErr, "Error creating field.");
        $hFeatureDefn = OGR_L_GetLayerDefn($this->hDestLayer);
        $this->assertNotNull($hFeatureDefn, "Could not retrieve feature definition");
        $hF = OGR_F_Create($hFeatureDefn);
        $this->assertNotNull($hF, "Could not create feature");

        $iFieldIndex = 0;
        OGR_F_SetFieldStringList($hF, $iFieldIndex, $strListValueIn);

        $strListValueOut = OGR_F_GetFieldAsStringList($hF, $iFieldIndex);

        $expected = serialize($strListValueIn);
        $actual = serialize($strListValueOut);
        $this->AssertEquals(
            $expected,
            $actual,
            "Problem with OGR_F_SetFieldStringList() or OGR_F_GetFieldAsStringList()."
        );

        OGR_F_Destroy($hF);
    }
}

?>
	




