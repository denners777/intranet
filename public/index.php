<?php

use Phalcon\Logger\Adapter\File as LoggerFile;

ini_set('display_errors', true);
error_reporting(E_ALL);

define('APP_PATH', realpath('..'));

$error = false;

try {
    if (is_file(APP_PATH . '/vendor/autoload.php')) {
        require_once APP_PATH . '/vendor/autoload.php';
    }

    require_once APP_PATH . '/app/config/bootstrap.php';

    $di = new Phalcon\Di\FactoryDefault();
    $app = new Bootstrap($di);
    echo $app->run([]);
} catch (\Exception $e) {
    $error = true;
} catch (\PDOException $e) {
    $error = true;
}

if ($error) {
    require_once APP_PATH . '/app/shared/views/common/errors/main.php';
    $logger = new LoggerFile(APP_PATH . '/logs/' . date('Y-m-d') . '.log');
    $logger->error($e->getMessage());
    Rollbar::report_exception($e);
}



