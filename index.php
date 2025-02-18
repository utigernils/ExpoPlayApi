<?php

require_once __DIR__ . '/TinyApiHelper/tiny.php';

$api = new TinyAPI([
    'host' => 'localhost',
    'dbname' => 'expoplay',
    'user' => 'root',
    'pass' => ''
]);

$api->registerRoute('GET', '/ExpoPlayAPI/index.php/test', function() use ($api) {
    return "Hello, world!";
});

$api->run();
