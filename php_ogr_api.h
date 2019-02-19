/******************************************************************************
 * Project:  PHP Interface for OGR C API
 * Purpose:  API function signature declarations
 * Author:   Normand Savard, nsavard@dmsolutions.ca
 * Author:   Edward Nash, e.nash@dvz-mv.de
 *
 ******************************************************************************
 * Copyright (c) 2019, DVZ Datenverarbeitungszentrum Mecklenburg-Vorpommern GmbH
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
 */

/*
 * Declaration of exposed functions
 */

PHP_FUNCTION(cplerrorreset);
PHP_FUNCTION(cplgetlasterrorno);
PHP_FUNCTION(cplgetlasterrortype);
PHP_FUNCTION(cplgetlasterrormsg);
PHP_FUNCTION(ogr_ds_destroy);
PHP_FUNCTION(ogropen);
PHP_FUNCTION(ogr_g_createfromwkb);
PHP_FUNCTION(ogr_g_createfromwkt);
PHP_FUNCTION(ogr_g_destroygeometry);
PHP_FUNCTION(ogr_g_creategeometry);
PHP_FUNCTION(ogr_g_getdimension);
PHP_FUNCTION(ogr_g_getcoordinatedimension);
PHP_FUNCTION(ogr_g_clone);
PHP_FUNCTION(ogr_g_getenvelope);
PHP_FUNCTION(ogr_g_importfromwkb);
PHP_FUNCTION(ogr_g_exporttowkb);
PHP_FUNCTION(ogr_g_wkbsize);
PHP_FUNCTION(ogr_g_importfromwkt);
PHP_FUNCTION(ogr_g_exporttowkt);
PHP_FUNCTION(ogr_g_getgeometrytype);
PHP_FUNCTION(ogr_g_getgeometryname);
PHP_FUNCTION(ogr_g_dumpreadable);
PHP_FUNCTION(ogr_g_flattento2d);
PHP_FUNCTION(ogr_g_assignspatialreference);
PHP_FUNCTION(ogr_g_getspatialreference);
PHP_FUNCTION(ogr_g_transform);
PHP_FUNCTION(ogr_g_transformto);
PHP_FUNCTION(ogr_g_intersect);
PHP_FUNCTION(ogr_g_equal);
PHP_FUNCTION(ogr_g_empty);
PHP_FUNCTION(ogr_g_getpointcount);
PHP_FUNCTION(ogr_g_getx);
PHP_FUNCTION(ogr_g_gety);
PHP_FUNCTION(ogr_g_getz);
PHP_FUNCTION(ogr_g_getpoint);
PHP_FUNCTION(ogr_g_setpoint);
PHP_FUNCTION(ogr_g_addpoint);
PHP_FUNCTION(ogr_g_getgeometrycount);
PHP_FUNCTION(ogr_g_getgeometryref);
PHP_FUNCTION(ogr_g_addgeometry);
PHP_FUNCTION(ogr_g_addgeometrydirectly);
PHP_FUNCTION(ogr_g_removegeometry);
PHP_FUNCTION(ogrbuildpolygonfromedges);
PHP_FUNCTION(ogr_fld_create);
PHP_FUNCTION(ogr_fld_destroy);
PHP_FUNCTION(ogr_fld_setname);
PHP_FUNCTION(ogr_fld_getnameref);
PHP_FUNCTION(ogr_fld_gettype);
PHP_FUNCTION(ogr_fld_settype);
PHP_FUNCTION(ogr_fld_getjustify);
PHP_FUNCTION(ogr_fld_setjustify);
PHP_FUNCTION(ogr_fld_getwidth);
PHP_FUNCTION(ogr_fld_setwidth);
PHP_FUNCTION(ogr_fld_getprecision);
PHP_FUNCTION(ogr_fld_setprecision);
PHP_FUNCTION(ogr_fld_set);
PHP_FUNCTION(ogr_getfieldtypename);
PHP_FUNCTION(ogr_fd_create);
PHP_FUNCTION(ogr_fd_destroy);
PHP_FUNCTION(ogr_fd_getname);
PHP_FUNCTION(ogr_fd_getfieldcount);
PHP_FUNCTION(ogr_fd_getfielddefn);
PHP_FUNCTION(ogr_fd_getfieldindex);
PHP_FUNCTION(ogr_fd_addfielddefn);
PHP_FUNCTION(ogr_fd_getgeomtype);
PHP_FUNCTION(ogr_fd_setgeomtype);
PHP_FUNCTION(ogr_fd_reference);
PHP_FUNCTION(ogr_fd_dereference);
PHP_FUNCTION(ogr_fd_getreferencecount);
PHP_FUNCTION(ogr_f_create);
PHP_FUNCTION(ogr_f_destroy);
PHP_FUNCTION(ogr_f_getdefnref);
PHP_FUNCTION(ogr_f_setgeometrydirectly);
PHP_FUNCTION(ogr_f_setgeometry);
PHP_FUNCTION(ogr_f_getgeometryref);
PHP_FUNCTION(ogr_f_clone);
PHP_FUNCTION(ogr_f_equal);
PHP_FUNCTION(ogr_f_getfieldcount);
PHP_FUNCTION(ogr_f_getfielddefnref);
PHP_FUNCTION(ogr_f_getfieldindex);
PHP_FUNCTION(ogr_f_isfieldset);
PHP_FUNCTION(ogr_f_unsetfield);
PHP_FUNCTION(ogr_f_getrawfieldref);
PHP_FUNCTION(ogr_f_getfieldasinteger);
PHP_FUNCTION(ogr_f_getfieldasdouble);
PHP_FUNCTION(ogr_f_getfieldasstring);
PHP_FUNCTION(ogr_f_getfieldasintegerlist);
PHP_FUNCTION(ogr_f_getfieldasdoublelist);
PHP_FUNCTION(ogr_f_getfieldasstringlist);
PHP_FUNCTION(ogr_f_getfieldasdatetime);
PHP_FUNCTION(ogr_f_setfieldinteger);
PHP_FUNCTION(ogr_f_setfielddouble);
PHP_FUNCTION(ogr_f_setfieldstring);
PHP_FUNCTION(ogr_f_setfieldintegerlist);
PHP_FUNCTION(ogr_f_setfielddoublelist);
PHP_FUNCTION(ogr_f_setfieldstringlist);
PHP_FUNCTION(ogr_f_setfielddatetime);
PHP_FUNCTION(ogr_f_setfieldraw);
PHP_FUNCTION(ogr_f_getfid);
PHP_FUNCTION(ogr_f_setfid);
PHP_FUNCTION(ogr_f_dumpreadable);
PHP_FUNCTION(ogr_f_setfrom);
PHP_FUNCTION(ogr_f_getstylestring);
PHP_FUNCTION(ogr_f_setstylestring);
PHP_FUNCTION(ogr_l_getspatialfilter);
PHP_FUNCTION(ogr_l_setspatialfilter);
PHP_FUNCTION(ogr_l_setattributefilter);
PHP_FUNCTION(ogr_l_resetreading);
PHP_FUNCTION(ogr_l_getnextfeature);
PHP_FUNCTION(ogr_l_getfeature);
PHP_FUNCTION(ogr_l_setfeature);
PHP_FUNCTION(ogr_l_createfeature);
PHP_FUNCTION(ogr_l_deletefeature);
PHP_FUNCTION(ogr_l_getlayerdefn);
PHP_FUNCTION(ogr_l_getspatialref);
PHP_FUNCTION(ogr_l_getfeaturecount);
PHP_FUNCTION(ogr_l_getextent);
PHP_FUNCTION(ogr_l_testcapability);
PHP_FUNCTION(ogr_l_createfield);
PHP_FUNCTION(ogr_l_starttransaction);
PHP_FUNCTION(ogr_l_committransaction);
PHP_FUNCTION(ogr_l_rollbacktransaction);
PHP_FUNCTION(ogr_ds_destroy);
PHP_FUNCTION(ogr_ds_getname);
PHP_FUNCTION(ogr_ds_getlayercount);
PHP_FUNCTION(ogr_ds_getlayer);
PHP_FUNCTION(ogr_ds_getlayerbyname);
PHP_FUNCTION(ogr_ds_createlayer);
PHP_FUNCTION(ogr_ds_testcapability);
PHP_FUNCTION(ogr_ds_executesql);
PHP_FUNCTION(ogr_ds_releaseresultset);
PHP_FUNCTION(ogr_ds_getdriver);
PHP_FUNCTION(ogr_dr_getname);
PHP_FUNCTION(ogr_dr_open);
PHP_FUNCTION(ogr_dr_testcapability);
PHP_FUNCTION(ogr_dr_createdatasource);
PHP_FUNCTION(ogropen);
PHP_FUNCTION(ogrregisterdriver);
PHP_FUNCTION(ogrgetdrivercount);
PHP_FUNCTION(ogrgetdriver);
PHP_FUNCTION(ogrgetdriverbyname);
PHP_FUNCTION(ogrregisterall);
PHP_FUNCTION(osr_newspatialreference);
PHP_FUNCTION(osr_destroyspatialreference);
PHP_FUNCTION(osr_reference);
PHP_FUNCTION(osr_dereference);
PHP_FUNCTION(osr_release);
PHP_FUNCTION(osr_validate);
PHP_FUNCTION(osr_fixupordering);
PHP_FUNCTION(osr_fixup);
PHP_FUNCTION(osr_stripctparms);
PHP_FUNCTION(osr_importfromepsg);
PHP_FUNCTION(osr_importfromepsga);
PHP_FUNCTION(osr_importfromwkt);
PHP_FUNCTION(osr_importfromproj4);
PHP_FUNCTION(osr_importfromesri);
PHP_FUNCTION(osr_exporttowkt);
PHP_FUNCTION(osr_exporttoprettywkt);
PHP_FUNCTION(osr_exporttoproj4);
PHP_FUNCTION(osr_morphtoesri);
PHP_FUNCTION(osr_morphfromesri);
PHP_FUNCTION(osr_getattrvalue);
PHP_FUNCTION(osr_getangularunits);
PHP_FUNCTION(osr_getlinearunits);
PHP_FUNCTION(osr_getprimemeridian);
PHP_FUNCTION(osr_isgeographic);
PHP_FUNCTION(osr_islocal);
PHP_FUNCTION(osr_isprojected);
PHP_FUNCTION(osr_isgeocentric);
PHP_FUNCTION(osr_isvertical);
PHP_FUNCTION(osr_issamegeogcs);
PHP_FUNCTION(osr_issame);
PHP_FUNCTION(osr_setfromuserinput);
PHP_FUNCTION(osr_gettowgs84);
PHP_FUNCTION(osr_getsemimajor);
PHP_FUNCTION(osr_getsemiminor);
PHP_FUNCTION(osr_getinvflattening);
PHP_FUNCTION(osr_getauthoritycode);
PHP_FUNCTION(osr_getauthorityname);
PHP_FUNCTION(osr_getprojparm);
PHP_FUNCTION(osr_getnormprojparm);
PHP_FUNCTION(osr_getutmzone);
PHP_FUNCTION(osr_autoidentifyepsg);
PHP_FUNCTION(osr_epsgtreatsaslatlong);
PHP_FUNCTION(osr_getaxis);
PHP_FUNCTION(is_osr);

/*
 * Declaration of function signatures
 */

ZEND_BEGIN_ARG_INFO_EX(arginfo_cplerrorreset, 0, 0, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_cplgetlasterrorno, 0, 0, IS_LONG, NULL, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_cplgetlasterrortype, 0, 0, IS_LONG, NULL, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_cplgetlasterrormsg, 0, 0, IS_STRING, NULL, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_createfromwkb, 0, 3, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, wkb, IS_STRING, 0)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    ZEND_ARG_INFO(1, geom)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_createfromwkt, 0, 3, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, wkt, IS_STRING, 0)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    ZEND_ARG_INFO(1, geom)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_g_destroygeometry, 0, 0, 1)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_creategeometry, 0, 1, IS_REFERENCE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geomtype, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_getdimension, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_getcoordinatedimension, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_clone, 0, 1, IS_REFERENCE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_g_getenvelope, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    ZEND_ARG_INFO(1, envelope)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_importfromwkb, 0, 2, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, wkb, IS_STRING, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_exporttowkb, 0, 3, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, byteorder, IS_LONG, 0)
    ZEND_ARG_INFO(1, wkb)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_wkbsize, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_importfromwkt, 0, 2, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, wkb, IS_STRING, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_exporttowkt, 0, 2, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    ZEND_ARG_INFO(1, wkt)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_getgeometrytype, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_getgeometryname, 0, 1, IS_STRING, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_g_dumpreadable, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, file, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, prefix, IS_STRING, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_g_flattento2d, 0, 0, 1)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_g_assignspatialreference, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_getspatialreference, 0, 1, IS_REFERENCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_transform, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, transformation, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_transformto, 0, 2, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_intersect, 0, 2, _IS_BOOL, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, othergeom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_equal, 0, 2, _IS_BOOL, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, othergeom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_empty, 0, 1, _IS_BOOL, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_getpointcount, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_getx, 0, 2, IS_DOUBLE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_gety, 0, 2, IS_DOUBLE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_getz, 0, 2, IS_DOUBLE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_g_getpoint, 0, 0, 5)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
    ZEND_ARG_INFO(1, x)
    ZEND_ARG_INFO(1, y)
    ZEND_ARG_INFO(1, z)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_g_setpoint, 0, 0, 5)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, x, IS_DOUBLE, 0)
    _ZEND_ARG_TYPE_INFO(0, y, IS_DOUBLE, 0)
    _ZEND_ARG_TYPE_INFO(0, z, IS_DOUBLE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_g_addpoint, 0, 0, 4)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, x, IS_DOUBLE, 0)
    _ZEND_ARG_TYPE_INFO(0, y, IS_DOUBLE, 0)
    _ZEND_ARG_TYPE_INFO(0, z, IS_DOUBLE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_getgeometrycount, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_getgeometryref, 0, 2, IS_REFERENCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_addgeometry, 0, 2, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, othergeom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_g_removegeometry, 0, 3, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, delete, _IS_BOOL, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogrbuildpolygonfromedges, 0, 5, IS_REFERENCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, linesascollection, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, besteffort, _IS_BOOL, 0)
    _ZEND_ARG_TYPE_INFO(0, autoclose, _IS_BOOL, 0)
    _ZEND_ARG_TYPE_INFO(0, autoclose, IS_DOUBLE, 0)
    ZEND_ARG_INFO(1, error)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fld_create, 0, 2, IS_REFERENCE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, name, IS_STRING, 0)
    _ZEND_ARG_TYPE_INFO(0, fieldtype, IS_LONG, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_fld_destroy, 0, 0, 1)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_fld_setname, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, name, IS_STRING, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fld_getnameref, 0, 1, IS_STRING, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fld_gettype, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_fld_settype, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, fieldtype, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fld_getjustify, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_fld_setjustify, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, justify, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fld_getwidth, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_fld_setwidth, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, width, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fld_getprecision, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_fld_setprecision, 0, 0, 0)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, precision, IS_LONG, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_fld_set, 0, 0, 6)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, name, IS_STRING, 0)
    _ZEND_ARG_TYPE_INFO(0, fieldtype, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, width, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, precision, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, justify, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_getfieldtypename, 0, 1, IS_STRING, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fd_create, 0, 1, IS_RESOURCE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, name, IS_STRING, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_fd_destroy, 0, 0, 1)
    _ZEND_ARG_TYPE_INFO(0, featuredefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fd_getname, 0, 1, IS_STRING, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, featuredefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fd_getfieldcount, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, featuredefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fd_getfielddefn, 0, 2, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, featuredefn, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fd_getfieldindex, 0, 2, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, featuredefn, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, fieldname, IS_STRING, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_fd_addfielddefn, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, featuredefn, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fd_getgeomtype, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, featuredefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_fd_setgeomtype, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, featuredefn, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, geomtype, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fd_reference, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, featuredefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fd_dereference, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, featuredefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_fd_getreferencecount, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, featuredefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_create, 0, 1, IS_RESOURCE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, featuredefn, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_f_destroy, 0, 0, 1)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getdefnref, 0, 1, IS_RESOURCE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_setgeometry, 0, 2, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, geom, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getgeometryref, 0, 1, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_clone, 0, 1, IS_RESOURCE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_equal, 0, 2, _IS_BOOL, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, otherfeature, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getfieldcount, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getfielddefnref, 0, 2, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getfieldindex, 0, 2, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, fieldname, IS_STRING, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_isfieldset, 0, 2, _IS_BOOL, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_f_unsetfield, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getrawfieldref, 0, 2, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getfieldasinteger, 0, 2, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getfieldasdouble, 0, 2, IS_DOUBLE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getfieldasstring, 0, 2, IS_STRING, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getfieldasintegerlist, 0, 2, IS_ARRAY, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
    ZEND_ARG_INFO(1, count)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getfieldasdoublelist, 0, 2, IS_ARRAY, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
    ZEND_ARG_INFO(1, count)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getfieldasstringlist, 0, 2, IS_ARRAY, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getfieldasdatetime, 0, 2, IS_ARRAY, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_f_setfieldinteger, 0, 0, 3)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, value, IS_LONG, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_f_setfielddouble, 0, 0, 3)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, value, IS_DOUBLE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_f_setfieldstring, 0, 0, 4)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, value, IS_STRING, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_f_setfieldintegerlist, 0, 0, 4)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, count, IS_LONG, 0)
    ZEND_ARG_ARRAY_INFO(0, value, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_f_setfielddoublelist, 0, 0, 4)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, count, IS_LONG, 0)
    ZEND_ARG_ARRAY_INFO(0, value, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_f_setfieldstringlist, 0, 0, 3)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
    ZEND_ARG_ARRAY_INFO(0, value, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_f_setfielddatetime, 0, 0, 3)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, year, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, month, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, day, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, hour, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, minute, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, second, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, tzflag, IS_LONG, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_f_setfieldraw, 0, 0, 3)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
    _ZEND_ARG_TYPE_INFO(0, field, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getfid, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_setfid, 0, 2, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, fid, IS_LONG, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_f_dumpreadable, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, file, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_setfrom, 0, 3, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, otherfeature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, forgiving, _IS_BOOL, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_f_getstylestring, 0, 1, IS_STRING, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_f_setstylestring, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, style, IS_STRING, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_getspatialfilter, 0, 1, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_l_setspatialfilter, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, filtergeom, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_setattributefilter, 0, 2, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, query, IS_STRING, 1)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_l_resetreading, 0, 0, 1)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_getnextfeature, 0, 1, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_getfeature, 0, 2, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, featureid, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_setfeature, 0, 2, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_createfeature, 0, 2, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, feature, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_deletefeature, 0, 2, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, featureid, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_getlayerdefn, 0, 1, IS_RESOURCE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_getspatialref, 0, 1, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_getfeaturecount, 0, 2, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, force, _IS_BOOL, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_getextent, 0, 3, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
    ZEND_ARG_INFO(1, extent)
    _ZEND_ARG_TYPE_INFO(0, force, _IS_BOOL, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_testcapability, 0, 2, _IS_BOOL, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, capability, IS_STRING, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_createfield, 0, 3, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, fielddefn, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, approxok, _IS_BOOL, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_starttransaction, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_committransaction, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_l_rollbacktransaction, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_ds_destroy, 0, 0, 1)
    _ZEND_ARG_TYPE_INFO(0, datasource, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_ds_getname, 0, 1, IS_STRING, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, datasource, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_ds_getlayercount, 0, 1, IS_LONG, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, datasource, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_ds_getlayer, 0, 2, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, datasource, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_ds_getlayerbyname, 0, 2, IS_RESOURCE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, datasource, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, name, IS_STRING, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_ds_createlayer, 0, 5, IS_RESOURCE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, datasource, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, name, IS_STRING, 0)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, geomtype, IS_LONG, 0)
    ZEND_ARG_ARRAY_INFO(0, options, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_ds_testcapability, 0, 2, _IS_BOOL, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, datasource, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, capabilitiy, IS_STRING, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_ds_executesql, 0, 4, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, datasource, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, sql, IS_STRING, 0)
    _ZEND_ARG_TYPE_INFO(0, filtergeom, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, dialect, IS_STRING, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogr_ds_releaseresultset, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, datasource, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, layer, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_ds_getdriver, 0, 1, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, datasource, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_dr_getname, 0, 1, IS_STRING, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, driver, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_dr_open, 0, 3, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, driver, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, name, IS_STRING, 0)
    _ZEND_ARG_TYPE_INFO(0, update, _IS_BOOL, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_dr_testcapability, 0, 2, _IS_BOOL, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, driver, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, capabilitiy, IS_STRING, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogr_dr_createdatasource, 0, 3, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, driver, IS_RESOURCE, 0)
    _ZEND_ARG_TYPE_INFO(0, name, IS_STRING, 0)
    ZEND_ARG_ARRAY_INFO(0, options, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogropen, 0, 2, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, name, IS_STRING, 0)
    _ZEND_ARG_TYPE_INFO(0, update, _IS_BOOL, 0)
    ZEND_ARG_INFO(1, driver)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogrregisterdriver, 0, 0, 1)
    _ZEND_ARG_TYPE_INFO(0, driver, IS_RESOURCE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogrgetdrivercount, 0, 0, IS_LONG, NULL, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogrgetdriver, 0, 1, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, i, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_ogrgetdriverbyname, 0, 1, IS_RESOURCE, NULL, 0)
    _ZEND_ARG_TYPE_INFO(0, name, IS_STRING, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ogrregisterall, 0, 0, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_newspatialreference, 0, 1, IS_RESOURCE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, data, IS_STRING, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_osr_destroyspatialreference, 0, 0, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_reference, 0, 1, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_dereference, 0, 1, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_osr_release, 0, 0, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_validate, 0, 1, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_fixupordering, 0, 1, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_fixup, 0, 1, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_stripctparms, 0, 1, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_importfromepsg, 0, 2, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, code, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_importfromepsga, 0, 2, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, code, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_importfromwkt, 0, 2, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, wkt, IS_STRING, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_importfromproj4, 0, 2, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, proj, IS_STRING, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_importfromesri, 0, 2, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    ZEND_ARG_ARRAY_INFO(0, prj, 1)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_osr_exporttowkt, 0, 0, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_osr_exporttoprettywkt, 0, 0, 2)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, simplify, _IS_BOOL, 1)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_osr_exporttoproj4, 0, 0, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_morphtoesri, 0, 1, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_morphfromesri, 0, 1, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_getattrvalue, 0, 2, IS_STRING, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, nodename, IS_STRING, 0)
    _ZEND_ARG_TYPE_INFO(0, attr, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_getangularunits, 0, 1, IS_ARRAY, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_getlinearunits, 0, 1, IS_ARRAY, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_getprimemeridian, 0, 1, IS_ARRAY, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_isgeographic, 0, 1, _IS_BOOL, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_islocal, 0, 1, _IS_BOOL, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_isprojected, 0, 1, _IS_BOOL, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_isgeocentric, 0, 1, _IS_BOOL, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_isvertical, 0, 1, _IS_BOOL, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_issamegeogcs, 0, 2, _IS_BOOL, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, othersrs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_issame, 0, 2, _IS_BOOL, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, othersrs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_setfromuserinput, 0, 2, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, data, IS_STRING, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_gettowgs84, 0, 1, IS_ARRAY, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_getsemimajor, 0, 1, IS_DOUBLE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_getsemiminor, 0, 1, IS_DOUBLE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_getinvflattening, 0, 1, IS_DOUBLE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_getauthoritycode, 0, 2, IS_STRING, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, targetkey, IS_STRING, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_getauthorityname, 0, 2, IS_STRING, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, targetkey, IS_STRING, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_getprojparm, 0, 2, IS_DOUBLE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, name, IS_STRING, 0)
    _ZEND_ARG_TYPE_INFO(0, defaultvalue, IS_DOUBLE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_getnormprojparm, 0, 2, IS_DOUBLE, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, name, IS_STRING, 0)
    _ZEND_ARG_TYPE_INFO(0, defaultvalue, IS_DOUBLE, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_getutmzone, 0, 1, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_autoidentifyepsg, 0, 1, IS_LONG, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_epsgtreatsaslatlong, 0, 1, _IS_BOOL, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_osr_getaxis, 0, 3, IS_ARRAY, NULL, 1)
    _ZEND_ARG_TYPE_INFO(0, srs, IS_RESOURCE, 1)
    _ZEND_ARG_TYPE_INFO(0, targetkey, IS_STRING, 0)
    _ZEND_ARG_TYPE_INFO(0, axis, IS_LONG, 0)
ZEND_END_ARG_INFO()

_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_is_osr, 0, 1, _IS_BOOL, NULL, 0)
    ZEND_ARG_INFO(0, value)
ZEND_END_ARG_INFO()

/*
 * Every user visible function must have an entry in ogr_functions[]
 */
static const zend_function_entry ogr_functions[] = {
    PHP_FE(cplerrorreset, arginfo_cplerrorreset)
    PHP_FE(cplgetlasterrorno, arginfo_cplgetlasterrorno)
    PHP_FE(cplgetlasterrortype, arginfo_cplgetlasterrortype)
    PHP_FE(cplgetlasterrormsg, arginfo_cplgetlasterrormsg)
    PHP_FE(ogr_g_createfromwkb, arginfo_ogr_g_createfromwkb)
    PHP_FE(ogr_g_createfromwkt, arginfo_ogr_g_createfromwkt)
    PHP_FE(ogr_g_destroygeometry, arginfo_ogr_g_destroygeometry)
    PHP_FE(ogr_g_creategeometry, arginfo_ogr_g_creategeometry)
    PHP_FE(ogr_g_getdimension, arginfo_ogr_g_getdimension)
    PHP_FE(ogr_g_getcoordinatedimension, arginfo_ogr_g_getcoordinatedimension)
    PHP_FE(ogr_g_clone, arginfo_ogr_g_clone)
    PHP_FE(ogr_g_getenvelope, arginfo_ogr_g_getenvelope)
    PHP_FE(ogr_g_importfromwkb, arginfo_ogr_g_importfromwkb)
    PHP_FE(ogr_g_exporttowkb, arginfo_ogr_g_exporttowkb)
    PHP_FE(ogr_g_wkbsize, arginfo_ogr_g_wkbsize)
    PHP_FE(ogr_g_importfromwkt, arginfo_ogr_g_importfromwkt)
    PHP_FE(ogr_g_exporttowkt, arginfo_ogr_g_exporttowkt)
    PHP_FE(ogr_g_getgeometrytype, arginfo_ogr_g_getgeometrytype)
    PHP_FE(ogr_g_getgeometryname, arginfo_ogr_g_getgeometryname)
    PHP_FE(ogr_g_dumpreadable, arginfo_ogr_g_dumpreadable)
    PHP_FE(ogr_g_flattento2d, arginfo_ogr_g_flattento2d)
    PHP_FE(ogr_g_assignspatialreference, arginfo_ogr_g_assignspatialreference)
    PHP_FE(ogr_g_getspatialreference, arginfo_ogr_g_getspatialreference)
    PHP_FE(ogr_g_transform, arginfo_ogr_g_transform)
    PHP_FE(ogr_g_transformto, arginfo_ogr_g_transformto)
    PHP_FE(ogr_g_intersect, arginfo_ogr_g_intersect)
    PHP_FE(ogr_g_equal, arginfo_ogr_g_equal)
    PHP_FE(ogr_g_empty, arginfo_ogr_g_empty)
    PHP_FE(ogr_g_getpointcount, arginfo_ogr_g_getpointcount)
    PHP_FE(ogr_g_getx, arginfo_ogr_g_getx)
    PHP_FE(ogr_g_gety, arginfo_ogr_g_gety)
    PHP_FE(ogr_g_getz, arginfo_ogr_g_getz)
    PHP_FE(ogr_g_getpoint, arginfo_ogr_g_getpoint)
    PHP_FE(ogr_g_setpoint, arginfo_ogr_g_setpoint)
    PHP_FE(ogr_g_addpoint, arginfo_ogr_g_addpoint)
    PHP_FE(ogr_g_getgeometrycount, arginfo_ogr_g_getgeometrycount)
    PHP_FE(ogr_g_getgeometryref, arginfo_ogr_g_getgeometryref)
    PHP_FE(ogr_g_addgeometry, arginfo_ogr_g_addgeometry)
    PHP_FE(ogr_g_removegeometry, arginfo_ogr_g_removegeometry)
    PHP_FE(ogrbuildpolygonfromedges, arginfo_ogrbuildpolygonfromedges)
    PHP_FE(ogr_fld_create, arginfo_ogr_fld_create)
    PHP_FE(ogr_fld_destroy, arginfo_ogr_fld_destroy)
    PHP_FE(ogr_fld_setname, arginfo_ogr_fld_setname)
    PHP_FE(ogr_fld_getnameref, arginfo_ogr_fld_getnameref)
    PHP_FE(ogr_fld_gettype, arginfo_ogr_fld_gettype)
    PHP_FE(ogr_fld_settype, arginfo_ogr_fld_settype)
    PHP_FE(ogr_fld_getjustify, arginfo_ogr_fld_getjustify)
    PHP_FE(ogr_fld_setjustify, arginfo_ogr_fld_setjustify)
    PHP_FE(ogr_fld_getwidth, arginfo_ogr_fld_getwidth)
    PHP_FE(ogr_fld_setwidth, arginfo_ogr_fld_setwidth)
    PHP_FE(ogr_fld_getprecision, arginfo_ogr_fld_getprecision)
    PHP_FE(ogr_fld_setprecision, arginfo_ogr_fld_setprecision)
    PHP_FE(ogr_fld_set, arginfo_ogr_fld_set)
    PHP_FE(ogr_getfieldtypename, arginfo_ogr_getfieldtypename)
    PHP_FE(ogr_fd_create, arginfo_ogr_fd_create)
    PHP_FE(ogr_fd_destroy, arginfo_ogr_fd_destroy)
    PHP_FE(ogr_fd_getname, arginfo_ogr_fd_getname)
    PHP_FE(ogr_fd_getfieldcount, arginfo_ogr_fd_getfieldcount)
    PHP_FE(ogr_fd_getfielddefn, arginfo_ogr_fd_getfielddefn)
    PHP_FE(ogr_fd_getfieldindex, arginfo_ogr_fd_getfieldindex)
    PHP_FE(ogr_fd_addfielddefn, arginfo_ogr_fd_addfielddefn)
    PHP_FE(ogr_fd_getgeomtype, arginfo_ogr_fd_getgeomtype)
    PHP_FE(ogr_fd_setgeomtype, arginfo_ogr_fd_setgeomtype)
    PHP_FE(ogr_fd_reference, arginfo_ogr_fd_reference)
    PHP_FE(ogr_fd_dereference, arginfo_ogr_fd_dereference)
    PHP_FE(ogr_fd_getreferencecount, arginfo_ogr_fd_getreferencecount)
    PHP_FE(ogr_f_create, arginfo_ogr_f_create)
    PHP_FE(ogr_f_destroy, arginfo_ogr_f_destroy)
    PHP_FE(ogr_f_getdefnref, arginfo_ogr_f_getdefnref)
    PHP_FE(ogr_f_setgeometry, arginfo_ogr_f_setgeometry)
    PHP_FE(ogr_f_getgeometryref, arginfo_ogr_f_getgeometryref)
    PHP_FE(ogr_f_clone, arginfo_ogr_f_clone)
    PHP_FE(ogr_f_equal, arginfo_ogr_f_equal)
    PHP_FE(ogr_f_getfieldcount, arginfo_ogr_f_getfieldcount)
    PHP_FE(ogr_f_getfielddefnref, arginfo_ogr_f_getfielddefnref)
    PHP_FE(ogr_f_getfieldindex, arginfo_ogr_f_getfieldindex)
    PHP_FE(ogr_f_isfieldset, arginfo_ogr_f_isfieldset)
    PHP_FE(ogr_f_unsetfield, arginfo_ogr_f_unsetfield)
    PHP_FE(ogr_f_getrawfieldref, arginfo_ogr_f_getrawfieldref)
    PHP_FE(ogr_f_getfieldasinteger, arginfo_ogr_f_getfieldasinteger)
    PHP_FE(ogr_f_getfieldasdouble, arginfo_ogr_f_getfieldasdouble)
    PHP_FE(ogr_f_getfieldasstring, arginfo_ogr_f_getfieldasstring)
    PHP_FE(ogr_f_getfieldasintegerlist, arginfo_ogr_f_getfieldasintegerlist)
    PHP_FE(ogr_f_getfieldasdoublelist, arginfo_ogr_f_getfieldasdoublelist)
    PHP_FE(ogr_f_getfieldasstringlist, arginfo_ogr_f_getfieldasstringlist)
    PHP_FE(ogr_f_getfieldasdatetime, arginfo_ogr_f_getfieldasdatetime)
    PHP_FE(ogr_f_setfieldinteger, arginfo_ogr_f_setfieldinteger)
    PHP_FE(ogr_f_setfielddouble, arginfo_ogr_f_setfielddouble)
    PHP_FE(ogr_f_setfieldstring, arginfo_ogr_f_setfieldstring)
    PHP_FE(ogr_f_setfieldintegerlist, arginfo_ogr_f_setfieldintegerlist)
    PHP_FE(ogr_f_setfielddoublelist, arginfo_ogr_f_setfielddoublelist)
    PHP_FE(ogr_f_setfieldstringlist, arginfo_ogr_f_setfieldstringlist)
    PHP_FE(ogr_f_setfielddatetime, arginfo_ogr_f_setfielddatetime)
    PHP_FE(ogr_f_setfieldraw, arginfo_ogr_f_setfieldraw)
    PHP_FE(ogr_f_getfid, arginfo_ogr_f_getfid)
    PHP_FE(ogr_f_setfid, arginfo_ogr_f_setfid)
    PHP_FE(ogr_f_dumpreadable, arginfo_ogr_f_dumpreadable)
    PHP_FE(ogr_f_setfrom, arginfo_ogr_f_setfrom)
    PHP_FE(ogr_f_getstylestring, arginfo_ogr_f_getstylestring)
    PHP_FE(ogr_f_setstylestring, arginfo_ogr_f_setstylestring)
    PHP_FE(ogr_l_getspatialfilter, arginfo_ogr_l_getspatialfilter)
    PHP_FE(ogr_l_setspatialfilter, arginfo_ogr_l_setspatialfilter)
    PHP_FE(ogr_l_setattributefilter, arginfo_ogr_l_setattributefilter)
    PHP_FE(ogr_l_resetreading, arginfo_ogr_l_resetreading)
    PHP_FE(ogr_l_getnextfeature, arginfo_ogr_l_getnextfeature)
    PHP_FE(ogr_l_getfeature, arginfo_ogr_l_getfeature)
    PHP_FE(ogr_l_setfeature, arginfo_ogr_l_setfeature)
    PHP_FE(ogr_l_createfeature, arginfo_ogr_l_createfeature)
    PHP_FE(ogr_l_deletefeature, arginfo_ogr_l_deletefeature)
    PHP_FE(ogr_l_getlayerdefn, arginfo_ogr_l_getlayerdefn)
    PHP_FE(ogr_l_getspatialref, arginfo_ogr_l_getspatialref)
    PHP_FE(ogr_l_getfeaturecount, arginfo_ogr_l_getfeaturecount)
    PHP_FE(ogr_l_getextent, arginfo_ogr_l_getextent)
    PHP_FE(ogr_l_testcapability, arginfo_ogr_l_testcapability)
    PHP_FE(ogr_l_createfield, arginfo_ogr_l_createfield)
    PHP_FE(ogr_l_starttransaction, arginfo_ogr_l_starttransaction)
    PHP_FE(ogr_l_committransaction, arginfo_ogr_l_committransaction)
    PHP_FE(ogr_l_rollbacktransaction, arginfo_ogr_l_rollbacktransaction)
    PHP_FE(ogr_ds_destroy, arginfo_ogr_ds_destroy)
    PHP_FE(ogr_ds_getname, arginfo_ogr_ds_getname)
    PHP_FE(ogr_ds_getlayercount, arginfo_ogr_ds_getlayercount)
    PHP_FE(ogr_ds_getlayer, arginfo_ogr_ds_getlayer)
    PHP_FE(ogr_ds_getlayerbyname, arginfo_ogr_ds_getlayerbyname)
    PHP_FE(ogr_ds_createlayer, arginfo_ogr_ds_createlayer)
    PHP_FE(ogr_ds_testcapability, arginfo_ogr_ds_testcapability)
    PHP_FE(ogr_ds_executesql, arginfo_ogr_ds_executesql)
    PHP_FE(ogr_ds_releaseresultset, arginfo_ogr_ds_releaseresultset)
    PHP_FE(ogr_ds_getdriver, arginfo_ogr_ds_getdriver)
    PHP_FE(ogr_dr_getname, arginfo_ogr_dr_getname)
    PHP_FE(ogr_dr_open, arginfo_ogr_dr_open)
    PHP_FE(ogr_dr_testcapability, arginfo_ogr_dr_testcapability)
    PHP_FE(ogr_dr_createdatasource, arginfo_ogr_dr_createdatasource)
    PHP_FE(ogropen, arginfo_ogropen)
    PHP_FE(ogrregisterdriver, arginfo_ogrregisterdriver)
    PHP_FE(ogrgetdrivercount, arginfo_ogrgetdrivercount)
    PHP_FE(ogrgetdriver, arginfo_ogrgetdriver)
    PHP_FE(ogrgetdriverbyname, arginfo_ogrgetdriverbyname)
    PHP_FE(ogrregisterall, arginfo_ogrregisterall)
    PHP_FE(osr_newspatialreference, arginfo_osr_newspatialreference)
    PHP_FE(osr_destroyspatialreference, arginfo_osr_destroyspatialreference)
    PHP_FE(osr_reference, arginfo_osr_reference)
    PHP_FE(osr_dereference, arginfo_osr_dereference)
    PHP_FE(osr_release, arginfo_osr_release)
    PHP_FE(osr_validate, arginfo_osr_validate)
    PHP_FE(osr_fixupordering, arginfo_osr_fixupordering)
    PHP_FE(osr_fixup, arginfo_osr_fixup)
    PHP_FE(osr_stripctparms, arginfo_osr_stripctparms)
    PHP_FE(osr_importfromepsg, arginfo_osr_importfromepsg)
    PHP_FE(osr_importfromepsga, arginfo_osr_importfromepsga)
    PHP_FE(osr_importfromwkt, arginfo_osr_importfromwkt)
    PHP_FE(osr_importfromproj4, arginfo_osr_importfromproj4)
    PHP_FE(osr_importfromesri, arginfo_osr_importfromesri)
    PHP_FE(osr_exporttowkt, arginfo_osr_exporttowkt)
    PHP_FE(osr_exporttoprettywkt, arginfo_osr_exporttoprettywkt)
    PHP_FE(osr_exporttoproj4, arginfo_osr_exporttoproj4)
    PHP_FE(osr_morphtoesri, arginfo_osr_morphtoesri)
    PHP_FE(osr_morphfromesri, arginfo_osr_morphfromesri)
    PHP_FE(osr_getattrvalue, arginfo_osr_getattrvalue)
    PHP_FE(osr_getangularunits, arginfo_osr_getangularunits)
    PHP_FE(osr_getlinearunits, arginfo_osr_getlinearunits)
    PHP_FE(osr_getprimemeridian, arginfo_osr_getprimemeridian)
    PHP_FE(osr_isgeographic, arginfo_osr_isgeographic)
    PHP_FE(osr_islocal, arginfo_osr_islocal)
    PHP_FE(osr_isprojected, arginfo_osr_isprojected)
    PHP_FE(osr_isgeocentric, arginfo_osr_isgeocentric)
    PHP_FE(osr_isvertical, arginfo_osr_isvertical)
    PHP_FE(osr_issamegeogcs, arginfo_osr_issamegeogcs)
    PHP_FE(osr_issame, arginfo_osr_issame)
    PHP_FE(osr_setfromuserinput, arginfo_osr_setfromuserinput)
    PHP_FE(osr_gettowgs84, arginfo_osr_gettowgs84)
    PHP_FE(osr_getsemimajor, arginfo_osr_getsemimajor)
    PHP_FE(osr_getsemiminor, arginfo_osr_getsemiminor)
    PHP_FE(osr_getinvflattening, arginfo_osr_getinvflattening)
    PHP_FE(osr_getauthoritycode, arginfo_osr_getauthoritycode)
    PHP_FE(osr_getauthorityname, arginfo_osr_getauthorityname)
    PHP_FE(osr_getprojparm, arginfo_osr_getprojparm)
    PHP_FE(osr_getnormprojparm, arginfo_osr_getnormprojparm)
    PHP_FE(osr_getutmzone, arginfo_osr_getutmzone)
    PHP_FE(osr_autoidentifyepsg, arginfo_osr_autoidentifyepsg)
    PHP_FE(osr_epsgtreatsaslatlong, arginfo_osr_epsgtreatsaslatlong)
    PHP_FE(osr_getaxis, arginfo_osr_getaxis)
    PHP_FE(is_osr, arginfo_is_osr)
    PHP_FE_END  /* Must be the last line in ogr_functions[] */
};
/* }}} */
