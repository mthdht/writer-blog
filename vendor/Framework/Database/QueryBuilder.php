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
    private $values;
    private $attribute;
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

    public function insert()
    {
        $this->action = strtoupper(__FUNCTION__);
        foreach (func_get_args() as $key => $value) {
            $this->fields = implode(', ', array_keys($value));
            $value = array_map(function ($elem) {
                return '\'' . $elem . '\'';
            }, $value);
            $this->values[] = implode(', ', $value);
        }

        return $this;
    }

    public function where()
    {
        $tab = func_get_args();
        $this->where[] = [$tab[0], $tab[1], ':' . $tab[0]];
        $this->attribute[$tab[0]] = $tab[2];
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

    private function getSelectQuery() {
        $this->query = "SELECT "
            . implode(", ", $this->fields)
            . " FROM " . $this->table;

        // where clause ?
        if (isset($this->where)) {
            $where = implode(" AND ", array_map(function ($element) {
                return implode(" ", $element);
            }, $this->where));
            $this->query .= " WHERE " . $where;
        }

        // order by
        $this->query .= " ORDER BY " . implode(", ", $this->orderBy);

        // limit ?
        if (isset($this->limit)) {
            $this->query .= " LIMIT " . $this->offset[0] . ", " . $this->limit[0];
        }
    }

    private function getInsertQuery()
    {
        $this->query = "INSERT INTO " . $this->table . "(" . $this->fields . ") VALUES";
        foreach ($this->values as $key => $value) {
            $this->query .= "(" . $value . ")";
            $this->query .= next($this->values) == true ? ", " : null;
        }
    }

    public function getQuery()
    {
        switch ($this->action) {
            case "SELECT":
                $this->getSelectQuery();
                break;
            case "INSERT":
                $this->getInsertQuery();
                break;
        }
        return $this->query;
    }

    public function get()
    {
        $query = $this->getQuery();
        return $this->db->prepare($query, $this->attribute);
    }

    public static function __callStatic($name, $arguments)
    {
        $queryBuilder = new QueryBuilder(new Database('blog', 'root', 'root', 'localhost'));
        return call_user_func_array([$queryBuilder, $name], $arguments);
    }
}