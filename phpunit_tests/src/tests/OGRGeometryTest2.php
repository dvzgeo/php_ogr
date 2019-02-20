<?php

class OGRGeometryTest2 extends PHPUnit_Framework_TestCase
{
    public $hContainer;
    public $hRing1;
    public $hRing2;

    public $strPathToOutputData;
    public $strTmpDumpFile;
    public $strPathToData;
    public $bUpdate;
    public $strDestDataSource;
    public $strOutputLayer;
    public $eGeometryType;

    public static function setUpBeforeClass()
    {
        OGRRegisterAll();
    }

    public function setUp()
    {
        /*Create a polygon.*/
        $eType = wkbPolygon;
        $this->hContainer = OGR_G_CreateGeometry($eType);
        $this->assertNotNull($this->hContainer, "Could not create geometry");

        $eType = wkbLinearRing;
        $this->hRing1 = OGR_G_CreateGeometry($eType);
        $this->assertNotNull($this->hRing1, "Could not create linear ring");
        OGR_G_AddPoint($this->hRing1, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($this->hRing1, 12.34, 456.78, 0.0);
        OGR_G_AddPoint($this->hRing1, 12.34, 45.67, 0.0);
        OGR_G_AddPoint($this->hRing1, 123.45, 45.67, 0.0);
        OGR_G_AddPoint($this->hRing1, 123.45, 456.78, 0.0);
        $eErr = OGR_G_AddGeometry($this->hContainer, $this->hRing1);
        $this->assertEquals(OGRERR_NONE, $eErr, "Could not add exterior ring to geometry");

        $eType = wkbLinearRing;
        $this->hRing2 = OGR_G_CreateGeometry($eType);
        $this->assertNotNull($this->hRing2, "Could not create linear ring");
        OGR_G_AddPoint($this->hRing2, 123.45, 456.78, 0.0);
        OGR_G_AddPoint($this->hRing2, 100.0, 456.78, 0.0);
        OGR_G_AddPoint($this->hRing2, 100.0, 355.25, 0.0);
        OGR_G_AddPoint($this->hRing2, 123.45, 355.25, 0.0);
        OGR_G_AddPoint($this->hRing2, 123.45, 456.78, 0.0);
        $eErr = OGR_G_AddGeometry($this->hContainer, $this->hRing2);
        $this->assertEquals(OGRERR_NONE, $eErr, "Could not add exterior ring to geometry");

        /*Prepare to write temporary data for comparison.*/
        $this->strPathToData = test_data_path("andorra", "shp");
        $this->strPathToOutputData = create_temp_directory(__CLASS__);
        $this->strTmpDumpFile = "DumpFile.tmp";
        $this->bUpdate = false;
        $this->strDestDataSource = "OutputDS";
        $this->strOutputLayer = "OutputLayer";
        $this->eGeometryType = wkbPolygon;
    }

    public function tearDown()
    {
        OGR_G_DestroyGeometry($this->hRing1);
        OGR_G_DestroyGeometry($this->hRing2);
        OGR_G_DestroyGeometry($this->hContainer);

        delete_directory($this->strPathToOutputData);

        unset($this->hRing1);
        unset($this->hring2);
        unset($this->hContainer);

        unset($this->strPathToData);
        unset($this->strPathToOutputData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->strDestDataSource);
        unset($this->strOutputLayer);
        unset($this->eGeometryType);
    }

    /***********************************************************************
     *                            testOGR_G_GetSpatialRef()
     ************************************************************************/

    public function testOGR_G_GetSpatialRef()
    {
        $hSrcDriver = null;
        $hSrcDS = OGROpen($this->strPathToData, $this->bUpdate, $hSrcDriver);
        $this->assertNotNull($hSrcDS, "Could not open source dataset");

        $hSrcLayer = OGR_DS_GetLayer($hSrcDS, 0);
        $this->assertNotNull($hSrcLayer, "Could not retrieve source layer");

        $hSrcSRS = OGR_L_GetSpatialRef($hSrcLayer);
        $this->AssertNotNull(
            $hSrcSRS,
            "Problem with OGR_L_GetSpatialRef(): handle is not supposed to be NULL."
        );
    }

    /***********************************************************************
     *                            testOGR_G_AssignSpatialReference()
     ************************************************************************/

    public function testOGR_G_AssignSpatialReference()
    {
        $strStandardFile = reference_data_path(__CLASS__, __FUNCTION__ . ".prj");

        $hSrcDS = OGROpen($this->strPathToData, $this->bUpdate, $hSrcDriver);
        $this->assertNotNull($hSrcDS, "Could not open source dataset");

        $hSrcLayer = OGR_DS_GetLayer($hSrcDS, 0);
        $this->assertNotNull($hSrcLayer, "Could not retrieve source layer");


        $hSrcSRS = OGR_L_GetSpatialRef($hSrcLayer);
        $this->AssertNotNull(
            $hSrcSRS,
            "Problem with OGR_L_GetSpatialRef(): handle is not supposed to be NULL."
        );

        $iGeometry = 1;
        OGR_G_AssignSpatialReference($this->hContainer, $hSrcSRS);

        $hDestSRS = OGR_G_GetSpatialReference($this->hContainer);
        $this->AssertNotNull(
            $hDestSRS,
            "Problem with OGR_G_AssignSpatialReference or OGR_G_GetSpatialReference(): handle is not supposed to be NULL."
        );

        /*Write spatial reference to a layer of a data source
          will permit to see the result.  There is no way now
          to see the spatial reference of a single geometry. */

        $hDestDriver = OGRGetDriverByName("ESRI Shapefile");
        $this->assertNotNull($hDestDriver, "Could not open destination driver");
        $hDestDS = OGR_Dr_CreateDataSource(
            $hDestDriver,
            $this->strPathToOutputData . $this->strDestDataSource,
            null /*Options*/
        );
        $this->assertNotNull($hDestDS, "Could not create target datasource");

        $hDestLayer = OGR_DS_CreateLayer(
            $hDestDS,
            $this->strOutputLayer,
            $hDestSRS,
            $this->eGeometryType,
            null /*Options*/
        );
        $this->assertNotNull($hDestLayer, "Could not create target layer");

        $hFDefn = OGR_L_GetLayerDefn($hSrcLayer);
        $this->assertNotNull($hFDefn, "Could not get target layer definition");

        $iField = 0;
        $eErr = OGR_L_CreateField(
            $hDestLayer,
            OGR_FD_GetFieldDefn($hFDefn, $iField),
            0 /*bApproOK*/
        );
        $this->assertEquals(OGRERR_NONE, $eErr, "Could not create new field");

        $hDestFeature = OGR_F_Create($hFDefn);

        $eErr = @OGR_F_SetGeometry($hDestFeature, $this->hContainer);
        $this->assertEquals(OGRERR_NONE, $eErr, "Could not set geometry on feature");

        $eErr = OGR_L_CreateFeature($hDestLayer, $hDestFeature);
        $this->assertEquals(OGRERR_NONE, $eErr, "Could not add feature to layer");

        OGR_DS_Destroy($hSrcDS);

        OGR_DS_Destroy($hDestDS);

        $this->assertFileEquals(
            $strStandardFile,
            $this->strPathToOutputData . $this->strDestDataSource . DIRECTORY_SEPARATOR . $this->strOutputLayer . '.prj',
            "Problem with OGR_G_AssignSpatialReference() or OGR_G_GetSpatialRef(): Files comparison did not matched.\n"
        );
    }
    /***********************************************************************
     *                            testOGR_G_TransformTo()
     *                            TO VERIFY
     ************************************************************************/

    /*    function testOGR_G_TransformTo() {
            $strStandardFile = "testOGR_G_TransformTo.std";

            $hSrcDriver = null;
            $hSrcDS = OGROpen($this->strPathToData, $this->bUpdate, $hSrcDriver);

        $hSrcLayer = OGR_DS_GetLayer($hSrcDS, 0);

            $hSrcSRS = OGR_L_GetSpatialRef($hSrcLayer);

            $iGeometry = 0;
            $hDestGeometry = OGR_G_GetGeometryRef($this->hContainer, $iGeometry);

            OGR_G_AssignSpatialReference($hDestGeometry, $hSrcSRS);

            CPLErrorReset();
            printf("avant tranformto\n");
            $eErr = OGR_G_TransformTo($hDestGeometry, $hSrcSRS);
            printf("apres tranformto\n");

            $eErrMsg = CPLGetLastErrorMsg();

            $expected = OGRERR_NONE;

            $this->assertEquals($expected, $eErr, $eErrMsg);

            printf("destsrs=%d\n", $hDestSRS);
            $hDestSRS = OGR_G_GetSpatialReference($hDestGeometry);
            printf("destsrs=%s\n", $hDestSRS);


            $hDestDriver = OGRGetDriver(5);
            $hDestDS = OGR_Dr_CreateDataSource($hDestDriver,
                                               $this->strPathToOutputData. $this->strDestDataSource,
                                               null );
            printf("destds=%s\n", $hDestDS);

            $hDestLayer = OGR_DS_CreateLayer($hDestDS, $this->strOutputLayer,
                                         $hDestSRS,
                                         $this->eGeometryType,
                                         null );

            printf("after layer creation\n");
            $hFDefn = OGR_L_GetLayerDefn($hSrcLayer);

            $iField =0;
            if( OGR_L_CreateField( $hDestLayer,
                                   OGR_FD_GetFieldDefn( $hFDefn, $iField),
                                   0  ) != OGRERR_NONE ){
                return(FALSE);
            }

            $hDestFeature = OGR_F_Create($hFDefn);

            $eErr = @OGR_F_SetGeometry($hDestFeature, $hDestGeometry);

            $eErr = OGR_L_CreateFeature($hDestLayer, $hDestFeature);

            OGR_DS_Destroy($hDestDS);


            system("ogrinfo -al ".$this->strPathToOutputData. $this->strDestDataSource." >". $this->strPathToOutputData. $this->strTmpDumpFile);

            system("diff --brief ".$this->strPathToOutputData. $this->strTmpDumpFile. " ".$this->strPathToStandardData.$strStandardFile,
                   $iRetval);

            printf("retval = %d\n", $iRetval);

            $this->assertFalse($iRetval, "Problem with ". "OGR_G_TransformTo(): ". "Files comparison did not matched.\n");

            OGR_DS_Destroy($hSrcDS);
            printf("fin\n");
        }
    */
}
