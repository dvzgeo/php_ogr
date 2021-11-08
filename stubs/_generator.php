<?php
/******************************************************************************
 * Project:  PHP Interface for OGR C API
 * Purpose:  Generate extension function stubs as PHP file
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

$apiDefs = implode(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'php_ogr_api.h'));

$inputFile = fopen($apiDefs, 'rb');
if (!$inputFile) {
    echo 'Could not open ', $apiDefs, ' for reading';
    exit(1);
}

$function = null;
$returnType = null;
$args = array();
$numReqArgs = 0;
while (false !== ($line = fgets($inputFile))) {
    $line = trim($line);
    if (strncmp($line, 'ZEND_BEGIN_ARG_INFO_EX', 22) === 0) {
        $function = preg_replace('/^.*arginfo_(\w+).*?$/', '$1', $line);
        $returnType = null;
        $numReqArgs = preg_replace('/^.*(\d+)\s*\).*?$/', '$1', $line);
        $args = array();
    } else if (strncmp($line, '_ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX', 40) === 0) {
        $function = preg_replace('/^.*arginfo_(\w+).*?$/', '$1', $line);
        $returnTypeConst = preg_replace('/^.*IS_(\w+).*?$/', '$1', $line);
        if ($returnTypeConst === 'LONG') {
            $returnType = 'int';
        } else {
            $returnType = strtolower($returnTypeConst);
        }
        $numReqArgs = (int) preg_replace('/^.*(\d+),\s*_?IS_\w+.*?$/', '$1', $line);
        $args = array();
    } else if (strncmp($line, 'ZEND_ARG_INFO', 13) === 0) {
        $name = preg_replace('/^.*\([01],\s*(\w+)\).*?$/', '$1', $line);
        $reference = (bool) preg_replace('/^.*\(([01]).*?$/', '$1', $line);
        $args[$name] = array(
            'type' => 'mixed',
            'reference' => $reference,
            'nullable' => true
        );
    } else if (strncmp($line, '_ZEND_ARG_TYPE_INFO', 19) === 0) {
        $name = preg_replace('/^.*\(0,\s*(\w+),.*?$/', '$1', $line);
        $nullable = (bool) preg_replace('/^.*([01])\).*?$/', '$1', $line);
        $typeConst = preg_replace('/^.*IS_(\w+).*?$/', '$1', $line);
        $reference = (bool) preg_replace('/^.*\(([01]).*?$/', '$1', $line);
        if ($typeConst === 'LONG') {
            $type = 'int';
        } else {
            $type = strtolower($typeConst);
        }
        $args[$name] = array(
            'type' => $type,
            'reference' => $reference,
            'nullable' => $nullable
        );
    } else if (strncmp($line, 'ZEND_END_ARG_INFO()', 19) === 0) {
        echo PHP_EOL, PHP_EOL, '/**', PHP_EOL;
        foreach ($args as $argName => $argInfo) {
            echo ' * @param ', $argInfo['type'], ' $', $argName;
            if ($argInfo['reference']) {
                echo ' (by reference)';
            }
            echo PHP_EOL;
        }
        if ($returnType !== null) {
            echo ' * @return ', $returnType, PHP_EOL;
        }
        echo ' */', PHP_EOL;
        echo 'function ', $function, '(';
        $firstArg = true;
        $argNum = 1;
        foreach ($args as $argName => $argInfo) {
            if ($argNum > 1) {
                echo ', ';
            }
            if ($argInfo['type'] === 'array') {
                echo $argInfo['type'], ' ';
            }
            if ($argInfo['reference']) {
                echo '&';
            }
            echo '$', $argName;
            if ($argNum > $numReqArgs) {
                echo ' = ';
                if (($argInfo['type'] === 'array') && (!$argInfo['nullable'])) {
                    echo 'array()';
                } else {
                    echo 'null';
                }
            }
            $argNum += 1;
        }
        echo ')', PHP_EOL, '{', PHP_EOL, '}', PHP_EOL;
    }
}

fclose($inputFile);
