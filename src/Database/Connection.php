<?php

namespace Core\Database;

use Core\Exception\DatabaseException;
use PDO;
use PDOStatement;
use PDOException;

class Connection
{
    /**
     * Database instance.
     *
     * @var PDO
     */
    private static $instance;

    /**
     * The Database credentials.
     * 
     * @var array
     */
    protected array $credentials = [];

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

        $this->credentials = [
            'dsn'      => $dsn,
            'username' => $username,
            'password' => $password,
            'options'  => $options,
        ];

        list($dsn, $username, $password, $options) = array_values($this->credentials);

        try {
            $this->pdo = new PDO($dsn, $username, $password, array_merge($this->options, $options));
        } catch (PDOException $e) {
            throw new DatabaseException("{$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}", $e->getCode());
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
     * Generates a WHERE clause based on the provided conditions
     * 
     * @param array $where The conditions to generate the WHERE clause from
     * 
     * @return string The generated WHERE clause
     */
    // private function generateWhereClause($where)
    // {
    //     if (is_array($where)) {
    //         $whereClause = [];
    //         $whereConditions = [];
    //         $usingOr = false;

    //         foreach ($where as $key => $value) {
    //             if (is_string($value) && strtoupper($value) === 'OR') {
    //                 $usingOr = true;
    //                 continue;
    //             }

    //             $comparisonOperator = $value[0];
    //             $condition = "$key $comparisonOperator :$key";

    //             if ($usingOr) {
    //                 $whereClause[] = "($condition)";
    //                 $usingOr = false;
    //             } else {
    //                 $whereConditions[] = $condition;
    //             }
    //         }

    //         if (!empty($whereConditions)) {
    //             $whereClause[] = implode(' AND ', $whereConditions);
    //         }

    //         return implode(' OR ', $whereClause);
    //     } else {
    //         return $where;
    //     }
    // }

    private function generateWhereClause($where) {
        $whereClause = [];
        if (is_array($where)) {
            $whereConditions = [];
            $usingOr = false;
    
            foreach ($where as $key => $value) {
                if (is_string($value) && strtoupper($value) === 'OR') {
                    if (!empty($whereConditions)) {
                        $whereClause[] = $this->generateAndClause($whereConditions);
                        $whereConditions = [];
                    }
                    $usingOr = true;
                    continue;
                }
    
                $comparisonOperator = $value[0];
                $condition = "$key $comparisonOperator :$key";
    
                if ($usingOr) {
                    $whereClause[] = $condition;
                    $usingOr = false;
                } else {
                    $whereConditions[] = $condition;
                }
            }
    
            if (!empty($whereConditions)) {
                $whereClause[] = $this->generateAndClause($whereConditions);
            }
    
            return implode(' OR ', $whereClause);
        } else {
            return $where;
        }
    }
    
    private function generateAndClause($whereConditions) {
        return '(' . implode(' AND ', $whereConditions) . ')';
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

    /**
     * Hide sensitive information from the stack trace.
     *
     * @return array
     */
    public function __debugInfo()
    {
        return [
            'dsn'      => $this->credentials['dsn'],
            'username' => '******',
            'password' => '******',
            'options'  => $this->credentials['options'],
        ];
    }
}
