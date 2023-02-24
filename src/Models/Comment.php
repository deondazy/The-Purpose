<?php 

namespace Core\Models;

use Core\Models\Base;

class Comment extends Base
{
    protected $table = 'comments';

    public function __construct($connection)
    {
        parent::__construct($connection, $this->table);
    }

    public function getUserCommentCount($userId)
    {
        return $this->getAll("COUNT('id') as count", ['whereRaw' => ["user_id = %s AND status != 'TRASH' AND status != 'SPAM'", $userId]]);
    }

}
