<BODY>
<HTML>
<PRE>
<?php

/******************************************************************************
 * $Id$
 *
 * Project:  PHP Interface for OGR C API
 * Purpose:  Test program for PHP/OGR module.
 * Author:   Normand Savard, nsavard@dmsolutions.ca
 *
 ******************************************************************************
 * Copyright (c) 2003, DM Solutions Group Inc
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *****************************************************************************/


/************************************************************************/
/*                            DumpPoint                                 */
/*                                                                      */
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

        $eErr = OGR_G_DumpReadable($hGeom);

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


function OGR_G_DumpReadable($hGeom)
{

    switch (OGR_G_GetGeometryType($hGeom)) {
      case wkbUnknown:
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
      case wkbLinearRing:
        $eErr = DumpMultiLineString( $hGeom );
        break;
      case wkbNone:
      default:
        $eErr = OGRERR_UNSUPPORTED_GEOMETRY_TYPE;
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


    printf( "OGRFeature(%s):%ld\n", 
            OGR_FD_GetName($hFeatureDefn), 
            OGR_F_GetFID($hFeature) );

    $numFields = OGR_FD_GetFieldCount($hFeatureDefn);

    for( $iField = 0; $iField < $numFields; $iField++ )
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
        OGR_G_DumpReadable( OGR_F_GetGeometryRef($hFeature) );
    }
    printf("\n");
}


/**********************************************************************
 *                      Main
 *
 * 
 *
 **********************************************************************/

// Check for command-line arguments
if (count($_SERVER["argv"]) >= 2)
{
    // Filename passed as argument in command-line mode
    $strfilename = $_SERVER["argv"][1];
}
else
{
    // Set your default test filename here (for use in web environment)
    $strfilename ="test.tab";  
}


// Register all drivers
   OGRRegisterAll();

// Open data source 
   $hSFDriver=NULL;
   $hDatasource = OGROpen($strfilename, 0, $hSFDriver);

   printf("\nDatasource = ");
   print_r($hDatasource);

   printf("\nSFDriver = ");
   print_r($hSFDriver);

   if ( ! $hDatasource)
   {
      printf("Unable to open %s\n", $strfilename);
      return -1;
   }


  /* Loop through layers and dump their contents */


  $numLayers = OGR_DS_GetLayerCount($hDatasource);

  printf("\nLayers count = %s\n",$numLayers);

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

        printf("Feature(s) count= %d", OGR_L_GetFeatureCount($hLayer, 
                                                   TRUE /*bforce*/)); 
        printf("\n\n");

        /* And dump each feature individually */

        while( ($hFeature = OGR_L_GetNextFeature( $hLayer )) != NULL )
        {
 

            OGR_F_DumpReadable( $hFeature);
            OGR_F_Destroy( $hFeature );
        }

         printf("\n\n----- EOF -----\n");

        /* No need to free layer handle, it belongs to the datasource */

   }


    /* Close data source */
    OGR_DS_Destroy($hDatasource);


?>

</PRE>
</BODY>
</HTML>
