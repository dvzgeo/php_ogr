# OGR/PHP Extension

This repository contains the OGR/PHP Extension, originally developed by DM Solutions Group.

The original source code (with history!) was retrieved from the CVS repository at cvs.maptools.org:/cvs/maptools/cvsroot using cvssuck, then imported into Git using cvs2git. The imported version is tagged as cvsimport for posterity.

The original webpage/documentation for OGR/PHP is still available at http://dl.maptools.org/dl/php_ogr/php_ogr_documentation.html

The code is available under a MIT-style license - see LICENSE. The original license file from DM Solutions was called README.TXT and contained the same text.

## Supported GDAL/OGR version

Currently both GDAL 2.x and 3.x have been successfully tested.

Note that there is also some variation in the functions exposed depending on the underlying GDAL/OGR version: In case of problems then it is recommended that `function_exists` should be used in PHP to test.

## Supported PHP version

Currently PHP 5 >= 5.4 and PHP 7 are supported. The last version known to support PHP 5 <= 5.3 is tagged as php53 for reference.

## Why here?

OGR/PHP (or PHP_OGR) still does a good job of making the OGR library available in PHP, but being stuck in CVS obscurity it seems to no longer be maintained or developed further to take advantage of new features in OGR. By "forking" it onto GitHub I hope that that may change.

## Building and testing

Building is pretty standard for PHP extensions:

```bash
cd path/to/php_ogr
phpize
./configure
make
```

This will leave the `ogr.so` file under `modules`. This may be installed and/or made available to PHP by adding the line `extension=path/to/ogr.so` to `php.ini`

PHPUnit (5.7) tests are provided for the API functions. These may be run as
follows:

```bash
cd phpunit_tests
composer update --prefer-dist
php vendor/bin/phpunit
```

Note that some test results will differ depending on the installed GDAL/OGR version - alternative results for specific versions are stored under `phpunit_tests/data/reference` (`default` when no difference is expeced).

For the PHPUnit tests, OpenStreetMap data are used. See file `phpunit_tests/data/andorra/README` for full details and license information.

## Using

The file `stubs/ogr.php` contains automatically generated function stubs for all functions defined in the extension, which may assist users of IDEs.
In general, the function signatures match those as described in the [OGR C API](https://www.gdal.org/ogr__api_8h.html) or the [OGR SRS API](https://www.gdal.org/ogr__srs__api_8h.html) for `OSR_*`.-functions, to which users are referred for detailed information on function parameters and return values.
Note that not all functions from the C APIs are exposed: This may be due to the memory management performed by PHP which conflict with the manaual management required in C (e.g. for `OGR_F_SetGeometryDirectly()`), or simply because the wrapper hasn't been written yet ;-)

Additionally, the PHPUnit tests show some examples of how the exposed functions may be used.

Finally, under `examples` there are some examples from the original OGR/PHP, which may or may not work but are retained for information.

## Memory management

Most of the memory management is performed automatically using the PHP reference counting and GC. In almost all cases any memory allocated by OGR and no longer referenced will be automatically freed when a variable is reassigned, unset or goes out of scope (or at the next subsequent garbage collection).
