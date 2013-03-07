<?php
/**
 * Alexandr Sibov aka Cyber (cyberdelia1987@gmail.com)
 * Дата создания: 06.10.12 14:23
 */

define('DS', DIRECTORY_SEPARATOR);
define('PROJECT_BASE_PATH', dirname(realpath(__FILE__)).DS);
define('APP_PATH', PROJECT_BASE_PATH.'app/');

date_default_timezone_set('Europe/Chisinau');

require_once(APP_PATH.'libraries/common/functions/common.php');
require_once(APP_PATH.'libraries/common/autoload.php');
require_once(APP_PATH.'libraries/common/error/handler.php');

$application = MLib_Application::getInstance();
$application->run();