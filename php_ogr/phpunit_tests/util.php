<?php
/**
 * A set of utility functions.
 *
 */

/**
 * Write the result to a file.
 *
 * @param  
 * @param  file handle
 * @access public
 */
 



/************************************************************************/
/*                            DumpPoint                                 */
/*                                                                      */
/************************************************************************/

function DumpPoint($fp, $hGeom, $iPoint )

{

    $strOutput =  sprintf( "%.3f %.3f %.3f\n", OGR_G_GetX($hGeom, $iPoint),
            OGR_G_GetY($hGeom, $iPoint),
            OGR_G_GetZ($hGeom, $iPoint));

    fputs($fp, $strOutput,strlen($strOutput)); 

    return OGRERR_NONE;
}

/************************************************************************/
/*                            DumpLineString                            */
/*                                                                      */
/************************************************************************/

function DumpLineString( $fp, $hGeom )

{
    $strOutput =  sprintf( "%s:\n", OGR_G_GetGeometryName($hGeom) );

    fputs($fp, $strOutput,strlen($strOutput)); 

    $nPointCount = OGR_G_GetPointCount($hGeom);

    for( $i = 0; $i < $nPointCount; $i++ )
    {
        if( OGR_G_GetCoordinateDimension($hGeom) == 3 ){
            $strOutput =  sprintf("%.3f %.3f %.3f\n", OGR_G_GetX($hGeom, $i),
                                 OGR_G_GetY($hGeom, $i),
                                 OGR_G_GetZ($hGeom, $i));
            fputs($fp, $strOutput,strlen($strOutput)); 
        }
        else{
            $strOutput =  sprintf("%.3f %.3f\n", OGR_G_GetX($hGeom, $i),
                                 OGR_G_GetY($hGeom, $i));
            fputs($fp, $strOutput,strlen($strOutput)); 
        }
    }

    return OGRERR_NONE;
}


/************************************************************************/
/*                            DumpPolygon                               */
/*                                                                      */
/************************************************************************/
function DumpPolygon( $fp, $hGeom )

{
/* -------------------------------------------------------------------- */
/*      Build a list of strings containing the stuff for each ring.     */
/* -------------------------------------------------------------------- */
    $strOutput =  sprintf("%s:\n", OGR_G_GetGeometryName($hGeom) );

    fputs($fp, $strOutput,strlen($strOutput)); 

    $nRingCount = OGR_G_GetGeometryCount($hGeom);

    for( $iRing = 0; $iRing < $nRingCount; $iRing++ )
    {
        $hRing = OGR_G_GetGeometryRef($hGeom, $iRing);
        $eErr = DumpLineString( $fp, $hRing, &$strRings );
        if( $eErr != OGRERR_NONE )
            return $eErr;
    }
    
    return OGRERR_NONE;
}

/************************************************************************/
/*                            DumpMultiPoint                            */
/*                                                                      */
/************************************************************************/

function DumpMultipoint( $fp, $hGeom)

{
    $strOutput =  sprintf("%s:\n", OGR_G_GetGeometryName($hGeom) );
    fputs($fp, $strOutput,strlen($strOutput)); 

    for( $i = 0; $i < OGR_G_GetGeometryCount($hGeom); $i++ )
    {
        $hPoint = OGR_G_GetGeometryRef($hGEom, $i );

        if( $i > 0 )
            fputs($fp, "\n",strlen("\n")); 

        if( OGR_G_GetCoordinateDimension($hGeom) == 3 ){
            $strOutput =  sprintf("%.3f %.3f %.3f\n", OGR_G_GetX($hGeom, $i),
                                 OGR_G_GetY($hGeom, $i),
                                 OGR_G_GetZ($hGeom, $i));
            fputs($fp, $strOutput,strlen($strOutput)); 
        }
        else{
            $strOutput =  sprintf("%.3f %.3f\n", OGR_G_GetX($hGeom, $i),
                                 OGR_G_GetY($hGeom, $i));
            fputs($fp, $strOutput,strlen($strOutput)); 
        }
    }
    return OGRERR_NONE;
}

/************************************************************************/
/*                            DumpMultiLineString                       */
/*                                                                      */
/************************************************************************/


function DumpMultiLineString( $fp, $hGeom)

{
/* -------------------------------------------------------------------- */
/*      Build a list of strings containing the stuff for each ring.     */
/* -------------------------------------------------------------------- */
    $strOutput =  sprintf( "%s:\n", OGR_G_GetGeometryName($hGeom) );
    fputs($fp, $strOutput,strlen($strOutput)); 

    for( $iLine = 0; $iLine <  OGR_G_GetGeometryCount($hGeom); $iLine++ )
    {
        $hLine = OGR_G_GetGeometryRef($hGeom, $iLine);
        $eErr = DumpLineString( $fp, $hLine );
        if( $eErr != OGRERR_NONE )
            return $eErr;
    }
   return OGRERR_NONE;
}

/************************************************************************/
/*                            DumpMultiPolygon                          */
/*                                                                      */
/************************************************************************/

function   DumpMultiPolygon($fp, $hGeom)

{

/* -------------------------------------------------------------------- */
/*      Build a list of strings containing the stuff for each ring.     */
/* -------------------------------------------------------------------- */
    $strOutput =  sprintf( "%s:\n", OGR_G_GetGeometryName($hGeom) );
    fputs($fp, $strOutput,strlen($strOutput)); 

    for( $iLine = 0; $iLine < OGR_G_GetGeometryCount($hGeom); $iLine++ )
    {
        $hPolygon = OGR_G_GetGeometryRef($hGeom, $iLine);

        $eErr = DumpPolygon($fp, $hPolygon, &$strPolygon );
        
        if( $eErr != OGRERR_NONE )
            return eErr;
    }
    
    return OGRERR_NONE;
}

/************************************************************************/
/*                            DumpGeometryCollection                    */
/*                                                                      */
/************************************************************************/

function   DumpGeometryCollection( $fp, $hGeom)

{

/* -------------------------------------------------------------------- */
/*      Build a list of strings containing the stuff for each Geom.     */
/* -------------------------------------------------------------------- */

    $strOutput =  sprintf("%s:\n", OGR_GetGetGeometryName($hGeom));
    fputs($fp, $strOutput,strlen($strOutput)); 

    $nGeomCount = OGR_G_GetGeometryCount($hGeom);

    for( $iGeom = 0; $iGeom < $nGeomCount; $iGeom++ )
    {
        $hSubGeom = OGR_G_GetGeometryRef($hGEom, $i );

        $eErr = OGR_G_DumpReadable($fp, $hGeom);

        if( $eErr != OGRERR_NONE )
            return $eErr;
    }

    return OGRERR_NONE;
}


/**********************************************************************
 *                      OGR_G_DumpReadable()
 *
 * Dump all geometry on a layer.
 *
 **********************************************************************/


function OGR_G_DumpReadable($fp, $hGeom)
{
    switch (OGR_G_GetGeometryType($hGeom)) {
      case wkbUnknown:
        break;
      case wkbPoint:
      case wkbPoint25D:
        $eErr = DumpPoint( $fp, $hGeom, 0 );
        break;
      case wkbLineString:
      case wkbLineString25D:
        $eErr = DumpLineString( $fp, $hGeom );
        break;
      case wkbPolygon:
      case wkbPolygon25D:
        $eErr = DumpPolygon( $fp, $hGeom );
        break;
      case wkbMultiPoint:
      case wkbMultiPoint25D:
        $eErr = DumpMultipoint( $fp, $hGeom );
        break;
      case wkbMultiLineString:
      case wkbMultiLineString25D:
        $eErr = DumpMultiLineString( $fp, $hGeom );
        break;
      case wkbMultiPolygon:
      case wkbMultiPolygon25D:
        $eErr = DumpMultiPolygon( $fp, $hGeom );
        break;
      case wkbGeometryCollection:
      case wkbGeometryCollection25D:
        $eErr = DumpGeometryCollection( $fp, $hGeom );
        break;
      case wkbLinearRing:
        $eErr = DumpMultiLineString( $fp, $hGeom );
        break;
      case wkbNone:
      default:
        $eErr = OGRERR_UNSUPPORTED_GEOMETRY_TYPE;
        break;
    } 

}


/**********************************************************************
 *                      OGR_F_DumpReadable()
 *
 * Dump all features on a layer.
 *
 **********************************************************************/

function OGR_F_DumpReadable( $fp, $hFeature)

{

    $hFeatureDefn = OGR_F_GetDefnRef($hFeature);


    $strOutput =  sprintf( "OGRFeature(%s):%ld\n", 
            OGR_FD_GetName($hFeatureDefn), 
            OGR_F_GetFID($hFeature) );

    printf("normfid=%d\n",OGR_F_GetFID($hFeature));
    fputs($fp, $strOutput,strlen($strOutput)); 

    $numFields = OGR_FD_GetFieldCount($hFeatureDefn);

    for( $iField = 0; $iField < $numFields; $iField++ )
    {

        $hFieldDefn = OGR_FD_GetFieldDefn($hFeatureDefn, $iField);

        $strOutput =  sprintf( "  %s (%s) = ", OGR_FLD_GetNameRef($hFieldDefn),
                OGR_GetFieldTypeName(OGR_FLD_GetType($hFieldDefn)) );

        fputs($fp, $strOutput,strlen($strOutput)); 

        if( OGR_F_IsFieldSet( $hFeature, $iField ) ) {
           $strOutput =  sprintf( "%s\n", OGR_F_GetFieldAsString( 
                                          $hFeature, $iField ) );

           fputs($fp, $strOutput,strlen($strOutput)); 
        }
        else {
           fputs($fp, "(null)\n", strlen("(null)\n")); 
        }
            
    }

    if( OGR_F_GetStyleString($hFeature) != NULL ) {
        $strOutput =  sprintf( "  Style = %s\n", OGR_F_GetStyleString(
                                                 $hFeature) );
    
        fputs($fp, $strOutput,strlen($strOutput)); 
    }

    if( OGR_F_GetGeometryRef($hFeature) != NULL ){
        OGR_G_DumpReadable( $fp, OGR_F_GetGeometryRef($hFeature) );
    }

    fputs($fp, "\n",strlen("\n")); 
}

/**********************************************************************
 *                      OGRFieldDefnDump()
 *
 * Dump a specific field definition.
 *
 **********************************************************************/

function OGRFieldDefnDump( $fp, $hFieldDefn)

{

        $strFieldDefn = OGR_FLD_GetNameRef($hFieldDefn);

        $strTypeName = OGR_GetFieldTypeName(OGR_FLD_GetType($hFieldDefn));

        $strOutput =  sprintf( "  %s (%s) = ", $strFieldDefn, $strTypeName  );

        fputs($fp, $strOutput,strlen($strOutput));

}
/**********************************************************************
 *                      OGRDumpAllLayers()
 *
 * Dump all layers.
 *
 **********************************************************************/
function OGRDumpAllLayers ($fp, $hDatasource, $bForce){

    $bForce = TRUE;
  /* Loop through layers and dump their contents */


  $numLayers = OGR_DS_GetLayerCount($hDatasource);

  $strOutput =  sprintf("\nLayer(s) count = %s\n",$numLayers);
  fputs($fp, $strOutput,strlen($strOutput)); 

  for($i=0; $i<$numLayers; $i++)
  {
      $hLayer = OGR_DS_GetLayer( $hDatasource, $i );

      /* Dump info about this layer */
      $hLayerDefn = OGR_L_GetLayerDefn( $hLayer );
      $numFields = OGR_FD_GetFieldCount( $hLayerDefn );

      fputs($fp, "\n===================\n", 
            strlen("\n===================\n")); 

      $strOutput =  sprintf("Layer %d: '%s'\n\n", i, 
                            OGR_FD_GetName($hLayerDefn));
      fputs($fp, $strOutput,strlen($strOutput)); 

 
      for($j=0; $j<$numFields; $j++)
      {

          $hFieldDefn = OGR_FD_GetFieldDefn( $hLayerDefn, $j );
          $strOutput =  sprintf(" Field %d: %s (%s)\n", $j, 
                        OGR_Fld_GetNameRef($hFieldDefn), 
                        OGR_GetFieldTypeName(OGR_Fld_GetType($hFieldDefn)) );

          fputs($fp, $strOutput,strlen($strOutput)); 
      }

      fputs($fp, "\n", strlen("\n")); 

      /* And dump each feature individually */

      $strOutput =  sprintf("Feature(s) count= %d", 
                            OGR_L_GetFeatureCount($hLayer, $bForce)); 

      fputs($fp, $strOutput,strlen($strOutput)); 

      fputs($fp, "\n\n", strlen("\n\n")); 


      while( ($hFeature = OGR_L_GetNextFeature( $hLayer )) != NULL )
      {
 

          OGR_F_DumpReadable( $fp, $hFeature);
          OGR_F_Destroy( $hFeature );
      }

      fputs($fp, "\n\n----- EOF -----\n", strlen("\n\n----- EOF -----\n")); 

      /* No need to free layer handle, it belongs to the datasource */

  }
 
}

/**********************************************************************
 *                      OGRDumpSingleLayer()
 *
 * Dump a single layer.
 *
 **********************************************************************/
function OGRDumpSingleLayer ($fp, $hLayer, $bForce){

    $bForce = TRUE;

      /* Dump info about this layer */
    $hLayerDefn = OGR_L_GetLayerDefn( $hLayer );
    $numFields = OGR_FD_GetFieldCount( $hLayerDefn );

    fputs($fp, "\n===================\n", 
          strlen("\n===================\n")); 

    $strOutput =  sprintf("Layer %d: '%s'\n\n", i, 
                          OGR_FD_GetName($hLayerDefn));
    fputs($fp, $strOutput,strlen($strOutput)); 

 
    for($j=0; $j<$numFields; $j++)
    {

        $hFieldDefn = OGR_FD_GetFieldDefn( $hLayerDefn, $j );
        $strOutput =  sprintf(" Field %d: %s (%s)\n", $j, 
                              OGR_Fld_GetNameRef($hFieldDefn), 
                              OGR_GetFieldTypeName(OGR_Fld_GetType($hFieldDefn)) );

        fputs($fp, $strOutput,strlen($strOutput)); 
    }

    fputs($fp, "\n", strlen("\n")); 

      /* And dump each feature individually */

    $strOutput =  sprintf("Feature(s) count= %d", 
                          OGR_L_GetFeatureCount($hLayer, $bForce)); 

    fputs($fp, $strOutput,strlen($strOutput)); 

    fputs($fp, "\n\n", strlen("\n\n")); 


    while( ($hFeature = OGR_L_GetNextFeature( $hLayer )) != NULL )
    {
 

        OGR_F_DumpReadable( $fp, $hFeature);
        OGR_F_Destroy( $hFeature );
    }

    fputs($fp, "\n\n----- EOF -----\n", strlen("\n\n----- EOF -----\n")); 

    /* No need to free layer handle, it belongs to the datasource */

}

/**********************************************************************
 *                      OGRDumpLayerDefn()
 *
 * Dump a layer definition.
 *
 **********************************************************************/
function OGRDumpLayerDefn ($fp, $hLayerDefn){

    /* Dump info about this layer */
    $numFields = OGR_FD_GetFieldCount( $hLayerDefn );

    fputs($fp, "\n===================\n", 
          strlen("\n===================\n")); 

    $strOutput =  sprintf("Layer %d: '%s'\n\n", i, 
                          OGR_FD_GetName($hLayerDefn));
    fputs($fp, $strOutput,strlen($strOutput)); 

 
    for($j=0; $j<$numFields; $j++)
    {

        $hFieldDefn = OGR_FD_GetFieldDefn( $hLayerDefn, $j );
        $strOutput =  sprintf(" Field %d: %s (%s)\n", $j, 
                              OGR_Fld_GetNameRef($hFieldDefn), 
                              OGR_GetFieldTypeName(OGR_Fld_GetType($hFieldDefn)) );

        fputs($fp, $strOutput,strlen($strOutput)); 
    }

    fputs($fp, "\n", strlen("\n")); 

    fputs($fp, "\n\n----- EOF -----\n", strlen("\n\n----- EOF -----\n")); 

    /* No need to free layer handle, it belongs to the datasource */

}

/************************************************************************/
/*                                OGR_WriteResult_main()                */
/************************************************************************/
/**
 * Write the result to a file.
 *
 * @param  string
 * @param  string
 * @access public
 */

function utilWriteResult( $hSrcDS, $hSrcLayer, $hDstDS )

{
    printf("in utilWriteResult()\n");
/* -------------------------------------------------------------------- */
/*      Create the layer.                                               */
/* -------------------------------------------------------------------- */
    if( !OGR_DS_TestCapability( $hDstDS, ODsCCreateLayer ) )
    {
        printf( "%s data source does not support layer creation.\n",
                OGR_DS_GetName($hDstDS) );
        return OGRERR_FAILURE;
    }

    $hFDefn = OGR_L_GetLayerDefn($hSrcLayer);

    $hDstLayer = OGR_DS_CreateLayer( $hDstDS, OGR_FD_GetName($hFDefn),
                                     OGR_L_GetSpatialRef($hSrcLayer), 
                                     OGR_FD_GetGeomType($hFDefn),NULL );

    if( $hDstLayer == NULL ){
        printf("layer null\n");     
   return FALSE;
    }

/* -------------------------------------------------------------------- */
/*      Add fields.                                                     */
/* -------------------------------------------------------------------- */
    for( $iField = 0; $iField < OGR_FD_GetFieldCount($hFDefn); $iField++ )
    {
        if( OGR_L_CreateField( $hDstLayer, 
                               OGR_FD_GetFieldDefn( $hFDefn, $iField),
                               0 /*bApproOK*/ ) != OGRERR_NONE )
            return FALSE;
    }
/* -------------------------------------------------------------------- */
/*      Transfer features.                                              */
/* -------------------------------------------------------------------- */
    OGR_L_ResetReading($hSrcLayer);

    while( ($hFeature = OGR_L_GetNextFeature($hSrcLayer)) != NULL )
    {

        $hDstFeature = OGR_F_Create( OGR_L_GetLayerDefn($hDstLayer) );

        if( OGR_F_SetFrom( $hDstFeature, $hFeature, 
                           FALSE /*bForgiving*/ ) != OGRERR_NONE )
        {
            OGR_F_Destroy($hFeature);
            
            printf("Unable to translate feature %d from layer %s.\n", 
                   OGR_F_GetFID($hFeature), OGR_FD_GetName($hFDefn) );
            return FALSE;
        }
        
        OGR_F_Destroy($hFeature);
        
        if( OGR_L_CreateFeature( $hDstLayer, $hDstFeature ) != OGRERR_NONE )
        {
            OGR_F_Destroy($hDstFeature);
            return FALSE;
        }

        OGR_F_Destroy($hDstFeature);
    }
    return TRUE;

}
?>
