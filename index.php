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

function setNumber($number) {
    global $session;
    $session->set('number', intval($number)); 
    echo json_encode(['New number' => $session->get('number')]);
}

function getNumber() {
    global $session;
    echo json_encode(['Number' => $session->get('number')]);
}

function clearSession() {
    global $session;
    $session->clear();
    echo json_encode(['Session state'=> 'cleared']);
}

$router->addRoute(
    method: 'GET', 
    path: '/setNumber/{number}', 
    callback: 'setNumber',
    permissionCallback: true, 
    loginCallback: true
);  

$router->addRoute(
    method: 'GET', 
    path: '/getNumber', 
    callback: 'getNumber',
    permissionCallback: true, 
    loginCallback: true
);  

$router->addRoute(
    method: 'GET', 
    path: '/clearSession', 
    callback: 'clearSession',
    permissionCallback: true, 
    loginCallback: true
);  


$router->dispatch();