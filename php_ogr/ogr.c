/******************************************************************************
 * $Id$
 *
 * Project:  PHP Interface for OGR C API
 * Purpose:  Implementation of PHP wrapper functions.
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
 ******************************************************************************
 *
 * $Log$
 * Revision 1.11  2003/03/31 22:03:35  nsavard
 * Corrected bugs in OGR_G_GetEnvelope.
 *
 * Revision 1.10  2003/03/31 15:08:20  assefa
 * Change all return values to lowercase in getextent function.
 *
 * Revision 1.9  2003/03/28 21:30:36  assefa
 * Correct bug in GetExtents function.
 *
 * Revision 1.8  2003/03/25 14:54:34  daniel
 * Prevent crashes when returning NULL strings or resources
 *
 * Revision 1.7  2003/03/24 20:08:14  nsavard
 * Take into account the case when a C function return a NULL resource in
 * OGR_G_GetSpatialReference, OGR_L_GetSpatialFilter, OGR_L_GetSpatialRef.
 *
 * Revision 1.6  2003/03/19 16:56:40  nsavard
 * Add "php_array2list" function, an array to string list function.  Corrected
 * a few bugs.
 *
 * Revision 1.5  2003/03/19 00:47:42  nsavard
 * Corrected some bugs and cleaned up.
 *
 * Revision 1.4  2003/03/17 20:03:00  nsavard
 * Corrected some bugs.  Enabling NULL parameters in some zend_parse_parameters
 * functions with "!" option.
 *
 * Revision 1.3  2003/03/14 00:31:18  assefa
 * Windows compilation.
 *
 * Revision 1.2  2003/03/13 23:51:53  daniel
 * Added header with license and CVS ids
 *
 */


#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_ogr.h"

/* Include OGR C Wrappers declarations */
#include "ogr_srs_api.h"
#include "ogr_api.h"
#include "cpl_error.h"
#include "cpl_conv.h"
#include "cpl_string.h"

/* If you declare any globals in php_ogr.h uncomment this:
ZEND_DECLARE_MODULE_GLOBALS(ogr)
*/


#ifdef PHP4
#define ZEND_DEBUG 0
#endif


/* True global resources - no need for thread safety here */

static int le_Datasource;
static int le_SFDriver;
static int le_Layer;
static int le_SpatialReference;
static int le_SpatialReferenceRef;
static int le_CoordinateTransformation;
static int le_Geometry;
static int le_GeometryRef;
static int le_FieldDefn;
static int le_FieldDefnRef;
static int le_Field;
static int le_FieldRef;
static int le_FeatureDefn;
static int le_FeatureDefnRef;
static int le_Feature;


/*Force some resource arguments to be passed as reference.*/
static unsigned char five_args_third_fourth_fifth_args_force_ref[] = { 5,  BYREF_NONE, BYREF_NONE, BYREF_FORCE, BYREF_FORCE, BYREF_FORCE };

static unsigned char three_args_first_arg_force_ref[] = { 3, BYREF_FORCE, BYREF_NONE, BYREF_NONE };
static unsigned char three_args_third_arg_force_ref[] = { 3, BYREF_NONE, BYREF_NONE, BYREF_FORCE };
static unsigned char three_args_second_arg_force_ref[] = { 3, BYREF_NONE, BYREF_FORCE, BYREF_NONE };
static unsigned char two_args_first_arg_force_ref[] = { 2, BYREF_FORCE, BYREF_NONE };


/* {{{ ogr_functions[]
 *
 * Every user visible function must have an entry in ogr_functions[].
 */
function_entry ogr_functions[] = {
    PHP_FE(ogr_g_createfromwkb, NULL)
    PHP_FE(ogr_g_createfromwkt, NULL)
    PHP_FE(ogr_g_destroygeometry, NULL)
    PHP_FE(ogr_g_creategeometry,    NULL)
    PHP_FE(ogr_g_getdimension,  NULL)
    PHP_FE(ogr_g_getcoordinatedimension,    NULL)
    PHP_FE(ogr_g_clone, NULL)
    PHP_FE(ogr_g_getenvelope,   two_args_first_arg_force_ref)
#ifdef CONSTRUCT_FLAG    
    PHP_FE(ogr_g_importfromwkb, NULL)
    PHP_FE(ogr_g_exporttowkb,   three_args_first_arg_force_ref)
#endif
    PHP_FE(ogr_g_wkbsize,   NULL)
#ifdef CONSTRUCT_FLAG
    PHP_FE(ogr_g_importfromwkt, NULL)
    PHP_FE(ogr_g_exporttowkt,   two_args_first_arg_force_ref)
#endif    
    PHP_FE(ogr_g_getgeometrytype,   NULL)
    PHP_FE(ogr_g_getgeometryname,   NULL)
#ifdef CONSTRUCT_FLAG
    PHP_FE(ogr_g_dumpreadable, three_args_first_arg_force_ref)
#endif
    PHP_FE(ogr_g_flattento2d,   NULL)
    PHP_FE(ogr_g_assignspatialreference,    NULL)
    PHP_FE(ogr_g_getspatialreference,   NULL)
    PHP_FE(ogr_g_transform, NULL)
    PHP_FE(ogr_g_transformto,   NULL)
    PHP_FE(ogr_g_intersect, NULL)
    PHP_FE(ogr_g_equal, NULL)
    PHP_FE(ogr_g_empty, NULL)
    PHP_FE(ogr_g_getpointcount, NULL)
    PHP_FE(ogr_g_getx,  NULL)
    PHP_FE(ogr_g_gety,  NULL)
    PHP_FE(ogr_g_getz,  NULL)
    PHP_FE(ogr_g_getpoint,  five_args_third_fourth_fifth_args_force_ref)
    PHP_FE(ogr_g_setpoint,  NULL)
    PHP_FE(ogr_g_addpoint,  NULL)
    PHP_FE(ogr_g_getgeometrycount,  NULL)
    PHP_FE(ogr_g_getgeometryref,    NULL)
    PHP_FE(ogr_g_addgeometry,   NULL)
#ifdef CONSTRUCT_FLAG
    PHP_FE(ogr_g_addgeometrydirectly,   NULL)
#endif
    PHP_FE(ogr_g_removegeometry,    NULL)
    PHP_FE(ogrbuildpolygonfromedges,    NULL)
    PHP_FE(ogr_fld_create,  NULL)
    PHP_FE(ogr_fld_destroy, NULL)
    PHP_FE(ogr_fld_setname, NULL)
    PHP_FE(ogr_fld_getnameref,  NULL)
    PHP_FE(ogr_fld_gettype, NULL)
    PHP_FE(ogr_fld_settype, NULL)
    PHP_FE(ogr_fld_getjustify,  NULL)
    PHP_FE(ogr_fld_setjustify,  NULL)
    PHP_FE(ogr_fld_getwidth,    NULL)
    PHP_FE(ogr_fld_setwidth,    NULL)
    PHP_FE(ogr_fld_getprecision,    NULL)
    PHP_FE(ogr_fld_setprecision,    NULL)
    PHP_FE(ogr_fld_set, NULL)
    PHP_FE(ogr_getfieldtypename,    NULL)
    PHP_FE(ogr_fd_create,   NULL)
    PHP_FE(ogr_fd_destroy,  NULL)
    PHP_FE(ogr_fd_getname,  NULL)
    PHP_FE(ogr_fd_getfieldcount,    NULL)
    PHP_FE(ogr_fd_getfielddefn, NULL)
    PHP_FE(ogr_fd_getfieldindex,    NULL)
    PHP_FE(ogr_fd_addfielddefn, NULL)
    PHP_FE(ogr_fd_getgeomtype,  NULL)
    PHP_FE(ogr_fd_setgeomtype,  NULL)
    PHP_FE(ogr_fd_reference,    NULL)
    PHP_FE(ogr_fd_dereference,  NULL)
    PHP_FE(ogr_fd_getreferencecount,    NULL)
    PHP_FE(ogr_f_create,    NULL)
    PHP_FE(ogr_f_destroy,   NULL)
    PHP_FE(ogr_f_getdefnref,    NULL)
#ifdef CONSTRUCT_FLAG
    PHP_FE(ogr_f_setgeometrydirectly,   NULL)
#endif
    PHP_FE(ogr_f_setgeometry,   NULL)
    PHP_FE(ogr_f_getgeometryref,    NULL)
    PHP_FE(ogr_f_clone, NULL)
    PHP_FE(ogr_f_equal, NULL)
    PHP_FE(ogr_f_getfieldcount, NULL)
    PHP_FE(ogr_f_getfielddefnref,   NULL)
    PHP_FE(ogr_f_getfieldindex, NULL)
    PHP_FE(ogr_f_isfieldset,    NULL)
    PHP_FE(ogr_f_unsetfield,    NULL)
    PHP_FE(ogr_f_getrawfieldref,    NULL)
    PHP_FE(ogr_f_getfieldasinteger, NULL)
    PHP_FE(ogr_f_getfieldasdouble,  NULL)
    PHP_FE(ogr_f_getfieldasstring,  NULL)
    PHP_FE(ogr_f_getfieldasintegerlist, NULL)
    PHP_FE(ogr_f_getfieldasdoublelist,  NULL)
    PHP_FE(ogr_f_getfieldasstringlist,  NULL)
    PHP_FE(ogr_f_setfieldinteger,   NULL)
    PHP_FE(ogr_f_setfielddouble,    NULL)
    PHP_FE(ogr_f_setfieldstring,    NULL)
    PHP_FE(ogr_f_setfieldintegerlist,   NULL)
    PHP_FE(ogr_f_setfielddoublelist,    NULL)
    PHP_FE(ogr_f_setfieldstringlist,    NULL)
    PHP_FE(ogr_f_setfieldraw,   NULL)
    PHP_FE(ogr_f_getfid,    NULL)
    PHP_FE(ogr_f_setfid,    NULL)
#ifdef CONSTRUCT_FLAG
    PHP_FE(ogr_f_dumpreadable,  NULL)
#endif
    PHP_FE(ogr_f_setfrom,   NULL)
    PHP_FE(ogr_f_getstylestring,    NULL)
    PHP_FE(ogr_f_setstylestring,    NULL)
    PHP_FE(ogr_l_getspatialfilter,  NULL)
    PHP_FE(ogr_l_setspatialfilter,  NULL)
    PHP_FE(ogr_l_setattributefilter,    NULL)
    PHP_FE(ogr_l_resetreading,  NULL)
    PHP_FE(ogr_l_getnextfeature,    NULL)
    PHP_FE(ogr_l_getfeature,    NULL)
    PHP_FE(ogr_l_setfeature,    NULL)
    PHP_FE(ogr_l_createfeature, NULL)
    PHP_FE(ogr_l_getlayerdefn,  NULL)
    PHP_FE(ogr_l_getspatialref, NULL)
    PHP_FE(ogr_l_getfeaturecount,   NULL)
    PHP_FE(ogr_l_getextent, three_args_second_arg_force_ref)
    PHP_FE(ogr_l_testcapability,    NULL)
    PHP_FE(ogr_l_createfield,   NULL)
    PHP_FE(ogr_l_starttransaction,  NULL)
    PHP_FE(ogr_l_committransaction, NULL)
    PHP_FE(ogr_l_rollbacktransaction,   NULL)
    PHP_FE(ogr_ds_destroy,  NULL)
    PHP_FE(ogr_ds_getname, NULL)
    PHP_FE(ogr_ds_getlayercount, NULL)
    PHP_FE(ogr_ds_getlayer, NULL)
    PHP_FE(ogr_ds_createlayer,  NULL)
    PHP_FE(ogr_ds_testcapability,  NULL)
    PHP_FE(ogr_ds_executesql,   NULL)
    PHP_FE(ogr_ds_releaseresultset, NULL)
    PHP_FE(ogr_dr_getname,  NULL)
    PHP_FE(ogr_dr_open, NULL)
    PHP_FE(ogr_dr_testcapability,  NULL)
    PHP_FE(ogr_dr_createdatasource, NULL)
    PHP_FE(ogropen, three_args_third_arg_force_ref)
    PHP_FE(ogrregisterdriver,  NULL)
    PHP_FE(ogrgetdrivercount,   NULL)
    PHP_FE(ogrgetdriver,    NULL)
    PHP_FE(ogrregisterall,  NULL)
    {NULL, NULL, NULL}  /* Must be the last line in ogr_functions[] */
};
/* }}} */

/* {{{ ogr_module_entry
 */
zend_module_entry ogr_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
    STANDARD_MODULE_HEADER,
#endif
    "ogr",
    ogr_functions,
    PHP_MINIT(ogr),
    PHP_MSHUTDOWN(ogr),
    PHP_RINIT(ogr),     /* Replace with NULL if there's nothing to do at request start */
    PHP_RSHUTDOWN(ogr), /* Replace with NULL if there's nothing to do at request end */
    PHP_MINFO(ogr),
#if ZEND_MODULE_API_NO >= 20010901
    "0.1", /* Replace with version number for your extension */
#endif
    STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_OGR
ZEND_GET_MODULE(ogr)
#endif

/* {{{ PHP_INI
 */
/* Remove comments and fill if you need to have entries in php.ini
PHP_INI_BEGIN()
    STD_PHP_INI_ENTRY("ogr.global_value",      "42", PHP_INI_ALL, OnUpdateInt, global_value, zend_ogr_globals, ogr_globals)
    STD_PHP_INI_ENTRY("ogr.global_string", "foobar", PHP_INI_ALL, OnUpdateString, global_string, zend_ogr_globals, ogr_globals)
PHP_INI_END()
*/
/* }}} */

/* {{{ php_ogr_init_globals
 */
/* Uncomment this function if you have INI entries
static void php_ogr_init_globals(zend_ogr_globals *ogr_globals)
{
    ogr_globals->global_value = 0;
    ogr_globals->global_string = NULL;
}
*/


/*Resource destructors function.*/
/* }}} */

/* {{{ ogr_free_Datasource() */

static void
ogr_free_Datasource(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
    OGRDataSourceH hds = (OGRDataSourceH)rsrc->ptr;

    OGR_DS_Destroy( hds ); 

}

/* }}} */

/* {{{ ogr_free_SFDriver() */

static void
ogr_free_SFDriver(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{

/* Nothing to do here since the datasource destructor already frees all
 * SFDriver.
 */
}

/* }}} */
/* {{{ ogr_free_Layer() */
static void
ogr_free_Layer(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
/* Nothing to do here since the datasource destructor already frees all
 * layers.
 */
}

/* }}} */
/* {{{ ogr_free_SpatialReference() */
static void
ogr_free_SpatialReference(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
    OGRSpatialReferenceH hSRS = (OGRSpatialReferenceH)rsrc->ptr;
    OSRDestroySpatialReference( hSRS );
}

/* }}} */
/* {{{ ogr_free_SpatialReferenceRef() */
static void
ogr_free_SpatialReferenceRef(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
/* Dummy destructor since this is only a reference on a resource
 * and we are not the owner.
 */
}

/* }}} */
/* {{{ ogr_free_CoordinateTransformation() */
static void
ogr_free_CoordinateTransformation(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
    OGRCoordinateTransformationH hCT = (OGRCoordinateTransformationH)rsrc->ptr;
    OCTDestroyCoordinateTransformation(hCT);

}

/* }}} */

/* {{{ ogr_free_Geometry() */

static void
ogr_free_Geometry(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
    OGRGeometryH hGeom = (OGRGeometryH)rsrc->ptr;
    OGR_G_DestroyGeometry( hGeom ); 

}


/* }}} */

/* {{{ ogr_free_GeometryRef() */

static void
ogr_free_GeometryRef(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
/* Dummy destructor since this is only a reference on a resource
 * and we are not the owner.
 */
}

/* }}} */

/* {{{ ogr_free_FieldDefn() */

static void
ogr_free_FieldDefn(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
    OGRFieldDefnH hFieldDefn = (OGRFieldDefnH)rsrc->ptr;
    OGR_Fld_Destroy( hFieldDefn ); 

}

/* }}} */

/* {{{ ogr_free_FieldDefnRef() */

static void
ogr_free_FieldDefnRef(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
/* Dummy destructor since this is only a reference on a resource
 * and we are not the owner.
 */
}

/* }}} */

/* {{{ ogr_free_Field() */

static void
ogr_free_Field(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
/* Nothing to do here since the FieldDefn destructor already frees all
 * fields.
 */
}

/* }}} */

/* {{{ ogr_free_FieldRef() */

static void
ogr_free_FieldRef(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
/* Dummy destructor since this is only a reference on a resource
 * and we are not the owner.
 */
}

/* }}} */

/* {{{ ogr_free_FeatureDefn() */

static void
ogr_free_FeatureDefn(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
    OGRFeatureDefnH hFeatureDefn = (OGRFeatureDefnH)rsrc->ptr;
    OGR_FD_Destroy( hFeatureDefn ); 

}

/* }}} */

/* {{{ ogr_free_FeatureDefnRef() */

static void
ogr_free_FeatureDefnRef(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
/* Dummy destructor since this is only a reference on a resource
 * and we are not the owner.
 */
}

/* }}} */

/* {{{ ogr_free_Feature() */

static void
ogr_free_Feature(zend_rsrc_list_entry *rsrc TSRMLS_DC)
{
    OGRFeatureH hFeature = (OGRFeatureH)rsrc->ptr;
    OGR_F_Destroy( hFeature ); 

}


/* }}} */

/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(ogr)
{

    /* If you have INI entries, uncomment these lines 
    ZEND_INIT_MODULE_GLOBALS(ogr, php_ogr_init_globals, NULL);
    REGISTER_INI_ENTRIES();
    */
    le_Datasource = zend_register_list_destructors_ex(ogr_free_Datasource,
                                                     NULL, "OGRDatasource", 
                                                     module_number);

    le_SFDriver = zend_register_list_destructors_ex(ogr_free_SFDriver,
                                                     NULL, "OGRSFDriver", 
                                                     module_number);

    le_Layer = zend_register_list_destructors_ex(ogr_free_Layer,
                                                     NULL, "OGRLayer", 
                                                     module_number);

    le_SpatialReference = zend_register_list_destructors_ex(ogr_free_SpatialReference,
                                                     NULL, "OGRSpatialReference", 
                                                     module_number);

    le_SpatialReferenceRef = zend_register_list_destructors_ex(ogr_free_SpatialReferenceRef,
                                                     NULL, "OGRSpatialReferenceRef", 
                                                     module_number);

    le_CoordinateTransformation = zend_register_list_destructors_ex(ogr_free_CoordinateTransformation,
                                                     NULL, "OGRCoordinateTransformation", 
                                                     module_number);

    le_Geometry = zend_register_list_destructors_ex(ogr_free_Geometry,
                                                     NULL, "OGRGeometry", 
                                                     module_number);
    
    le_GeometryRef = zend_register_list_destructors_ex(ogr_free_GeometryRef,
                                                     NULL, "OGRGeometryRef", 
                                                     module_number);
 
    le_FieldDefn = zend_register_list_destructors_ex(ogr_free_FieldDefn,
                                                     NULL, "OGRFieldDefn", 
                                                     module_number);

    le_FieldDefnRef = zend_register_list_destructors_ex(ogr_free_FieldDefnRef,
                                                     NULL, "OGRFieldDefnRef", 
                                                     module_number);

    le_Field = zend_register_list_destructors_ex(ogr_free_Field,
                                                     NULL, "OGRField", 
                                                     module_number);

    le_FieldRef = zend_register_list_destructors_ex(ogr_free_FieldRef,
                                                     NULL, "OGRFieldRef", 
                                                     module_number);

    le_FeatureDefn = zend_register_list_destructors_ex(ogr_free_FeatureDefn,
                                                     NULL, "OGRFeatureDefn", 
                                                     module_number);

    le_FeatureDefnRef = zend_register_list_destructors_ex(ogr_free_FeatureDefnRef,
                                                     NULL, "OGRFeatureDefn", 
                                                     module_number);

    le_Feature = zend_register_list_destructors_ex(ogr_free_Feature,
                                                     NULL, "OGRFeature", 
                                                     module_number);


 
    /*Register constants*/
#define OGR_CONST_FLAG CONST_CS | CONST_PERSISTENT


    REGISTER_LONG_CONSTANT("OGRERR_NONE",                       OGRERR_NONE,                        OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OGRERR_NOT_ENOUGH_DATA",            OGRERR_NOT_ENOUGH_DATA,             OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OGRERR_NOT_ENOUGH_MEMORY",          OGRERR_NOT_ENOUGH_MEMORY,           OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OGRERR_UNSUPPORTED_GEOMETRY_TYPE",  OGRERR_UNSUPPORTED_GEOMETRY_TYPE,   OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OGRERR_UNSUPPORTED_OPERATION",      OGRERR_UNSUPPORTED_OPERATION,       OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OGRERR_CORRUPT_DATA",               OGRERR_CORRUPT_DATA,                OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OGRERR_FAILURE",                    OGRERR_FAILURE,                     OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OGRERR_UNSUPPORTED_SRS",            OGRERR_UNSUPPORTED_SRS,             OGR_CONST_FLAG);

    REGISTER_LONG_CONSTANT("wkb25DBit",              wkb25DBit,               OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("ogrZMarker",             ogrZMarker,              OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbXDR",                 wkbXDR,                  OGR_CONST_FLAG);    
    REGISTER_LONG_CONSTANT("wkbNDR",                 wkbNDR,                  OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbUnknown",             wkbUnknown,              OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbPoint",               wkbPoint,                OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbLineString",          wkbLineString,           OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbPolygon",             wkbPolygon,              OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbMultiPoint",          wkbMultiPoint,           OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbMultiLineString",     wkbMultiLineString,      OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbMultiPolygon",        wkbMultiPolygon,         OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbGeometryCollection",  wkbGeometryCollection,   OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbNone",                wkbNone,                 OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbLinearRing",          wkbLinearRing,           OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbPoint25D",               wkbPoint25D,                OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbLineString25D",          wkbLineString25D,           OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbPolygon25D",             wkbPolygon25D,              OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbMultiPoint25D",          wkbMultiPoint25D,           OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbMultiLineString25D",     wkbMultiLineString25D,      OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbMultiPolygon25D",        wkbMultiPolygon25D,         OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("wkbGeometryCollection25D",  wkbGeometryCollection25D,   OGR_CONST_FLAG);


    REGISTER_LONG_CONSTANT("OFTInteger",          OFTInteger,            OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OFTIntegerList",      OFTIntegerList,        OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OFTReal",             OFTReal,               OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OFTRealList",         OFTRealList,           OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OFTString",           OFTString,             OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OFTStringList",       OFTStringList,         OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OFTWideString",       OFTWideString,         OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OFTWideStringList",   OFTWideStringList,     OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OFTBinary",           OFTBinary,             OGR_CONST_FLAG);

    REGISTER_LONG_CONSTANT("OJUndefined",    OJUndefined,         OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OJLeft",         OJLeft,              OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OJRight",        OJRight,             OGR_CONST_FLAG);


    REGISTER_LONG_CONSTANT("OGRNullFID",          OGRNullFID,            OGR_CONST_FLAG);
    REGISTER_LONG_CONSTANT("OGRUnsetMarker",      OGRUnsetMarker,        OGR_CONST_FLAG);

    REGISTER_STRING_CONSTANT("OLCRandomRead",         OLCRandomRead,         OGR_CONST_FLAG);
    REGISTER_STRING_CONSTANT("OLCSequentialWrite",    OLCSequentialWrite,    OGR_CONST_FLAG);
    REGISTER_STRING_CONSTANT("OLCRandomWrite",        OLCRandomWrite,        OGR_CONST_FLAG);
    REGISTER_STRING_CONSTANT("OLCFastSpatialFilter",  OLCFastSpatialFilter,  OGR_CONST_FLAG);
    REGISTER_STRING_CONSTANT("OLCFastFeatureCount",   OLCFastFeatureCount,   OGR_CONST_FLAG);
    REGISTER_STRING_CONSTANT("OLCFastGetExtent",      OLCFastGetExtent,      OGR_CONST_FLAG);
    REGISTER_STRING_CONSTANT("OLCCreateField",        OLCCreateField,        OGR_CONST_FLAG);
    REGISTER_STRING_CONSTANT("OLCTransactions",       OLCTransactions,        OGR_CONST_FLAG);

    REGISTER_STRING_CONSTANT("ODsCCreateLayer",         ODsCCreateLayer,        OGR_CONST_FLAG);
    REGISTER_STRING_CONSTANT("ODrCCreateDataSource",    ODrCCreateDataSource,   OGR_CONST_FLAG);


    return SUCCESS;
}

/* }}} */

/* {{{ PHP_MSHUTDOWN_FUNCTION
 */
PHP_MSHUTDOWN_FUNCTION(ogr)
{
    /* uncomment this line if you have INI entries
    UNREGISTER_INI_ENTRIES();
    */
    return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request start */
/* {{{ PHP_RINIT_FUNCTION
 */
PHP_RINIT_FUNCTION(ogr)
{
    return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request end */
/* {{{ PHP_RSHUTDOWN_FUNCTION
 */
PHP_RSHUTDOWN_FUNCTION(ogr)
{
    return SUCCESS;
}
/* }}} */

/* {{{ PHP_MINFO_FUNCTION
 */
PHP_MINFO_FUNCTION(ogr)
{
    php_info_print_table_start();
    php_info_print_table_header(2, "ogr support", "enabled");
    php_info_print_table_end();

    /* Remove comments if you have entries in php.ini
    DISPLAY_INI_ENTRIES();
    */
}

/* }}} */


/**********************************************************************
 * Support functions 
 **********************************************************************/

static void php_report_ogr_error(int nErrLevel)
{
    if (CPLGetLastErrorMsg() && (CPLGetLastErrorNo() != OGRERR_NONE))
        php_error(nErrLevel, CPLGetLastErrorMsg());

    CPLErrorReset();
}


static char **  php_array2string(char **papszStrList, zval *refastrvalues)
{
    int numelems = 0;
    zval **tmp = NULL;

	numelems = zend_hash_num_elements(Z_ARRVAL_P(refastrvalues));

	zend_hash_internal_pointer_reset(Z_ARRVAL_P(refastrvalues));
	while (zend_hash_get_current_data(Z_ARRVAL_P(refastrvalues), 
										 (void **) &tmp) == SUCCESS) {
		convert_to_string_ex(tmp);

        papszStrList = (char **)CSLAddString(papszStrList, (char *)tmp);

		zend_hash_move_forward(Z_ARRVAL_P(refastrvalues));
	}
    return papszStrList;
}

/* }}} */
/* The previous line is meant for vim and emacs, so it can correctly fold and 
   unfold functions in source code. See the corresponding marks just before 
   function definition, where the functions purpose is also documented. Please 
   follow this convention for the convenience of others editing your code.
*/

/* {{{ proto int ogr_g_createfromwkb(string strbydata, resource hsrs, resource refhnewgeom)
    */
PHP_FUNCTION(ogr_g_createfromwkb)
{
    int argc = ZEND_NUM_ARGS();
    int hsrs_id = -1;
    int refhnewgeom_id = -1;
    char *strbydata = NULL;
    int strbydata_len;
    zval *hsrs = NULL;
    zval *refhnewgeom = NULL;
    OGRGeometryH hNewGeom = NULL;
    OGRSpatialReferenceH hSpatialReference = NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "sr!z", &strbydata, &strbydata_len,  &hsrs, &refhnewgeom) == FAILURE) 
        return;

    if (hsrs) {
        ZEND_FETCH_RESOURCE2(hSpatialReference, OGRSpatialReferenceH, &hsrs, hsrs_id, "OGRSpatialReference", le_SpatialReference, le_SpatialReferenceRef);
    }
    if (hSpatialReference)
        eErr = (OGR_G_CreateFromWkb(strbydata, hSpatialReference, hNewGeom));

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }
    if (hNewGeom) {
        zval_dtor(refhnewgeom);
        ZEND_REGISTER_RESOURCE(refhnewgeom, hNewGeom, le_Geometry);
    }
    RETURN_LONG(eErr);
}

/* }}} */

/* {{{ proto int ogr_g_createfromwkt(string refadata, resource hsrs, resource refhnewgeom)
    */
PHP_FUNCTION(ogr_g_createfromwkt)
{
    int argc = ZEND_NUM_ARGS();
    int hsrs_id = -1;
    int refhnewgeom_id = -1;
    char *refstrdata = NULL;
    int refstrdata_len;
    zval *hsrs = NULL;
    zval *refhnewgeom = NULL;
    OGRGeometryH hNewGeom = NULL;
    OGRSpatialReferenceH hSpatialReference = NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "sr!z", &refstrdata, &refstrdata_len,  &hsrs, &refhnewgeom) == FAILURE) 
        return;

    if (hsrs) {
        ZEND_FETCH_RESOURCE2(hSpatialReference, OGRSpatialReferenceH, &hsrs, hsrs_id, "OGRSpatialReference", le_SpatialReference, le_SpatialReferenceRef);
    }
    if (hSpatialReference)
        eErr = (OGR_G_CreateFromWkt(&refstrdata, hSpatialReference, hNewGeom));

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }
    if (hNewGeom) {
        zval_dtor(refhnewgeom);
        ZEND_REGISTER_RESOURCE(refhnewgeom, hNewGeom, le_Geometry);
    }
    RETURN_LONG(eErr);
}

/* }}} */

/* {{{ proto void ogr_g_destroygeometry(resource hgeom)
    */
PHP_FUNCTION(ogr_g_destroygeometry)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hgeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry)
        zend_list_delete(hgeom->value.lval);
}

/* }}} */

/* {{{ proto resource ogr_g_creategeometry(int igeometrytype)
    */
PHP_FUNCTION(ogr_g_creategeometry)
{
    int argc = ZEND_NUM_ARGS();
    long igeometrytype;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "l", &igeometrytype) == FAILURE) 
        return;

    hGeometry = OGR_G_CreateGeometry(igeometrytype);

    if (hGeometry){
        ZEND_REGISTER_RESOURCE(return_value, hGeometry, le_Geometry);
    }
}

/* }}} */

/* {{{ proto int ogr_g_getdimension(resource hgeom)
    */
PHP_FUNCTION(ogr_g_getdimension)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hgeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry){
        RETURN_LONG(OGR_G_GetDimension(hGeometry)); 
    }
}

/* }}} */

/* {{{ proto int ogr_g_getcoordinatedimension(resource hgeom)
    */
PHP_FUNCTION(ogr_g_getcoordinatedimension)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hgeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry)
        RETURN_LONG(OGR_G_GetCoordinateDimension(hGeometry)); 
}

/* }}} */

/* {{{ proto resource ogr_g_clone(resource hgeom)
    */
PHP_FUNCTION(ogr_g_clone)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    OGRGeometryH hNewGeom = NULL, hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hgeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry)
        hNewGeom = OGR_G_Clone(hGeometry);

    if (!hNewGeom){
        php_report_ogr_error(E_WARNING);
        RETURN_NULL();
    }
    ZEND_REGISTER_RESOURCE(return_value, hNewGeom, le_Geometry);
}

/* }}} */

/* {{{ proto void ogr_g_getenvelope(resource hgeom, object oenvel)
    */
PHP_FUNCTION(ogr_g_getenvelope)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    zval *oenvel = NULL;
    OGREnvelope oEnvelope;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rz", &hgeom, &oenvel) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }

    if (hGeometry)
        OGR_G_GetEnvelope(hGeometry, &oEnvelope);

    if (object_init(oenvel)==FAILURE) {
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

    zval_dtor(oenvel);

    add_property_double(oenvel, "minx", oEnvelope.MinX);
    add_property_double(oenvel, "maxx", oEnvelope.MaxX);
    add_property_double(oenvel, "mint", oEnvelope.MinY);
    add_property_double(oenvel, "maxz", oEnvelope.MaxY);
}

#ifdef CONSTRUCT_FLAG
/* }}} */

/* {{{ proto int ogr_g_importfromwkb(resource hgeom, array abydata, int nsize)
    */
PHP_FUNCTION(ogr_g_importfromwkb)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    long nsize;
    zval *hgeom = NULL;
//  zval *abydata = NULL;  TOVERIFY
    char *abydata = NULL;
    int abydata_len;
    OGRGeometryH hGeometry = NULL;
    OGRErr eErr = OGRERR_FAILURE;

//  if (zend_parse_parameters(argc TSRMLS_CC, "ral", &hgeom, &abydata, &nsize) == FAILURE) 
    if (zend_parse_parameters(argc TSRMLS_CC, "rsl", &hgeom, &abydata, &abydata_len,  &nsize) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry)
        eErr = OGR_G_ImportFromWkb(hGeometry, abydata, nsize);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }

    RETURN_LONG(eErr);

}

/* }}} */

/* {{{ proto int ogr_g_exporttowkb(resource hgeom, int ibyteorder, array abydata)
    */
PHP_FUNCTION(ogr_g_exporttowkb)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    long ibyteorder;
    zval *hgeom = NULL;
//  zval *abydata = NULL;  TOVERIFY
    char *abydata = NULL;
    int *abydata_len;
    OGRGeometryH hGeometry = NULL;
    OGRErr eErr = OGRERR_FAILURE;

//  if (zend_parse_parameters(argc TSRMLS_CC, "rla", &hgeom, &ibyteorder, &abydata) == FAILURE) 
    if (zend_parse_parameters(argc TSRMLS_CC, "rls", &hgeom, &ibyteorder, &abydata, &abydata) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry)
        eErr = (OGR_G_ExportToWkb(hGeometry, ibyteorder, abydata));

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }

     RETURN_LONG(eErr);
}

#endif

/* }}} */

/* {{{ proto int ogr_g_wkbsize(resource hgeom)
    */
PHP_FUNCTION(ogr_g_wkbsize)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;
    int wkbsize = -1;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hgeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry){
        RETURN_LONG(OGR_G_WkbSize(hGeometry));
    }
}

#ifdef CONSTRUCT_FLAG
/* }}} */

/* {{{ proto int ogr_g_importfromwkt(resource hgeom, array refainput)
    */
PHP_FUNCTION(ogr_g_importfromwkt)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
//  zval *refainput = NULL;  TOVERIFY
    char *refainput = NULL;
    int refainput_len;
    OGRGeometryH hGeometry = NULL;
    OGRErr eErr = OGRERR_FAILURE;

//  if (zend_parse_parameters(argc TSRMLS_CC, "ra", &hgeom, &refainput) == FAILURE) 
    if (zend_parse_parameters(argc TSRMLS_CC, "ra", &hgeom, &refainput, &refainput_len) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }

    if (hGeometry)
        eErr = OGR_G_ImportFromWkt(hGeometry, &refainput);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }

    RETURN_LONG(eErr);

}

/* }}} */

/* {{{ proto int ogr_g_exporttowkt(resource hgeom, array refadsttext)
    */
PHP_FUNCTION(ogr_g_exporttowkt)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
//  zval *refadsttext = NULL;
    char *refadsttext = NULL;
    int refadsttext_len;
    OGRGeometryH hGeometry = NULL;
    OGRErr eErr = OGRERR_FAILURE;

//  if (zend_parse_parameters(argc TSRMLS_CC, "ra", &hgeom, &refadsttext) == FAILURE) 
    if (zend_parse_parameters(argc TSRMLS_CC, "rs", &hgeom, &refadsttext, &refadsttext_len) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry)
        eErr = OGR_G_ExportToWkt(hGeometry, &refadsttext);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }

    RETURN_LONG(eErr);

}

#endif


/* }}} */

/* {{{ proto int ogr_g_getgeometrytype(resource hgeom)
    */
PHP_FUNCTION(ogr_g_getgeometrytype)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hgeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry){
        RETURN_LONG(OGR_G_GetGeometryType(hGeometry));
    }
}

/* }}} */

/* {{{ proto string ogr_g_getgeometryname(resource hgeom)
    */
PHP_FUNCTION(ogr_g_getgeometryname)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hgeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry){
        const char *pszName;
        if ((pszName = OGR_G_GetGeometryName(hGeometry)) != NULL)
            RETURN_STRING((char *) pszName,1);
    }
}

#ifdef CONSTRUCT_FLAG
/* }}} */

/* {{{ proto void ogr_g_dumpreadable(resource hgeom, resource hfile, string strprefix)
    */
PHP_FUNCTION(ogr_g_dumpreadable)
{
    char *strprefix = NULL;
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    int hfile_id = -1;
    int strprefix_len;
    zval *hgeom = NULL;
    zval *hfile = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rrs", &hgeom, &hfile, &strprefix, &strprefix_len) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hfile) {
        ZEND_FETCH_RESOURCE(???, ???, hfile, hfile_id, "Text File Ptr", ???_rsrc_id);
    }

    OGR_G_DumpReadable
}
#endif

/* }}} */

/* {{{ proto void ogr_g_flattento2d(resource hgeom)
    */
PHP_FUNCTION(ogr_g_flattento2d)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hgeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry)
        OGR_G_FlattenTo2D(hGeometry);

}

/* }}} */

/* {{{ proto void ogr_g_assignspatialreference(resource hgeom, resource hsrs)
    */
PHP_FUNCTION(ogr_g_assignspatialreference)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    int hsrs_id = -1;
    zval *hgeom = NULL;
    zval *hsrs = NULL;
    OGRGeometryH hGeometry = NULL;
    OGRSpatialReferenceH hSpatialReference = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rr!", &hgeom, &hsrs) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hsrs) {
        ZEND_FETCH_RESOURCE2(hSpatialReference, OGRSpatialReferenceH, &hsrs, hsrs_id, "OGRSpatialReference", le_SpatialReference, le_SpatialReferenceRef);
    }
    if (hGeometry)
        OGR_G_AssignSpatialReference(hGeometry,hSpatialReference);
}


/* }}} */

/* {{{ proto resource ogr_g_getspatialreference(resource hgeom)
    */
PHP_FUNCTION(ogr_g_getspatialreference)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;
    OGRSpatialReferenceH hSpatialReference = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hgeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry)
        hSpatialReference = OGR_G_GetSpatialReference(hGeometry);

    if (!hSpatialReference)
        RETURN_NULL();

    ZEND_REGISTER_RESOURCE(return_value, hSpatialReference, le_SpatialReference);

}

/* }}} */

/* {{{ proto int ogr_g_transform(resource hgeom, resource hct)
 */
PHP_FUNCTION(ogr_g_transform)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    int hct_id = -1;
    zval *hgeom = NULL;
    zval *hct = NULL;
    OGRGeometryH hGeometry = NULL;
    OGRCoordinateTransformationH hCoordTransfo= NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "rr", &hgeom, &hct) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hct) {
        ZEND_FETCH_RESOURCE(hCoordTransfo, OGRCoordinateTransformationH, &hct, hct_id, "OGRCoordinateTransformationH", le_CoordinateTransformation);
    }

    if (hCoordTransfo && hGeometry)
        eErr = OGR_G_Transform(hGeometry, hCoordTransfo);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }
        RETURN_LONG(eErr);
}

/* }}} */

/* {{{ proto int ogr_g_transformto(resource hgeom, resource hsrs)
   hsrs ) */
PHP_FUNCTION(ogr_g_transformto)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    int hsrs_id = -1;
    zval *hgeom = NULL;
    zval *hsrs = NULL;
    OGRGeometryH hGeometry = NULL;
    OGRSpatialReferenceH hSpatialReference = NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "rr", &hgeom, &hsrs) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hsrs) {
        ZEND_FETCH_RESOURCE2(hSpatialReference, OGRSpatialReferenceH, &hsrs, hsrs_id, "OGRSpatialReference", le_SpatialReference, le_SpatialReferenceRef);
    }
    if (hSpatialReference && hGeometry)
        eErr = OGR_G_TransformTo(hGeometry, hSpatialReference);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }

    RETURN_LONG(eErr);
}

/* }}} */

/* {{{ proto int ogr_g_intersect(resource hgeom, resource hothergeom )
*/
PHP_FUNCTION(ogr_g_intersect)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    zval *hothergeom = NULL;
    int hothergeom_id = -1;
    OGRGeometryH hGeometry = NULL, hOtherGeometry =NULL;


    if (zend_parse_parameters(argc TSRMLS_CC, "rr", &hgeom, &hothergeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hothergeom) {
        ZEND_FETCH_RESOURCE2(hOtherGeometry, OGRGeometryH, &hothergeom, hothergeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hOtherGeometry && hGeometry){
        RETURN_LONG(OGR_G_Intersect(hGeometry, hOtherGeometry));
    }
}

/* }}} */

/* {{{ proto int ogr_g_equal(resource hgeom, resource hothergeom )
*/
PHP_FUNCTION(ogr_g_equal)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    int hothergeom_id = -1;
    zval *hothergeom = NULL;
    OGRGeometryH hGeometry = NULL, hOtherGeometry =NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rr", &hgeom, &hothergeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hothergeom) {
        ZEND_FETCH_RESOURCE2(hOtherGeometry, OGRGeometryH, &hothergeom, hothergeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hOtherGeometry && hGeometry){
        RETURN_LONG(OGR_G_Equal(hGeometry, hOtherGeometry));
    }
}


/* }}} */

/* {{{ proto void ogr_g_empty(resource hgeom)
    */
PHP_FUNCTION(ogr_g_empty)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hgeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry)
        OGR_G_Empty(hGeometry);
}

/* }}} */

/* {{{ proto int ogr_g_getpointcount(resource hgeom)
    */
PHP_FUNCTION(ogr_g_getpointcount)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hgeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry){
        RETURN_LONG(OGR_G_GetPointCount(hGeometry));
    }
}

/* }}} */

/* {{{ proto double ogr_g_getx(resource hgeom, int ipoint)
    */
PHP_FUNCTION(ogr_g_getx)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    long ipoint;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hgeom, &ipoint) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry){
        RETURN_DOUBLE(OGR_G_GetX(hGeometry, ipoint));
    }
}

/* }}} */

/* {{{ proto double ogr_g_gety(resource hgeom, int ipoint)
    */
PHP_FUNCTION(ogr_g_gety)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    long ipoint;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hgeom, &ipoint) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry){
        RETURN_DOUBLE(OGR_G_GetY(hGeometry, ipoint));
    }
}

/* }}} */

/* {{{ proto double ogr_g_getz(resource hgeom, int ipoint)
    */
PHP_FUNCTION(ogr_g_getz)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    long ipoint;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hgeom, &ipoint) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry){
        RETURN_DOUBLE(OGR_G_GetZ(hGeometry, ipoint));
    }
}

/* }}} */

/* {{{ proto void ogr_g_getpoint(resource hgeom, int ipoint, double refdfx, double refdfy, double refdfz)
    */
PHP_FUNCTION(ogr_g_getpoint)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    long ipoint;
    zval *refdfx;
    zval *refdfy;
    zval *refdfz;
    double dfx;
    double dfy;
    double dfz;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rlzzz", &hgeom, &ipoint, &refdfx, &refdfy, &refdfz) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (!hGeometry){
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

    OGR_G_GetPoint(hGeometry, ipoint, &dfx, &dfy, &dfz);

    zval_dtor(refdfx);
    zval_dtor(refdfy);
    zval_dtor(refdfz);
    ZVAL_DOUBLE(refdfx, dfx);
    ZVAL_DOUBLE(refdfy, dfy);
    ZVAL_DOUBLE(refdfz, dfz);
}

/* }}} */

/* {{{ proto void ogr_g_setpoint(resource hgeom, int ipoint, double fx, double fy, double fz)
    */
PHP_FUNCTION(ogr_g_setpoint)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    long ipoint;
    double dfx;
    double dfy;
    double dfz;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rlddd", &hgeom, &ipoint, &dfx, &dfy, &dfz) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry)
        OGR_G_SetPoint(hGeometry, ipoint, dfx, dfy, dfz);
}

/* }}} */

/* {{{ proto void ogr_g_addpoint(resource hgeom, double dfx, double dfy, double dfz)
    */
PHP_FUNCTION(ogr_g_addpoint)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    double dfx;
    double dfy;
    double dfz;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rddd", &hgeom, &dfx, &dfy, &dfz) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry)
        OGR_G_AddPoint(hGeometry, dfx, dfy, dfz);
}

/* }}} */

/* {{{ proto int ogr_g_getgeometrycount(resource hgeom)
    */
PHP_FUNCTION(ogr_g_getgeometrycount)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hgeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry){
        RETURN_LONG(OGR_G_GetGeometryCount(hGeometry));
    }
}

/* }}} */

/* {{{ proto resource ogr_g_getgeometryref(resource hgeom, int isubgeom)
    */
PHP_FUNCTION(ogr_g_getgeometryref)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    long isubgeom;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL, hGeometryRef = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hgeom, &isubgeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry)
        hGeometryRef = OGR_G_GetGeometryRef(hGeometry, isubgeom);

    if (!hGeometryRef){
        php_report_ogr_error(E_WARNING);
        RETURN_NULL();
    }
    ZEND_REGISTER_RESOURCE(return_value, hGeometryRef, le_GeometryRef);
}

/* }}} */

/* {{{ proto int ogr_g_addgeometry(resource hgeom, resource hothergeom)
    */
PHP_FUNCTION(ogr_g_addgeometry)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    int hothergeom_id = -1;
    zval *hgeom = NULL;
    zval *hothergeom = NULL;
    OGRGeometryH hGeometry = NULL, hOtherGeometry;
    OGRErr eErr = OGRERR_NONE;

    if (zend_parse_parameters(argc TSRMLS_CC, "rr", &hgeom, &hothergeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hothergeom) {
        ZEND_FETCH_RESOURCE2(hOtherGeometry, OGRGeometryH, &hothergeom, hothergeom_id, "hGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry && hOtherGeometry)
        eErr = OGR_G_AddGeometry(hGeometry, hOtherGeometry);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }

    RETURN_LONG(eErr);
}

#ifdef CONSTRUCT_FLAG

/* }}} */

/* {{{ proto int ogr_g_addgeometrydirectly(resource hgeom, resource hothergeom )
 */
PHP_FUNCTION(ogr_g_addgeometrydirectly)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    zval *hgeom = NULL;
    int hothergeom_id = -1;
    zval *hothergeom = NULL;
    OGRGeometryH hGeometry = NULL, hOtherGeometry;
    OGRErr eErr = OGRERR_NONE;

    if (zend_parse_parameters(argc TSRMLS_CC, "rr", &hgeom, &hothergeom) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hothergeom) {
        ZEND_FETCH_RESOURCE2(hOtherGeometry, OGRGeometryH, &hothergeom, hothergeom_id, "hGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry &&hOtherGeometry)
        eErr = OGR_G_AddGeometryDirectly(hGeometry, hOtherGeometry);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }
    zend_list_delete(hothergeom->value.lval);

    RETURN_LONG(eErr);
}
#endif

/* }}} */

/* {{{ proto int ogr_g_removegeometry(resource hgeom, int igeom, boolean bdelete)
    */
PHP_FUNCTION(ogr_g_removegeometry)
{
    int argc = ZEND_NUM_ARGS();
    int hgeom_id = -1;
    long igeom;
    zend_bool bdelete;
    zval *hgeom = NULL;
    OGRGeometryH hGeometry = NULL;
    OGRErr eErr = OGRERR_NONE;

    if (zend_parse_parameters(argc TSRMLS_CC, "rlb", &hgeom, &igeom, &bdelete) == FAILURE) 
        return;

    if (hgeom) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeom, hgeom_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hGeometry)
        eErr = OGR_G_RemoveGeometry(hGeometry, igeom, bdelete);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }
    RETURN_LONG(eErr);
}

/* }}} */

/* {{{ proto resource ogrbuildpolygonfromedges(resource hlinesascollection, boolean bbesteffort, boolean bautoclose, double dftolerance, int referr)
    */
PHP_FUNCTION(ogrbuildpolygonfromedges)
{
    int argc = ZEND_NUM_ARGS();
    int hlinesascollection_id = -1;
    zend_bool bbesteffort;
    zend_bool bautoclose;
    long eErr;
    zval *referr;
    double dftolerance;
    zval *hlinesascollection = NULL;
    OGRGeometryH hLines = NULL, hNewGeometry =NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rbbdz", &hlinesascollection, &bbesteffort, &bautoclose, &dftolerance, &referr) == FAILURE) 
        return;

    if (hlinesascollection) {
        ZEND_FETCH_RESOURCE2(hLines, OGRGeometryH, &hlinesascollection, hlinesascollection_id, "OGRGeometryH", le_Geometry, le_GeometryRef);
    }
    if (hLines)
        hNewGeometry = OGRBuildPolygonFromEdges(hlinesascollection, bbesteffort, bautoclose, dftolerance,(int*) &eErr);

    if (!hNewGeometry){
        php_report_ogr_error(E_WARNING);
        RETURN_NULL();
    }
    ZEND_REGISTER_RESOURCE(return_value, hNewGeometry, le_Geometry);
    zval_dtor(referr);
    ZVAL_LONG(referr, eErr);
}

/* }}} */

/* {{{ proto resource ogr_fld_create(string strnamein, int itype)
    */
PHP_FUNCTION(ogr_fld_create)
{
    char *strnamein = NULL;
    int argc = ZEND_NUM_ARGS();
    int strnamein_len;
    long itype;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "sl", &strnamein, &strnamein_len, &itype) == FAILURE) 
        return;

    hFieldDefn = OGR_Fld_Create(strnamein, itype);

    if (hFieldDefn){
        ZEND_REGISTER_RESOURCE(return_value, hFieldDefn, le_FieldDefn);
    }
}

/* }}} */

/* {{{ proto void ogr_fld_destroy(resource hfield)
    */
PHP_FUNCTION(ogr_fld_destroy)
{
    int argc = ZEND_NUM_ARGS();
    int hfield_id = -1;
    zval *hfield = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfield) == FAILURE) 
        return;

    if (hfield) {
        ZEND_FETCH_RESOURCE(hFieldDefn, OGRFieldDefnH, &hfield, hfield_id, "OGRFieldDefn", le_FieldDefn);
    }

    if(hFieldDefn)
        zend_list_delete(hfield->value.lval);
}

/* }}} */

/* {{{ proto void ogr_fld_setname(resource hfieldh, string strnamein)
    */
PHP_FUNCTION(ogr_fld_setname)
{
    char *strnamein = NULL;
    int argc = ZEND_NUM_ARGS();
    int hfieldh_id = -1;
    int strnamein_len;
    zval *hfieldh = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rs", &hfieldh, &strnamein, &strnamein_len) == FAILURE) 
        return;

    if (hfieldh) {
        ZEND_FETCH_RESOURCE2(hFieldDefn, OGRFieldDefnH, &hfieldh, hfieldh_id, "OGFieldDefn", le_FieldDefn, le_FieldDefnRef);
    }
    if (hFieldDefn)
        OGR_Fld_SetName(hFieldDefn, strnamein);

}

/* }}} */

/* {{{ proto string ogr_fld_getnameref(resource hfieldh)
    */
PHP_FUNCTION(ogr_fld_getnameref)
{
    int argc = ZEND_NUM_ARGS();
    int hfieldh_id = -1;
    zval *hfieldh = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfieldh) == FAILURE) 
        return;

    if (hfieldh) {
        ZEND_FETCH_RESOURCE2(hFieldDefn, OGRFieldDefnH, &hfieldh, hfieldh_id, "OGFieldDefn", le_FieldDefn, le_FieldDefnRef);
    }
    if (hFieldDefn){
        const char *pszName;
        if ((pszName = OGR_Fld_GetNameRef(hFieldDefn)) != NULL)
            RETURN_STRING((char *) pszName, 1);
    }
}

/* }}} */

/* {{{ proto int ogr_fld_gettype(resource hfieldh)
    */
PHP_FUNCTION(ogr_fld_gettype)
{
    int argc = ZEND_NUM_ARGS();
    int hfieldh_id = -1;
    zval *hfieldh = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfieldh) == FAILURE) 
        return;

    if (hfieldh) {
        ZEND_FETCH_RESOURCE2(hFieldDefn, OGRFieldDefnH, &hfieldh, hfieldh_id, "OGFieldDefn", le_FieldDefn, le_FieldDefnRef);
    }
    if (hFieldDefn){
        RETURN_LONG(OGR_Fld_GetType(hFieldDefn));
    }
}

/* }}} */

/* {{{ proto void ogr_fld_settype(resource hfieldh, int itype)
    */
PHP_FUNCTION(ogr_fld_settype)
{
    int argc = ZEND_NUM_ARGS();
    int hfieldh_id = -1;
    long itype;
    zval *hfieldh = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hfieldh, &itype) == FAILURE) 
        return;

    if (hfieldh) {
        ZEND_FETCH_RESOURCE2(hFieldDefn, OGRFieldDefnH, &hfieldh, hfieldh_id, "OGFieldDefn", le_FieldDefn, le_FieldDefnRef);
    }
    if (hFieldDefn){
        OGR_Fld_SetType(hFieldDefn, itype);
    }
}

/* }}} */

/* {{{ proto int ogr_fld_getjustify(resource hfieldh)
    */
PHP_FUNCTION(ogr_fld_getjustify)
{
    int argc = ZEND_NUM_ARGS();
    int hfieldh_id = -1;
    zval *hfieldh = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfieldh) == FAILURE) 
        return;

    if (hfieldh) {
        ZEND_FETCH_RESOURCE2(hFieldDefn, OGRFieldDefnH, &hfieldh, hfieldh_id, "OGFieldDefn", le_FieldDefn, le_FieldDefnRef);
    }
    if (hFieldDefn){
        RETURN_LONG(OGR_Fld_GetJustify(hFieldDefn));
    }
}

/* }}} */

/* {{{ proto void ogr_fld_setjustify(resource hfieldh, int ijustify)
    */
PHP_FUNCTION(ogr_fld_setjustify)
{
    int argc = ZEND_NUM_ARGS();
    int hfieldh_id = -1;
    long ijustify;
    zval *hfieldh = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hfieldh, &ijustify) == FAILURE) 
        return;

    if (hfieldh) {
        ZEND_FETCH_RESOURCE2(hFieldDefn, OGRFieldDefnH, &hfieldh, hfieldh_id, "OGFieldDefn", le_FieldDefn, le_FieldDefnRef);
    }
    if (hFieldDefn){
        OGR_Fld_SetJustify(hFieldDefn, ijustify);
    }
}

/* }}} */

/* {{{ proto int ogr_fld_getwidth(resource hfieldh)
    */
PHP_FUNCTION(ogr_fld_getwidth)
{
    int argc = ZEND_NUM_ARGS();
    int hfieldh_id = -1;
    zval *hfieldh = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfieldh) == FAILURE) 
        return;

    if (hfieldh) {
        ZEND_FETCH_RESOURCE2(hFieldDefn, OGRFieldDefnH, &hfieldh, hfieldh_id, "OGFieldDefn", le_FieldDefn, le_FieldDefnRef);
    }
    if (hFieldDefn){
        RETURN_LONG(OGR_Fld_GetWidth(hFieldDefn));
    }

}

/* }}} */

/* {{{ proto void ogr_fld_setwidth(resource hfieldh, int nwidth)
    */
PHP_FUNCTION(ogr_fld_setwidth)
{
    int argc = ZEND_NUM_ARGS();
    int hfieldh_id = -1;
    long nwidth;
    zval *hfieldh = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hfieldh, &nwidth) == FAILURE) 
        return;

    if (hfieldh) {
        ZEND_FETCH_RESOURCE2(hFieldDefn, OGRFieldDefnH, &hfieldh, hfieldh_id, "OGFieldDefn", le_FieldDefn, le_FieldDefnRef);
    }
    if (hFieldDefn){
        OGR_Fld_SetWidth(hFieldDefn, nwidth);
    }
}

/* }}} */

/* {{{ proto int ogr_fld_getprecision(resource hfieldh)
    */
PHP_FUNCTION(ogr_fld_getprecision)
{
    int argc = ZEND_NUM_ARGS();
    int hfieldh_id = -1;
    zval *hfieldh = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfieldh) == FAILURE) 
        return;

    if (hfieldh) {
        ZEND_FETCH_RESOURCE2(hFieldDefn, OGRFieldDefnH, &hfieldh, hfieldh_id, "OGFieldDefn", le_FieldDefn, le_FieldDefnRef);
    }
    if (hFieldDefn){
        RETURN_LONG(OGR_Fld_GetPrecision(hFieldDefn));
    }
}
/* }}} */

/* {{{ proto void ogr_fld_setprecision(resource hfieldh, int nprecision)
    */
PHP_FUNCTION(ogr_fld_setprecision)
{
    int argc = ZEND_NUM_ARGS();
    int hfieldh_id = -1;
    long nprecision;
    zval *hfieldh = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hfieldh, &nprecision) == FAILURE) 
        return;

    if (hfieldh) {
        ZEND_FETCH_RESOURCE2(hFieldDefn, OGRFieldDefnH, &hfieldh, hfieldh_id, "OGFieldDefn", le_FieldDefn, le_FieldDefnRef);
    }
    if (hFieldDefn){
        OGR_Fld_SetPrecision(hFieldDefn, nprecision);
    }
}

/* }}} */

/* {{{ proto void ogr_fld_set(resource hfieldh, string strnamein, int itypein, int nwidthin, int nprecisionin, int justifyin)
    */
PHP_FUNCTION(ogr_fld_set)
{
    char *strnamein = NULL;
    int argc = ZEND_NUM_ARGS();
    int hfieldh_id = -1;
    int strnamein_len;
    long itypein;
    long nwidthin;
    long nprecisionin;
    long justifyin;
    zval *hfieldh = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rsllll", &hfieldh, &strnamein, &strnamein_len, &itypein, &nwidthin, &nprecisionin, &justifyin) == FAILURE) 
        return;

    if (hfieldh) {
        ZEND_FETCH_RESOURCE2(hFieldDefn, OGRFieldDefnH, &hfieldh, hfieldh_id, "OGFieldDefn", le_FieldDefn, le_FieldDefnRef);
    }
    if (hFieldDefn){
        OGR_Fld_Set(hFieldDefn, strnamein, itypein, nwidthin, nprecisionin, justifyin);
    }
}

/* }}} */

/* {{{ proto string ogr_getfieldtypename(int itype)
    */
PHP_FUNCTION(ogr_getfieldtypename)
{
    int argc = ZEND_NUM_ARGS();
    long itype;
    const char *pszName;

    if (zend_parse_parameters(argc TSRMLS_CC, "l", &itype) == FAILURE) 
        return;

    if ((pszName = OGR_GetFieldTypeName(itype)) != NULL)
        RETURN_STRING((char *)pszName, 1);
}

/* }}} */

/* {{{ proto resource ogr_fd_create(string strname)
    */
PHP_FUNCTION(ogr_fd_create)
{
    char *strname = NULL;
    int argc = ZEND_NUM_ARGS();
    int strname_len;
    OGRFeatureDefnH hFeatureDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "s", &strname, &strname_len) == FAILURE) 
        return;

    hFeatureDefn = OGR_FD_Create(strname);

    if (hFeatureDefn){
        ZEND_REGISTER_RESOURCE(return_value, hFeatureDefn, le_FeatureDefn);
    }

}

/* }}} */

/* {{{ proto void ogr_fd_destroy(resource hdefin)
    */
PHP_FUNCTION(ogr_fd_destroy)
{
    int argc = ZEND_NUM_ARGS();
    int hdefin_id = -1;
    zval *hdefin = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hdefin) == FAILURE) 
        return;

    if (hdefin) {
        ZEND_FETCH_RESOURCE2(hFeatureDefn, OGRFeatureDefnH, &hdefin, hdefin_id, "OGRFeatureDefn", le_FeatureDefn, le_FeatureDefnRef);
    }
    if (hFeatureDefn)
        zend_list_delete(hdefin->value.lval);
}

/* }}} */

/* {{{ proto string ogr_fd_getname(resource hdefin)
    */
PHP_FUNCTION(ogr_fd_getname)
{
    int argc = ZEND_NUM_ARGS();
    int hdefin_id = -1;
    zval *hdefin = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hdefin) == FAILURE) 
        return;

    if (hdefin) {
        ZEND_FETCH_RESOURCE2(hFeatureDefn, OGRFeatureDefnH, &hdefin, hdefin_id, "OGRFeature", le_FeatureDefn, le_FeatureDefnRef);
    }
    if (hFeatureDefn){
        const char *pszName;
        if ((pszName = OGR_FD_GetName(hFeatureDefn)) != NULL)
            RETURN_STRING((char *) pszName, 1);
    }
}

/* }}} */

/* {{{ proto int ogr_fd_getfieldcount(resource hdefin)
    */
PHP_FUNCTION(ogr_fd_getfieldcount)
{
    int argc = ZEND_NUM_ARGS();
    int hdefin_id = -1;
    zval *hdefin = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hdefin) == FAILURE) 
        return;

    if (hdefin) {
        ZEND_FETCH_RESOURCE2(hFeatureDefn, OGRFeatureDefnH, &hdefin, hdefin_id, "OGRFeature", le_FeatureDefn, le_FeatureDefnRef);
    }
    if (hFeatureDefn){
        RETURN_LONG(OGR_FD_GetFieldCount(hFeatureDefn));
    }
}

/* }}} */

/* {{{ proto resource ogr_fd_getfielddefn(resource hdefin, int ifield)
    */
PHP_FUNCTION(ogr_fd_getfielddefn)
{
    int argc = ZEND_NUM_ARGS();
    int hdefin_id = -1;
    long ifield;
    zval *hdefin = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hdefin, &ifield) == FAILURE) 
        return;

    if (hdefin) {
        ZEND_FETCH_RESOURCE2(hFeatureDefn, OGRFeatureDefnH, &hdefin, hdefin_id, "OGRFeature", le_FeatureDefn, le_FeatureDefnRef);
    }
    if (hFeatureDefn){
        hFieldDefn = OGR_FD_GetFieldDefn(hFeatureDefn, ifield);
    }
    if (hFieldDefn)
        ZEND_REGISTER_RESOURCE(return_value, hFieldDefn, le_FieldDefnRef);
}

/* }}} */

/* {{{ proto int ogr_fd_getfieldindex(resource hdefin, string strfieldname)
    */
PHP_FUNCTION(ogr_fd_getfieldindex)
{
    char *strfieldname = NULL;
    int argc = ZEND_NUM_ARGS();
    int hdefin_id = -1;
    int strfieldname_len;
    zval *hdefin = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rs", &hdefin, &strfieldname, &strfieldname_len) == FAILURE) 
        return;

    if (hdefin) {
        ZEND_FETCH_RESOURCE2(hFeatureDefn, OGRFeatureDefnH, &hdefin, hdefin_id, "OGRFeature", le_FeatureDefn, le_FeatureDefnRef);
    }
    if (hFeatureDefn){
        RETURN_LONG(OGR_FD_GetFieldIndex(hFeatureDefn, strfieldname));
    }
}

/* }}} */

/* {{{ proto void ogr_fd_addfielddefn(resource hdefin, resource hnewdefn)
    */
PHP_FUNCTION(ogr_fd_addfielddefn)
{
    int argc = ZEND_NUM_ARGS();
    int hdefin_id = -1;
    int hnewdefn_id = -1;
    zval *hdefin = NULL;
    zval *hnewdefn = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rr", &hdefin, &hnewdefn) == FAILURE) 
        return;

    if (hdefin) {
        ZEND_FETCH_RESOURCE2(hFeatureDefn, OGRFeatureDefnH, &hdefin, hdefin_id, "OGRFeature", le_FeatureDefn, le_FeatureDefnRef);
    }
    if (hnewdefn) {
        ZEND_FETCH_RESOURCE2(hFieldDefn, OGRFieldDefnH, &hnewdefn, hnewdefn_id, "OGRFieldDefn", le_FieldDefn, le_FieldDefnRef);
    }
    if (hFeatureDefn && hFieldDefn)
        OGR_FD_AddFieldDefn(hFeatureDefn, hFieldDefn);
}

/* }}} */

/* {{{ proto int ogr_fd_getgeomtype(resource hdefin)
    */
PHP_FUNCTION(ogr_fd_getgeomtype)
{
    int argc = ZEND_NUM_ARGS();
    int hdefin_id = -1;
    zval *hdefin = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hdefin) == FAILURE) 
        return;

    if (hdefin) {
        ZEND_FETCH_RESOURCE2(hFeatureDefn, OGRFeatureDefnH, &hdefin, hdefin_id, "OGRFeature", le_FeatureDefn, le_FeatureDefnRef);
    }

    if (hFeatureDefn){
        RETURN_LONG(OGR_FD_GetGeomType(hFeatureDefn));
    }

}

/* }}} */

/* {{{ proto void ogr_fd_setgeomtype(resource hdefin, int itype)
    */
PHP_FUNCTION(ogr_fd_setgeomtype)
{
    int argc = ZEND_NUM_ARGS();
    int hdefin_id = -1;
    long itype;
    zval *hdefin = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;
    int iRefCount = 0;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hdefin, &itype) == FAILURE) 
        return;

    if (hdefin) {
        ZEND_FETCH_RESOURCE2(hFeatureDefn, OGRFeatureDefnH, &hdefin, hdefin_id, "OGRFeature", le_FeatureDefn, le_FeatureDefnRef);
    }
    if (hFeatureDefn){
        iRefCount = OGR_FD_GetReferenceCount(hFeatureDefn);
    }

    if(iRefCount){
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

    OGR_FD_SetGeomType(hFeatureDefn, itype);
}

/* }}} */

/* {{{ proto int ogr_fd_reference(resource hdefin)
    */
PHP_FUNCTION(ogr_fd_reference)
{
    int argc = ZEND_NUM_ARGS();
    int hdefin_id = -1;
    zval *hdefin = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hdefin) == FAILURE) 
        return;

    if (hdefin) {
        ZEND_FETCH_RESOURCE2(hFeatureDefn, OGRFeatureDefnH, &hdefin, hdefin_id, "OGRFeature", le_FeatureDefn, le_FeatureDefnRef);
    }
    if (hFeatureDefn){
        RETURN_LONG(OGR_FD_Reference(hFeatureDefn));
    }
}

/* }}} */

/* {{{ proto int ogr_fd_dereference(resource hdefin)
    */
PHP_FUNCTION(ogr_fd_dereference)
{
    int argc = ZEND_NUM_ARGS();
    int hdefin_id = -1;
    zval *hdefin = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hdefin) == FAILURE) 
        return;

    if (hdefin) {
        ZEND_FETCH_RESOURCE2(hFeatureDefn, OGRFeatureDefnH, &hdefin, hdefin_id, "OGRFeature", le_FeatureDefn, le_FeatureDefnRef);
    }
    if (hFeatureDefn){
        RETURN_LONG(OGR_FD_Dereference(hFeatureDefn));
    }
}

/* }}} */

/* {{{ proto int ogr_fd_getreferencecount(resource hdefin)
    */
PHP_FUNCTION(ogr_fd_getreferencecount)
{
    int argc = ZEND_NUM_ARGS();
    int hdefin_id = -1;
    zval *hdefin = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hdefin) == FAILURE) 
        return;

    if (hdefin) {
        ZEND_FETCH_RESOURCE2(hFeatureDefn, OGRFeatureDefnH, &hdefin, hdefin_id, "OGRFeature", le_FeatureDefn, le_FeatureDefnRef);
    }
    if (hFeatureDefn){
        RETURN_LONG(OGR_FD_GetReferenceCount(hFeatureDefn));
    }
}

/* }}} */

/* {{{ proto resource ogr_f_create(resource hdefin)
    */
PHP_FUNCTION(ogr_f_create)
{
    int argc = ZEND_NUM_ARGS();
    int hdefin_id = -1;
    zval *hdefin = NULL;
    OGRFeatureH hFeature = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hdefin) == FAILURE) 
        return;

    if (hdefin) {
        ZEND_FETCH_RESOURCE2(hFeatureDefn, OGRFeatureDefnH, &hdefin, hdefin_id, "OGRFeatureDefn", le_FeatureDefn, le_FeatureDefnRef);
    }

    if (hFeatureDefn)
        hFeature = OGR_F_Create(hFeatureDefn);

    if (hFeature){
        ZEND_REGISTER_RESOURCE(return_value, hFeature, le_Feature);
    }
}

/* }}} */

/* {{{ proto void ogr_f_destroy(resource hfeature)
    */
PHP_FUNCTION(ogr_f_destroy)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfeature) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat)
        zend_list_delete(hfeature->value.lval);
}

/* }}} */

/* {{{ proto resource ogr_f_getdefnref(resource hfeature)
    */
PHP_FUNCTION(ogr_f_getdefnref)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfeature) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat)
        hFeatureDefn = OGR_F_GetDefnRef(hFeat);

    if (hFeatureDefn)
        ZEND_REGISTER_RESOURCE(return_value, hFeatureDefn, le_FeatureDefnRef);
}

#ifdef CONSTRUCT_FLAG
/* }}} */

/* {{{ proto int ogr_f_setgeometrydirectly(resource hfeature, resource hgeomin)
    */
PHP_FUNCTION(ogr_f_setgeometrydirectly)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    int hgeomin_id = -1;
    zval *hfeature = NULL;
    zval *hgeomin = NULL;
    OGRGeometryH hGeometry = NULL;
    OGRFeatureH hFeat = NULL;
    OGRErr eErr = OGRERR_NONE;
    
    if (zend_parse_parameters(argc TSRMLS_CC, "rr", &hfeature, &hgeomin) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hgeomin) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeomin, hgeomin_id, "OGRFeature", le_Geometry, le_GeometryRef);
    }

    if (hGeometry && hFeat)
        eErr = OGR_F_SetGeometryDirectly(hFeat, hGeometry);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }

    zend_list_delete(hgeomin->value.lval);

    RETURN_LONG(eErr);
}


#endif

/* }}} */

/* {{{ proto int ogr_f_setgeometry(resource hfeature, resource hgeomin)
    */
PHP_FUNCTION(ogr_f_setgeometry)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    int hgeomin_id = -1;
    zval *hfeature = NULL;
    zval *hgeomin = NULL;
    OGRGeometryH hGeometry = NULL;
    OGRFeatureH hFeat = NULL;
    OGRErr eErr = OGRERR_FAILURE;


    if (zend_parse_parameters(argc TSRMLS_CC, "rr", &hfeature, &hgeomin) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hgeomin) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hgeomin, hgeomin_id, "OGRFeature", le_Geometry, le_GeometryRef);
    }

    if (hGeometry && hFeat)
        eErr = OGR_F_SetGeometry(hFeat, hGeometry);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }

    RETURN_LONG(eErr);
}

/* }}} */

/* {{{ proto resource ogr_f_getgeometryref(resource hfeature)
    */
PHP_FUNCTION(ogr_f_getgeometryref)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;
    OGRGeometryH hGeometry = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfeature) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat)
        hGeometry = OGR_F_GetGeometryRef(hFeat);

    if (hGeometry) {
        ZEND_REGISTER_RESOURCE(return_value, hGeometry, le_GeometryRef);
    }

}

/* }}} */

/* {{{ proto resource ogr_f_clone(resource hfeature)
    */
PHP_FUNCTION(ogr_f_clone)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL, hNewFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfeature) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat)
        hNewFeat = OGR_F_Clone(hFeat);

    if (!hNewFeat){
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }
    ZEND_REGISTER_RESOURCE(return_value, hNewFeat, le_Feature);
}

/* }}} */

/* {{{ proto int ogr_f_equal(resource hfeature, resource hotherfeature)
    */
PHP_FUNCTION(ogr_f_equal)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    int hotherfeature_id = -1;
    zval *hfeature = NULL;
    zval *hotherfeature = NULL;
    OGRFeatureH hFeat = NULL, hOtherFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rr", &hfeature, &hotherfeature) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hotherfeature) {
        ZEND_FETCH_RESOURCE(hOtherFeat, OGRFeatureH, &hotherfeature, hotherfeature_id, "OGRFeature", le_Feature);
    }

    if (hOtherFeat && hFeat){
        RETURN_LONG(OGR_F_Equal(hFeat, hOtherFeat));
    }
}

/* }}} */

/* {{{ proto int ogr_f_getfieldcount(resource hfeature)
    */
PHP_FUNCTION(ogr_f_getfieldcount)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfeature) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat){
        RETURN_LONG(OGR_F_GetFieldCount(hFeat));
    }
}

/* }}} */

/* {{{ proto resource ogr_f_getfielddefnref(resource hfeature, int ifield)
    */
PHP_FUNCTION(ogr_f_getfielddefnref)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;
    OGRFieldDefnH hFieldDefn = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hfeature, &ifield) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat)
        hFieldDefn = OGR_F_GetFieldDefnRef(hFeat, ifield);

    if (hFieldDefn)
        ZEND_REGISTER_RESOURCE(return_value, hFieldDefn, le_FieldDefnRef);
}

/* }}} */

/* {{{ proto int ogr_f_getfieldindex(resource hfeature, string strname)
    */
PHP_FUNCTION(ogr_f_getfieldindex)
{
    char *strname = NULL;
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    int strname_len;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rs", &hfeature, &strname, &strname_len) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat)
        RETURN_LONG(OGR_F_GetFieldIndex(hFeat, strname));
}

/* }}} */

/* {{{ proto int ogr_f_isfieldset(resource hfeature, int ifield)
    */
PHP_FUNCTION(ogr_f_isfieldset)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hfeature, &ifield) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat)
        RETURN_BOOL(OGR_F_IsFieldSet(hFeat, ifield));
}

/* }}} */

/* {{{ proto void ogr_f_unsetfield(resource hfeature, int ifield)
    */
PHP_FUNCTION(ogr_f_unsetfield)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hfeature, &ifield) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat)
        OGR_F_UnsetField(hFeat, ifield);
}

/* }}} */

/* {{{ proto resource ogr_f_getrawfieldref(resource hfeature, int ifield)
    */
PHP_FUNCTION(ogr_f_getrawfieldref)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;
    OGRField *hField = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hfeature, &ifield) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }

    if (hFeat)
        hField = OGR_F_GetRawFieldRef(hFeat, ifield);
    if(hField){
        ZEND_REGISTER_RESOURCE(return_value, hField, le_FieldRef);
    }
}

/* }}} */

/* {{{ proto int ogr_f_getfieldasinteger(resource hfeature, int ifield)
    */
PHP_FUNCTION(ogr_f_getfieldasinteger)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hfeature, &ifield) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if(hFeat){
        RETURN_LONG(OGR_F_GetFieldAsInteger(hFeat, ifield));
    }
}

/* }}} */

/* {{{ proto double ogr_f_getfieldasdouble(resource hfeature, int ifield)
    */
PHP_FUNCTION(ogr_f_getfieldasdouble)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hfeature, &ifield) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if(hFeat){
        RETURN_DOUBLE(OGR_F_GetFieldAsDouble(hFeat, ifield));
    }
}

/* }}} */

/* {{{ proto string ogr_f_getfieldasstring(resource hfeature, int ifield)
    */
PHP_FUNCTION(ogr_f_getfieldasstring)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;
    int numelems = 0;
    zval **tmp = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hfeature, &ifield) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if(hFeat){
        const char *pszValue;
        if ((pszValue = OGR_F_GetFieldAsString(hFeat, ifield)) != NULL)
            RETURN_STRING((char *)pszValue, 1);
    }
}

/* }}} */

/* {{{ proto array int ogr_f_getfieldasintegerlist(resource hfeature, int ifield, int refncount)
    */
PHP_FUNCTION(ogr_f_getfieldasintegerlist)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    zval *refncount;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;
    int numelements = 0;
    long *panList = NULL;
    int ncount = 0;

    if (zend_parse_parameters(argc TSRMLS_CC, "rlz", &hfeature, &ifield, &refncount) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat)
        (int *) panList = OGR_F_GetFieldAsIntegerList(hFeat, ifield, &ncount);

    if ((!panList) || (ncount <= 0)){
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

	if (array_init(return_value) == FAILURE)
	{
		RETURN_FALSE;
	}

	while (numelements <= ncount) {
        add_next_index_long(return_value, panList[numelements]);
        numelements++;
	}
    zval_dtor(refncount);
    ZVAL_LONG(refncount, ncount);
}

/* }}} */

/* {{{ proto array double ogr_f_getfieldasdoublelist(resource hfeature, int ifield, int refncount)
    */
PHP_FUNCTION(ogr_f_getfieldasdoublelist)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    zval *refncount;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;
    int numelements = 0;
    double *padfList = NULL;
    int ncount = 0;

    if (zend_parse_parameters(argc TSRMLS_CC, "rlz", &hfeature, &ifield, &refncount) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat)
        (double *) padfList =(double *) OGR_F_GetFieldAsDoubleList(hFeat, ifield, &ncount);

    if ((!padfList) || (ncount <= 0)){
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

	if (array_init(return_value) == FAILURE)
	{
		RETURN_FALSE;
	}

	while (numelements <= ncount) {
        add_next_index_double(return_value, padfList[numelements]);
        numelements++;
	}
    zval_dtor(refncount);
    ZVAL_DOUBLE(refncount, ncount);

}

/* }}} */

/* {{{ proto array string ogr_f_getfieldasstringlist(resource hfeature, int ifield)
    */
PHP_FUNCTION(ogr_f_getfieldasstringlist)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;
    int numelements = 0;
    char **papszStrList = NULL;
    zval **tmp = NULL;
    int ncount = 0;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hfeature, &ifield) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat)
        papszStrList = OGR_F_GetFieldAsStringList(hFeat, ifield);

    if (!papszStrList){
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

    ncount = CSLCount(papszStrList);

    if (ncount <=0){
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

	if (array_init(return_value) == FAILURE)
	{
		RETURN_FALSE;
	}

	while (numelements <= ncount) {
        add_next_index_string(return_value, (char *) CSLGetField(papszStrList, numelements), 1);
        numelements++;
	}
}

/* }}} */

/* {{{ proto void ogr_f_setfieldinteger(resource hfeature, int ifield, int nvalue)
    */
PHP_FUNCTION(ogr_f_setfieldinteger)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    long nvalue;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rll", &hfeature, &ifield, &nvalue) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if(hFeat){
        OGR_F_SetFieldInteger(hFeat, ifield, nvalue);
    }
}

/* }}} */

/* {{{ proto void ogr_f_setfielddouble(resource hfeature, int ifield, double dfvalue)
    */
PHP_FUNCTION(ogr_f_setfielddouble)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    double dfvalue;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rld", &hfeature, &ifield, &dfvalue) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if(hFeat){
        OGR_F_SetFieldDouble(hFeat, ifield, dfvalue);
    }
}
/* }}} */

/* {{{ proto void ogr_f_setfieldstring(resource hfeature, int ifield, string strvalue)
    */
PHP_FUNCTION(ogr_f_setfieldstring)
{
    char *strvalue = NULL;
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    int strvalue_len;
    long ifield;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rls", &hfeature, &ifield, &strvalue, &strvalue_len) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if(hFeat){
        OGR_F_SetFieldString(hFeat, ifield, strvalue);
    }
}

/* }}} */

/* {{{ proto void ogr_f_setfieldintegerlist(resource hfeature, int ifield, int ncount, int refanvalues)
    */
PHP_FUNCTION(ogr_f_setfieldintegerlist)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    long ncount;
    zval *refanvalues = NULL;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;
    int *alTmp = NULL;
    int numelements = 0;
    zval **tmp = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rlla", &hfeature, &ifield, &ncount, &refanvalues) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }

	numelements = zend_hash_num_elements(Z_ARRVAL_P(refanvalues));

    if ((numelements != ncount) || (numelements <= 0)){
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }
	alTmp = (int *) CPLMalloc(sizeof(int)*ncount);

    numelements = 0;

	zend_hash_internal_pointer_reset(Z_ARRVAL_P(refanvalues));
	while (zend_hash_get_current_data(Z_ARRVAL_P(refanvalues), 
										 (void **) &tmp) == SUCCESS) {


        alTmp[numelements] = Z_LVAL_PP(tmp);
        numelements++;

		zend_hash_move_forward(Z_ARRVAL_P(refanvalues));
	}

    if (hFeat)
        OGR_F_SetFieldIntegerList(hFeat, ifield, ncount, (int *)alTmp);

    CPLFree(alTmp);
}

/* }}} */

/* {{{ proto void ogr_f_setfielddoublelist(resource hfeature, int ifield, int ncount, double refadfvalues)
    */
PHP_FUNCTION(ogr_f_setfielddoublelist)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    long ncount;
    zval *refadfvalues =NULL;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;
    double *adfTmp = NULL;
    int numelements = 0;
    zval **tmp = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rlla", &hfeature, &ifield, &ncount, &refadfvalues) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }

	numelements = zend_hash_num_elements(Z_ARRVAL_P(refadfvalues));

    if ((numelements != ncount) || (numelements <= 0)){
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

	adfTmp = (double *) CPLMalloc(sizeof(double)*ncount);

    numelements = 0;

	zend_hash_internal_pointer_reset(Z_ARRVAL_P(refadfvalues));
	while (zend_hash_get_current_data(Z_ARRVAL_P(refadfvalues), 
										 (void **) &tmp) == SUCCESS) {

        adfTmp[numelements] = Z_DVAL_PP(tmp);
        numelements++;

		zend_hash_move_forward(Z_ARRVAL_P(refadfvalues));
	}

    if (hFeat)
        OGR_F_SetFieldDoubleList(hFeat, ifield, ncount, (double *)adfTmp);

        CPLFree ( adfTmp );
}

/* }}} */

/* {{{ proto void ogr_f_setfieldstringlist(resource hfeature, int ifield, array refastrvalues)
    */
PHP_FUNCTION(ogr_f_setfieldstringlist)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifield;
    zval *hfeature = NULL;
    zval *refastrvalues = NULL;
    OGRFeatureH hFeat = NULL;
    char **papszStrList = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rla", &hfeature, &ifield, &refastrvalues) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }

    papszStrList = php_array2string(papszStrList, refastrvalues);

    if (hFeat)
        OGR_F_SetFieldStringList(hFeat, ifield, papszStrList);

    CSLDestroy(papszStrList);
}

/* }}} */

/* {{{ proto void ogr_f_setfieldraw(resource hfeature, int ifield, resource hogrfield)
    */
PHP_FUNCTION(ogr_f_setfieldraw)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    int hogrfield_id = -1;
    long ifield;
    zval *hfeature = NULL;
    zval *hogrfield = NULL;
    OGRFeatureH hFeat = NULL;
    OGRField *hField = NULL;


    if (zend_parse_parameters(argc TSRMLS_CC, "rlr", &hfeature, &ifield, &hogrfield) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hogrfield) {
        ZEND_FETCH_RESOURCE2(hField, OGRField *, &hogrfield, hogrfield_id, "OGRField", le_Field, le_FieldRef);
    }
    
    if (hFeat && hField)
        OGR_F_SetFieldRaw(hFeat, ifield, hField);
}

/* }}} */

/* {{{ proto long ogr_f_getfid(resource hfeature)
    */
PHP_FUNCTION(ogr_f_getfid)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfeature) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat)
        RETURN_LONG(OGR_F_GetFID(hFeat));

}

/* }}} */

/* {{{ proto int ogr_f_setfid(resource hfeature, int ifidin)
    */
PHP_FUNCTION(ogr_f_setfid)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    long ifidin;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hfeature, &ifidin) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hFeat)
        eErr = OGR_F_SetFID(hFeat, ifidin);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }
    RETURN_LONG(eErr);
}

#ifdef CONSTRUCT_FLAG
/* }}} */

/* {{{ proto void ogr_f_dumpreadable(resource hfeature)
   hfileout ) */
PHP_FUNCTION(ogr_f_dumpreadable)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    zval *hfeature = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfeature) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(???, ???, hfeature, hfeature_id, "???", ???_rsrc_id);
    }

    php_error(E_WARNING, "ogr_f_dumpreadable: not yet implemented");
}

#endif

/* }}} */

/* {{{ proto int ogr_f_setfrom(resource hdstfeature, resource hsrcfeature, boolean bforgiving ) */
PHP_FUNCTION(ogr_f_setfrom)
{
    int argc = ZEND_NUM_ARGS();
    int hdstfeature_id = -1;
    zval *hdstfeature = NULL;
    int hsrcfeature_id = -1;
    zval *hsrcfeature = NULL;
    zend_bool bforgiving;
    OGRFeatureH hDstFeat = NULL, hSrcFeat = NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "rrb", &hdstfeature, &hsrcfeature, &bforgiving) == FAILURE) 
        return;

    if (hdstfeature) {
        ZEND_FETCH_RESOURCE(hDstFeat, OGRFeatureH, &hdstfeature, hdstfeature_id, "OGRFeature", le_Feature);
    }

    if (hsrcfeature) {
        ZEND_FETCH_RESOURCE(hSrcFeat, OGRFeatureH, &hsrcfeature, hsrcfeature_id, "OGRFeature", le_Feature);
    }

    if (hDstFeat && hSrcFeat){
        eErr = OGR_F_SetFrom(hDstFeat, hSrcFeat, bforgiving);
    }

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }
    RETURN_LONG(eErr);
}

/* }}} */

/* {{{ proto string ogr_f_getstylestring(resource hfeature)
    */
PHP_FUNCTION(ogr_f_getstylestring)
{
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hfeature) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }

    if (hFeat) {
        const char *pszStyleString;
        if ((pszStyleString = OGR_F_GetStyleString(hFeat)) != NULL)
            RETURN_STRING((char *)pszStyleString, 1);
    }
}

/* }}} */

/* {{{ proto void ogr_f_setstylestring(resource hfeature, string strstring)
    */
PHP_FUNCTION(ogr_f_setstylestring)
{
    char *strstring = NULL;
    int argc = ZEND_NUM_ARGS();
    int hfeature_id = -1;
    int strstring_len;
    zval *hfeature = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rs", &hfeature, &strstring, &strstring_len) == FAILURE) 
        return;

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }

    if (hFeat)
        OGR_F_SetStyleString(hFeat, strstring);
}

/* }}} */

/* {{{ proto resource ogr_l_getspatialfilter(resource hlayer)
    */
PHP_FUNCTION(ogr_l_getspatialfilter)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    zval *hlayer = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRGeometryH hGeom = NULL;
    int eType = 0;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hlayer) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }
    if (hLayerResource) 
        hGeom = OGR_L_GetSpatialFilter(hLayerResource);

    if (!hGeom)
        RETURN_NULL();

    ZEND_REGISTER_RESOURCE(return_value, hGeom, le_GeometryRef);
}

/* }}} */

/* {{{ proto void ogr_l_setspatialfilter(resource hlayer, resource hspatialfilter)
    */
PHP_FUNCTION(ogr_l_setspatialfilter)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    int hspatialfilter_id = -1;
    zval *hlayer = NULL;
    zval *hspatialfilter = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRGeometryH hGeom = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rr!", &hlayer, &hspatialfilter) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }
    if (hspatialfilter) {
        ZEND_FETCH_RESOURCE2(hGeom, OGRGeometryH, &hspatialfilter, hspatialfilter_id, "OGRGeometry", le_Geometry, le_GeometryRef);
    }
    if (hLayerResource && hGeom)
        OGR_L_SetSpatialFilter(hLayerResource, hGeom);
}
/* }}} */

/* {{{ proto int ogr_l_setattributefilter(resource hlayer, string strquery)
    */
PHP_FUNCTION(ogr_l_setattributefilter)
{
    char *strquery = NULL;
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    int strquery_len;
    zval *hlayer = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "rs", &hlayer, &strquery, &strquery_len) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }
    if (hLayerResource)
        eErr = OGR_L_SetAttributeFilter(hLayerResource, strquery);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }

    RETURN_LONG(eErr);
}

/* }}} */

/* {{{ proto void ogr_l_resetreading(resource hlayer)
    */
PHP_FUNCTION(ogr_l_resetreading)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    zval *hlayer = NULL;
    OGRLayerH hLayerResource = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hlayer) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }
    if (hLayerResource)
        OGR_L_ResetReading(hLayerResource);
}

/* }}} */

/* {{{ proto resource ogr_l_getnextfeature(resource hlayer)
    */
PHP_FUNCTION(ogr_l_getnextfeature)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    zval *hlayer = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hlayer) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }
    if (hLayerResource)
        hFeat = OGR_L_GetNextFeature(hLayerResource);

    if (hFeat)
        ZEND_REGISTER_RESOURCE(return_value, hFeat, le_Feature);
}

/* }}} */

/* {{{ proto resource ogr_l_getfeature(resource hlayer, long ifeatureid)
    */
PHP_FUNCTION(ogr_l_getfeature)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    long ifeatureid;
    zval *hlayer = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRFeatureH hFeat = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hlayer, &ifeatureid) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }
    if (hLayerResource)
        hFeat = OGR_L_GetFeature(hLayerResource, ifeatureid);

    if (hFeat)
        ZEND_REGISTER_RESOURCE(return_value, hFeat, le_Feature);

}

/* }}} */

/* {{{ proto int ogr_l_setfeature(resource hlayer, resource hfeature)
    */
PHP_FUNCTION(ogr_l_setfeature)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    int hfeature_id = -1;
    zval *hlayer = NULL;
    zval *hfeature = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRFeatureH hFeat = NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "rr", &hlayer, &hfeature) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }
    if (hfeature) {
        ZEND_FETCH_RESOURCE(hFeat, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }
    if (hLayerResource && hFeat)
        eErr = OGR_L_SetFeature(hLayerResource, hFeat);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }

    RETURN_LONG(eErr);
}

/* }}} */

/* {{{ proto int ogr_l_createfeature(resource hlayer, resource hfeature)
    */
PHP_FUNCTION(ogr_l_createfeature)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    int hfeature_id = -1;
    zval *hlayer = NULL;
    zval *hfeature = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRFeatureH hNewFeature = NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "rr", &hlayer, &hfeature) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }

    if (hfeature) {
        ZEND_FETCH_RESOURCE(hNewFeature, OGRFeatureH, &hfeature, hfeature_id, "OGRFeature", le_Feature);
    }

    if (hLayerResource && hNewFeature){
        eErr = (OGR_L_CreateFeature(hLayerResource, hNewFeature));
    }
    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
    }
    RETURN_LONG(eErr);
}

/* }}} */

/* {{{ proto resource ogr_l_getlayerdefn(resource hlayer)
    */
PHP_FUNCTION(ogr_l_getlayerdefn)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    zval *hlayer = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRFeatureDefnH hFeatureDefn = NULL;
    int numFields =0;
    
    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hlayer) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }
    if (hLayerResource)
        hFeatureDefn = OGR_L_GetLayerDefn(hLayerResource);

    if (hFeatureDefn)
        ZEND_REGISTER_RESOURCE(return_value, hFeatureDefn, le_FeatureDefnRef);
}

/* }}} */

/* {{{ proto resource ogr_l_getspatialref(resource hlayer)
    */
PHP_FUNCTION(ogr_l_getspatialref)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    zval *hlayer = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRSpatialReferenceH hSpatialRef = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hlayer) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }
    if (hLayerResource)
        hSpatialRef = OGR_L_GetSpatialRef(hLayerResource);

    if (!hSpatialRef)
        RETURN_NULL();

    ZEND_REGISTER_RESOURCE(return_value, hSpatialRef, le_SpatialReferenceRef);
}

/* }}} */

/* {{{ proto int ogr_l_getfeaturecount(resource hlayer, boolean bforce)
    */
PHP_FUNCTION(ogr_l_getfeaturecount)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    zend_bool bforce;
    zval *hlayer = NULL;
    OGRLayerH hLayerResource = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rb", &hlayer, &bforce) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }
    if (hLayerResource){
        RETURN_LONG(OGR_L_GetFeatureCount(hLayerResource, bforce));
    }
}

/* }}} */

/* {{{ proto int ogr_l_getextent(resource hlayer, object oextent, boolean bforce)
    */
PHP_FUNCTION(ogr_l_getextent)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    zend_bool bforce;
    zval *hlayer = NULL;
    zval *oextent = NULL;
    OGREnvelope oEnvelope;
    OGRLayerH hLayerResource = NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "rzb", &hlayer, &oextent, &bforce) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }

    if (hLayerResource)
        eErr = OGR_L_GetExtent(hLayerResource, &oEnvelope , bforce);

    if (eErr != OGRERR_NONE){
        php_report_ogr_error(E_WARNING);
        RETURN_LONG(eErr);
    }

    zval_dtor(oextent);

    if (object_init(oextent)==FAILURE) {
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

    add_property_double(oextent, "minx", oEnvelope.MinX);
    add_property_double(oextent, "maxx", oEnvelope.MaxX);
    add_property_double(oextent, "miny", oEnvelope.MinY);
    add_property_double(oextent, "maxy", oEnvelope.MaxY);
}

/* }}} */

/* {{{ proto int ogr_l_testcapability(resource hlayer, string strcapability)
    */
PHP_FUNCTION(ogr_l_testcapability)
{
    char *strcapability = NULL;
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    int strcapability_len;
    zval *hlayer = NULL;
    OGRLayerH hLayerResource = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rs", &hlayer, &strcapability, &strcapability_len) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }
    if (hLayerResource){
        RETURN_BOOL(OGR_L_TestCapability(hLayerResource, strcapability));
    }
}

/* }}} */

/* {{{ proto int ogr_l_createfield(resource hlayer, resource hfield, boolean bapproxok)
    */
PHP_FUNCTION(ogr_l_createfield)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    int hfield_id = -1;
    zend_bool bapproxok;
    zval *hlayer = NULL;
    zval *hfield = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRFieldDefnH hFieldDefn = NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "rrb", &hlayer, &hfield, &bapproxok) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }
    if (hfield) {
        ZEND_FETCH_RESOURCE2(hFieldDefn, OGRFieldDefnH, &hfield, hfield_id, "OGRFieldDefn", le_FieldDefn, le_FieldDefnRef);
    }
    if(hLayerResource && hFieldDefn)
        eErr = OGR_L_CreateField(hLayerResource, hFieldDefn, bapproxok);

    RETURN_LONG(eErr);
}

/* }}} */

/* {{{ proto int ogr_l_starttransaction(resource hlayer)
    */
PHP_FUNCTION(ogr_l_starttransaction)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    zval *hlayer = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hlayer) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }

    if(hLayerResource)
        eErr = OGR_L_StartTransaction(hLayerResource);

    RETURN_LONG(eErr);
}

/* }}} */

/* {{{ proto int ogr_l_committransaction(resource hlayer)
    */
PHP_FUNCTION(ogr_l_committransaction)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    zval *hlayer = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hlayer) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }

    if(hLayerResource)
        eErr = OGR_L_CommitTransaction(hLayerResource);

    RETURN_LONG(eErr);
}
/* }}} */

/* {{{ proto int ogr_l_rollbacktransaction(resource hlayer)
    */
PHP_FUNCTION(ogr_l_rollbacktransaction)
{
    int argc = ZEND_NUM_ARGS();
    int hlayer_id = -1;
    zval *hlayer = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRErr eErr = OGRERR_FAILURE;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hlayer) == FAILURE) 
        return;

    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }

    if(hLayerResource)
        eErr = OGR_L_RollbackTransaction(hLayerResource);

    RETURN_LONG(eErr);
}

/* }}} */

/* {{{ proto void OGR_DS_Destroy(resource hDS)
    */
PHP_FUNCTION(ogr_ds_destroy)
{
    int argc = ZEND_NUM_ARGS();
    int hDS_id = -1;
    zval *hDS = NULL;
    OGRDataSourceH hDataSource = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hDS) == FAILURE) 
        return;

    if (hDS) {
        ZEND_FETCH_RESOURCE(hDataSource, OGRDataSourceH , &hDS, hDS_id, "OGRDataSource", le_Datasource);
    }

    if (hDataSource)
       zend_list_delete(hDS->value.lval);
}

/* }}} */

/* {{{ proto string ogr_ds_getname(resource hds)
    */
PHP_FUNCTION(ogr_ds_getname)
{
    int argc = ZEND_NUM_ARGS();
    int hds_id = -1;
    zval *hds = NULL;
    OGRDataSourceH hDataSource = NULL;

 
    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hds) == FAILURE) 
        return;

    if (hds) {
        ZEND_FETCH_RESOURCE(hDataSource, OGRDataSourceH, &hds, hds_id, "OGRDataSource", le_Datasource); 
    }
    if (hDataSource){
        const char *pszName;
        if ((pszName = OGR_DS_GetName(hDataSource)) != NULL)
            RETURN_STRING((char *)pszName, 1);
    }
}

/* }}} */
/* {{{ proto int ogr_ds_getlayercount(resource hds)
    */
PHP_FUNCTION(ogr_ds_getlayercount)
{
    int argc = ZEND_NUM_ARGS();
    int hds_id = -1;
    zval *hds = NULL;
    OGRDataSourceH hDataSource = NULL;


    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hds) == FAILURE) 
        return;

    if (hds) {
        ZEND_FETCH_RESOURCE(hDataSource, OGRDataSourceH, &hds, hds_id, "OGRDataSource", le_Datasource);

    }
    if (hDataSource){
        RETURN_LONG(OGR_DS_GetLayerCount(hDataSource));        
    }
}

/* }}} */

/* {{{ proto resource ogr_ds_getlayer(resource hds, int ilayer)
    */
PHP_FUNCTION(ogr_ds_getlayer)
{
    int argc = ZEND_NUM_ARGS();
    int hds_id = -1;
    long ilayer;
    zval *hds = NULL;
    OGRDataSourceH hDataSource = NULL;
    OGRLayerH hLayer = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rl", &hds, &ilayer) == FAILURE) 
        return;

    if (hds) {
        ZEND_FETCH_RESOURCE(hDataSource, OGRDataSourceH, &hds, hds_id, "OGRDataSource", le_Datasource);
    }

    if (hDataSource){
        hLayer = OGR_DS_GetLayer(hDataSource, ilayer);
    }
    if (!hLayer) {
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

    ZEND_REGISTER_RESOURCE(return_value, hLayer, le_Layer);
}

/* }}} */

/* {{{ proto resource ogr_ds_createlayer(resource hds, string strname, resource hsrs, int igeometrytype, array astroptions)
    */
PHP_FUNCTION(ogr_ds_createlayer)
{
    char *strname = NULL;
    int argc = ZEND_NUM_ARGS();
    int hds_id = -1;
    int strname_len;
    int hsrs_id = -1;
    long igeometrytype;
    zval *hds = NULL;
    zval *hsrs = NULL;
    zval *astroptions = NULL;
    char **papszoptions = NULL;
    OGRDataSourceH hDataSource = NULL;
    OGRSpatialReferenceH hSpatialReference = NULL;
    OGRLayerH hLayer = NULL;


    if (zend_parse_parameters(argc TSRMLS_CC, "rsr!la!", &hds, &strname, &strname_len, &hsrs, &igeometrytype, &astroptions) == FAILURE)
        return;

    if (hds) {
        ZEND_FETCH_RESOURCE(hDataSource, OGRDataSourceH, &hds, hds_id, "OGRDataSource", le_Datasource);
    }

    if (hsrs) {
        ZEND_FETCH_RESOURCE2(hSpatialReference, OGRSpatialReferenceH, &hsrs, hsrs_id, "OGRSpatialReference", le_SpatialReference, le_SpatialReferenceRef);
        }

    if (astroptions){
        papszoptions = php_array2string(papszoptions, astroptions);
    }

    if (hDataSource){
        hLayer = OGR_DS_CreateLayer(hDataSource, strname, hSpatialReference, igeometrytype, papszoptions);
    }

    CSLDestroy(papszoptions);

    if (!hLayer) {
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

    ZEND_REGISTER_RESOURCE(return_value, hLayer, le_Layer);
}

/* }}} */

/* {{{ proto int ogr_ds_testcapability(resource hds, string strcapability)
    */
PHP_FUNCTION(ogr_ds_testcapability)
{
    char *strcapability = NULL;
    int argc = ZEND_NUM_ARGS();
    int hds_id = -1;
    int strcapability_len;
    zval *hds = NULL;
    OGRDataSourceH hDataSource = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rs", &hds, &strcapability, &strcapability_len) == FAILURE) 
        return;

    if (hds) {
        ZEND_FETCH_RESOURCE(hDataSource, OGRDataSourceH, &hds, hds_id, "OGRDataSource", le_Datasource);
    }
    if (hDataSource){
        RETURN_BOOL(OGR_DS_TestCapability(hDataSource, strcapability));
    }
}

/* }}} */

/* {{{ proto resource ogr_ds_executesql(resource hds, string strsqlcommand, resource hspatialfilter, string strdialect)
    */
PHP_FUNCTION(ogr_ds_executesql)
{
    char *strsqlcommand = NULL;
    char *strdialect = NULL;
    int argc = ZEND_NUM_ARGS();
    int hds_id = -1;
    int strsqlcommand_len;
    int hspatialfilter_id = -1;
    int strdialect_len;
    zval *hds = NULL;
    zval *hspatialfilter = NULL;
    OGRDataSourceH hDataSource = NULL;
    OGRGeometryH hGeometry = NULL;
    OGRLayerH hLayer = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rsr!s", &hds, &strsqlcommand, &strsqlcommand_len, &hspatialfilter, &strdialect, &strdialect_len) == FAILURE) 
        return;

    if (hds) {
        ZEND_FETCH_RESOURCE(hDataSource, OGRDataSourceH, &hds, hds_id, "OGRDataSource", le_Datasource);

    }
    if (hspatialfilter) {
        ZEND_FETCH_RESOURCE2(hGeometry, OGRGeometryH, &hspatialfilter, hspatialfilter_id, "OGRSpatialFilter", le_Geometry, le_GeometryRef);
    }

    if (hDataSource){
        CPLErrorReset();
        hLayer = OGR_DS_ExecuteSQL(hDataSource, strsqlcommand, hGeometry, strdialect);
    }

    if (!hLayer && (CPLGetLastErrorNo() != OGRERR_NONE)) {
        php_report_ogr_error(E_WARNING);
        RETURN_NULL();
    }
    if (!hLayer) {
        php_report_ogr_error(E_WARNING);
        RETURN_NULL();
    }

    ZEND_REGISTER_RESOURCE(return_value, hLayer, le_Layer);
}

/* }}} */

/* {{{ proto void ogr_ds_releaseresultset(resource hds, resource hlayer)
    */
PHP_FUNCTION(ogr_ds_releaseresultset)
{
    int argc = ZEND_NUM_ARGS();
    int hds_id = -1;
    int hlayer_id = -1;
    zval *hds = NULL;
    zval *hlayer = NULL;
    OGRLayerH hLayerResource = NULL;
    OGRDataSourceH hDataSource = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rr", &hds, &hlayer) == FAILURE) 
        return;

    if (hds) {
        ZEND_FETCH_RESOURCE(hDataSource, OGRDataSourceH, &hds, hds_id, "OGRDataSource", le_Datasource);
    }
    if (hlayer) {
        ZEND_FETCH_RESOURCE(hLayerResource, OGRLayerH, &hlayer, hlayer_id, "OGRLayer", le_Layer);
    }
    if (hDataSource && hLayerResource){
        OGR_DS_ReleaseResultSet(hDataSource, hLayerResource);
        zend_list_delete(hlayer->value.lval);
    }
}

/* }}} */

/* {{{ proto string ogr_dr_getname(resource hsfdriver)
    */
PHP_FUNCTION(ogr_dr_getname)
{
    int argc = ZEND_NUM_ARGS();
    int hsfdriver_id = -1;
    zval *hsfdriver = NULL;
    OGRSFDriverH hDriver = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hsfdriver) == FAILURE) 
        return;

    if (hsfdriver){
        ZEND_FETCH_RESOURCE(hDriver, OGRSFDriverH, &hsfdriver, hsfdriver_id, "OGRSFDriverH", le_SFDriver);
    }
    if (hDriver){
        const char *pszName;
        if ((pszName = OGR_Dr_GetName(hDriver)) != NULL)
            RETURN_STRING((char *)pszName, 1);
    }
}

/* {{{ proto resource ogr_dr_open(resource hsfdriver, string strname, boolean bupdate)
    */
PHP_FUNCTION(ogr_dr_open)
{
    char *strname = NULL;
    int argc = ZEND_NUM_ARGS();
    int hsfdriver_id = -1;
    int strname_len;
    zend_bool bupdate;
    zval *hsfdriver = NULL;
    OGRSFDriverH hDriver = NULL;
    OGRDataSourceH hDataSource = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rsb", &hsfdriver, &strname, &strname_len, &bupdate) == FAILURE) 
        return;

    if (hsfdriver){
        ZEND_FETCH_RESOURCE(hDriver, OGRSFDriverH, &hsfdriver, hsfdriver_id, "OGRSFDriverH", le_SFDriver);
    }
    if (hDriver)
        hDataSource = OGR_Dr_Open(hDriver, strname, bupdate);

    if (!hDataSource){
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

    ZEND_REGISTER_RESOURCE(return_value, hDataSource, le_Datasource);
}

/* }}} */

/* {{{ proto int ogr_dr_testcapability(resource hsfdriver, string strcapability)
    */
PHP_FUNCTION(ogr_dr_testcapability)
{
    char *strcapability = NULL;
    int argc = ZEND_NUM_ARGS();
    int hsfdriver_id = -1;
    int strcapability_len;
    zval *hsfdriver = NULL;
    OGRSFDriverH hDriver = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rs", &hsfdriver, &strcapability, &strcapability_len) == FAILURE) 
        return;

    if (hsfdriver){
        ZEND_FETCH_RESOURCE(hDriver, OGRSFDriverH, &hsfdriver, hsfdriver_id, "OGRSFDriverH", le_SFDriver);
    }
    if (hDriver){
       RETURN_BOOL(OGR_Dr_TestCapability(hDriver, strcapability));
    }
}

/* }}} */

/* {{{ proto resource ogr_dr_createdatasource(resource hsfdriver, string strname, array astroptions)
    */
PHP_FUNCTION(ogr_dr_createdatasource)
{
    char *strname = NULL;
    int argc = ZEND_NUM_ARGS();
    int hsfdriver_id = -1;
    int strname_len;
    zval *hsfdriver = NULL;
    zval *astroptions = NULL;
    char **papszoptions = NULL;
    OGRSFDriverH hDriver = NULL;
    OGRDataSourceH hDataSource = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "rsa!", &hsfdriver, &strname, &strname_len, &astroptions) == FAILURE) 
        return;

    if (hsfdriver) {
        ZEND_FETCH_RESOURCE(hDriver, OGRSFDriverH, &hsfdriver, hsfdriver_id, "OGRSFDriverH", le_SFDriver);
    }

    if (astroptions){
        papszoptions = php_array2string(papszoptions, astroptions);
    }

    if (hDriver){
        hDataSource = OGR_Dr_CreateDataSource(hDriver, strname, papszoptions );
    }
    if (!hDataSource){
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

    CSLDestroy(papszoptions);

    ZEND_REGISTER_RESOURCE(return_value, hDataSource, le_Datasource);
}

/* }}} */

/* {{{ proto resource OGROpen(string strName, boolean bUpdate, resource refhSFDriver)
    */
PHP_FUNCTION(ogropen)
{
    char *strName = NULL;
    int argc = ZEND_NUM_ARGS();
    int strName_len;
    int refhSFDriver_id = -1;
    zend_bool bUpdate;
    zval *refhSFDriver = NULL;
    OGRSFDriverH hDriver=NULL;
    OGRDataSourceH hFile = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "sb|r!", &strName, &strName_len, &bUpdate, &refhSFDriver) == FAILURE) 
        return;

    if (OGRGetDriverCount() == 0)
    {
        php_error(E_WARNING, "OGR drivers not registered, make sure you call OGRRegisterAll() before OGROpen()");
        RETURN_FALSE;
    }

    hFile = OGROpen(strName, bUpdate, &hDriver);

    if (hFile == NULL)
    {
        php_error(E_WARNING, "Unable to open datasource file");
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }

    /* Create return values */
    ZEND_REGISTER_RESOURCE(return_value, hFile, le_Datasource);

    /* refhSFDriver is optional and passed by reference */
    if (refhSFDriver) {
        zval_dtor(refhSFDriver);
        if (hDriver) {
            ZEND_REGISTER_RESOURCE(refhSFDriver, hDriver, le_SFDriver);
        } else {
            ZVAL_NULL(refhSFDriver);
        }
    }

}

/* }}} */

/* {{{ proto void ogrregisterdriver(resource hsfdriver)
    */
PHP_FUNCTION(ogrregisterdriver)
{
    int argc = ZEND_NUM_ARGS();
    int hsfdriver_id = -1;
    zval *hsfdriver = NULL;
    OGRSFDriverH hDriver = NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "r", &hsfdriver) == FAILURE) 
        return;

    if (hsfdriver){
        ZEND_FETCH_RESOURCE(hDriver, OGRSFDriverH, &hsfdriver, hsfdriver_id, "OGRSFDriverH", le_SFDriver);
    }
    if (hDriver)
        OGRRegisterDriver(hDriver);
}

/* {{{ proto int ogrgetdrivercount()
    */
PHP_FUNCTION(ogrgetdrivercount)
{
    if (ZEND_NUM_ARGS() != 0) {
        WRONG_PARAM_COUNT;
    }
    RETURN_LONG(OGRGetDriverCount());
}

/* }}} */

/* {{{ proto resource ogrgetdriver(int idriver)
    */
PHP_FUNCTION(ogrgetdriver)
{
    int argc = ZEND_NUM_ARGS();
    long idriver;
    OGRSFDriverH hDriver=NULL;

    if (zend_parse_parameters(argc TSRMLS_CC, "l", &idriver) == FAILURE) 
        return;

    hDriver = OGRGetDriver(idriver);

    if (!hDriver){
        php_report_ogr_error(E_WARNING);
        RETURN_FALSE;
    }
    ZEND_REGISTER_RESOURCE(return_value, hDriver, le_SFDriver);
}

/* }}} */

/* {{{ proto void ogrregisterall()
    */
PHP_FUNCTION(ogrregisterall)
{
    if (ZEND_NUM_ARGS() != 0) {
        WRONG_PARAM_COUNT;
    }
    OGRRegisterAll();
}




/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
