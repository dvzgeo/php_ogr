<?php
require_once 'phpunit-0.5/phpunit.php';
require_once 'phpunit-0.5/phpunit/gui/setupdecorator.php';
require_once 'phpunit-0.5/phpunit/gui/html.php';


$gui = new PHPUnit_GUI_SetupDecorator(new PHPUnit_GUI_HTML());


$gui->getSuitesFromDir("/usr2/home/nsavard/proj/php-4.3.2RC1/ext".
                       "/ogr/phpunit_tests/", 'php_ogr_testcase');

$gui->show();

?>
