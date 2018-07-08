<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\Database;



class Entity
{
    use Framework\Database\Hydrator;

    protected $id;

    public function __construct($attributes = [])
    {
        $this->fill($attributes);
    }


    public function getAttribute($key)
    {
        if (!$key) {
            return;
        }
        return $this->$key;
    }

    public function setAttribute($name, $value)
    {
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            $this->$method($value);
        } else {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        return $this->getAttribute($name);
    }

    public function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }
}