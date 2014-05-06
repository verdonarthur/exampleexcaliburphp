<?php

/**
 * This is the begin script of the app
 * 
 */
ini_set('display_errors', '1');

define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('CONTROLLERPATH', realpath(__DIR__ . '/controller/') . DIRECTORY_SEPARATOR);
define('MODELPATH', realpath(__DIR__ . '/model/') . DIRECTORY_SEPARATOR);
define('VIEWPATH', realpath(__DIR__ . '/view/') . DIRECTORY_SEPARATOR);
define('BOOTPATH', realpath(__DIR__ . '/excaliburphp/boot/') . DIRECTORY_SEPARATOR);
define('COREPATH', realpath(__DIR__ . '/excaliburphp/core/') . DIRECTORY_SEPARATOR);
define('MODULESPATH', realpath(__DIR__ . '/excaliburphp/modules/') . DIRECTORY_SEPARATOR);
define('CONFIGPATH', realpath(__DIR__ . '/excaliburphp/config/') . DIRECTORY_SEPARATOR);

require BOOTPATH . 'boot.php';
