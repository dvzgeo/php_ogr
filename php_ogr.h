/*
  +----------------------------------------------------------------------+
  | PHP Version 4                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2002 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 2.02 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available at through the world-wide-web at                           |
  | http://www.php.net/license/2_02.txt.                                 |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author:                                                              |
  +----------------------------------------------------------------------+

  $Id$ 
*/

#ifndef PHP_OGR_H
#define PHP_OGR_H

extern zend_module_entry ogr_module_entry;
#define phpext_ogr_ptr &ogr_module_entry

#ifdef PHP_WIN32
#define PHP_OGR_API __declspec(dllexport)
#else
#define PHP_OGR_API
#endif

#ifdef ZTS
#include "TSRM.h"
#endif

PHP_MINIT_FUNCTION(ogr);
PHP_MSHUTDOWN_FUNCTION(ogr);
PHP_RINIT_FUNCTION(ogr);
PHP_RSHUTDOWN_FUNCTION(ogr);
PHP_MINFO_FUNCTION(ogr);

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
  	Declare any global variables you may need between the BEGIN
	and END macros here:     

ZEND_BEGIN_MODULE_GLOBALS(ogr)
	int   global_value;
	char *global_string;
ZEND_END_MODULE_GLOBALS(ogr)
*/

/* In every utility function you add that needs to use variables 
   in php_ogr_globals, call TSRM_FETCH(); after declaring other 
   variables used by that function, or better yet, pass in TSRMLS_CC
   after the last function argument and declare your utility function
   with TSRMLS_DC after the last declared argument.  Always refer to
   the globals in your function as OGR_G(variable).  You are 
   encouraged to rename these macros something shorter, see
   examples in any other php module directory.
*/

#ifdef ZTS
#define OGR_G(v) TSRMG(ogr_globals_id, zend_ogr_globals *, v)
#else
#define OGR_G(v) (ogr_globals.v)
#endif

#endif	/* PHP_OGR_H */


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: t
 * End:
 */
