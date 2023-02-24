<?php 

namespace Core\Models;

use Core\Models\Base;

class Category extends Base
{
    protected $table = 'categories';

    public function __construct($connection)
    {
        parent::__construct($connection, $this->table);
    }
}