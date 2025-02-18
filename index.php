<?php

require_once 'src/config.php';
require_once 'src/router.php';
require_once 'src/db.php';

$config = new Config('config.ini');
$router = new Router($config->get('base_path'));
$db = new db($config->get('db_host'), $config->get('db_name'), $config->get('db_user'), $config->get('db_pass'));

$router->addRoute('GET', '/test', function() use ($db) {
    echo json_encode($db->getConnection()->query('SELECT * FROM player')->fetchAll());
});

$router->addRoute('POST', '/api/users', function() {
    $data = json_decode(file_get_contents('php://input'), true);
    echo json_encode(['message' => 'User created', 'data' => $data]);
});

$router->dispatch();