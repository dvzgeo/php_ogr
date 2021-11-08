<?php

use \PHPUnit\Framework\TestCase;

class OGRGeometryTest1 extends TestCase
{
    public $strPathToOutputData;
    public $strTmpDumpFile;
    public $hDestDS;
    public $hDestLayer;
    public $strDestDataSource;
    public $hOGRSFDriver;
    public $astrOptions;
    public $hContainer;
    public $hRing1;
    public $hRing2;

    public static function setUpBeforeClass() : void
    {
        OGRRegisterAll();
    }

    public function setUp() : void
    {

        /*Prepare to write temporary data for comparison.*/
        $this->strPathToOutputData = create_temp_directory(__CLASS__);
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->strDestDataSource = "OutputDS.gml";

        $iDriver = "GML";
        $this->hOGRSFDriver = OGRGetDriverByName($iDriver);
        $this->astrOptions = array("XSISCHEMA=OFF");
        $this->hDestDS = OGR_Dr_CreateDataSource(
            $this->hOGRSFDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            $this->astrOptions
        );
        $this->assertNotNull($this->hDestDS, "Unable to create destination data source");
        $this->hDestLayer = OGR_DS_CreateLayer(
            $this->hDestDS,
            $this->strDestDataSource,
            null,
            wkbPolygon,
            array("XSISCHEMA=OFF")
        );
        $this->assertNotNull($this->hDestLayer, "Unable to create layer");

        /*Create a polygon.*/
        $eType = wkbPolygon;
        $this->hContainer = OGR_G_CreateGeometry($eType);
        $this->assertNotNull($this->hContainer, "Unable to create polygon");

        $eType = wkbLinearRing;
        $this->hRing1 = OGR_G_CreateGeometry($eType);
        $this->assertNotNull($this->hRing1, "Could not create outer linear ring");
        OGR_G_AddPoint($this->hRing1, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($this->hRing1, 12.34, 456.78, 0.0);
        OGR_G_AddPoint($this->hRing1, 12.34, 45.67, 0.0);
        OGR_G_AddPoint($this->hRing1, 123.45, 45.67, 0.0);
        OGR_G_AddPoint($this->hRing1, 123.45, 456.78, 0.0);
        $eErr = OGR_G_AddGeometry($this->hContainer, $this->hRing1);
        $this->assertEquals($eErr, OGRERR_NONE, "Could not add outer ring to polygon");

        $eType = wkbLinearRing;
        $this->hRing2 = OGR_G_CreateGeometry($eType);
        $this->assertNotNull($this->hRing2, "Could not create inner linear ring");
        OGR_G_AddPoint($this->hRing2, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($this->hRing2, 100.0, 456.78, 0.0);
        OGR_G_AddPoint($this->hRing2, 100.0, 355.25, 0.0);
        OGR_G_AddPoint($this->hRing2, 123.45, 355.25, 0.0);
        OGR_G_AddPoint($this->hRing2, 123.45, 456.78, 0.0);
        $eErr = OGR_G_AddGeometry($this->hContainer, $this->hRing2);
        $this->assertEquals($eErr, OGRERR_NONE, "Could not add inner ring to polygon");
    }

    public function tearDown() : void
    {
        OGR_G_DestroyGeometry($this->hRing1);
        OGR_G_DestroyGeometry($this->hRing2);
        OGR_G_DestroyGeometry($this->hContainer);
        OGR_DS_Destroy($this->hDestDS);

        delete_directory($this->strPathToOutputData);

        unset($this->strPathToOutputData);
        unset($this->strTmpDumpFile);
        unset($this->strDestDataSource);
        unset($this->hDestLayer);
        unset($this->hDestDS);
        unset($this->strDirName);
        unset($this->OGRSFDriver);
        unset($this->astrOptions);
        unset($this->hRing1);
        unset($this->hring2);
        unset($this->hContainer);
    }

    /***********************************************************************
     *                            testOGR_G_GetGeometryRef()
     ************************************************************************/

    public function testOGR_G_GetGeometryRef()
    {
        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        $nRingCount = OGR_G_GetGeometryCount($this->hContainer);
        $expected = 2;
        $this->AssertEquals(
            $expected,
            $nRingCount,
            "Problem with OGR_G_GetGeometryRef():  supposed to have two rings."
        );

        $iGeometry = 1;
        $hGeometry = OGR_G_GetGeometryRef($this->hContainer, $iGeometry);
        $this->AssertNotNull(
            $hGeometry,
            "Problem with OGR_G_GetGeometryRef(): handle is not supposed to be NULL."
        );
        $expected = 5;
        $nPointCount = OGR_G_GetPointCount($hGeometry);
        $this->AssertEquals(
            $expected,
            $nPointCount,
            "Problem with OGR_G_GetGeometryRef():  supposed to be a ring five points."
        );

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_G_DumpReadable($hGeometry, $fpOut);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_G_GetGeometryRef() Files comparison did not matched.\n"
        );

        $expected = 2;
        $nGeometryCount = OGR_G_GetGeometryCount($this->hContainer);
        $this->AssertEquals(
            $expected,
            $nGeometryCount,
            "Problem with OGR_G_GetGeometryRef():  supposed to be a polygon with two rings."
        );

        OGR_G_DestroyGeometry($hGeometry);
    }

    /***********************************************************************
     *                            testOGR_G_RemoveGeometry0()
     ************************************************************************/

    public function testOGR_G_RemoveGeometry0()
    {
        $bDelete = true;
        $iGeometry = 1;

        $eErr = @OGR_G_RemoveGeometry($this->hContainer, $iGeometry, $bDelete);
        $expected = OGRERR_UNSUPPORTED_OPERATION;
        $this->AssertEquals(
            $expected,
            $eErr,
            "Problem with OGR_G_RemoveGeometry():  not supposed to be supported on polygon yet."
        );
    }

    /***********************************************************************
     *                            testOGR_G_RemoveGeometry1()
     ************************************************************************/

    public function testOGR_G_RemoveGeometry1()
    {
        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");
        $bDelete = true;

        $eType = wkbPolygon;
        $hPolygon1 = OGR_G_CreateGeometry($eType);
        $this->assertNotNull($hPolygon1, 'Could not create polygon');
        $eErr = OGR_G_AddGeometry($hPolygon1, $this->hRing1);
        $this->assertEquals(OGRERR_NONE, $eErr, 'Could not add exterior ring to polygon');

        $hPolygon2 = OGR_G_CreateGeometry($eType);
        $this->assertNotNull($hPolygon2, 'Could not create polygon');
        $eErr = OGR_G_AddGeometry($hPolygon2, $this->hRing2);
        $this->assertEquals(OGRERR_NONE, $eErr, 'Could not add exterior ring to polygon');

        $eType = wkbMultiPolygon;
        $hMultiPolygon = OGR_G_CreateGeometry($eType);
        $this->assertNotNull($hMultiPolygon, 'Could not create polygon');
        $eErr = OGR_G_AddGeometry($hMultiPolygon, $hPolygon1);
        $this->assertEquals(OGRERR_NONE, $eErr, 'Could not add polygon to multipolygon');
        $expected = 1;
        $nRingCount = OGR_G_GetGeometryCount($hMultiPolygon);
        $this->AssertEquals(
            $expected,
            $nRingCount,
            "Problem with OGR_G_RemoveGeometry():  supposed to have one ring now."
        );
        $eErr = OGR_G_AddGeometry($hMultiPolygon, $hPolygon2);
        $this->assertEquals(OGRERR_NONE, $eErr, 'Could not add polygon to multipolygon');
        $nRingCount = OGR_G_GetGeometryCount($hMultiPolygon);
        $expected = 2;
        $this->AssertEquals(
            $expected,
            $nRingCount,
            "Problem with OGR_G_RemoveGeometry():  supposed to have two rings now."
        );

        $nRingCount = OGR_G_GetGeometryCount($hMultiPolygon);

        $iGeometry = 1;

        $eErr = @OGR_G_RemoveGeometry($hMultiPolygon, $iGeometry, $bDelete);
        $this->assertEquals(OGRERR_NONE, $eErr, 'Could not add polygon from multipolygon');

        $nRingCount = OGR_G_GetGeometryCount($hMultiPolygon);
        $expected = 1;
        $this->AssertEquals(
            $expected,
            $nRingCount,
            "Problem with OGR_G_RemoveGeometry():  supposed to have only one ring now."
        );

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_G_DumpReadable($hMultiPolygon, $fpOut);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_G_RemoveGeometry() Files comparison did not matched."
        );
    }

    /***********************************************************************
     *                            testOGR_G_Equals()
     ************************************************************************/

    public function testOGR_G_Equals()
    {
        $bEqual = OGR_G_Equal($this->hRing1, $this->hRing2);
        $this->AssertFalse(
            $bEqual,
            "Problem with OGR_G_Equals: these two rings should not be equal."
        );
    }

    /***********************************************************************
     *                            testOGR_G_Intersect()
     ************************************************************************/

    public function testOGR_G_Intersect0()
    {
        $eType = wkbPolygon;
        $hPolygon = OGR_G_CreateGeometry($eType);
        $this->assertNotNull($hPolygon, "Could not create polygon");
        $eErr = OGR_G_AddGeometry($hPolygon, $this->hRing2);
        $this->assertEquals($eErr, OGRERR_NONE, "Could not add exterior ring to polygon");
        $bIntersect = OGR_G_Intersect($this->hContainer, $hPolygon);
        $this->AssertTrue(
            $bIntersect,
            "Problem with OGR_G_Intersect(): these two polygons should intersect."
        );
    }

    /***********************************************************************
     *                            testOGR_G_Empty()
     ************************************************************************/

    public function testOGR_G_Empty()
    {
        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        OGR_G_Empty($this->hRing2);

        $fpOut = fopen(
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "w"
        );

        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_G_DumpReadable($this->hRing2, $fpOut);

        fclose($fpOut);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strTmpDumpFile,
            "Problem with OGR_G_Empty() Files comparison did not matched.\n"
        );
    }

    /***********************************************************************
     *                            testOGR_G_Clone()
     ************************************************************************/

    public function testOGR_G_Clone()
    {
        $hGeometry = OGR_G_Clone($this->hRing1);
        $bEqual = OGR_G_Equal($this->hRing1, $hGeometry);
        $this->AssertTrue(
            $bEqual,
            "Problem with OGR_G_Clone(): these two rings should be the same."
        );

        OGR_G_DestroyGeometry($hGeometry);
    }

    /***********************************************************************
     *                            testOGR_G_GetEnvelope()
     ************************************************************************/

    public function testOGR_G_GetEnvelope()
    {
        CPLErrorReset();

        $eErr = OGR_G_GetEnvelope($this->hContainer, $hEnvelope);

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;

        $this->assertEquals($expected, $eErr, $eErrMsg);


        $expected = unserialize(
            'O:8:"stdClass":4:{s:4:"minx";d:12.34;s:4:"maxx";d:123.45;s:4:"miny";d:45.67;s:4:"maxy";d:456.78;}'
        );
        $this->AssertEquals(
            $expected,
            $hEnvelope,
            "Problem with OGR_G_GetEnvelope()."
        );
    }

    /***********************************************************************
     *                            testOGR_G_WkbSize()
     ************************************************************************/

    public function testOGR_G_WkbSize()
    {
        $nSize = OGR_G_WkbSize($this->hContainer);

        $expected = 1 /* byte order (byte) */
            + 4 /* type (4-byte uint) */
            + 4 /* nRings (4-byte uint) */
            + ( /* first linear ring */
                4 /* nPoints (4-byte uint) */
                + (
                    24 /* 3 8-byte doubles (x, y, z) */
                    * 5 /* points */
                )
            ) + ( /* second linear ring */
                4 /* nPoints (4-byte uint) */
                + (
                    24 /* 3 8-byte doubles (x, y, z) */
                    * 5 /* points */
                )
            );

        $this->AssertEquals(
            $expected,
            $nSize,
            "Problem with OGR_G_WkbSize()."
        );
    }
}
