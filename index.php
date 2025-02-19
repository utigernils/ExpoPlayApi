<?php

require_once 'src/config.php';
require_once 'src/router.php';
require_once 'src/db.php';

$config = new Config('config.ini');
$router = new Router($config->get('content_type'),$config->get('base_path'));
$db = new db($config->get('db_host'), $config->get('db_name'), $config->get('db_user'), $config->get('db_pass'));

function login() {
    return false;
}

$router->addRoute('GET', '/test', function() use ($db) {
    echo json_encode($db->getConnection()->query('SELECT * FROM player')->fetchAll());
}, 'login', 'login');  

$router->dispatch();