/******************************************************************************
 * Project:  PHP Interface for OGR C API
 * Purpose:  Implementation of PHP wrapper functions.
 * Author:   Normand Savard, nsavard@dmsolutions.ca
 * Author:   Edward Nash, e.nash@dvz-mv.de (OSR binding/PHP7-compatibility)
 *
 ******************************************************************************
 * Copyright (c) 2003, DM Solutions Group Inc
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
