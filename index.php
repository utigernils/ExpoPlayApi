<?php

require_once 'router/router.php';

$basePath = '/ExpoPlayAPI';

$router = new Router($basePath);

$router->addRoute('GET', '/api/users', function() {
    echo json_encode(['users' => ['Test', 'Test2', 'Test3']]);
});

$router->addRoute('POST', '/api/users', function() {
    $data = json_decode(file_get_contents('php://input'), true);
    echo json_encode(['message' => 'User created', 'data' => $data]);
});

$router->dispatch();