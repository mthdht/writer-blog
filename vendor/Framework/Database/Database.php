<?php
/**
 * @author mthdht
 * @license MIT
 */

namespace Framework\Database;


class Database
{

    protected $name;
    protected $username;
    protected $password;
    protected $host;
    protected $pdo;

    /**
     * Database constructor.
     * @param $name
     * @param $username
     * @param $password
     * @param $host
     */
    public function __construct($name, $username, $password, $host)
    {
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->host = $host;
    }


    public function getPDO()
    {
        if (is_null($this->pdo)) {
            $pdo = new \PDO('mysql:dbname=' . $this->name . ';host=' . $this->host , $this->username, $this->password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }

        return $this->pdo;
    }

    public function prepare($statement, $attributes = null, $classname = null)
    {
        $request = $this->getPDO()->prepare($statement);
        $request->execute($attributes);

        if (strpos($statement, 'UPDATE') === 0 ||
            strpos($statement, 'INSERT') === 0 ||
            strpos($statement, 'DELETE') === 0) {
            return $request;
        }

        if (is_null($classname)) {
            $request->setFetchMode(\PDO::FETCH_OBJ);
        } else {
            $request->setFetchMode(\PDO::FETCH_CLASS, $classname);
        }
        $data = $request->fetchAll();
        return $data;
    }


}