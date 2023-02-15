<?php 

namespace Core\Models;

use Core\Models\Base;

class User extends Base
{
    public function __construct()
    {
        parent::__construct('users');
    }
}