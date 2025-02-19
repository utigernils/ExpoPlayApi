<?php

require_once 'src/config.php';
require_once 'src/router.php';
require_once 'src/session.php';
require_once 'src/db.php';


$config = new Config(configPath:
    'config.ini'
);

$router = new Router(
    contentType: $config->get('content_type'),
    basePath:$config->get('base_path')
);

$session = new Session();

$db = new db(
    host:$config->get('db_host'), 
    db:$config->get('db_name'),
    user: $config->get('db_user'), 
    pass:$config->get('db_pass')
);

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