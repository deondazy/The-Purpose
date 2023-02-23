<?php 

namespace Core\Models;

use Core\Models\Base;
use Atlas\Query\Delete;

class PostTag extends Base
{
    protected $table = 'post_tags';

    public function __construct($connection)
    {
        parent::__construct($connection, $this->table);
    }

    public function deleteRemovedTags($postId, $tags)
    {
        $delete = Delete::new($this->connection)
            ->from($this->table)
            ->whereEquals(['post_id' => $postId])
            ->andWhereSprintf('tag_id NOT IN %s', $tags);
        $delete->perform();
    }

    public function deleteAllTags($postId)
    {
        $delete = Delete::new($this->connection)
            ->from($this->table)
            ->whereEquals(['post_id' => $postId]);
        $delete->perform();
    }

    public function saveTag($postId, $tagId)
    {
        return $this->create([
            'post_id' => $postId,
            'tag_id'  => $tagId
        ]);
    }
}