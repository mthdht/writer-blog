<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\Routing;


class Route
{

    private $path;
    private $handler;
    private $matches;
    private $parameter;

    public function __construct($path, $handler)
    {
        $this->path = $path;
        $this->handler = $handler;
    }

    public function match($url) {
        // replace {param} by regex on path
        $path = preg_replace_callback('#\{([\w]+)\}#', [$this, 'parameterRegex'], $this->path);
        // check if regex match the url
        if (preg_match('#^'.$path.'$#', $url, $matches)) {
            array_shift($matches);
            $this->matches = $matches;
            return true;
        }
        return false;
    }

    public function handle()
    {
        // check if handler is a string
        if (is_string($this->handler)) {
            // check if the string match the 'XXXController@method' pattern
            if (preg_match('#[A-Za-z]+Controller@[a-z]+#', $this->handler)) {
                // call good controller and his associate method
                $handlerParameter = explode('@', $this->handler);
                $controller = 'App\\Controllers\\' . $handlerParameter[0];
                $controller = new $controller();
                $method = $handlerParameter[1];
                return call_user_func_array([$controller, $method], $this->matches);
            } else {
                throw new \Exception('Controller handler not valid');
            }
        } else {
            return call_user_func_array($this->handler, $this->matches);
        }
    }

    public function where($parameter, $regex)
    {
        $this->parameter[$parameter] = $regex;
    }

    private function parameterRegex($match)
    {
        if (isset($this->parameter[$match[1]])) {
            return '(' . $this->parameter[$match[1]] . ')';
        }
        return '([^/]+)';
    }

}