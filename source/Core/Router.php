<?php
namespace Source\Core;

class Router {
    private array $routes = [];
    private string $namespace = "";
    private ?string $error = null;
    private array $named = [];

    public function __construct() {}

    public function namespace(string $ns): void {
        $this->namespace = rtrim($ns, "\\");
    }

    public function add(string $method, string $path, string $handler, ?string $name = null): void {
        $this->routes[] = [$method, "#^" . $this->regex($path) . "$#", $handler, $name];
        if ($name) { $this->named[$name] = $path; }
    }

    public function get(string $path, string $handler, ?string $name = null): void {
        $this->add("GET", $path, $handler, $name);
    }

    public function post(string $path, string $handler, ?string $name = null): void {
        $this->add("POST", $path, $handler, $name);
    }

    public function group(string $prefix): void {}

    public function dispatch(): void {
        $uri = parse_url($_SERVER["REQUEST_URI"] ?? "/", PHP_URL_PATH);
        $method = $_SERVER["REQUEST_METHOD"] ?? "GET";

        foreach ($this->routes as [$m, $pattern, $handler]) {
            if ($m === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                [$class, $action] = explode(":", $handler);
                $class = $this->namespace . "\\" . $class;
                if (!class_exists($class)) { $this->error = "500"; return; }
                $controller = new $class();
                if (!method_exists($controller, $action)) { $this->error = "500"; return; }
                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }
        $this->error = "404";
    }

    public function error(): ?string { return $this->error; }

    public function redirect(string $name, array $params = []): void {
        $path = $this->named[$name] ?? "/";
        foreach ($params as $k=>$v) { $path = str_replace("{" . $k . "}", $v, $path); }
        header("Location: " . $path);
        exit;
    }

    private function regex(string $path): string {
        return preg_replace("/\{([a-zA-Z0-9_]+)\}/", "(?P<$1>[^/]+)", $path);
    }
}
