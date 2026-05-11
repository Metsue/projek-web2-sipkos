<?php
/**
 * Router Class
 * 
 * Sistem routing sederhana untuk mengarahkan request ke controller yang sesuai
 * Support untuk routing parameter dan middleware
 * 
 * @author SIPKOS Team
 * @version 1.0
 */

class Router
{
    // Store routes
    private $routes = [];
    private $current_controller;
    private $current_method;
    private $current_params = [];

    /**
     * Tambah route GET
     */
    public function get($route, $controller_method)
    {
        $this->addRoute('GET', $route, $controller_method);
    }

    /**
     * Tambah route POST
     */
    public function post($route, $controller_method)
    {
        $this->addRoute('POST', $route, $controller_method);
    }

    /**
     * Tambah route untuk method apapun
     */
    public function any($route, $controller_method)
    {
        $this->addRoute('GET', $route, $controller_method);
        $this->addRoute('POST', $route, $controller_method);
    }

    /**
     * Tambah route
     */
    private function addRoute($method, $route, $controller_method)
    {
        $route = '/' . trim($route, '/');

        if (!isset($this->routes[$method])) {
            $this->routes[$method] = [];
        }

        $this->routes[$method][$route] = $controller_method;
    }

    /**
     * Dispatch request ke controller
     */
    public function dispatch()
    {
        $request_method = $_SERVER['REQUEST_METHOD'];
        $request_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove base URL from request
        $base_path = parse_url(BASE_URL, PHP_URL_PATH);
        if (strpos($request_url, $base_path) === 0) {
            $request_url = substr($request_url, strlen($base_path));
        }

        $request_url = '/' . trim($request_url, '/');

        // Check direct route match
        if (isset($this->routes[$request_method][$request_url])) {
            return $this->callController($this->routes[$request_method][$request_url]);
        }

        // Check pattern matching routes
        if (isset($this->routes[$request_method])) {
            foreach ($this->routes[$request_method] as $route => $controller_method) {
                if ($this->matchRoute($route, $request_url, $params)) {
                    $_GET = array_merge($_GET, $params);
                    return $this->callController($controller_method);
                }
            }
        }

        // Route not found - call 404
        return $this->notFound();
    }

    /**
     * Match route pattern and extract parameters
     */
    private function matchRoute($pattern, $url, &$params = [])
    {
        // Convert pattern placeholders to regex
        // Support both {id} and :id route parameter syntax
        $pattern_regex = preg_replace_callback('/(\{([^}]+)\}|:([a-zA-Z_][a-zA-Z0-9_]*))/', function($matches) {
            $name = !empty($matches[2]) ? $matches[2] : $matches[3];
            return '(?P<' . $name . '>[^/]+)';
        }, $pattern);
        
        $pattern_regex = '#^' . $pattern_regex . '/?$#';

        if (preg_match($pattern_regex, $url, $matches)) {
            // Extract named parameters
            foreach ($matches as $key => $value) {
                if (!is_numeric($key)) {
                    $params[$key] = $value;
                }
            }
            return true;
        }

        return false;
    }

    /**
     * Call controller method
     */
    private function callController($controller_method)
    {
        // Split controller@method
        list($controller, $method) = explode('@', $controller_method);

        // Capitalize controller name
        $controller_name = ucfirst($controller) . 'Controller';
        $controller_path = APP . 'controllers/' . $controller_name . '.php';

        // Check if controller exists
        if (!file_exists($controller_path)) {
            die("Controller not found: " . $controller_name);
        }

        // Include controller
        require_once $controller_path;

        // Create controller instance
        $controller_instance = new $controller_name();

        // Check if method exists
        if (!method_exists($controller_instance, $method)) {
            die("Method not found: {$controller_name}@{$method}");
        }

        // Call method
        return call_user_func([$controller_instance, $method]);
    }

    /**
     * 404 Not Found
     */
    private function notFound()
    {
        http_response_code(404);
        echo "404 - Page Not Found";
        exit;
    }
}
?>
