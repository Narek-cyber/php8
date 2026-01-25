<?php

namespace Wfm;

use Exception;

class Router
{
    /**
     * @var array
     */
    protected static array $routes = [];
    /**
     * @var array
     */
    protected static array $route = [];

    /**
     * @param $regexp
     * @param $route
     * @return void
     */
    public static function add($regexp, $route = []): void
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * @return array
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }

    /**
     * @return array
     */
    public static function getRoute(): array
    {
        return self::$route;
    }

    /**
     * @param $url
     * @return void
     * @throws Exception
     */
    public static function dispatch($url): void
    {
        if (self::matchRoute($url)) {
            $controller = 'App\Controllers\\' . self::$route['admin_prefix'] . self::$route['controller'] . 'Controller';
            if (class_exists($controller)) {
                $controllerObject = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action'] . 'Action');
                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                } else {
                    throw new Exception("Method $controller::$action not found.", 404);
                }
            } else {
                throw new Exception("Controller $controller not found.", 404);
            }

        } else {
            throw new Exception("Page not found.", 404);
        }
    }

    /**
     * @param $url
     * @return bool
     */
    public static function matchRoute($url): bool
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#", $url, $matches)) {
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }

                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }

                if (!isset($route['admin_prefix'])) {
                    $route['admin_prefix'] = '';
                } else {
                    $route['admin_prefix'] .= '\\';
                }

                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;

                return true;
            }
        }
        return false;
    }

    /**
     * CamelCase
     * @param $name
     * @return string
     */
    protected static function upperCamelCase($name): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    /**
     * camelCase
     * @param $name
     * @return string
     */
    protected static function lowerCamelCase($name): string
    {
        return lcfirst(self::upperCamelCase($name));
    }
}