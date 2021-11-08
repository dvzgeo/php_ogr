<?php

use \PHPUnit\Framework\TestCase;

/**
 * Tests for OGR_?_DumpReadable() functions
 *
 * @author Edward Nash
 */
class OGRDumpReadableTest0 extends TestCase
{

    /**
     * @var string
     */
    protected $strPathToOutputData;

    /**
     * @var resource
     */
    protected $hGeometry;

    /**
     * @var resource
     */
    protected $hFeature;

    /**
     * @var resource
     */
    protected $hFeatureDefn;

    /**
     * @var string
     */
    protected $outFile;

    public function setUp()
    {
        $this->strPathToOutputData = create_temp_directory(__CLASS__);
        $this->outFile = $this->strPathToOutputData . "dump";

        $this->hGeometry = OGR_G_CreateGeometry(wkbPoint);
        OGR_G_SetPoint($this->hGeometry, 0, 123.45, 456.78, 0);

        $this->hFeatureDefn = OGR_FD_Create("test");
        OGR_FD_SetGeomType($this->hFeatureDefn, wkbPoint);
        OGR_FD_AddFieldDefn($this->hFeatureDefn, OGR_Fld_Create("name", OFTString));

        $this->hFeature = OGR_F_Create($this->hFeatureDefn);
        OGR_F_SetGeometry($this->hFeature, $this->hGeometry);
        OGR_F_SetFieldString($this->hFeature, 0, "foo");
    }

    public function tearDown()
    {
        delete_directory($this->strPathToOutputData);
        OGR_G_DestroyGeometry($this->hGeometry);
    }

    /**
     * Test OGR_G_DumpReadable for one geometry with no prefix
     */
    public function testOGR_G_DumpReadable0()
    {
        $refFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        $fpOut = fopen($this->outFile, "w");
        $this->assertNotFalse($fpOut, "Dump file creation error");

        $hGeometry = OGR_G_CreateGeometry(wkbPoint);

        OGR_G_SetPoint($hGeometry, 0, 123.45, 456.78, 0);

        OGR_G_DumpReadable($this->hGeometry, $fpOut);

        fclose($fpOut);

        $this->assertFileEquals(
            $refFile,
            $this->outFile,
            "Problem with OGR_G_DumpReadable: Output not as expected"
        );
    }

    /**
     * Test OGR_G_DumpReadable for one geometry with a prefix
     */
    public function testOGR_G_DumpReadable1()
    {
        $refFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        $fpOut = fopen($this->outFile, "w");
        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_G_DumpReadable($this->hGeometry, $fpOut, "***");

        fclose($fpOut);

        $this->assertFileEquals(
            $refFile,
            $this->outFile,
            "Problem with OGR_G_DumpReadable: Output not as expected with a prefix"
        );
    }

    /**
     * Test OGR_G_DumpReadable for two geometries
     */
    public function testOGR_G_DumpReadable2()
    {
        $refFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        $fpOut = fopen($this->outFile, "w");
        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_G_DumpReadable($this->hGeometry, $fpOut);

        $hGeometry = OGR_G_CreateGeometry(wkbPoint);
        OGR_G_SetPoint($hGeometry, 0, 456.78, 123.45, 0);
        OGR_G_DumpReadable($hGeometry, $fpOut);

        fclose($fpOut);

        $this->assertFileEquals(
            $refFile,
            $this->outFile,
            "Problem with OGR_G_DumpReadable: Output not as expected for two geometries"
        );
    }

    /**
     * Test OGR_F_DumpReadable for one feature
     */
    public function testOGR_F_DumpReadable0()
    {
        $refFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        $fpOut = fopen($this->outFile, "w");
        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_F_DumpReadable($this->hFeature, $fpOut);

        fclose($fpOut);

        $this->assertFileEquals(
            $refFile,
            $this->outFile,
            "Problem with OGR_F_DumpReadable: Output not as expected"
        );
    }

    /**
     * Test OGR_F_DumpReadable for two features
     */
    public function testOGR_F_DumpReadable1()
    {
        $refFile = reference_data_path(__CLASS__, __FUNCTION__ . ".std");

        $fpOut = fopen($this->outFile, "w");
        $this->assertNotFalse($fpOut, "Dump file creation error");

        OGR_F_DumpReadable($this->hFeature, $fpOut);

        $hGeometry = OGR_G_CreateGeometry(wkbPoint);
        OGR_G_SetPoint($hGeometry, 0, 456.78, 123.45, 0);

        $hFeature = OGR_F_Create($this->hFeatureDefn);
        OGR_F_SetGeometry($hFeature, $hGeometry);
        OGR_F_SetFieldString($hFeature, 0, "bar");

        OGR_F_DumpReadable($hFeature, $fpOut);

        fclose($fpOut);

        $this->assertFileEquals(
            $refFile,
            $this->outFile,
            "Problem with OGR_F_DumpReadable: Output not as expected"
        );
    }
}
