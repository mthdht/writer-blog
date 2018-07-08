<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\Database;


class QueryBuilder
{

    /**
     * The table in which the query will happen
     * @var string
     */
    private $table;

    /**
     * The fields that we want to change/insert/get
     * @var array
     */
    private $fields;

    /**
     * The pseudo values we want to bind to attributes in database prepare statement
     * e.g : [ ':id', ':title', ':field' ... ]
     * @var array
     */
    private $values;

    /**
     * The attributes we want to bind to pseudo values
     * @var array
     */
    private $attributes;

    /**
     * The where clause for the query with pseudo value
     * e.g : [ 'id', '=', ':id' ]
     * @var array
     */
    private $where;

    /**
     * The field that the select query results should be order by
     * @var string
     */
    private $orderBy;

    /**
     * The number of result that we want
     * @var int
     */
    private $limit;

    /**
     * the index that the select query should start
     * @var int
     */
    private $offset = 0;

    /**
     * The type of query
     * e.g : 'INSERT' | 'SELECT' | 'UPDATE' | 'DELETE'
     * @var string
     */
    private $action;

    /**
     * All the pamareters for table join
     * @var array
     */
    private $joinParam;

    /**
     * The database instance for all queries
     * @var Framework\Database\Database
     */
    private $db;

    /**
     * The statement for the database prepare method
     * @var string
     */
    private $query;

    /**
     * QueryBuilder constructor.
     * @param Database $db
     */
    private function __construct(Database $db)
    {
        $this->db = $db;
    }


    /**
     * Stock the name of table
     * @param $table
     * @return $this
     */
    private function table($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Stock the action, and fields attribute
     * @params string The fields to stock
     * @return $this
     */
    public function select()
    {
        $this->fields = func_get_args();
        $this->action = strtoupper(__FUNCTION__);
        return $this;
    }

    /**
     * Stock the action, fields and attributes
     * @param array the column/value to store in database
     * @return mixed
     */
    public function insert()
    {
        $this->action = strtoupper(__FUNCTION__);
        $arg = func_get_args()[0];
        $this->fields = array_keys($arg);
        $this->attributes = $arg;

        foreach ($arg as $key => $value) {
            $this->values[] = ':' . $key;
        }

        return $this;
    }

    /**
     * Stock the action, fields and attribute
     * @param array the column/value to update in database
     * @return $this
     */
    public function update()
    {
        $arg = func_get_args()[0];
        $this->action = strtoupper(__FUNCTION__);
        $this->fields = array_keys($arg);
        $this->attributes = $arg;

        foreach ($arg as $key => $value) {
            $this->values[] = ':' . $key;
        }

        return $this;
    }

    /**
     * Stock the action
     * @return $this
     */
    public function delete() {
        $this->action = strtoupper(__FUNCTION__);
        return $this;
    }

    /**
     * Stock the where clause
     * @params string the condition for where
     * @return $this
     */
    public function where()
    {
        $tab = func_get_args();
        $this->where[] = [$tab[0], $tab[1], ':' . $tab[0]];
        $this->attributes[$tab[0]] = $tab[2];
        return $this;
    }

    /**
     * Stock the orderBy
     * @param string
     * @return $this
     */
    public function orderBy($value) {
        $this->orderBy = $value;
        return $this;
    }

    /**
     * Stock the limit
     * @param int
     * @return $this
     */
    public function take($value)
    {
        $this->limit = $value;
        return $this;
    }

    /**
     * Stock the offset
     * @param int
     * @return $this
     */
    public function offset($value)
    {
        $this->offset = $value;
        return $this;
    }

    /**
     * Stock join parameter for the query
     * @param array
     * @return $this
     */
    private function joins($args)
    {
        $this->joinParam['table'] = $args[0];
        array_shift($args);
        $this->joinParam['condition'] = $args;
        return $this;
    }


    /**
     * Stock the join method (INNER JOIN) and call generic joins method
     * @return QueryBuilder
     */
    public function join()
    {
        $this->joinParam['join_method'] = 'INNER JOIN';
        return $this->joins(func_get_args());
    }

    /**
     * Stock the join method (LEFT JOIN) and call generic joins method
     * @return QueryBuilder
     */
    public function leftJoin()
    {
        $this->joinParam['join_method'] = 'LEFT JOIN';
        return $this->joins(func_get_args());
    }

    /**
     * Stock the join method (RIGHT JOIN) and call generic joins method
     * @return QueryBuilder
     */
    public function rightJoin()
    {
        $this->joinParam['join_method'] = 'RIGHT JOIN';
        return $this->joins(func_get_args());
    }

    /**
     * Create the query string for select statement
     */
    private function getSelectQuery() {
        $this->query = "SELECT "
            . implode(", ", $this->fields)
            . " FROM " . $this->table;

        //join ?
        if (isset($this->joinParam)) {
            $this->query .= ' ' . $this->joinParam['join_method']
            . ' ' . $this->joinParam['table']
            .' ON ' . implode(' ', $this->joinParam['condition']);

        }

        // where clause ?
        if (isset($this->where)) {
            $where = implode(" AND ", array_map(function ($element) {
                return implode(" ", $element);
            }, $this->where));
            $this->query .= " WHERE " . $where;
        }

        // order by
        $this->query .= isset($this->orderBy) ? " ORDER BY " . $this->orderBy : null;

        // limit ?
        if (isset($this->limit)) {
            $this->query .= " LIMIT " . $this->offset . ", " . $this->limit;
        }
    }

    /**
     *  Create the query string for insert statement
     */
    private function getInsertQuery()
    {
        $this->query = "INSERT INTO " . $this->table . "(" . implode(', ', $this->fields) . ") VALUES";
        $this->query .= "(" . implode (', ', $this->values) . ")";
    }

    /**
     * Create the query string for update statement
     */
    private function getUpdateQuery()
    {
        $this->query = "UPDATE " . $this->table . ' SET ';
        foreach ($this->fields as $key => $value) {
            $this->query .= $value . ' = ' . $this->values[$key];
            $this->query .= next($this->fields) != false ? ', ': null;
        }

        // wher clause ?
        if (isset($this->where)) {
            $where = implode(" AND ", array_map(function ($element) {
                return implode(" ", $element);
            }, $this->where));
            $this->query .= " WHERE " . $where;
        }
    }

    /**
     * Create the query string for delete statement
     */
    private function getDeleteQuery()
    {
        $this->query = "DELETE FROM " . $this->table;

        // wher clause ?
        if (isset($this->where)) {
            $where = implode(" AND ", array_map(function ($element) {
                return implode(" ", $element);
            }, $this->where));
            $this->query .= " WHERE " . $where;
        }
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        switch ($this->action) {
            case "SELECT":
                $this->getSelectQuery();
                break;
            case "INSERT":
                $this->getInsertQuery();
                break;
            case "UPDATE":
                $this->getUpdateQuery();
                break;
            case 'DELETE':
                $this->getDeleteQuery();
                break;
        }
        return $this->query;
    }

    /**
     * Execute the query to database
     * @return array|bool|\PDOStatement
     */
    public function send()
    {
        $query = $this->getQuery();
        $classname = 'App\\Models\\' . ucfirst(substr($this->table, 0, -1));
        return $this->db->prepare($query, $this->attributes, $classname);
    }

    public static function __callStatic($name, $arguments)
    {
        $queryBuilder = new QueryBuilder(new Database('blog', 'root', 'root', 'localhost'));
        return call_user_func_array([$queryBuilder, $name], $arguments);
    }
}