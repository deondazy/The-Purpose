<?php

namespace Core\Models;

use Atlas\Query\Delete;
use Atlas\Query\Insert;
use Atlas\Query\Select;
use Atlas\Query\Update;
use Atlas\Pdo\Connection;

abstract class Base
{
    /**
     * The Database Table
     * 
     * @var string
     */
    protected $table;

    /**
     * Set the Database connection in the constructor
     * 
     * @param Connection $connection
     */
    public function __construct(protected Connection $connection)
    {
    }

    /**
     * Create a new record in the Database
     *
     * @param array $data The data ['column' => 'value'] to insert.
     *
     * @return int The last insert ID.
     */
    public function create(array $data)
    {
        $insert = Insert::new($this->connection)
            ->into($this->table)
            ->columns($data);
        $insert->perform();

        return $insert->getLastInsertId();
    }

    /**
     * Get a Value from a specific Column.
     *
     * @param string|array $columns The column(s) to get.
     * @param array $conditions The conditions to get the data.
     *
     * @return mixed The data.
     */
    public function get($columns, $id)
    {
        $select = Select::new($this->connection)
            ->columns($columns)
            ->from($this->table)
            ->whereEquals(['id' => $id]);

        return $select->fetchOne();
    }

    public function getAll($columns = '*', $conditions = [])
    {
        $select = Select::new($this->connection)
            ->columns($columns)
            ->from($this->table);

        if (isset($conditions['join'])) {
            $select->join($conditions['join'][0], $conditions['join'][1], $conditions['join'][2]);
        }

        if (isset($conditions['where'])) {
            $select->whereEquals($conditions['where']);
        }

        if (isset($conditions['whereRaw'])) {
            $select->whereSprintf($conditions['whereRaw'][0], $conditions['whereRaw'][1]);
        }

        if (isset($conditions['orderBy'])) {
            $orderBy = implode(',', $conditions['orderBy']);
            $select->orderBy($orderBy);
        }

        return $select->fetchAll();
    }

    /**
     * Update a value in a column
     *
     * @param array $data ['colum' => 'value'] for update
     * @param array $conditions The conditions to update the data.
     *
     * @return int Number of updated columns
     */
    public function update(array $condition, array $data)
    {
        $update = Update::new($this->connection)
            ->table($this->table)
            ->columns($data)
            ->whereEquals($condition);
        $result = $update->perform();

        return $result->rowCount();
    }

    /**
     * Delete a value from a table's column
     *
     * @param array $conditions The conditions to delete the data.
     *
     * @return int Number of deleted columns
     */
    public function delete(array $conditions)
    {
        $delete = Delete::new($this->connection)
            ->from($this->table)
            ->whereEquals($conditions);
        $result = $delete->perform();
        
        return $result->rowCount();
    }

    /**
     * Get the count of the returned data
     * 
     */
    public function count($conditions = [])
    {
        $select = Select::new($this->connection)
            ->columns('COUNT(id) as count')
            ->from($this->table);

            if (isset($conditions)) {
                $select->whereEquals($conditions);
            }

        return $select->fetchOne();
    }
}
