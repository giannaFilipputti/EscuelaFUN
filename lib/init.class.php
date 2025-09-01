<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));


require_once (ROOT . DS . 'lib' . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'lib' . DS . 'extraer_variables_seg.php');

spl_autoload_register(array(
    'Autoloader',
    'load'
));

$db = new EasyPDO('mysql:dbname='.DB_NAME.';host='.DB_HOST.';charset=UTF8', DB_USER, DB_PASSWORD);