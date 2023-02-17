<?php 

namespace Core\Models;

use Core\Models\Base;

class Category extends Base
{
    public function __construct()
    {
        parent::__construct('categories');
    }
}