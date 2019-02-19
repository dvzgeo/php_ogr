<?php
/**
 * A set of utility functions.
 *
 */

/**
 * Write the result to a file.
 *
 * @param
 * @param  file handle
 *
 * @access public
 */

/**********************************************************************
 *                      OGRFieldDefnDump()
 *
 * Dump a specific field definition.
 *
 **********************************************************************/

function OGRFieldDefnDump($fp, $hFieldDefn)
{
    $strFieldDefn = OGR_FLD_GetNameRef($hFieldDefn);

    $strTypeName = OGR_GetFieldTypeName(OGR_FLD_GetType($hFieldDefn));

    $strOutput = sprintf("  %s (%s) = ", $strFieldDefn, $strTypeName);

    fputs($fp, $strOutput, strlen($strOutput));
}

/**********************************************************************
 *                      OGRDumpAllLayers()
 *
 * Dump all layers.
 *
 **********************************************************************/
function OGRDumpAllLayers($fp, $hDatasource, $bForce)
{
    $bForce = true;
    /* Loop through layers and dump their contents */


    $numLayers = OGR_DS_GetLayerCount($hDatasource);

    $strOutput = sprintf("\nLayer(s) count = %s\n", $numLayers);
    fputs($fp, $strOutput, strlen($strOutput));

    for ($i = 0; $i < $numLayers; $i++) {
        $hLayer = OGR_DS_GetLayer($hDatasource, $i);

        /* Dump info about this layer */
        $hLayerDefn = OGR_L_GetLayerDefn($hLayer);
        $numFields = OGR_FD_GetFieldCount($hLayerDefn);

        fputs(
            $fp,
            "\n===================\n",
            strlen("\n===================\n")
        );

        $strOutput = sprintf(
            "Layer %d: '%s'\n\n",
            $i,
            OGR_FD_GetName($hLayerDefn)
        );
        fputs($fp, $strOutput, strlen($strOutput));


        for ($j = 0; $j < $numFields; $j++) {
            $hFieldDefn = OGR_FD_GetFieldDefn($hLayerDefn, $j);
            $strOutput = sprintf(
                " Field %d: %s (%s)\n",
                $j,
                OGR_Fld_GetNameRef($hFieldDefn),
                OGR_GetFieldTypeName(OGR_Fld_GetType($hFieldDefn))
            );

            fputs($fp, $strOutput, strlen($strOutput));
        }

        fputs($fp, "\n", strlen("\n"));

        /* And dump each feature individually */

        $strOutput = sprintf(
            "Feature(s) count= %d",
            OGR_L_GetFeatureCount($hLayer, $bForce)
        );

        fputs($fp, $strOutput, strlen($strOutput));

        fputs($fp, "\n\n", strlen("\n\n"));


        while (($hFeature = OGR_L_GetNextFeature($hLayer)) != null) {
            OGR_F_DumpReadable($hFeature, $fp);
            OGR_F_Destroy($hFeature);
        }

        fputs($fp, "\n\n----- EOF -----\n", strlen("\n\n----- EOF -----\n"));

        /* No need to free layer handle, it belongs to the datasource */
    }
}

/**********************************************************************
 *                      OGRDumpSingleLayer()
 *
 * Dump a single layer.
 *
 **********************************************************************/
function OGRDumpSingleLayer($fp, $hLayer, $bForce)
{
    $bForce = true;

    /* Dump info about this layer */
    $hLayerDefn = OGR_L_GetLayerDefn($hLayer);
    $numFields = OGR_FD_GetFieldCount($hLayerDefn);

    fputs(
        $fp,
        "\n===================\n",
        strlen("\n===================\n")
    );

    $strOutput = sprintf(
        "Layer '%s'\n\n",
        OGR_FD_GetName($hLayerDefn)
    );
    fputs($fp, $strOutput, strlen($strOutput));


    for ($j = 0; $j < $numFields; $j++) {
        $hFieldDefn = OGR_FD_GetFieldDefn($hLayerDefn, $j);
        $strOutput = sprintf(
            " Field %d: %s (%s)\n",
            $j,
            OGR_Fld_GetNameRef($hFieldDefn),
            OGR_GetFieldTypeName(
                OGR_Fld_GetType($hFieldDefn)

            )
        );

        fputs($fp, $strOutput, strlen($strOutput));
    }

    fputs($fp, "\n", strlen("\n"));

    /* And dump each feature individually */

    $strOutput = sprintf(
        "Feature(s) count= %d",
        OGR_L_GetFeatureCount($hLayer, $bForce)
    );

    fputs($fp, $strOutput, strlen($strOutput));

    fputs($fp, "\n\n", strlen("\n\n"));


    while (($hFeature = OGR_L_GetNextFeature($hLayer)) != null) {
        OGR_F_DumpReadable($hFeature, $fp);
        OGR_F_Destroy($hFeature);
    }

    fputs($fp, "\n\n----- EOF -----\n", strlen("\n\n----- EOF -----\n"));

    /* No need to free layer handle, it belongs to the datasource */
}

/**********************************************************************
 *                      OGRDumpLayerDefn()
 *
 * Dump a layer definition.
 *
 **********************************************************************/
function OGRDumpLayerDefn($fp, $hLayerDefn)
{

    /* Dump info about this layer */
    $numFields = OGR_FD_GetFieldCount($hLayerDefn);

    fputs(
        $fp,
        "\n===================\n",
        strlen("\n===================\n")
    );

    $strOutput = sprintf(
        "Layer: '%s'\n\n",
        OGR_FD_GetName($hLayerDefn)
    );
    fputs($fp, $strOutput, strlen($strOutput));


    for ($j = 0; $j < $numFields; $j++) {
        $hFieldDefn = OGR_FD_GetFieldDefn($hLayerDefn, $j);
        $strOutput = sprintf(
            " Field %d: %s (%s)\n",
            $j,
            OGR_Fld_GetNameRef($hFieldDefn),
            OGR_GetFieldTypeName(OGR_Fld_GetType($hFieldDefn))
        );

        fputs($fp, $strOutput, strlen($strOutput));
    }

    fputs($fp, "\n", strlen("\n"));

    fputs($fp, "\n\n----- EOF -----\n", strlen("\n\n----- EOF -----\n"));

    /* No need to free layer handle, it belongs to the datasource */
}

/************************************************************************/
/*                                OGR_WriteResult_main()                */
/************************************************************************/
/**
 * Write the result to a file.
 *
 * @param  string
 * @param  string
 *
 * @access public
 */

function utilWriteResult($hSrcDS, $hSrcLayer, $hDstDS)
{
    printf("in utilWriteResult()\n");
    /* -------------------------------------------------------------------- */
    /*      Create the layer.                                               */
    /* -------------------------------------------------------------------- */
    if (!OGR_DS_TestCapability($hDstDS, ODsCCreateLayer)) {
        printf(
            "%s data source does not support layer creation.\n",
            OGR_DS_GetName($hDstDS)
        );
        return OGRERR_FAILURE;
    }

    $hFDefn = OGR_L_GetLayerDefn($hSrcLayer);

    $hDstLayer = OGR_DS_CreateLayer(
        $hDstDS,
        OGR_FD_GetName($hFDefn),
        OGR_L_GetSpatialRef($hSrcLayer),
        OGR_FD_GetGeomType($hFDefn),
        null
    );

    if ($hDstLayer == null) {
        printf("layer null\n");
        return false;
    }

    /* -------------------------------------------------------------------- */
    /*      Add fields.                                                     */
    /* -------------------------------------------------------------------- */
    for ($iField = 0; $iField < OGR_FD_GetFieldCount($hFDefn); $iField++) {
        $createResult = OGR_L_CreateField(
            $hDstLayer,
            OGR_FD_GetFieldDefn($hFDefn, $iField),
            0 /*bApproOK*/
        );
        if ($createResult != OGRERR_NONE) {
            return false;
        }
    }
    /* -------------------------------------------------------------------- */
    /*      Transfer features.                                              */
    /* -------------------------------------------------------------------- */
    OGR_L_ResetReading($hSrcLayer);

    while (($hFeature = OGR_L_GetNextFeature($hSrcLayer)) != null) {
        $hDstFeature = OGR_F_Create(OGR_L_GetLayerDefn($hDstLayer));
        $setResult = OGR_F_SetFrom(
            $hDstFeature,
            $hFeature,
            false /*bForgiving*/
        );
        if ($setResult != OGRERR_NONE) {
            OGR_F_Destroy($hFeature);

            printf(
                "Unable to translate feature %d from layer %s.\n",
                OGR_F_GetFID($hFeature),
                OGR_FD_GetName($hFDefn)
            );
            return false;
        }

        OGR_F_Destroy($hFeature);

        if (OGR_L_CreateFeature($hDstLayer, $hDstFeature) != OGRERR_NONE) {
            OGR_F_Destroy($hDstFeature);
            return false;
        }

        OGR_F_Destroy($hDstFeature);
    }
    return true;
}

/************************************************************************/
/*                                create_temp_directory                 */
/************************************************************************/
/**
 * Create a temporary directory
 *
 * @param string $prefix Optional directory name prefix
 * @param string $parent Optional parent directory (default is system temp)
 *
 * @return string|boolean Path to directory (incl. trailing slash) or FALSE
 */
function create_temp_directory($prefix = '', $parent = null)
{
    if ($parent === null) {
        $parent = sys_get_temp_dir();
    }
    if (!is_writable($parent)) {
        return false;
    }
    // prevent infinite loops
    for ($i = 0; $i < 10000; $i++) {
        $candidate = sprintf('%s%s%s%d', $parent, DIRECTORY_SEPARATOR, $prefix, rand(100000, 999999));
        if (mkdir($candidate)) {
            return $candidate . DIRECTORY_SEPARATOR;
        }
    }
    return false;
}

/************************************************************************/
/*                                delete_directory                      */
/************************************************************************/
/**
 * Recursively delete a directory
 *
 * @param string $path Path to directory to delete
 *
 * @return boolean Success?
 */
function delete_directory($path)
{
    if (!($path && is_dir($path))) {
        return false;
    }
    foreach (scandir($path) as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        $filepath = $path . DIRECTORY_SEPARATOR . $file;
        if (is_dir($filepath)) {
            if (!delete_directory($filepath)) {
                return false;
            }
        } elseif (!unlink($filepath)) {
            return false;
        }
    }
    return rmdir($path);
}

/************************************************************************/
/*                                test_data_path                        */
/************************************************************************/
/**
 * Get path to test data
 *
 * @param mixed $what Array of path components, or individual path
 *                    components as individual arguments
 *
 * @return string
 */
function test_data_path($what = null)
{
    $components = array(__DIR__, '..', 'data');
    if (is_array($what)) {
        $components = array_merge($components, $what);
    } elseif (func_num_args() > 0) {
        $components = array_merge($components, func_get_args());
    }
    return implode(DIRECTORY_SEPARATOR, $components);
}

/************************************************************************/
/*                                reference_data_path                   */
/************************************************************************/
/**
 * Get path to (possibly OGR-version-specific) reference data
 *
 * @param mixed $what Array of path components, or individual path components
 *                    as individual arguments
 *
 * @return string
 */
function reference_data_path($what = null)
{
    $referenceFolder = 'reference';
    if (is_array($what)) {
        $args = $what;
    } elseif (func_num_args() > 0) {
        $args = func_get_args();
    }
    // try to find a version-specific reference file
    if (defined('OGR_VERSION_NUM')) {
        $major = (int) floor(OGR_VERSION_NUM / 1000000);
        $minor = (int) floor((OGR_VERSION_NUM % 1000000) / 10000);
        $bugfix = (int) floor((OGR_VERSION_NUM % 10000) / 100);
        $candidates = array(
            sprintf('%02d.%02d.%02d', $major, $minor, $bugfix),
            sprintf('%02d.%02d.xx', $major, $minor),
            sprintf('%02d.xx.xx', $major)
        );
        foreach($candidates as $candidate) {
            $candidateArgs = $args;
            array_unshift($candidateArgs, $candidate);
            array_unshift($candidateArgs, $referenceFolder);
            $candidatePath = test_data_path($candidateArgs);
            if (file_exists($candidatePath)) {
                return $candidatePath;
            }
        }
    }
    // no version-spr
    array_unshift($args, 'default');
    array_unshift($args, $referenceFolder);
    return test_data_path($args);
}