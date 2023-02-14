<?php

namespace Core;

use Core\Database\Query;

abstract class Base
{
    /**
     * The Query Builder
     * 
     * @var Core\Database\Query
     */
    protected $query;

    /**
     * Constructor sets the Database Table.
     *
     * @param string $table The Database Table.
     */
    public function __construct($table)
    {
        $this->query = new Query($table);
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
        return $this->query->insert($data)->run();
    }

    /**
     * Get a Value from a specific Column.
     *
     * @param string|array $columns The column(s) to get.
     * @param array $conditions The conditions to get the data.
     *
     * @return mixed The data.
     */
    public function get($columns = '*', $conditions = [])
    {
        $query = $this->query->select($columns);

        if (isset($conditions['where'])) {
            $query = $query->where($conditions['where'][0], $conditions['where'][1], $conditions['where'][2] ?? "=");
        }

        if (isset($conditions['orWhere'])) {
            $query = $query->orWhere($conditions['orWhere'][0], $conditions['orWhere'][1], $conditions['orWhere'][2] ?? "=");
        }
        
        if (isset($conditions['orderBy'])) {
            $query = $query->orderBy($conditions['orderBy'][0], $conditions['orderBy'][1] ?? "ASC");
        }
        
        if (isset($conditions['limit'])) {
            $query = $query->limit($conditions['limit']);
        }
        
        if (isset($conditions['offset'])) {
            $query = $query->offset($conditions['offset']);
        }

        return $query->run();
    }

    /**
     * Update a value in a column
     *
     * @param array $data ['colum' => 'value'] for update
     * @param array $conditions The conditions to update the data.
     *
     * @return int Number of updated columns
     */
    public function update(array $data, $conditions = [])
    {
        $query = $this->query->update($data);
        
        $query = $query->where($conditions[0], $conditions[1], $conditions[2] ?? "=");

        return $query->run();
    }

    /**
     * Delete a value from a table's column
     *
     * @param array $conditions The conditions to delete the data.
     *
     * @return int Number of deleted columns
     */
    public function delete($conditions = [])
    {
        $query = $this->query->delete();
        
        $query = $query->where($conditions[0], $conditions[1], $conditions[2] ?? "=");

        return $query->run();
    }
}
