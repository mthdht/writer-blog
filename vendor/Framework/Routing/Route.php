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

    public function __construct($path, $handler)
    {
        $this->path = $path;
        $this->handler = $handler;
    }

    public function match($url) {
        // replace {param} by regex on path
        $path = preg_replace('#\{([\w]+)\}#', '([^/]+)', $this->path);
        // check if regex match the url
        if (preg_match('#^'.$path.'$#', $url, $matches)) {
            $this->matches = $matches;
            var_dump($this->matches);
            return true;
        }
        return false;
    }
}