<?php
require_once 'phpunit-0.5/phpunit.php';

class OGRSFDriverMiscellaneousTest extends PHPUnit_TestCase {
    var $strPathToData;
    var $strBadPathToData;
    var $bUpdate;
    var $hOGRSFDriver;
    var $strFilename;

    function testOGRGetDriverCount() {
        $result = OGRGetDriverCount();
        $this->assertEquals($expected, $result, "Driver count is supposed to be
                             zero", 0 /*$delta*/);
    }
}
?> 
