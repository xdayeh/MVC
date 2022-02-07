<?php

namespace AbuDayeh;

use AbuDayeh\Controllers\DashController;
use AbuDayeh\Controllers\SiteController;
use AbuDayeh\Controllers\LoginController;
use AbuDayeh\Core\Application;
use AbuDayeh\Models\LoginModel;

define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', realpath(dirname(__FILE__)) . DS . '..' . DS . 'App' . DS);
define('LANGUAGES_PATH', APP_PATH . DS . 'Core' . DS . 'Languages' . DS);
define('URL_XP', "http://" . $_SERVER["SERVER_NAME"] . substr($_SERVER["PHP_SELF"], 0, strrpos($_SERVER["PHP_SELF"], DS)) . DS);
define('CSS', URL_XP . 'style'. DS . 'stylesheet' . DS);
define('JS',  URL_XP . 'style'. DS . 'javascript' . DS);
define('IMG', URL_XP . 'style'. DS . 'img' . DS);
$Config = [
    'userClass' => LoginModel::class,
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

$app->router->get(DS.'dashboard', [DashController::class, 'dashboard']);
$app->router->get(DS.'profile', [DashController::class, 'profile']);
$app->run();
