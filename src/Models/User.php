<?php 

namespace Core\Models;

use Core\Models\Base;
use Core\Utility;

class User extends Base
{
    protected $table = 'users';

    public function __construct($connection)
    {
        parent::__construct($connection, $this->table);
    }

    public function getAvatar($userId, $email = null)
    {
        $uploadedAvatar = $this->get('avatar', $userId)['avatar'] ?? null;

        if (is_null($email)) {
            $email = $this->get('email', $userId)['email'] ?? 'guest';
        }

        $username = $this->get('username', $userId)['username'] ?? null;

        if (!$uploadedAvatar) {
            return Utility::generateAvatar($email);
        }

        return "/public/uploads/avatar/{$username}/{$uploadedAvatar}";
    }
}