<?php 

namespace Core\Models;

use Core\Models\Base;

class UserRole extends Base
{
    protected $table = 'user_roles';

    public function getUserRoleId($userId)
    {
        return $this->getAll('role_id', ['where' => ['user_id' => $userId]])[0]['role_id'];
    }
}
