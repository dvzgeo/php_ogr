# OGR/PHP Extension

This repository contains the OGR/PHP Extension, originally developed by DM Solutions Group.

The original source code (with history!) was retrieved from the CVS repository at cvs.maptools.org:/cvs/maptools/cvsroot using cvssuck, then imported into Git using cvs2git. The imported version is tagged as cvsimport for posterity.

The original webpage/documentation for OGR/PHP is still available at http://dl.maptools.org/dl/php_ogr/php_ogr_documentation.html - this is the same as the file php_ogr_documentation.html

The code is available under a MIT-style license - see LICENSE, which is the same license as the original license file from DM Solutions (originally README.TXT).

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
