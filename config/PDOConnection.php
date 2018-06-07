<?php

require_once('config.php');

class PDOConnection
{
    protected $config;
    protected $_link;
    protected $_result;

    function __construct()
    {
        $this->connection = new config();
        $this->config = array(
            'DBType' => $this->connection->adapter,
            'host' => $this->connection->host,
            'database' => $this->connection->database,
            'user' => $this->connection->user,
            'password' => $this->connection->password,
        );
    }

    function __destruct()
    {
        self::disconnect();
    }

    function connect()
    {
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_FOUND_ROWS => true
        );
        if ($this->_link === null) {
            try {
                $this->_link = new PDO($this->config['DBType'] . ":host=" . $this->config['host'] . ";dbname=" . $this->config['database'],
                    $this->config['user'], $this->config['password'], $options);
            } catch (PDOException $e) {
                throw new RuntimeException($e->getMessage());
            }
        }
        return $this->_link;
    }

    function disconnect()
    {
        $this->_link = null;
    }

    public function query($query)
    {
        if (!is_string($query) || empty($query))
            throw new InvalidArgumentException('query invalid');
        self::connect();
        try {
            $this->_result = $this->_link->prepare($query);
        } catch (PDOException $e) {
            throw new RuntimeException($e->getMessage());
        }
        return $this->_result;
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->_result->bindValue($param, $value, $type);
    }

    function select($table, $conditions = '', $fileds = '*', $order = '', $limit = null, $offset = 0)
    {
        $query = "SELECT $fileds FROM $table "
            . (($conditions) ? " WHERE " . $conditions : '')
            . (($order) ? " ORDER BY " . $order : ' ')
            . (($limit) ? " LIMIT " . $limit : ' ')
            . (($offset && $limit) ? " OFFSET " . $offset : ' ');

        self::query($query);
        self::execute();
        return self::countRows();
    }

    public function countRows()
    {
        return $this->_result !== null ? $this->_result->rowCount() : 0;
    }

    function count($table, $conditions = '', $limit = null, $offset = 0)
    {
        $query = "SELECT COUNT(*) as res FROM $table "
            . (($conditions) ? " WHERE " . $conditions : '')
            . (($limit) ? " LIMIT " . $limit : ' ')
            . (($offset && $limit) ? " OFFSET " . $offset : ' ');

        self::query($query);
        self::execute();
        return self::getSResult()["res"];
    }

    public function getInsertId($value = null)
    {
        return $this->_link !== null ? $this->_link->lastInsertId($value) : null;
    }

    public function getLastIdDb($table)
    {
        self::select($table, "", 'id', 'id DESC', 1);
        self::execute();
        return $this->_result->fetch()['id'];
    }

    public function execute()
    {
        $this->_result->execute();
    }

    public function quoteValue($value)
    {
        if ($value === null)
            $value = 'NULL';
        if ($value instanceof DateTime)
            $value = $value->format('Y-m-d H:i:s');
        if (!is_numeric($value))
            $value = '\'' . $value . '\'';
        return $value;
    }

    public function fetchClass($class)
    {
        self::execute();
        if ($this->_result !== null)
            $row = $this->_result->fetchAll(PDO::FETCH_CLASS, $class);
        return $row;
    }

    public function fetchObjects()
    {
        if ($this->_result !== null)
            $row = $this->_result->fetchAll(PDO::FETCH_OBJ);
        return $row;
    }

    public function insert($table, array $data)
    {
        $fields = implode(',', array_keys($data));
        $values = implode(',', array_map(array($this, 'quoteValue'), array_values($data)));
        $query = "INSERT INTO " . $table . " (" . $fields . ")  VALUES (" . $values . ")";

        self::query($query);
        self::execute();
        return self::getInsertId();
    }

    public function update($table, array $data, $conditions)
    {
        $set = array();
        foreach ($data as $field => $value) {
            $set[] = $field . '=' . $this->quoteValue($value);
        }
        $set = implode(',', $set);
        $query = "UPDATE " . $table . " SET " . $set . (($conditions) ? " WHERE " . $conditions : '');
        self::query($query);
        self::execute();
        return self::countRows();
    }

    public function delete($table, $conditions)
    {
        $query = "DELETE FROM " . $table . (($conditions) ? " WHERE " . $conditions : "");
        self::query($query);
        self::execute();
        return self::countRows();
    }

    /**
     * @param PDO::FETCH_COLUMN $options
     * @return mixed
     */
    public function getResults($options = null)//one column: $options = PDO::FETCH_COLUMN
    {
        $this->execute();
        return $this->_result->fetchAll($options);
    }

    public function getSResult($options = null)//one column: $options = PDO::FETCH_COLUMN
    {
        $this->execute();
        return $this->_result->fetchAll($options)[0];
    }

    public function debugDump()
    {
        $this->_result->debugDumpParams();
    }
}