<?php

defined('ROOT') || define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
// set a constant that holds the project's "application" folder, like "/var/www/application".
defined('APP') || define('APP', ROOT . 'application' . DIRECTORY_SEPARATOR);
defined('PUB') || define('PUB', ROOT . 'public' . DIRECTORY_SEPARATOR);

// This is the (totally optional) auto-loader for Composer-dependencies (to load tools into your project).
// If you have no idea what this means: Don't worry, you don't need it, simply leave it like it is.
if (file_exists(ROOT . 'vendor/autoload.php')) {
    require ROOT . 'vendor/autoload.php';
}
/* -- Define App Environment -- */
if (strstr($_SERVER['SERVER_NAME'], 'dev')) {
    define('APPLICATION_ENV', 'development');
} else if (strstr($_SERVER['SERVER_NAME'], 'test')) {
    define('APPLICATION_ENV', 'testing');
} else {
    define('APPLICATION_ENV', 'production');
}

define('URL_PUBLIC_FOLDER', 'public');
define('URL_PROTOCOL', 'http://');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);
$obj = new \Library\Application();