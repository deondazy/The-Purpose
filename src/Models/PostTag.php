<?php 

namespace Core\Models;

use Core\Models\Base;

class PostTag extends Base
{
    public function __construct()
    {
        parent::__construct('post_tags');
    }
}