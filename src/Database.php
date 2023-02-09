<?php

namespace Core;

use Core\Exception\DatabaseException;
use PDO;
use PDOStatement;
use PDOException;

class Database
{
    /**
     * Database instance.
     *
     * @var PDO
     */
    private static $instance;

    /**
     * The active PDO connection.
     *
     * @var PDO
     */
    private $pdo;

    /**
     * The prepared PDOStatement.
     *
     * @var PDOStatement
     */
    private $statement;

    /**
     * Connection options.
     *
     * @var array
     */
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ];

    /**
     * This class cannot be instantiated
     */
    private function __construct()
    {
    }

    /**
     * This class cannot be cloned
     */
    private function __clone()
    {
    }

    /**
     * Return an instance of the Database class (Singleton).
     * 
     * @throws DatabaseException
     * 
     * @return Database
     */
    public static function instance()
    {
        static $mutex = false;
        if (empty(static::$instance)) {
            if ($mutex === true) {
                throw new DatabaseException('Instance creation is already in progress');
            }
            $mutex = true;
            static::$instance = new static();
            $mutex = false;
        }
        return static::$instance;
    }


    /**
     * Connect to the Database.
     *
     * Sets connection options, and connect to the Database
     *
     * @param string $dsn Data Source Name for the database driver
     * @param string $username Database username
     * @param string $password Database password
     * @param array $options Database connection options
     *
     * @throws DatabaseException
     * 
     * @return PDO
     */
    public function connect($dsn, $username = null, $password = null, $options = [])
    {
        if ($this->isConnected()) {
            return $this->pdo;
        }

        if ($dsn instanceof PDO) {
            $this->pdo = $dsn;
        } else {
            try {
                $this->pdo = new PDO($dsn, $username, $password, array_merge($this->options, $options));
            } catch (PDOException $e) {
                throw new DatabaseException("{$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}", $e->getCode());
            }
        }

        return $this->pdo;
    }

    /**
     * Checks if there's an active Database connection.
     *
     * @return bool
     */
    public function isConnected()
    {
        return (isset($this->pdo) && $this->pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS));
    }

    /**
     * Close database connection (Clean up).
     */
    public function close()
    {
        $this->pdo       = null;
        $this->statement = null;
    }

    /**
     * Prepare a query to run against the database.
     *
     * @param string $query
     *
     * @throws DatabaseException
     *
     * @return PDOStatement
     */
    public function query($query)
    {
        try {
            $this->statement = $this->pdo->prepare($query);
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
        return $this->statement;
    }

    /**
     * Bind the inputs with the query placeholders.
     *
     * @param string $param
     * @param string $value
     * @param string $type
     *
     * @return bool
     */
    public function bind($param, $value = null, $type = null)
    {
        if (is_array($param)) {
            foreach ($param as $key => $val) {
                $this->bind($key, $val);
            }
            return;
        }
        
        if (is_null($type)) {
            $type = gettype($value);
            switch ($type) {
                case 'integer':
                    $type = PDO::PARAM_INT;
                    break;
                case 'boolean':
                    $type = PDO::PARAM_BOOL;
                    break;
                case 'NULL':
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        
        $this->statement->bindValue($param, $value, $type);
    }


    /**
     * Execute the prepared statement.
     *
     * @throws DatabaseException
     *
     * @return bool
     */
    public function execute()
    {
        if (!($this->statement instanceof PDOStatement)) {
            throw new DatabaseException('The statement is not a PDOStatement object.');
        }

        try {
            return $this->statement->execute();
        } catch (PDOException $e) {
            throw new DatabaseException('Error executing PDO statement: ' . $e->getMessage());
        }
    }

    /**
     * Insert Query
     *
     * @param string $table Table to run the query on
     * @param array $data Array of data to insert
     *
     * @return int Last inserted id
     */
    public function insert($table, array $data)
    {
        $columns = implode("`, `", array_keys($data));
        $placeholders = implode(", :", array_keys($data));
        $query = "INSERT INTO `{$table}` (`{$columns}`) VALUES (:{$placeholders})";

        $this->query($query);

        foreach ($data as $param => $value) {
            $this->bind(":{$param}", $value);
        }

        $this->execute();

        return $this->lastInsertId();
    }

    /**
     * Update Query
     *
     * @param string $table Table to update
     * @param string $id Id of the item to update
     * @param array $data Array of data to update
     *
     * @return int Number of rows updated
     */
    public function update($table, array $data, $id)
    {
        $set = '';
        foreach ($data as $column => $value) {
            // use column names as named parameters
            $set .= "{$column} = :{$column}, ";
        }
        $set = rtrim($set, ', '); // remove last comma(,)

        // Construct the query
        $this->query("UPDATE {$table} SET {$set} WHERE id = :id");

        $this->bind(':id', $id);

        // Bind the {$set} parameters
        foreach ($data as $param => $value) {
            $this->bind(":{$param}", $value);
        }

        $this->execute();

        return $this->rowCount();
    }

    /**
     * Delete Query
     *
     * @param string $table Table to update
     * @param string $id Id of the item to update
     *
     * @return int Number of rows deleted
     */
    public function delete($table, $id)
    {
        $this->query("DELETE FROM {$table} WHERE id = :id");
        $this->bind(':id', $id);
        $this->execute();
        return $this->rowCount();
    }

    /**
     * Get result of a single entry column
     *
     * @param string $field
     * @param int $id
     * @return string
     */
    public function get($table, $field, $id)
    {
        $this->query("SELECT `{$field}` FROM `{$table}` WHERE `id` = :id");
        $this->bind(':id', $id);
        $this->execute();

        if ($this->rowCount() > 0) {
            return $this->fetchOne()->$field;
        }
        
        return null;
    }

    /**
     * Get all entries from a table
     *
     * @param string $table
     * @param string|array $columns
     *   - 'where' (optional): The WHERE clause of the query.
     *   - 'order' (optional): The ORDER BY clause of the query.
     *   - 'limit' (optional): The LIMIT clause of the query.
     *   - 'offset' (optional): The OFFSET clause of the query.
     * @param array $conditions
     * 
     * @return array
     */
    public function getAll($table, $columns = '*', $conditions = [])
    {
        $query = "SELECT ";

        if (is_array($columns)) {
            $query .= implode(', ', $columns);
        } else {
            $query .= $columns;
        }

        $query .= " FROM {$table} ";

        if (isset($conditions['where'])) {
            $query .= "WHERE {$conditions['where']} ";
        }
    
        if (isset($conditions['order'])) {
            $query .= "ORDER BY {$conditions['order']} ";
        }
    
        if (isset($conditions['limit'])) {
            $query .= "LIMIT {$conditions['limit']} ";
        }
    
        if (isset($conditions['offset'])) {
            $query .= "OFFSET {$conditions['offset']} ";
        }
    
        $this->query($query);
        $this->execute();
    
        return $this->fetchAll();
    }

    /**
     * Execute prepared statement and fetch array of all the result set rows.
     *
     * @return array
     */
    public function fetchAll()
    {
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Execute the prepared statement and fetch a single row from the result set.
     *
     * @return object
     */
    public function fetchOne()
    {
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Count the affected rows returned by the last query.
     *
     * @return int
     */
    public function rowCount()
    {
        return $this->statement->rowCount();
    }

    /**
     * The last AUTO_INCREMENTed id for the last INSERT query.
     *
     * @return int
     */
    public function lastInsertId()
    {
        return (int)$this->pdo->lastInsertId();
    }
}
