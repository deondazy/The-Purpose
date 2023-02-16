<?php

namespace Core\Database;

use Core\Database\Connection;

class Query
{
    protected $query;
    protected $table;
    protected $columns;
    protected $where;
    protected $orderBy;
    protected $params;
    protected $limit;
    protected $offset;

    public function __construct($table)
    {
        $this->table = $table;
        $this->params = [];
    }

    public function select($columns = '*')
    {
        if (is_array($columns)) {
            $this->columns .= implode(', ', $columns);
        } else {
            $this->columns = $columns;
        }

        $this->query = "SELECT $this->columns FROM {$this->table}";
        return $this;
    }

    public function insert($data)
    {
        $columns = array_keys($data);
        $values = array_map(function ($value, $key) {
            return ":$key";
        }, array_values($data), array_keys($data));
        $this->query = "INSERT INTO " . $this->table . "(" . implode(", ", $columns) . ") VALUES(" . implode(", ", $values) . ")";
        $this->params = $data;
        return $this;
    }

    public function update($data)
    {
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = :$column";
            $this->params[$column] = $value;
        }
        $this->query = "UPDATE " . $this->table . " SET " . implode(", ", $set);
        return $this;
    }

    public function delete()
    {
        $this->query = "DELETE FROM " . $this->table;
        return $this;
    }

    public function where($column, $value, $operator = "=", $condition = "AND")
    {
        if (empty($this->where)) {
            $this->where = " WHERE ";
        } else {
            $this->where .= " $condition ";
        }
        $this->where .= "$column $operator :$column";
        $this->params[$column] = $value;
        return $this;
    }

    public function orWhere($column, $value, $operator = "=")
    {
        return $this->where($column, $value, $operator, "OR");
    }

    public function orderBy($column, $direction = "ASC")
    {
        $this->orderBy = "ORDER BY $column $direction";
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function getSql()
    {
        $sql = $this->query . $this->where;
        
        if ($this->orderBy) {
            $sql .= " " . $this->orderBy;
        }
        
        if ($this->limit) {
            $sql .= " LIMIT " . $this->limit;
        }
        
        if ($this->offset) {
            $sql .= " OFFSET " . $this->offset;
        }
        
        return $sql;
    }

    public function run()
    {
        $sql = $this->getSql();
        $db = Connection::instance();
        $db->query($sql);

        if (isset($this->params)) {
            $db->bind($this->params);
        }

        $db->execute();

        if (stripos($this->query, 'insert') === 0) {
            return $db->lastInsertId();
        } elseif (stripos($this->query, 'select') === 0) {
            if ($db->rowCount() > 1) {
                return $db->fetchAll();
            }
            return $db->fetchOne();
        } else {
            return $db->rowCount();
        }
    }

    public function getTable()
    {
        return $this->table;
    }
}