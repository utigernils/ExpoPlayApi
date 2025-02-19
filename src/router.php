<?php
class Router {
    private $routes = [];
    private $basePath = '';

    public function __construct($contentType, $basePath = '') {
        $this->basePath = $basePath;
        header('Content-Type: ' . $contentType);
    }

    public function addRoute($method, $path, $callback, $permissionCallback = null, $loginCallback = null) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
            'permissionCallback' => $permissionCallback,
            'loginCallback' => $loginCallback
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
                if (isset($route['loginCallback']) && is_callable($route['loginCallback'])) {
                    if (!call_user_func($route['loginCallback'])) {
                        header("HTTP/1.0 401 Unauthorized");
                        echo '401 Unauthorized';
                        return;
                    }
                }
                if (isset($route['permissionCallback']) && is_callable($route['permissionCallback'])) {
                    if (!call_user_func($route['permissionCallback'])) {
                        header("HTTP/1.0 403 Forbidden");
                        echo '403 Forbidden';
                        return;
                    }
                }
                call_user_func($route['callback']);
                return;
            }
        }

        header("HTTP/1.0 404 Not Found");
        echo '404 Not Found';
    }
}