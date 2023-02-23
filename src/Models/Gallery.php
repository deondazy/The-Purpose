<?php 

namespace Core\Models;

use Core\Models\Base;
use Core\Utility;

class Gallery extends Base
{
    protected $table = 'gallery';

    public function __construct($connection)
    {
        parent::__construct($connection, $this->table);
    }
}
