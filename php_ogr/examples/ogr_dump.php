<BODY>
<HTML>
<PRE>
<?php
/* $Id$ */

/************************************************************************/
/*                            DumpPoint                                 */
/*                                                                      */
/*      Translate this structure into it's well known text format       */
/*      equivelent.                                                     */
/************************************************************************/

function DumpPoint( $hGeom, $iPoint )

{

    printf( "%.3f %.3f %.3f\n", OGR_G_GetX($hGeom, $iPoint),
            OGR_G_GetY($hGeom, $iPoint),
            OGR_G_GetZ($hGeom, $iPoint));

    return OGRERR_NONE;
}

/************************************************************************/
/*                            DumpLineString                            */
/*                                                                      */
/*      Translate this structure into it's well known text format       */
/*      equivelent.  This could be made alot more CPU efficient!        */
/************************************************************************/

function DumpLineString( $hGeom )

{
    printf( "%s:\n", OGR_G_GetGeometryName($hGeom) );

    $nPointCount = OGR_G_GetPointCount($hGeom);

    for( $i = 0; $i < $nPointCount; $i++ )
    {
        if( OGR_G_GetCoordinateDimension($hGeom) == 3 ){
            printf("%.3f %.3f %.3f\n", OGR_G_GetX($hGeom, $i),
                                 OGR_G_GetY($hGeom, $i),
                                 OGR_G_GetZ($hGeom, $i));
        }
        else{
            printf("%.3f %.3f\n", OGR_G_GetX($hGeom, $i),
                                 OGR_G_GetY($hGeom, $i));
        }
    }

    return OGRERR_NONE;
}


/************************************************************************/
/*                            DumpPolygon                               */
/*                                                                      */
/*      Translate this structure into it's well known text format       */
/*      equivelent.  This could be made alot more CPU efficient!        */
/************************************************************************/
function DumpPolygon( $hGeom )

{
/* -------------------------------------------------------------------- */
/*      Build a list of strings containing the stuff for each ring.     */
/* -------------------------------------------------------------------- */
    printf("%s:\n", OGR_G_GetGeometryName($hGeom) );

    $nRingCount = OGR_G_GetGeometryCount($hGeom);

    for( $iRing = 0; $iRing < $nRingCount; $iRing++ )
    {
        $hRing = OGR_G_GetGeometryRef($hGeom, $iRing);
        $eErr = DumpLineString( $hRing, &$strRings );
        if( $eErr != OGRERR_NONE )
            return $eErr;
    }
    
    return OGRERR_NONE;
}

/************************************************************************/
/*                            DumpMultiPoint                            */
/*                                                                      */
/*      Translate this structure into it's well known text format       */
/*      equivelent.  This could be made alot more CPU efficient!        */
/************************************************************************/

function DumpMultipoint( $hGeom)

{
    printf("%s:\n", OGR_G_GetGeometryName($hGeom) );

    for( $i = 0; $i < OGR_G_GetGeometryCount($hGeom); $i++ )
    {
        $hPoint = OGR_G_GetGeometryRef($hGEom, $i );

        if( $i > 0 )
            printf("\n");

        if( OGR_G_GetCoordinateDimension($hGeom) == 3 ){
            printf("%.3f %.3f %.3f\n", OGR_G_GetX($hGeom, $i),
                                 OGR_G_GetY($hGeom, $i),
                                 OGR_G_GetZ($hGeom, $i));
        }
        else{
            printf("%.3f %.3f\n", OGR_G_GetX($hGeom, $i),
                                 OGR_G_GetY($hGeom, $i));
        }
    }
    return OGRERR_NONE;
}

/************************************************************************/
/*                            DumpMultiLineString                       */
/*                                                                      */
/*      Translate this structure into it's well known text format       */
/*      equivelent.  This could be made alot more CPU efficient!        */
/************************************************************************/


function DumpMultiLineString( $hGeom)

{
/* -------------------------------------------------------------------- */
/*      Build a list of strings containing the stuff for each ring.     */
/* -------------------------------------------------------------------- */
    printf( "%s:\n", OGR_G_GetGeometryName($hGeom) );

    for( $iLine = 0; $iLine <  OGR_G_GetGeometryCount($hGeom); $iLine++ )
    {
        $hLine = OGR_G_GetGeometryRef($hGeom, $iLine);
        $eErr = DumpLineString( $hLine );
        if( $eErr != OGRERR_NONE )
            return $eErr;
    }
   return OGRERR_NONE;
}

/************************************************************************/
/*                            DumpMultiPolygon                          */
/*                                                                      */
/*      Translate this structure into it's well known text format       */
/*      equivelent.  This could be made alot more CPU efficient!        */
/************************************************************************/

function   DumpMultiPolygon($hGeom)

{

/* -------------------------------------------------------------------- */
/*      Build a list of strings containing the stuff for each ring.     */
/* -------------------------------------------------------------------- */
    printf( "%s:\n", OGR_G_GetGeometryName($hGeom) );

    for( $iLine = 0; $iLine < OGR_G_GetGeometryCount($hGeom); $iLine++ )
    {
        $hPolygon = OGR_G_GetGeometryRef($hGeom, $iLine);

            $eErr = DumpPolygon($hPolygon, &$strPolygon );

        if( $eErr != OGRERR_NONE )
            return eErr;
    }
    
    return OGRERR_NONE;
}

/************************************************************************/
/*                            DumpGeometryCollection                    */
/*                                                                      */
/*      Translate this structure into it's well known text format       */
/*      equivelent.  This could be made alot more CPU efficient!        */
/************************************************************************/

function   DumpGeometryCollection( $hGeom)

{

/* -------------------------------------------------------------------- */
/*      Build a list of strings containing the stuff for each Geom.     */
/* -------------------------------------------------------------------- */

    printf("%s:\n", OGR_GetGetGeometryName($hGeom));

    $nGeomCount = OGR_G_GetGeometryCount($hGeom);

    for( $iGeom = 0; $iGeom < $nGeomCount; $iGeom++ )
    {
        $hSubGeom = OGR_G_GetGeometryRef($hGEom, $i );


        switch (OGR_G_GetGeometryType($hSubGeom)) {
          case wkbUnkonwn:
            print "0\n";
            break;
          case wkbPoint:
          case wkbPoint25D:
            $eERR = exportToWktwkbPoint( $hSubGeom, 0 );
            break;
          case wkbLineString:
          case wkbLineString25D:
            $eErr = exportToWktwkbLineString( $hSubGeom );
            break;
          case wkbPolygon:
          case wkbPolygon25D:
            $eErr = exportToWktwkbPolygon( $hSubGeom );
            break;
          case wkbMultiPoint:
          case wkbMultiPoint25D:
            $eErr = exportToWktwkbMultipoint( $hSubGeom );
            break;
          case wkbMultiLineString:
          case wkbMultiLineString25D:
            $eErr = exportToWktwkbMultiLineString( $hSubGeom );
            break;
          case wkbMultiPolygon:
          case wkbMultiPolygon25D:
            $eErr = exportToWktwkbMultiLinePolygon( $hSubGeom );
            break;
        }

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


function OGR_G_DumpReadable($hGeom, $strPrefix)
{

    $pszWkt = NULL;
    
    if( $pszPrefix == NULL )
        $pszPrefix = "";

    switch (OGR_G_GetGeometryType($hGeom)) {
       case wkbUnkonwn:
         break;
       case wkbPoint:
       case wkbPoint25D:
         $eErr = DumpPoint( $hGeom, 0 );
         break;
       case wkbLineString:
       case wkbLineString25D:
         $eErr = DumpLineString( $hGeom );
         break;
       case wkbPolygon:
       case wkbPolygon25D:
         $eErr = DumpPolygon( $hGeom );
         break;
        case wkbMultiPoint:
        case wkbMultiPoint25D:
         $eErr = DumpMultipoint( $hGeom );
          break;
        case wkbMultiLineString:
        case wkbMultiLineString25D:
         $eErr = DumpMultiLineString( $hGeom );
          break;
        case wkbMultiPolygon:
        case wkbMultiPolygon25D:
         $eErr = DumpMultiPolygon( $hGeom );
          break;
       case wkbGeometryCollection:
       case wkbGeometryCollection25D:
         $eErr = DumpGeometryCollection( $hGeom );
         break;
       case wkbNone:
         $eErr = OGRERR_UNSUPPORTED_GEOMETRY_TYPE;
         break;
       case wkbLinearRing:
         $eErr = DumpMultiLineString( $hGeom );
         break;
    } 

}


/**********************************************************************
 *                      OGRCDump()
 *
 * Dump all features on a layer.
 *
 **********************************************************************/

 function OGR_F_DumpReadable( $hFeature)

{

    $hFeatureDefn = OGR_F_GetDefnRef($hFeature);


    printf( "OGRFeature(%s):%ld\n", OGR_FD_GetName($hFeatureDefn), OGR_F_GetFID($hFeature) );

    for( $iField = 0; $iField < (OGR_FD_GetFieldCount($hFeatureDefn)); $iField++ )
    {



        $hFieldDefn = OGR_FD_GetFieldDefn($hFeatureDefn, $iField);



        printf( "  %s (%s) = ", OGR_FLD_GetNameRef($hFieldDefn),
               OGR_GetFieldTypeName(OGR_FLD_GetType($hFieldDefn)) );



       if( OGR_F_IsFieldSet( $hFeature, $iField ) )
          printf( "%s\n", OGR_F_GetFieldAsString( $hFeature, $iField ) );
         else
            printf( "(null)\n" );
            
    }

    if( OGR_F_GetStyleString($hFeature) != NULL )
        printf( "  Style = %s\n", OGR_F_GetStyleString($hFeature) );
    

    if( OGR_F_GetGeometryRef($hFeature) != NULL ){
        OGR_G_DumpReadable( OGR_F_GetGeometryRef($hFeature),  "  " );
    }
    printf("\n");
}


/**********************************************************************
 *                      Main
 *
 * 
 *
 **********************************************************************/


// Register all drivers
   OGRRegisterAll();

// Open data source 
   $hSFDriver=NULL;
//   $strfilename = "/home/nsavard/proj/php-4.3.1/ext/ogr/OGRTests/norsa1.tab";
$strfilename ="/usr1/home/daniel/ttt/canada/outfme/CANADA.tab";
   $hDatasource = OGROpen($strfilename, 0, $hSFDriver);

   printf("\hDatasource = ");
   print_r($hDatasource);

   printf("\hSFDriver = ");
   print_r($hSFDriver);

   if ( ! $hDatasource)
   {
      printf("Unable to open \n\n%s\n", $strfilename);
      return -1;
   }


//_____________
  /* Loop through layers and dump their contents */



  $numLayers = OGR_DS_GetLayerCount($hDatasource);

  printf("\nLayers count = %s",$numLayers);

  for($i=0; $i<$numLayers; $i++)
  {
     $hLayer = OGR_DS_GetLayer( $hDatasource, $i );

     /* Dump info about this layer */
     $hLayerDefn = OGR_L_GetLayerDefn( $hLayer );
     $numFields = OGR_FD_GetFieldCount( $hLayerDefn );

        printf("\n===================\n");
        printf("Layer %d: '%s'\n\n", i, OGR_FD_GetName($hLayerDefn));


 
        for($j=0; $j<$numFields; $j++)
        {

            $hFieldDefn = OGR_FD_GetFieldDefn( $hLayerDefn, $j );
            printf(" Field %d: %s (%s)\n", $j, 
                   OGR_Fld_GetNameRef($hFieldDefn), 
                   OGR_GetFieldTypeName(OGR_Fld_GetType($hFieldDefn)) );
        }
        printf("\n");

        /* And dump each feature individually */

        printf("Features count= %d", OGR_L_GetFeatureCount($hLayer, $i)); 
        printf("\n\n");


        while( ($hFeature = OGR_L_GetNextFeature( $hLayer )) != NULL )
        {
 

            OGR_F_DumpReadable( $hFeature);
            OGR_F_Destroy( $hFeature );
        }

         printf("\n\n\nFINFINFINFIN");

        /* No need to free layer handle, it belongs to the datasource */

   }


    /* Close data source */
    OGR_DS_Destroy($hDatasource);

    return 0;








?>

</PRE>
</BODY>
</HTML>








