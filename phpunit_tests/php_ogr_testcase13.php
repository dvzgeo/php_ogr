<?php

$testSuites_list[] = "OGRGeometryTest1";                             

class OGRGeometryTest1 extends PHPUnit_TestCase {
    var $strPathToOutputData;
    var $strTmpDumpFile;
    var $strPathToStandardData;
    var $hDestDS;
    var $hDestLayer;
    var $strDestDataSource;
    var $strDirName;
    var $hOGRSFDriver;
    var $astrOptions;
    var $hContainer;
    var $hRing1;
    var $hRing2;
 
    function setUp() {

        /*Prepare to write temporary data for comparison.*/
        $this->strDirName = "testcase/";
        $this->strPathToStandardData = "./data/testcase/";
	$this->strPathToOutputData = "../../ogrtests/".$this->strDirName;
	$this->strTmpDumpFile = "DumpFile.tmp";
        $this->strDestDataSource = "OutputDS.tab";

        if (file_exists($this->strPathToOutputData)) {
            system( "rm -R ".$this->strPathToOutputData);
        }

        mkdir($this->strPathToOutputData, 0777);

        $iDriver = 5;
        $this->hOGRSFDriver = OGRGetDriver($iDriver);
        $this->astrOptions = null;
        $this->hDestDS = OGR_Dr_CreateDataSource($this->hOGRSFDriver, 
                                               $this->strPathToOutputData.
                                               $this->strDestDataSource,
                                               $this->astrOptions );

        if ($this->hDestDS == null) {
            printf("Unable to create destination data source\n");
            return FALSE;
        }
        $iLayer = 0;

        $this->hDestLayer = OGR_DS_GetLayer($this->hDestDS, $iLayer);

        /*Create a polygon.*/
        $eType = wkbPolygon;
        $this->hContainer = OGR_G_CreateGeometry($eType);


        $eType = wkbLinearRing;
        $this->hRing1 = OGR_G_CreateGeometry($eType);
        OGR_G_AddPoint($this->hRing1, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($this->hRing1, 12.34, 456.78, 0.0);
        OGR_G_AddPoint($this->hRing1, 12.34, 45.67, 0.0);
        OGR_G_AddPoint($this->hRing1, 123.45, 45.67, 0.0);
        OGR_G_AddPoint($this->hRing1, 123.45, 456.78, 0.0);
        $eErr = OGR_G_AddGeometry($this->hContainer, $this->hRing1);

        $eType = wkbLinearRing;
        $this->hRing2 = OGR_G_CreateGeometry($eType);
        OGR_G_AddPoint($this->hRing2, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($this->hRing2, 100.0, 456.78, 0.0);
        OGR_G_AddPoint($this->hRing2, 100.0, 355.25, 0.0);
        OGR_G_AddPoint($this->hRing2, 123.45, 355.25, 0.0);
        OGR_G_AddPoint($this->hRing2, 123.45, 456.78, 0.0);
        $eErr = OGR_G_AddGeometry($this->hContainer, $this->hRing2);


    }
    function tearDown() {
        OGR_G_DestroyGeometry($this->hRing1);
        OGR_G_DestroyGeometry($this->hRing2);
        OGR_G_DestroyGeometry($this->hContainer);
        OGR_DS_Destroy($this->hDestDS);

/*        if (file_exists($this->strPathToOutputData)) {
            system( "rm -R ".$this->strPathToOutputData);
            }*/

        unset($this->strPathToStandardData);
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

    function testOGR_G_GetGeometryRef() {
        $strStandardFile = "testOGR_G_GetGeometryRef";

        $nRingCount = OGR_G_GetGeometryCount($this->hContainer);
        $expected = 2;
        $this->AssertEquals($expected, $nRingCount, "Problem with ".
                            "OGR_G_GetGeometryRef():  supposed to have two ".
                            "rings.");

        $iGeometry = 1;
        $hGeometry = OGR_G_GetGeometryRef($this->hContainer, $iGeometry);
        $this->AssertNotNull($hGeometry, "Problem with ".
                                          "OGR_G_GetGeometryRef(): ".
                                         "handle is not supposed to be NULL.");
        $expected = 5;
        $nPointCount = OGR_G_GetPointCount($hGeometry);
        $this->AssertEquals($expected, $nPointCount, "Problem with ".
                            "OGR_G_GetGeometryRef():  supposed to be a ring ".
                            "five points.");

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");
	
        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
	}

        OGR_G_DumpReadable($fpOut, $hGeometry);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToOutputData.
                $this->strTmpDumpFile.
                " ".$this->strPathToStandardData.$strStandardFile,
                $iRetval);

        $this->assertFalse($iRetval, "Problem with OGR_G_GetGeometryRef() ".
                             "Files comparison did not matched.\n");

        $expected = 2;
        $nGeometryCount = OGR_G_GetGeometryCount($this->hContainer);
        $this->AssertEquals($expected, $nGeometryCount, "Problem with ".
                            "OGR_G_GetGeometryRef():  supposed to be a ".
                            "polygon with two rings.");

        OGR_G_DestroyGeometry($hGeometry);
    }
/***********************************************************************
*                            testOGR_G_RemoveGeometry0()
************************************************************************/

    function testOGR_G_RemoveGeometry0() {
        $strStandardFile = "testOGR_G_RemoveGeometry0";
        $bDelete = TRUE;
        $iGeometry = 1;

        $eErr = @OGR_G_RemoveGeometry($this->hContainer, $iGeometry, $bDelete);
        $expected = 4;
        $this->AssertEquals($expected, $eErr, "Problem with ".
                            "OGR_G_RemoveGeometry():  not supposed to be ".
                            "supported on polygon yet.");
    }
/***********************************************************************
*                            testOGR_G_RemoveGeometry1()
************************************************************************/

    function testOGR_G_RemoveGeometry1() {
        $strStandardFile = "testOGR_G_RemoveGeometry1";
        $bDelete = TRUE;

        $eType = wkbPolygon;
        $hPolygon1 = OGR_G_CreateGeometry($eType);
        $eErr = OGR_G_AddGeometry($hPolygon1, $this->hRing1);

        $hPolygon2 = OGR_G_CreateGeometry($eType);
        $eErr = OGR_G_AddGeometry($hPolygon2, $this->hRing2);

        $eType = wkbMultiPolygon;
        $hMultiPolygon = OGR_G_CreateGeometry($eType);
        $eErr = OGR_G_AddGeometry($hMultiPolygon, $hPolygon1);
        $eErr = OGR_G_AddGeometry($hMultiPolygon, $hPolygon2);

        $iGeometry = 1;

        $eErr = @OGR_G_RemoveGeometry($hMultiPolygon, $iGeometry, $bDelete);

        $nRingCount = OGR_G_GetGeometryCount($hMultiPolygon);
        $expected = 1;
        $this->AssertEquals($expected, $nRingCount, "Problem with ".
                            "OGR_G_RemoveGeometry():  supposed to have ".
                            "only one ring now.");

        $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");
	
        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
	}

        OGR_G_DumpReadable($fpOut, $hMultiPolygon);

        fclose($fpOut);

        system("diff --brief ".$this->strPathToOutputData.
                $this->strTmpDumpFile.
                " ".$this->strPathToStandardData.$strStandardFile,
                $iRetval);

        $this->assertFalse($iRetval, "Problem with OGR_G_RemoveGeometry() ".
                             "Files comparison did not matched.\n");

    }
/***********************************************************************
*                            testOGR_G_Equals()
************************************************************************/

    function testOGR_G_Equals() {
        $bEqual = OGR_G_Equal($this->hRing1, $this->hRing2);
        $this->AssertFalse($bEqual, "Problem with OGR_G_Equals: ".
                            "these two rings should not be equal.");
    }
/***********************************************************************
*                            testOGR_G_Intersect()
************************************************************************/

    function testOGR_G_Intersect() {
        $bIntersect = OGR_G_Intersect($this->hRing1, $this->hRing2);
        $this->AssertTrue($bIntersect, "Problem with OGR_G_Intersect(): ".
                          "these two rings should intersect.");
    }
/***********************************************************************
*                            testOGR_G_Empty()
************************************************************************/

    function testOGR_G_Empty() {
        $strStandardFile = "testOGR_G_Empty";

        OGR_G_Empty($this->hRing2);

       $fpOut = fopen($this->strPathToOutputData.
                       $this->strTmpDumpFile, "w");
	
        if ($fpOut == FALSE) {
            printf("Dump file creation error\n");
            return FALSE;
	}

        OGR_G_DumpReadable($fpOut, $this->hRing2);

        fclose($fpOut);
        
        system("diff --brief ".$this->strPathToOutputData.
                $this->strTmpDumpFile.
                " ".$this->strPathToStandardData.$strStandardFile,
                $iRetval);

        $this->assertFalse($iRetval, "Problem with OGR_G_RemoveGeometry() ".
                             "Files comparison did not matched.\n");

    }
/***********************************************************************
*                            testOGR_G_Clone()
************************************************************************/

    function testOGR_G_Clone() {
        $hGeometry = OGR_G_Clone($this->hRing1);
        $bEqual = OGR_G_Equal($this->hRing1, $hGeometry);
        $this->AssertTrue($bEqual, "Problem with OGR_G_Clone(): ".
                          "these two rings should be the same.");

        OGR_G_DestroyGeometry($hGeometry);
    }
/***********************************************************************
*                            testOGR_G_GetEnvelope()
************************************************************************/

    function testOGR_G_GetEnvelope() {

        CPLErrorReset();

        OGR_G_GetEnvelope($this->hContainer, $hEnvelope);

        $eErrMsg = CPLGetLastErrorMsg();

        $expected = OGRERR_NONE;

        $this->assertEquals($expected, $eErr, $eErrMsg);


        $actual = serialize($hEnvelope);

        $expected = "O:8:\"stdClass\":4:{s:4:\"minx\";d:12.34;s:4:\"maxx\";".
            "d:123.45;s:4:\"miny\";d:45.67;s:4:\"maxy\";d:456.78;}";
        $this->AssertEquals($expected, $actual, "Problem with ".
                            "OGR_G_GetEnvelope().");

    }
/***********************************************************************
*                            testOGR_G_WkbSize()
************************************************************************/

    function testOGR_G_WkbSize() {
        $nSize = OGR_G_WkbSize($this->hContainer);

        $expected = 177; /*nSize += (4 + 16 * 5) * 2 rings et nSize =9. */

        $this->AssertEquals($expected, $nSize, 
                            "Problem with OGR_G_WkbSize().");

    }

}
?>
