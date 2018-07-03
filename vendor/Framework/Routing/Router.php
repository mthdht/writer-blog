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
        self::$routes['GET'][] = $route;
        return $route;
    }

    public static function post($path, $handler)
    {
        $route = new Route($path, $handler);
        self::$routes['POST'][] = $route;
        return $route;
    }

    public static function run()
    {
        if (!isset(self::$routes[$_SERVER['REQUEST_METHOD']])) {
            throw new \Exception('Request method not found!');
        }

        foreach (self::$routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($_SERVER['REQUEST_URI'])) {
                return $route->handle();
            }
        }

        throw new \Exception('No Route Matches this URL');

    }

}