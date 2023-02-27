<?php 

namespace Core\Models;

use Core\Models\Base;

class Event extends Base
{
    protected $table = 'events';

    public function __construct($connection)
    {
        parent::__construct($connection, $this->table);
    }
}
