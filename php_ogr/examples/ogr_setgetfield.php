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
 *                      OGRSetGetInteger()
 *
 * Create a field as integer, assign a value and retrive it after.
 *
 **********************************************************************/

function OGRSetGetInteger($hFeatureIn, $iField, $value)
{

    /*Assigning an integer value to the field to the field "0".*/

    OGR_F_SetFieldInteger($hFeatureIn, $iField, $value);

    /*Retrieving the field value. */
    $value = OGR_F_GetFieldAsInteger($hFeatureIn, $iField);

    printf("Integer value = %d\n",$value );

    return OGRERR_NONE;
}

/**********************************************************************
 *                      OGRSetGetDouble()
 *
 * Create a field as double, assign a value and retrive it after.
 *
 **********************************************************************/

function OGRSetGetDouble($hFeatureIn, $iField, $value)
{

    /*Assigning a double value to the field to the field "0".*/

    OGR_F_SetFieldDouble($hFeatureIn, $iField, $value);

    /*Retrieving the field value. */
    $value = OGR_F_GetFieldAsDouble($hFeatureIn, $iField);

    printf("Double value = %.2f\n",$value );

    return OGRERR_NONE;
}

/**********************************************************************
 *                      OGRSetGetString()
 *
 * Create a field as string, assign a value and retrive it after.
 *
 **********************************************************************/

function OGRSetGetString($hFeatureIn, $iField, $value)
{

    /*Assigning a string value to the field to the field "0".*/

    OGR_F_SetFieldString($hFeatureIn, $iField, $value);

    /*Retrieving the field value. */
    $value = OGR_F_GetFieldAsString($hFeatureIn, $iField);

    printf("String value = %s\n",$value );

    return OGRERR_NONE;
}

/**********************************************************************
 *                      OGRSetGetIntegerList()
 *
 * Create a field as integer, assign a value and retrive it after.
 *
 **********************************************************************/

function OGRSetGetIntegerList($hFeatureIn, $iField, &$nCount, $value)
{

    /*Assigning an integer value to the field to the field "0".*/

    OGR_F_SetFieldIntegerList($hFeatureIn, $iField, $nCount, $value);

    /*Retrieving the field value. */
    $value[] = OGR_F_GetFieldAsIntegerList($hFeatureIn, $iField, $nCount);


    for ($i = 0; $i < $nCount; $i++) {
    printf("Integer value[%d] = %d\n", $i, $value[$i] );
    }
    return OGRERR_NONE;
}

/**********************************************************************
 *                      OGRSetGetDoubleList()
 *
 * Create a field as double, assign a value and retrive it after.
 *
 **********************************************************************/

function OGRSetGetDoubleList($hFeatureIn, $iField, $nCount, $value)
{

    /*Assigning a double value to the field to the field "0".*/

    OGR_F_SetFieldDoubleList($hFeatureIn, $iField, $nCount, $value);

    /*Retrieving the field value. */
    $value = OGR_F_GetFieldAsDoubleList($hFeatureIn, $iField, $nCount);

    for ($i = 0; $i < $nCount; $i++) {
        printf("Double value[%d] = %.2f\n", $i, $value[$i] );
    }
    return OGRERR_NONE;
}

/**********************************************************************
 *                      OGRSetGetStringList()
 *
 * Create a field as string, assign a value and retrive it after.
 *
 **********************************************************************/

function OGRSetGetStringList($hFeatureIn, $iField, $value)
{

    /*Assigning a string value to the field to the field "0".*/

    OGR_F_SetFieldStringList($hFeatureIn, $iField,  $value);

    /*Retrieving the field value. */
    $value[] = OGR_F_GetFieldAsStringList($hFeatureIn, $iField);

    $i = 0;
    while ($value[$i]){
        printf("String value[%d] = %s\n", $i, $value[$i] );
        $i++;
    }

    return OGRERR_NONE;
}


/**********************************************************************
 *                      Main
 *
 * 
 *
 **********************************************************************/

   $intValue = 4312;
   $doubleValue = 6533.58;
   $stringValue = "Liberty";

   $intListValue[0] = 31;
   $intListValue[1] = 25;
   $intListValue[2] = 12;
   $numInteger = 3;

   $doubleListValue[0] = 3658.12;
   $doubleListValue[1] = 2563.35;
   $doubleListValue[2] = 312.11;
   $numDouble = 3;

   $stringListValue[0] = "Tom Sayers";
   $stringListValue[1] = "Julia Robertson";
   $stringListValue[2] = "Jinny Sayers Robertson";
   $stringListValue[3] =  NULL ;



    /*Preparing feature definition with field definitions 0 to 5.*/
    $hFeatureDefn = OGR_FD_Create("options");

    $hfieldDefn = OGR_Fld_Create( "Address", OFTInteger );
    OGR_FD_AddFieldDefn($hFeatureDefn, $hfieldDefn);

    $hfieldDefn = OGR_Fld_Create( "Total earning", OFTReal );
    OGR_FD_AddFieldDefn($hFeatureDefn, $hfieldDefn);

    $hfieldDefn = OGR_Fld_Create( "Street", OFTString );
    OGR_FD_AddFieldDefn($hFeatureDefn, $hfieldDefn);

    $hfieldDefn = OGR_Fld_Create( "Age", OFTIntegerList );
    OGR_FD_AddFieldDefn($hFeatureDefn, $hfieldDefn);

    $hfieldDefn = OGR_Fld_Create( "Individual earning", OFTRealList );
    OGR_FD_AddFieldDefn($hFeatureDefn, $hfieldDefn);

    $hfieldDefn = OGR_Fld_Create( "First-Last Names", OFTStringList );
    OGR_FD_AddFieldDefn($hFeatureDefn, $hfieldDefn);


    /*Creating a new feature with the previous definition */
    $hFeature = OGR_F_Create($hFeatureDefn);

    /*Testing if the field is created. */
    $numFields = OGR_F_GetFieldCount($hFeature);
    printf("nombre de field = %d\n", $numFields);

    $fieldIndex = OGR_F_GetFieldIndex($hFeature, "First-Last Names");
    printf("field index = %d\n", $fieldIndex);

   $fieldIndex = 0;
   $eErr = OGRSetGetInteger($hFeature, $fieldIndex, $intValue);
   $fieldIndex = 1;
   $eErr = OGRSetGetDouble($hFeature, $fieldIndex, $doubleValue);
   $fieldIndex = 2;
   $eErr = OGRSetGetString($hFeature, $fieldIndex, $stringValue);

   $fieldIndex = 3;
   $eErr = OGRSetGetIntegerList($hFeature, $fieldIndex, $numInteger, $intListValue);
   $fieldIndex = 4;
   $eErr = OGRSetGetDoubleList($hFeature, $fieldIndex, $numDouble, $doubleListValue);
   $fieldIndex = 5;
   $eErr = OGRSetGetStringList($hFeature, $fieldIndex, $stringListValue);


   if ($eErr != OGRERR_NONE)
      printf("Warning %s\n", $eErr);

   OGR_F_Destroy($hFeature);

   return OGRERR_NONE;


?>

</PRE>
</BODY>
</HTML>







