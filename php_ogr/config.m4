dnl $Id$
dnl config.m4 for extension ogr

PHP_ARG_WITH(ogr, for ogr support,
[  --with-ogr[=DIR]       Include OGR support (DIR=GDAL/OGR install dir.)])

if test "$PHP_OGR" != "no"; then


  dnl # --with-ogr -> check with-path
  SEARCH_PATH="/usr/local /usr"
  SEARCH_FOR="/include/ogr_api.h"

  if test -r $PHP_OGR/; then
    OGR_DIR=$PHP_OGR
  else # search default path list
    AC_MSG_CHECKING([for ORG files in default path])
    for i in $SEARCH_PATH ; do
      if test -r $i/$SEARCH_FOR; then
        OGR_DIR=$i
        AC_MSG_RESULT(found in $i)
      fi
    done
  fi

  if test -z "$OGR_DIR"; then
    AC_MSG_RESULT([not found])
    AC_MSG_ERROR([Please install the OGR distribution])
  fi

  if ${OGR_DIR}/bin/gdal-config --libs print > /dev/null 2>&1; then
    OGR_CONFIG=${OGR_DIR}/bin/gdal-config
  else
    if ${OGR_DIR}/gdal-config --libs print > /dev/null 2>&1; then
       OGR_CONFIG=${OGR_DIR}/gdal-config
    fi
  fi

  ogr_version_full=`$OGR_CONFIG --version`
  ogr_version=`echo ${ogr_version_full} | awk 'BEGIN { FS = "."; } { printf "%d", ($1 * 1000 + $2) * 1000 + $3;}'`
  if test "$ogr_version" -ge 1001008; then
    AC_MSG_RESULT($ogr_version_full)
    OGR_LIBS=`$OGR_CONFIG --libs`
    OGR_CFLAGS=`$OGR_CONFIG --cflags`
  else
    AC_MSG_ERROR(GDAL/OGR version 1.1.8 or later is required to compile php with OGR support)
  fi

  PHP_EVAL_INCLINE($OGR_CFLAGS)
  PHP_ADD_INCLUDE($OGR_DIR/include)
  PHP_EVAL_LIBLINE($OGR_LIBS, OGR_SHARED_LIBADD)

  if test x`$OGR_CONFIG --ogr-enabled` = "xyes" ; then
      AC_DEFINE(HAVE_OGR,1,[ ])
  else
      AC_MSG_ERROR(OGR support not found.  Please make sure your GDAL includes OGR support.)
  fi

  PHP_SUBST(OGR_SHARED_LIBADD)

  PHP_NEW_EXTENSION(ogr, ogr.c, $ext_shared)
  PHP_EXTENSION(ogr, $ext_shared)
fi
