/******************************************************************************
 * Project:  PHP Interface for OGR C API
 * Purpose:  Shims for PHP5 and PHP7 compatibility
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


/* Shim macros ZEND_FETCH_RESOURCE and ZEND_FETCH_RESOURCE2 for PHP7 */
#if PHP_MAJOR_VERSION < 7
#define _ZEND_FETCH_RESOURCE(rsrc, rsrc_type, passed_id, default_id, resource_type_name, resource_type) \
    ZEND_FETCH_RESOURCE(rsrc, rsrc_type, &passed_id, default_id, resource_type_name, resource_type)
#define _ZEND_FETCH_RESOURCE2(rsrc, rsrc_type, passed_id, default_id, resource_type_name, resource_type1, resource_type2) \
    ZEND_FETCH_RESOURCE2(rsrc, rsrc_type, &passed_id, default_id, resource_type_name, resource_type1, resource_type2)
#else
#define _ZEND_FETCH_RESOURCE(rsrc, rsrc_type, passed_id, default_id, resource_type_name, resource_type) \
    rsrc = (rsrc_type) zend_fetch_resource(Z_RES_P(passed_id), resource_type_name, resource_type); \
    if (rsrc == NULL) RETURN_FALSE;
#define _ZEND_FETCH_RESOURCE2(rsrc, rsrc_type, passed_id, default_id, resource_type_name, resource_type1, resource_type2) \
   rsrc = (rsrc_type) zend_fetch_resource2(Z_RES_P(passed_id), resource_type_name, resource_type1, resource_type2); \
   if (rsrc == NULL) RETURN_FALSE;
#endif

/* Define macro ZEND_REGISTER_RESOURCE for PHP7 */
#if PHP_MAJOR_VERSION >= 7
#define ZEND_REGISTER_RESOURCE(zval, rsrc, resource_type) \
    ZVAL_RES(zval, zend_register_resource(rsrc, resource_type));
#endif

/* Shim function zend_list_delete for PHP7 */
#if PHP_MAJOR_VERSION < 7
#define _ZEND_FREE_RESOURCE(zv) zend_list_delete(Z_LVAL_P(zv))
#else
#define _ZEND_FREE_RESOURCE(zv) zend_list_close(Z_RES_P(zv))
#endif

/* shim ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX and ZEND_ARG_TYPE_INFO for PHP5 backwards compatibility */
#if PHP_MAJOR_VERSION < 7
#define _ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(name, return_reference, arginfo_required_num, type, class_name, allow_null) \
    ZEND_BEGIN_ARG_INFO_EX(name, return_reference, 0, arginfo_required_num)
#define _ZEND_ARG_TYPE_INFO(pass_by_ref, name, type_hint, allow_null) \
    ZEND_ARG_INFO(pass_by_ref, name)
#else
#define _ZEND_ARG_TYPE_INFO(pass_by_ref, name, type_hint, allow_null) \
    ZEND_ARG_TYPE_INFO(pass_by_ref, name, type_hint, allow_null)
/* class_name argument was removed in PHP 7.2 */
#if PHP_MINOR_VERSION < 2
#define _ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(name, return_reference, arginfo_required_num, type, class_name, allow_null) \
    ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(name, return_reference, arginfo_required_num, type, class_name, allow_null)
#else
#define _ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(name, return_reference, arginfo_required_num, type, class_name, allow_null) \
    ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(name, return_reference, arginfo_required_num, type, allow_null)
#endif
#endif

/* shim zend_rsrc_list_entry (PHP5) and zend_resource (PHP7) */
#if PHP_MAJOR_VERSION < 7
typedef zend_rsrc_list_entry zend_resource_t;
#else
typedef zend_resource zend_resource_t;
#endif

/* shim string handling functions */
#if PHP_MAJOR_VERSION < 7
#define _RETURN_DUPLICATED_STRING(str) RETURN_STRING(str, 1)
#define _ZVAL_STRING(zv, str) ZVAL_STRING(zv, str, 1)
#define _ZVAL_STRINGL(zv, str, len) ZVAL_STRINGL(zv, str, len, 1)
#define _ADD_ASSOC_STRING(zval, key, str) \
    add_assoc_string(zval, key, str, 1)
#define _ADD_NEXT_INDEX_STRING(zval, str) \
    add_next_index_string(zval, str, 1)
#else
#define _RETURN_DUPLICATED_STRING(str) \
    RETURN_STR(zend_string_init(str, strlen(str), 0))
#define _ZVAL_STRING(zv, str) ZVAL_STRING(zv, str)
#define _ZVAL_STRINGL(zv, str, len) ZVAL_STRINGL(zv, str, len)
#define _ADD_ASSOC_STRING(zval, key, str) \
    add_assoc_str(zval, key, zend_string_init(str, strlen(str), 0))
#define _ADD_NEXT_INDEX_STRING(zval, str) \
    add_next_index_str(zval, zend_string_init(str, strlen(str), 0))
#endif

/* shim usage of zend_list_find */
#if PHP_MAJOR_VERSION < 7
#define _ZEND_LIST_FINDD(zv, zvType) zend_list_find(Z_RESVAL_P(zv), &zvType)
#else
#define _ZEND_LIST_FINDD(zv, zvType) zvType = Z_RES_P(zv)->type
#endif

/* define shim macros for looping over a PHP array zval */
#if PHP_MAJOR_VERSION < 7
typedef zval** zval_loop_iterator_t;
#define _ZVAL_LOOP_ITERATOR_STRVAL(zv) Z_STRVAL_PP(zv)
#define _ZVAL_LOOP_ITERATOR_LVAL(zv) Z_LVAL_PP(zv)
#define _ZVAL_LOOP_ITERATOR_DVAL(zv) Z_DVAL_PP(zv)
#define _ZVAL_SIMPLE_LOOP_START(azv, izv) \
    zend_hash_internal_pointer_reset(Z_ARRVAL_P(azv)); \
    while (zend_hash_get_current_data(Z_ARRVAL_P(azv), (void **) &izv) == SUCCESS) {
#define _ZVAL_SIMPLE_LOOP_END(azv) \
        zend_hash_move_forward(Z_ARRVAL_P(azv)); \
    }
#else
typedef zval* zval_loop_iterator_t;
#define _ZVAL_LOOP_ITERATOR_STRVAL(zv) Z_STRVAL_P(zv)
#define _ZVAL_LOOP_ITERATOR_LVAL(zv) Z_LVAL_P(zv)
#define _ZVAL_LOOP_ITERATOR_DVAL(zv) Z_DVAL_P(zv)
#define _ZVAL_SIMPLE_LOOP_START(azv, izv) \
    ZEND_HASH_FOREACH_VAL(Z_ARRVAL_P(azv), izv) {
#define _ZVAL_SIMPLE_LOOP_END(azv) \
    } ZEND_HASH_FOREACH_END();
#endif

/* shim php_stream_from_zval */
#if PHP_MAJOR_VERSION < 7
#define _PHP_STREAM_FROM_ZVAL(stream, hfile) php_stream_from_zval(stream, &hfile)
#else
#define _PHP_STREAM_FROM_ZVAL(stream, hfile) php_stream_from_zval(stream, hfile)
#endif

/* shim zend_long for PHP 5 */
#if PHP_MAJOR_VERSION < 7
typedef long zend_long;
#endif

/* shim zval string length type */
#if PHP_MAJOR_VERSION < 7
typedef int strsize_t;
#else
typedef size_t strsize_t;
#endif

/* shim zval_ptr_dtor */
#if PHP_MAJOR_VERSION < 7
#define _ZVAL_PTR_DTOR(__zval) zval_dtor(__zval)
#else
#define _ZVAL_PTR_DTOR(__zval) zval_ptr_dtor(__zval)
#endif
