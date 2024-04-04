<?php

namespace AplikasiKas\Core;

class Router
{
    private static array $routes = [];
    public static function add($method, $url, $controller, $function): void
    {
        self::$routes[] = [
            'method' => $method,
            'url' => $url,
            'controller' => $controller,
            'function' => $function
        ];
    }
    public static function run(): void
    {
        $url = '/';

        if (isset($_SERVER['PATH_INFO'])) $url = $_SERVER['PATH_INFO'];
        $method = $_SERVER['REQUEST_METHOD'];
        foreach (self::$routes as $route) {
            $pattern = '#^' . $route['url'] . '$#';
            if (preg_match($pattern, $url, $variables) && $method == $route['method']) {
                $controller = new $route['controller'];
                $function = $route['function'];
                array_shift($variables);
                call_user_func_array([$controller, $function], $variables);
                return;
            }
        }
        http_response_code(404);
        View::setView('NotFoundPage');
    }
}