<?php 

namespace Core\Models;

use Core\Models\Base;

class Session extends Base
{
    protected $table = 'sessions';

    public function __construct($connection)
    {
        parent::__construct($connection, $this->table);
    }
}
