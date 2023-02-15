<?php 

namespace Core\Model;

use Core\Model\Base;

class User extends Base
{
    public function __construct()
    {
        parent::__construct('users');
    }
}