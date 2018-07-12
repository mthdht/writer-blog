<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\Routing;


use Framework\Http\Request;

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

    public static function run(Request $request)
    {
        if (!isset(self::$routes[$request->method()])) {
            throw new \Exception('Request method not found!');
        }

        foreach (self::$routes[$request->method()] as $route) {
            if ($route->match($request->path())) {
                return $route->handle($request);
            }
        }

        throw new \Exception('No Route Matches this URL');

    }

}