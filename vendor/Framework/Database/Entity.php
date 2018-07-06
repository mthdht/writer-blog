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

    public function __get($name)
    {
        // TODO: Implement __get() method.
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }
}