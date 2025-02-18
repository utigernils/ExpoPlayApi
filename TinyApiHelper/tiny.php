<?php


class TinyAPI {
    private $routes = [];
    private $db;

    public function __construct($dbConfig) {
        $this->db = new PDO(
            "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}",
            $dbConfig['user'],
            $dbConfig['pass']
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function registerRoute($method, $path, $callback) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $this->parsePath($path),
            'callback' => $callback
        ];
    }

    private function parsePath($path) {
        return preg_replace('/{([^}]+)}/', '(?P<$1>[^/]+)', $path);
    }

    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        foreach ($this->routes as $route) {
            $pattern = "#^" . $route['path'] . "$#";
            if ($method === $route['method'] && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                echo json_encode(call_user_func_array($route['callback'], $matches));
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
    }

    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

