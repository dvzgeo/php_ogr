<?php
//require_once `phpunit-0.5/phpunit.php';
require_once 'util.php';

class OGRGeometryTest2 extends PHPUnit_TestCase {
    var $hContainer;
    var $hRing1;
    var $hRing2;

    var $strPathToOutputData;
    var $strTmpDumpFile;
    var $strPathToStandardData;
    var $strPathToData;
    var $bUpdate;
    var $strDestDataSource;
    var $strOutputLayer;
    var $eGeometryType;
 
    function OGRGeometryTest2($name){
        $this->PHPUnit_TestCase($name);	
    }

    function setUp() {
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

        /*Prepare to write temporary data for comparison.*/
        $this->strDirName = "testcase/";
        $this->strPathToData = "./data/mifwgs1984";
        $this->strPathToStandardData = "./data/testcase/";
	$this->strPathToOutputData = "../../ogrtests/".$this->strDirName;
	$this->strTmpDumpFile = "DumpFile.tmp";
	$this->bUpdate = FALSE;
        $this->strDestDataSource = "OutputDS";
        $this->strOutputLayer = "OutputLayer";
        $this->eGeometryType = wkbPolygon;

        if (file_exists($this->strPathToOutputData)) {
            system( "rm -R ".$this->strPathToOutputData);
        }
        mkdir($this->strPathToOutputData, 0777);
    }

    function tearDown() {
        OGR_G_DestroyGeometry($this->hRing1);
        OGR_G_DestroyGeometry($this->hRing2);
        OGR_G_DestroyGeometry($this->hContainer);

        unset($this->hRing1);
        unset($this->hring2);
        unset($this->hContainer);

        unset($this->strPathToData);
        unset($this->strPathToStandardData);
        unset($this->strPathToOutputData);
        unset($this->strTmpDumpFile);
        unset($this->bUpdate);
        unset($this->strDestDataSource);
        unset($this->strOutputLayer);
        unset($this->eGeometryType);
    }
/***********************************************************************
*                            testOGR_G_GetAssignSpatialRef()                  
************************************************************************/

    function testOGR_G_GetAssignSpatialRef() {
        $strStandardFile = "testOGR_G_GetAssignSpatialRef.std";

        $hSrcDriver = null;
        $hSrcDS = OGROpen($this->strPathToData, $this->bUpdate, $hSrcDriver);

	$hSrcLayer = OGR_DS_GetLayer($hSrcDS, 0);

        $hSrcSRS = OGR_L_GetSpatialRef($hSrcLayer);
        $this->AssertNotNull($hSrcSRS, "Problem with ".
                                    "OGR_L_GetSpatialRef(): ".
                                    "handle is not supposed to be NULL.");

        $iGeometry = 1;
        $hDestGeometry = OGR_G_GetGeometryRef($this->hContainer, $iGeometry);
        OGR_G_AssignSpatialReference($hDestGeometry, $hSrcSRS);

        $hDestSRS = OGR_G_GetSpatialReference($hDestGeometry);
        $this->AssertNotNull($hDestSRS, "Problem with ".
                                    "OGR_G_AssignSpatialReference or".
                                    "OGR_G_GetSpatialReference(): ".
                                    "handle is not supposed to be NULL.");

        /*Write spatial reference to a layer of a data source
          will permit to see the result.  There is no way now
          to see the spatial reference of a single geometry. */

        $hDestDriver = OGRGetDriver(5);
        $hDestDS = OGR_Dr_CreateDataSource($hDestDriver, 
                                           $this->strPathToOutputData.
                                           $this->strDestDataSource, 
                                           null /*Options*/);


        $hDestLayer = OGR_DS_CreateLayer($hDestDS, $this->strOutputLayer, 
                                     $hDestSRS,
                                     $this->eGeometryType,
                                     null /*Options*/);

        $hFDefn = OGR_L_GetLayerDefn($hSrcLayer);

        $iField =0;
        if( OGR_L_CreateField( $hDestLayer, 
                               OGR_FD_GetFieldDefn( $hFDefn, $iField),
                               0 /*bApproOK*/ ) != OGRERR_NONE ){
            return(FALSE);
        }

        $hDestFeature = OGR_F_Create($hFDefn);

        $eErr = @OGR_F_SetGeometry($hDestFeature, $hDestGeometry);

        $eErr = OGR_L_CreateFeature($hDestLayer, $hDestFeature);

        OGR_DS_Destroy($hDestDS);


        system("ogrinfo -al ".$this->strPathToOutputData.
               $this->strDestDataSource." >".
               $this->strPathToOutputData.
               $this->strTmpDumpFile);

        system("diff --brief ".$this->strPathToOutputData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);


        $this->assertFalse($iRetval, "Problem with ".
                  "OGR_G_AssignSpatialReference() or OGR_G_GetSpatialRef(): ".
                  "Files comparison did not matched.\n");

        OGR_DS_Destroy($hSrcDS);

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
                                           $this->strPathToOutputData.
                                           $this->strDestDataSource, 
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


        system("ogrinfo -al ".$this->strPathToOutputData.
               $this->strDestDataSource." >".
               $this->strPathToOutputData.
               $this->strTmpDumpFile);

        system("diff --brief ".$this->strPathToOutputData.
               $this->strTmpDumpFile.
               " ".$this->strPathToStandardData.$strStandardFile,
               $iRetval);

        printf("retval = %d\n", $iRetval);

        $this->assertFalse($iRetval, "Problem with ".
                  "OGR_G_TransformTo(): ".
                  "Files comparison did not matched.\n");

        OGR_DS_Destroy($hSrcDS);
        printf("fin\n");
    }
*/
}
?>










