<BODY>
<HTML>
<PRE>
<?php

   $eErr = OGR2Tab_copy_srs();

   if ($eErr != OGRERR_NONE)
   {
      printf("Some errors were reported (error %d)\n", $eErr);
   }
   else
   {
      printf("ogr2tab_copy_srs completed with no errors.\n");
   }

/************************************************************************/
/*                                ogr2tab_copy_srs()                    */
/************************************************************************/

function ogr2tab_copy_srs()
{
    /*Corresponding MapInfo File driver number.*/
    $iDriver = 5;
    $strFormat = "MapInfo File";

    /*Path to existing data source to modify to fit user needs.*/
    $strSrcDataSource = "./phpunit_tests/data/tab/mpasabe200/Commune.TAB";

    /*Path to new data source to modify to fit user needs.*/
    $strDestDataSource = "../ogrtests/tmp/output";

    /*New layer name to modify to fit user needs.*/
    $strDestLayerName = "MyNewLayer";

    /*Layer selected to fetch a feature from.  If the data source name in
      $strSrcDataSource is a "tab" file, the layer number, specified by 
      $iLayer, to copy from must be set to zero.  Otherwise the layer 
      number might be any number between 0 and the layer count.*/

//    $iLayer = 1;
    $iLayer = 0;
    
/* -------------------------------------------------------------------- */
/*      Register format(s).                                             */
/* -------------------------------------------------------------------- */
    OGRRegisterAll();


/* -------------------------------------------------------------------- */
/*      Open the existing data source.                                  */
/* -------------------------------------------------------------------- */

    $hSFDriver = NULL;
    $hSrcDS = OGROpen( $strSrcDataSource, FALSE, $hSFDriver );
/* -------------------------------------------------------------------- */
/*      Report failure                                                  */
/* -------------------------------------------------------------------- */
    if( $hSrcDS == NULL )
    {
       
        printf( "FAILURE:\nUnable to open datasource `%s'\n", 
                $strSrcDataSource );

        return OGRERR_FAILURE;
    }

/* -------------------------------------------------------------------- */
/*      Find the output driver handle.                                  */
/* -------------------------------------------------------------------- */

    if( $hSFDriver == NULL )
    {
        $hSFDriver = OGRGetDriver($iDriver);
    }

    if( $hSFDriver == NULL )
    {
        printf( "Unable to find driver `%s'.\n", $strFormat );
        
        return OGRERR_FAILURE;
    }

/* -------------------------------------------------------------------- */
/*      Create the destination data source.                             */
/* -------------------------------------------------------------------- */

   $hDestDS = OGR_Dr_CreateDataSource( $hSFDriver, $strDestDataSource, NULL);
 
    if( $hDestDS == NULL )
        return OGRERR_FAILURE;

/* -------------------------------------------------------------------- */
/*      Select an existing layer from the existing data source to get   */
/*      the projection information from.  To modify accordingly to user */
/*      needs.                                                          */
/* -------------------------------------------------------------------- */
    if( OGR_DS_GetLayerCount($hSrcDS) > 0)
    {
        $hSrcLayer = OGR_DS_GetLayer($hSrcDS, $iLayer);

        if( $hSrcLayer == NULL )
        {
            printf( "FAILURE: Couldn't fetch advertised layer %d!\n",
                    $iLayer);
            return OGRERR_FAILURE;
        }

        $hSrcSRS = OGR_L_GetSpatialRef($hSrcLayer);
    }

/* -------------------------------------------------------------------- */
/*      Create a new layer based on the existing data source            */
/*      information.                                                    */
/* -------------------------------------------------------------------- */

    $hSrcFDefn = OGR_L_GetLayerDefn($hSrcLayer);
    $eType = OGR_FD_GetGeomType($hSrcFDefn);

    $hDestLayer = OGR_DS_CreateLayer($hDestDS, 
                                     $strDestLayerName,
                                     $hSrcSRS, 
                                     $eType,
                                     NULL /*Options*/);

    if( $hDestLayer == NULL )
        return FALSE;

/* -------------------------------------------------------------------- */
/*      Create the field definitions for the new layer based on the     */
/*      existing field definitions of the source layer.                 */
/* -------------------------------------------------------------------- */

    for( $iField = 0; $iField < OGR_FD_GetFieldCount($hSrcFDefn); $iField++ )
    {
        if( OGR_L_CreateField( $hDestLayer, 
                               OGR_FD_GetFieldDefn( $hSrcFDefn, $iField),
                               0 /*bApproOK*/ ) != OGRERR_NONE )
            return OGRERR_FAILURE;
    }

/* -------------------------------------------------------------------- */
/*      Get only one feature on the existing layer and copy it to the   */
/*      new layer.                                                      */
/* -------------------------------------------------------------------- */

    OGR_L_ResetReading($hSrcLayer);

    $hSrcFeature = OGR_L_GetNextFeature($hSrcLayer);
    {

        $hDestFeature = OGR_F_Create( OGR_L_GetLayerDefn($hDestLayer) );

        if( OGR_F_SetFrom( $hDestFeature, $hSrcFeature, FALSE /*bForgiving*/ ) 
            != OGRERR_NONE )
        {
            OGR_F_Destroy($hDestFeature);
            
            printf("Unable to copy feature %d from layer %s.\n", 
                   OGR_F_GetFID($hSrcFeature), OGR_FD_GetName($hSrcFDefn) );
            return OGRERR_FAILURE;
        }
        
        OGR_F_Destroy($hSrcFeature);
        
        if( OGR_L_CreateFeature( $hDestLayer, $hDestFeature ) != OGRERR_NONE )
        {
            OGR_F_Destroy($hDestFeature);
            return OGRERR_FAILURE;
        }

        OGR_F_Destroy($hDestFeature);
    }

/* -------------------------------------------------------------------- */
/*      Close down.                                                     */
/* -------------------------------------------------------------------- */
    OGR_DS_Destroy($hSrcDS);
    OGR_DS_Destroy($hDestDS);

    return OGRERR_NONE;

}
?>
</PRE>
</BODY>
</HTML>
