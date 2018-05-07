<?php

define("ENVOIRMENT", "development");

define("SITE_NAME", "Money Keeper");
define('URL', 'http://' . $_SERVER['HTTP_HOST'] . PATH);
define('ROOT', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
define('CORE_PATH', ROOT.DS.'core'.DS);
define('APP_PATH', ROOT.DS.'app'.DS);
define('ERROR_LOG_FILE', 'error.log');

define('DB_HOST',    'localhost');
define('DB_USER',    'root');
define('DB_PASS',    '123');
define('DB_NAME',    'money_keeper');
define('DB_CHARSET', 'utf8');


