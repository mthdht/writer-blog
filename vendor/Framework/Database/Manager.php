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

    protected function where()
    {
        return $this->builder->select('*')->where(...func_get_args());
    }

    protected function all($column = ['*'])
    {
        return $this->builder->select(implode(', ', $column));
    }

    protected function find($id)
    {
        return $this->builder->select('*')->where('id', '=', $id)->send();
    }

    protected function update($data)
    {
        return $this->builder->update($data);
    }

    protected function delete($id)
    {
        return $this->builder->delete()->where('id', '=', $id)->send();
    }

    protected function create($data)
    {
        return $this->builder->insert($data)->send();
    }

    public static function __callStatic($name, $arguments)
    {
        $class = get_called_class();
        $manager = new $class();
        return call_user_func_array([$manager, $name], $arguments);
    }

}