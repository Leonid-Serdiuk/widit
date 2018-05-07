<?php
// consts
require_once ('config.php');
require_once(CORE_PATH . 'httperror.php');
function set_error_reporting() {
    if (ENVOIRMENT == 'development') {
        error_reporting(E_ALL);
        ini_set("display_errors", "on");
    }
    else if (ENVOIRMENT == 'production') {
        error_reporting(E_ALL);
        ini_set("display_errors", "off");
        ini_set("log_errors", "on");
        ini_set("error_log", ROOT.DS."logs".DS.ERROR_LOG_FILE);
    } else {
        HttpError::show(503, 'The application environment is not set correctly.');
    }
}

set_error_reporting();

require_once (CORE_PATH.'loader.php');

Loader::letsGo();
