<BODY>
<HTML>
<PRE>
<?php

/******************************************************************************
 * $Id:
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


/**********************************************************************
 *                      
 *
 *                    Utility functions.
 *
 **********************************************************************/

function PHPEQUAL($str1, $str2)
{

    $str1 = strtolower($str1);
    $str2 = strtolower($str2);

    return(!strcmp($str1, $str2));

}


/**********************************************************************
 *                      OGRCCreate()
 *
 * Create a new dataset using OGR C API with a few features in it.
 *
 **********************************************************************/

function OGRCCreate($strFname)
{

    /* Register all OGR drivers */
    OGRRegisterAll();

    /* Fetch MITAB driver - we want to create a TAB file */
    $numDrivers = OGRGetDriverCount();
    printf("nombre drivers = %d", $numDrivers);

    for($i=0; $i<$numDrivers; $i++)
    {
        $hdriver = OGRGetDriver($i);
        if (PHPEQUAL("MapInfo File", OGR_Dr_GetName($hdriver))){
            printf("\nDriver name = %s driver number = %d\n", OGR_Dr_GetName($hdriver), $i);
           break;  /* Found it! */
        }
        $hdriver = NULL;
    }

    if (!$hdriver)
    {
        printf("Driver not found!\n");
        return -1;
    }

    /* Create new file using this driver */

   /*Uncomment and add options here. */
 /* $aoptions[0] = 'option1';
    $aoptions[1] = 'option2';
    $hdatasource = OGR_Dr_CreateDataSource($hdriver, $strFname, $aoptions);
*/

    /* Or use no option.*/
    $hdatasource = OGR_Dr_CreateDataSource($hdriver, $strFname, NULL);

    if ($hdatasource == NULL)
    {
        printf("Unable to create %s\n", $strFname);
        return -1;
    }

    /* MapInfo data sources are created with one empty layer.  But we have
       to specify the "dat" extension with filename, example:  "filename.dat"
       on the command line.  If we want to dump data from the newly created
       file we have to specify the "tab" extension with filename, 
       example:  "filename.tab".
       Fetch the layer handle */
//    $hlayer = OGR_DS_GetLayer($hdatasource, 0 /*layer number*/);

    /*Or create a new layer.*/
    $hlayer = OGR_DS_CreateLayer($hdatasource, "Test", NULL /*Spatial reference*/, wkbPoint, NULL/*Array of options*/);

    if ($hlayer == NULL)
    {
        printf("Unable to create new layer in %s\n", $strFname);
        return -1;
    }

    /* Add a few fields to the layer defn */
    $hfieldDefn = OGR_Fld_Create( "id", OFTInteger );
    $eErr = OGR_L_CreateField($hlayer, $hfieldDefn, 0);
    if( $eErr != OGRERR_NONE )
        return $eErr;

    $hfieldDefn = OGR_Fld_Create( "area", OFTReal );
    $eErr = OGR_L_CreateField($hlayer, $hfieldDefn, 0);
    if( $eErr != OGRERR_NONE )
        return $eErr;

    $hfieldDefn = OGR_Fld_Create( "name", OFTString );
    $eErr = OGR_L_CreateField($hlayer, $hfieldDefn, 0);
    if( $eErr != OGRERR_NONE )
        return $eErr;

    /* We'll need the layerDefn handle to create new features in this layer */
    $hlayerDefn = OGR_L_GetLayerDefn( $hlayer );

    /* Create a new point */
    $hfeature = OGR_F_Create( $hlayerDefn );
    OGR_F_SetFieldInteger( $hfeature, 0, 1);
    OGR_F_SetFieldDouble( $hfeature, 1, 123.45);
    OGR_F_SetFieldString( $hfeature, 2, "Feature #1");


    $hgeometry = OGR_G_CreateGeometry( wkbPoint );
    OGR_G_SetPoint($hgeometry, 0, 123.45, 456.78, 0);

    $eErr = OGR_F_SetGeometry($hfeature, $hgeometry);
    if( $eErr != OGRERR_NONE )
        return $eErr;

    $eErr = OGR_L_CreateFeature( $hlayer, $hfeature );
    if( $eErr != OGRERR_NONE ){
        printf("Error trapped");
        return $eErr;
    }

    /* Create a new line */
    $hfeature = OGR_F_Create( $hlayerDefn );

    OGR_F_SetFieldInteger( $hfeature, 0, 2);
    OGR_F_SetFieldDouble( $hfeature, 1, 42.45);
    OGR_F_SetFieldString( $hfeature, 2, "Feature #2");

    $hgeometry = OGR_G_CreateGeometry( wkbLineString );
    OGR_G_AddPoint($hgeometry, 123.45, 456.78, 0);
    OGR_G_AddPoint($hgeometry, 12.34,  45.67, 0);

    $eErr = OGR_F_SetGeometry($hfeature, $hgeometry);
    if( $eErr != OGRERR_NONE )
        return $eErr;
 
    $eErr = OGR_L_CreateFeature( $hlayer, $hfeature );
    if( $eErr != OGRERR_NONE )
        return $eErr;

    /* Create a new polygon (square) */
    $hfeature = OGR_F_Create( $hlayerDefn );
    OGR_F_SetFieldInteger( $hfeature, 0, 3);
    OGR_F_SetFieldDouble( $hfeature, 1, 49.71);
    OGR_F_SetFieldString( $hfeature, 2, "Feature #3");

    $hgeometry = OGR_G_CreateGeometry( wkbPolygon );
    $hring = OGR_G_CreateGeometry( wkbLinearRing );
    OGR_G_AddPoint($hring, 123.45, 456.78, 0);
    OGR_G_AddPoint($hring, 12.34,  456.78, 0);
    OGR_G_AddPoint($hring, 12.34,  45.67, 0);
    OGR_G_AddPoint($hring, 123.45, 45.67, 0);
    OGR_G_AddPoint($hring, 123.45, 456.78, 0);

    $eErr = OGR_G_AddGeometry($hgeometry, $hring);
    if( $eErr != OGRERR_NONE )
        return $eErr;

    $eErr =OGR_F_SetGeometry($hfeature, $hgeometry);
    if( $eErr != OGRERR_NONE )
        return $eErr;

    $eErr = OGR_L_CreateFeature( $hlayer, $hfeature );
    if( $eErr != OGRERR_NONE )
        return $eErr;

    /* Close data source */
    OGR_DS_Destroy( $hdatasource );

    return OGRERR_NONE;

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
    printf("\nfilename =%s", $strfilename);
}
else
{
// Set your default test filename here (for use in web environment)
    $strfilename ="test.dat";  
}

   $eErr = OGRCCreate($strfilename);

   if ($eErr != OGRERR_NONE)
      printf("Warning %s\n", $eErr);
   else
      return OGRERR_NONE;

?>

</PRE>
</BODY>
</HTML>



















