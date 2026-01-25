<?php

namespace Wfm;

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
     * @param array $route
     * @return void
     */
    public static function add($regexp, array $route = []): void
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
     */
    public static function dispatch($url): void
    {
        var_dump($url);
    }
}