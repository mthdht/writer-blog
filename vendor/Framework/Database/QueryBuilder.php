<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\Database;


class QueryBuilder
{

    private $table;
    private $fields;
    private $whereClauses;
    private $orderBy;
    private $limit;
    private $offset;


    private function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function select()
    {
        $this->fields = func_get_args();
        return $this;
    }


    public static function __callStatic($name, $arguments)
    {

        $queryBuilder = new QueryBuilder();
        return call_user_func_array([$queryBuilder, $name], $arguments);

    }
}