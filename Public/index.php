<?php

namespace AbuDayeh;

use AbuDayeh\Controllers\SiteController;
use AbuDayeh\Controllers\LoginController;
use AbuDayeh\Core\Application;

define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', realpath(dirname(__FILE__)) . DS . '..' . DS . 'App' . DS);
define('URL_XP', "http://" . $_SERVER["SERVER_NAME"] . substr($_SERVER["PHP_SELF"], 0, strrpos($_SERVER["PHP_SELF"], DS)) . DS . 'style'. DS);
define('CSS', URL_XP . 'stylesheet' . DS);
define('JS',  URL_XP . 'javascript' . DS);
define('IMG', URL_XP . 'img' . DS);
$Config = [
    'db'        => [
        'HostName'  => '127.0.0.1',
        'UserName'  => 'root',
        'Password'  => 'root',
        'DbName'    => 'MVC2',
    ]
];

require_once APP_PATH . 'Core' . DS .'AutoLoader.php';
$app = new Application(APP_PATH, $Config);

$app->router->get(DS, [SiteController::class, 'home']);
$app->router->get(DS.'login', [LoginController::class, 'login']);
$app->router->post(DS.'login', [LoginController::class, 'login']);
$app->router->get(DS.'logout', [LoginController::class, 'logout']);

$app->router->get(DS.'profile', [SiteController::class, 'profile']);
$app->run();
