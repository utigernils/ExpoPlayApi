<?php

require_once 'src/config.php';
require_once 'src/router.php';
require_once 'src/db.php';

$config = new Config('config.ini');
$router = new Router($config->get('content_type'),$config->get('base_path'));
$db = new db($config->get('db_host'), $config->get('db_name'), $config->get('db_user'), $config->get('db_pass'));

function login() {
    return true;
}

function testResponse() {
    echo json_encode(['Hello' => 'World']);
}

$router->addRoute(
    method: 'GET', 
    path: '/test', 
    callback: 'testResponse',
    permissionCallback: 'login', 
    loginCallback:'login'
);  

$router->dispatch();