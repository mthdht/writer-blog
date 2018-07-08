<?php
/**
 * @author
 * @license MIT
 */

namespace Framework\Database;

use Framework\Database\QueryBuilder;

class Manager
{

    protected $table;
    protected $builder;

    private function __construct()
    {
        $tableName = explode('\\', get_called_class());
        $tableName = end ($tableName);
        $tableName = str_replace('Manager', '', $tableName);
        $this->table = strtolower($tableName);
        $this->builder = QueryBuilder::table($this->table);

    }

    private function all($column = ['*'])
    {
        return $this->builder->select(implode(', ', $column))->send();
    }

    public static function find($id)
    {

    }

    public static function update($id, $data)
    {

    }

    public static function delete($id)
    {

    }

    public static function create($data)
    {

    }

    public static function __callStatic($name, $arguments)
    {
        $class = get_called_class();
        $manager = new $class();
        return call_user_func_array([$manager, $name], $arguments);
    }

}