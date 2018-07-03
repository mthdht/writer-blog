<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\Routing;


class Router
{

    private static $routes = [];

    public static function get($path, $handler)
    {
        $route = new Route($path, $handler);
        self::$routes['get'][] = $route;
    }

    public static function post($path, $handler)
    {
        $route = new Route($path, $handler);
        self::$routes['post'][] = $route;
    }

    public static function run()
    {

    }

}