<?php
/******************************************************************************
 * Project:  PHP Interface for OGR C API
 * Purpose:  Extension function stubs as PHP file
 * Author:   Edward Nash, e.nash@dvz-mv.de
 *
 ******************************************************************************
 * Copyright (c) 2019-2021, DVZ Datenverarbeitungszentrum Mecklenburg-Vorpommern GmbH
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

/* following lines generated using _generator.php */

/**
 */
function cplerrorreset()
{
}


/**
 * @return int
 */
function cplgetlasterrorno()
{
}


/**
 * @return int
 */
function cplgetlasterrortype()
{
}


/**
 * @return string
 */
function cplgetlasterrormsg()
{
}


/**
 * @param string $wkb
 * @param resource $srs
 * @param mixed $geom (by reference)
 * @return int
 */
function ogr_g_createfromwkb($wkb, $srs, &$geom)
{
}


/**
 * @param string $wkt
 * @param resource $srs
 * @param mixed $geom (by reference)
 * @return int
 */
function ogr_g_createfromwkt($wkt, $srs, &$geom)
{
}


/**
 * @param resource $geom
 */
function ogr_g_destroygeometry($geom)
{
}


/**
 * @param int $geomtype
 * @return reference
 */
function ogr_g_creategeometry($geomtype)
{
}


/**
 * @param resource $geom
 * @return int
 */
function ogr_g_getdimension($geom)
{
}


/**
 * @param resource $geom
 * @return int
 */
function ogr_g_getcoordinatedimension($geom)
{
}


/**
 * @param resource $geom
 * @return reference
 */
function ogr_g_clone($geom)
{
}


/**
 * @param resource $geom
 * @param mixed $envelope (by reference)
 */
function ogr_g_getenvelope($geom, &$envelope)
{
}


/**
 * @param resource $geom
 * @param string $wkb
 * @return int
 */
function ogr_g_importfromwkb($geom, $wkb)
{
}


/**
 * @param resource $geom
 * @param int $byteorder
 * @param mixed $wkb (by reference)
 * @return int
 */
function ogr_g_exporttowkb($geom, $byteorder, &$wkb)
{
}


/**
 * @param resource $geom
 * @return int
 */
function ogr_g_wkbsize($geom)
{
}


/**
 * @param resource $geom
 * @param string $wkb
 * @return int
 */
function ogr_g_importfromwkt($geom, $wkb)
{
}


/**
 * @param resource $geom
 * @param mixed $wkt (by reference)
 * @return int
 */
function ogr_g_exporttowkt($geom, &$wkt)
{
}


/**
 * @param resource $geom
 * @return int
 */
function ogr_g_getgeometrytype($geom)
{
}


/**
 * @param resource $geom
 * @return string
 */
function ogr_g_getgeometryname($geom)
{
}


/**
 * @param resource $geom
 * @param resource $file
 * @param string $prefix
 */
function ogr_g_dumpreadable($geom, $file, $prefix = null)
{
}


/**
 * @param resource $geom
 */
function ogr_g_flattento2d($geom)
{
}


/**
 * @param resource $geom
 * @param resource $srs
 */
function ogr_g_assignspatialreference($geom, $srs)
{
}


/**
 * @param resource $geom
 * @return reference
 */
function ogr_g_getspatialreference($geom)
{
}


/**
 * @param resource $geom
 * @param resource $transformation
 * @return int
 */
function ogr_g_transform($geom, $transformation = null)
{
}


/**
 * @param resource $geom
 * @param resource $srs
 * @return int
 */
function ogr_g_transformto($geom, $srs)
{
}


/**
 * @param resource $geom
 * @param resource $othergeom
 * @return bool
 */
function ogr_g_intersect($geom, $othergeom)
{
}


/**
 * @param resource $geom
 * @param resource $othergeom
 * @return bool
 */
function ogr_g_equal($geom, $othergeom)
{
}


/**
 * @param resource $geom
 * @return bool
 */
function ogr_g_empty($geom)
{
}


/**
 * @param resource $geom
 * @return int
 */
function ogr_g_getpointcount($geom)
{
}


/**
 * @param resource $geom
 * @param int $i
 * @return double
 */
function ogr_g_getx($geom, $i)
{
}


/**
 * @param resource $geom
 * @param int $i
 * @return double
 */
function ogr_g_gety($geom, $i)
{
}


/**
 * @param resource $geom
 * @param int $i
 * @return double
 */
function ogr_g_getz($geom, $i)
{
}


/**
 * @param resource $geom
 * @param int $i
 * @param mixed $x (by reference)
 * @param mixed $y (by reference)
 * @param mixed $z (by reference)
 */
function ogr_g_getpoint($geom, $i, &$x, &$y, &$z)
{
}


/**
 * @param resource $geom
 * @param int $i
 * @param double $x
 * @param double $y
 * @param double $z
 */
function ogr_g_setpoint($geom, $i, $x, $y, $z)
{
}


/**
 * @param resource $geom
 * @param double $x
 * @param double $y
 * @param double $z
 */
function ogr_g_addpoint($geom, $x, $y, $z)
{
}


/**
 * @param resource $geom
 * @return int
 */
function ogr_g_getgeometrycount($geom)
{
}


/**
 * @param resource $geom
 * @param int $i
 * @return reference
 */
function ogr_g_getgeometryref($geom, $i)
{
}


/**
 * @param resource $geom
 * @param resource $othergeom
 * @return int
 */
function ogr_g_addgeometry($geom, $othergeom)
{
}


/**
 * @param resource $geom
 * @param int $i
 * @param bool $delete
 * @return int
 */
function ogr_g_removegeometry($geom, $i, $delete)
{
}


/**
 * @param resource $linesascollection
 * @param bool $besteffort
 * @param double $autoclose
 * @param mixed $error (by reference)
 * @return reference
 */
function ogrbuildpolygonfromedges($linesascollection, $besteffort, $autoclose, &$error)
{
}


/**
 * @param string $name
 * @param int $fieldtype
 * @return reference
 */
function ogr_fld_create($name, $fieldtype)
{
}


/**
 * @param resource $fielddefn
 */
function ogr_fld_destroy($fielddefn)
{
}


/**
 * @param resource $fielddefn
 * @param string $name
 */
function ogr_fld_setname($fielddefn, $name)
{
}


/**
 * @param resource $fielddefn
 * @return string
 */
function ogr_fld_getnameref($fielddefn)
{
}


/**
 * @param resource $fielddefn
 * @return int
 */
function ogr_fld_gettype($fielddefn)
{
}


/**
 * @param resource $fielddefn
 * @param int $fieldtype
 */
function ogr_fld_settype($fielddefn, $fieldtype)
{
}


/**
 * @param resource $fielddefn
 * @return int
 */
function ogr_fld_getjustify($fielddefn)
{
}


/**
 * @param resource $fielddefn
 * @param int $justify
 */
function ogr_fld_setjustify($fielddefn, $justify)
{
}


/**
 * @param resource $fielddefn
 * @return int
 */
function ogr_fld_getwidth($fielddefn)
{
}


/**
 * @param resource $fielddefn
 * @param int $width
 */
function ogr_fld_setwidth($fielddefn, $width)
{
}


/**
 * @param resource $fielddefn
 * @return int
 */
function ogr_fld_getprecision($fielddefn)
{
}


/**
 * @param resource $fielddefn
 * @param int $precision
 */
function ogr_fld_setprecision($fielddefn = null, $precision = null)
{
}


/**
 * @param resource $fielddefn
 * @param string $name
 * @param int $fieldtype
 * @param int $width
 * @param int $precision
 * @param int $justify
 */
function ogr_fld_set($fielddefn, $name, $fieldtype, $width, $precision, $justify)
{
}


/**
 * @param int $fielddefn
 * @return string
 */
function ogr_getfieldtypename($fielddefn)
{
}


/**
 * @param string $name
 * @return resource
 */
function ogr_fd_create($name)
{
}


/**
 * @param resource $featuredefn
 */
function ogr_fd_destroy($featuredefn)
{
}


/**
 * @param resource $featuredefn
 * @return string
 */
function ogr_fd_getname($featuredefn)
{
}


/**
 * @param resource $featuredefn
 * @return int
 */
function ogr_fd_getfieldcount($featuredefn)
{
}


/**
 * @param resource $featuredefn
 * @param int $i
 * @return resource
 */
function ogr_fd_getfielddefn($featuredefn, $i)
{
}


/**
 * @param resource $featuredefn
 * @param string $fieldname
 * @return int
 */
function ogr_fd_getfieldindex($featuredefn, $fieldname)
{
}


/**
 * @param resource $featuredefn
 * @param resource $fielddefn
 */
function ogr_fd_addfielddefn($featuredefn, $fielddefn)
{
}


/**
 * @param resource $featuredefn
 * @return int
 */
function ogr_fd_getgeomtype($featuredefn)
{
}


/**
 * @param resource $featuredefn
 * @param int $geomtype
 */
function ogr_fd_setgeomtype($featuredefn, $geomtype)
{
}


/**
 * @param resource $featuredefn
 * @return int
 */
function ogr_fd_reference($featuredefn)
{
}


/**
 * @param resource $featuredefn
 * @return int
 */
function ogr_fd_dereference($featuredefn)
{
}


/**
 * @param resource $featuredefn
 * @return int
 */
function ogr_fd_getreferencecount($featuredefn)
{
}


/**
 * @param resource $featuredefn
 * @return resource
 */
function ogr_f_create($featuredefn)
{
}


/**
 * @param resource $feature
 */
function ogr_f_destroy($feature)
{
}


/**
 * @param resource $feature
 * @return resource
 */
function ogr_f_getdefnref($feature)
{
}


/**
 * @param resource $feature
 * @param resource $geom
 * @return int
 */
function ogr_f_setgeometry($feature, $geom)
{
}


/**
 * @param resource $feature
 * @return resource
 */
function ogr_f_getgeometryref($feature)
{
}


/**
 * @param resource $feature
 * @return resource
 */
function ogr_f_clone($feature)
{
}


/**
 * @param resource $feature
 * @param resource $otherfeature
 * @return bool
 */
function ogr_f_equal($feature, $otherfeature)
{
}


/**
 * @param resource $feature
 * @return int
 */
function ogr_f_getfieldcount($feature)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @return resource
 */
function ogr_f_getfielddefnref($feature, $i)
{
}


/**
 * @param resource $feature
 * @param string $fieldname
 * @return int
 */
function ogr_f_getfieldindex($feature, $fieldname)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @return bool
 */
function ogr_f_isfieldset($feature, $i)
{
}


/**
 * @param resource $feature
 * @param int $i
 */
function ogr_f_unsetfield($feature, $i)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @return resource
 */
function ogr_f_getrawfieldref($feature, $i)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @return int
 */
function ogr_f_getfieldasinteger($feature, $i)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @return double
 */
function ogr_f_getfieldasdouble($feature, $i)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @return string
 */
function ogr_f_getfieldasstring($feature, $i)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @param mixed $count (by reference)
 * @return array
 */
function ogr_f_getfieldasintegerlist($feature, $i, &$count = null)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @param mixed $count (by reference)
 * @return array
 */
function ogr_f_getfieldasdoublelist($feature, $i, &$count = null)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @return array
 */
function ogr_f_getfieldasstringlist($feature, $i)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @return array
 */
function ogr_f_getfieldasdatetime($feature, $i)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @param int $value
 */
function ogr_f_setfieldinteger($feature, $i, $value)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @param double $value
 */
function ogr_f_setfielddouble($feature, $i, $value)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @param string $value
 */
function ogr_f_setfieldstring($feature, $i, $value)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @param int $count
 */
function ogr_f_setfieldintegerlist($feature, $i, $count)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @param int $count
 */
function ogr_f_setfielddoublelist($feature, $i, $count)
{
}


/**
 * @param resource $feature
 * @param int $i
 */
function ogr_f_setfieldstringlist($feature, $i)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @param int $year
 * @param int $month
 * @param int $day
 * @param int $hour
 * @param int $minute
 * @param int $second
 * @param int $tzflag
 */
function ogr_f_setfielddatetime($feature, $i, $year, $month = null, $day = null, $hour = null, $minute = null, $second = null, $tzflag = null)
{
}


/**
 * @param resource $feature
 * @param int $i
 * @param resource $field
 */
function ogr_f_setfieldraw($feature, $i, $field)
{
}


/**
 * @param resource $feature
 * @return int
 */
function ogr_f_getfid($feature)
{
}


/**
 * @param resource $feature
 * @param int $fid
 * @return int
 */
function ogr_f_setfid($feature, $fid)
{
}


/**
 * @param resource $feature
 * @param resource $file
 */
function ogr_f_dumpreadable($feature, $file)
{
}


/**
 * @param resource $feature
 * @param resource $otherfeature
 * @param bool $forgiving
 * @return int
 */
function ogr_f_setfrom($feature, $otherfeature, $forgiving)
{
}


/**
 * @param resource $feature
 * @return string
 */
function ogr_f_getstylestring($feature)
{
}


/**
 * @param resource $feature
 * @param string $style
 */
function ogr_f_setstylestring($feature, $style)
{
}


/**
 * @param resource $layer
 * @return resource
 */
function ogr_l_getspatialfilter($layer)
{
}


/**
 * @param resource $layer
 * @param resource $filtergeom
 */
function ogr_l_setspatialfilter($layer, $filtergeom)
{
}


/**
 * @param resource $layer
 * @param string $query
 * @return int
 */
function ogr_l_setattributefilter($layer, $query)
{
}


/**
 * @param resource $layer
 */
function ogr_l_resetreading($layer)
{
}


/**
 * @param resource $layer
 * @return resource
 */
function ogr_l_getnextfeature($layer)
{
}


/**
 * @param resource $layer
 * @param int $featureid
 * @return resource
 */
function ogr_l_getfeature($layer, $featureid)
{
}


/**
 * @param resource $layer
 * @param resource $feature
 * @return int
 */
function ogr_l_setfeature($layer, $feature)
{
}


/**
 * @param resource $layer
 * @param resource $feature
 * @return int
 */
function ogr_l_createfeature($layer, $feature)
{
}


/**
 * @param resource $layer
 * @param int $featureid
 * @return int
 */
function ogr_l_deletefeature($layer, $featureid)
{
}


/**
 * @param resource $layer
 * @return resource
 */
function ogr_l_getlayerdefn($layer)
{
}


/**
 * @param resource $layer
 * @return resource
 */
function ogr_l_getspatialref($layer)
{
}


/**
 * @param resource $layer
 * @param bool $force
 * @return int
 */
function ogr_l_getfeaturecount($layer, $force)
{
}


/**
 * @param resource $layer
 * @param mixed $extent (by reference)
 * @param bool $force
 * @return int
 */
function ogr_l_getextent($layer, &$extent, $force)
{
}


/**
 * @param resource $layer
 * @param string $capability
 * @return bool
 */
function ogr_l_testcapability($layer, $capability)
{
}


/**
 * @param resource $layer
 * @param resource $fielddefn
 * @param bool $approxok
 * @return int
 */
function ogr_l_createfield($layer, $fielddefn, $approxok)
{
}


/**
 * @param resource $layer
 * @return int
 */
function ogr_l_starttransaction($layer)
{
}


/**
 * @param resource $layer
 * @return int
 */
function ogr_l_committransaction($layer)
{
}


/**
 * @param resource $layer
 * @return int
 */
function ogr_l_rollbacktransaction($layer)
{
}


/**
 * @param resource $datasource
 */
function ogr_ds_destroy($datasource)
{
}


/**
 * @param resource $datasource
 * @return string
 */
function ogr_ds_getname($datasource)
{
}


/**
 * @param resource $datasource
 * @return int
 */
function ogr_ds_getlayercount($datasource)
{
}


/**
 * @param resource $datasource
 * @param int $i
 * @return resource
 */
function ogr_ds_getlayer($datasource, $i)
{
}


/**
 * @param resource $datasource
 * @param string $name
 * @return resource
 */
function ogr_ds_getlayerbyname($datasource, $name)
{
}


/**
 * @param resource $datasource
 * @param string $name
 * @param resource $srs
 * @param int $geomtype
 * @return resource
 */
function ogr_ds_createlayer($datasource, $name, $srs, $geomtype)
{
}


/**
 * @param resource $datasource
 * @param string $capabilitiy
 * @return bool
 */
function ogr_ds_testcapability($datasource, $capabilitiy)
{
}


/**
 * @param resource $datasource
 * @param string $sql
 * @param resource $filtergeom
 * @param string $dialect
 * @return resource
 */
function ogr_ds_executesql($datasource, $sql, $filtergeom, $dialect)
{
}


/**
 * @param resource $datasource
 * @param resource $layer
 */
function ogr_ds_releaseresultset($datasource, $layer)
{
}


/**
 * @param resource $datasource
 * @return resource
 */
function ogr_ds_getdriver($datasource)
{
}


/**
 * @param resource $driver
 * @return string
 */
function ogr_dr_getname($driver)
{
}


/**
 * @param resource $driver
 * @param string $name
 * @param bool $update
 * @return resource
 */
function ogr_dr_open($driver, $name, $update)
{
}


/**
 * @param resource $driver
 * @param string $capabilitiy
 * @return bool
 */
function ogr_dr_testcapability($driver, $capabilitiy)
{
}


/**
 * @param resource $driver
 * @param string $name
 * @return resource
 */
function ogr_dr_createdatasource($driver, $name)
{
}


/**
 * @param string $name
 * @param bool $update
 * @param mixed $driver (by reference)
 * @return resource
 */
function ogropen($name, $update, &$driver = null)
{
}


/**
 * @param resource $driver
 */
function ogrregisterdriver($driver)
{
}


/**
 * @return int
 */
function ogrgetdrivercount()
{
}


/**
 * @param int $i
 * @return resource
 */
function ogrgetdriver($i)
{
}


/**
 * @param string $name
 * @return resource
 */
function ogrgetdriverbyname($name)
{
}


/**
 */
function ogrregisterall()
{
}


/**
 * @param string $data
 * @return resource
 */
function osr_newspatialreference($data)
{
}


/**
 * @param resource $srs
 */
function osr_destroyspatialreference($srs)
{
}


/**
 * @param resource $srs
 * @return int
 */
function osr_reference($srs)
{
}


/**
 * @param resource $srs
 * @return int
 */
function osr_dereference($srs)
{
}


/**
 * @param resource $srs
 */
function osr_release($srs)
{
}


/**
 * @param resource $srs
 * @return int
 */
function osr_validate($srs)
{
}


/**
 * @param resource $srs
 * @param int $code
 * @return int
 */
function osr_importfromepsg($srs, $code)
{
}


/**
 * @param resource $srs
 * @param int $code
 * @return int
 */
function osr_importfromepsga($srs, $code)
{
}


/**
 * @param resource $srs
 * @param string $wkt
 * @return int
 */
function osr_importfromwkt($srs, $wkt)
{
}


/**
 * @param resource $srs
 * @param string $proj
 * @return int
 */
function osr_importfromproj4($srs, $proj)
{
}


/**
 * @param resource $srs
 * @return int
 */
function osr_importfromesri($srs)
{
}


/**
 * @param resource $srs
 */
function osr_exporttowkt($srs)
{
}


/**
 * @param resource $srs
 * @param bool $simplify
 */
function osr_exporttoprettywkt($srs, $simplify)
{
}


/**
 * @param resource $srs
 */
function osr_exporttoproj4($srs)
{
}


/**
 * @param resource $srs
 * @return int
 */
function osr_morphtoesri($srs)
{
}


/**
 * @param resource $srs
 * @return int
 */
function osr_morphfromesri($srs)
{
}


/**
 * @param resource $srs
 * @param string $nodename
 * @param int $attr
 * @return string
 */
function osr_getattrvalue($srs, $nodename, $attr = null)
{
}


/**
 * @param resource $srs
 * @return array
 */
function osr_getangularunits($srs)
{
}


/**
 * @param resource $srs
 * @return array
 */
function osr_getlinearunits($srs)
{
}


/**
 * @param resource $srs
 * @return array
 */
function osr_getprimemeridian($srs)
{
}


/**
 * @param resource $srs
 * @return bool
 */
function osr_isgeographic($srs)
{
}


/**
 * @param resource $srs
 * @return bool
 */
function osr_islocal($srs)
{
}


/**
 * @param resource $srs
 * @return bool
 */
function osr_isprojected($srs)
{
}


/**
 * @param resource $srs
 * @return bool
 */
function osr_isgeocentric($srs)
{
}


/**
 * @param resource $srs
 * @return bool
 */
function osr_isvertical($srs)
{
}


/**
 * @param resource $srs
 * @param resource $othersrs
 * @return bool
 */
function osr_issamegeogcs($srs, $othersrs)
{
}


/**
 * @param resource $srs
 * @param resource $othersrs
 * @return bool
 */
function osr_issame($srs, $othersrs)
{
}


/**
 * @param resource $srs
 * @param string $data
 * @return int
 */
function osr_setfromuserinput($srs, $data)
{
}


/**
 * @param resource $srs
 * @return array
 */
function osr_gettowgs84($srs)
{
}


/**
 * @param resource $srs
 * @return double
 */
function osr_getsemimajor($srs)
{
}


/**
 * @param resource $srs
 * @return double
 */
function osr_getsemiminor($srs)
{
}


/**
 * @param resource $srs
 * @return double
 */
function osr_getinvflattening($srs)
{
}


/**
 * @param resource $srs
 * @param string $targetkey
 * @return string
 */
function osr_getauthoritycode($srs, $targetkey)
{
}


/**
 * @param resource $srs
 * @param string $targetkey
 * @return string
 */
function osr_getauthorityname($srs, $targetkey)
{
}


/**
 * @param resource $srs
 * @param string $name
 * @param double $defaultvalue
 * @return double
 */
function osr_getprojparm($srs, $name, $defaultvalue = null)
{
}


/**
 * @param resource $srs
 * @param string $name
 * @param double $defaultvalue
 * @return double
 */
function osr_getnormprojparm($srs, $name, $defaultvalue = null)
{
}


/**
 * @param resource $srs
 * @return int
 */
function osr_getutmzone($srs)
{
}


/**
 * @param resource $srs
 * @return int
 */
function osr_autoidentifyepsg($srs)
{
}


/**
 * @param resource $srs
 * @return bool
 */
function osr_epsgtreatsaslatlong($srs)
{
}


/**
 * @param resource $srs
 * @param string $targetkey
 * @param int $axis
 * @return array
 */
function osr_getaxis($srs, $targetkey, $axis)
{
}


/**
 * @param mixed $value
 * @return bool
 */
function is_osr($value)
{
}
