<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\Database;


trait Hydrator
{

    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }
}