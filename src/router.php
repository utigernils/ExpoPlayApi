<?php
class Router {
    private $routes = [];
    private $basePath = '';

    public function __construct($basePath = '') {
        $this->basePath = $basePath;
    }

    public function addRoute($method, $path, $callback) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!empty($this->basePath)) {
            $requestUri = substr($requestUri, strlen($this->basePath));
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                call_user_func($route['callback']);
                return;
            }
        }

        header("HTTP/1.0 404 Not Found");
        echo '404 Not Found';
    }
}