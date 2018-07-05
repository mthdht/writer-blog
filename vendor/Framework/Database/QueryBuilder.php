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
    private $where;
    private $orderBy = ['id'];
    private $limit;
    private $offset = 0;
    private $action;
    private $db;
    private $query;

    private function __construct(Database $db)
    {
        $this->db = $db;
    }


    private function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function select()
    {
        $this->fields = func_get_args();
        $this->action = strtoupper(__FUNCTION__);
        return $this;
    }

    public function where()
    {
        $this->where[] = func_get_args();
        return $this;
    }

    public function orderBy() {
        $this->orderBy = func_get_args();
        return $this;
    }

    public function take()
    {
        $this->limit = func_get_args();
        return $this;
    }

    public function offset()
    {
        $this->offset = func_get_args();
        return $this;
    }

    public static function __callStatic($name, $arguments)
    {

        $queryBuilder = new QueryBuilder(new Database('blog', 'root', 'Mth12Dht89', 'localhost'));
        return call_user_func_array([$queryBuilder, $name], $arguments);

    }
}