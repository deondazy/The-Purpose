<?php 

namespace Core\Models;

use Core\Models\Base;
use Core\Utility;
use Atlas\Pdo\Connection;

class Tag extends Base
{
    public $table = 'tags';

    // public function __construct(Connection $connection)
    // {
    //     parent::__construct($connection, $this->table);
    // }

    public function saveNewTags(array $newTags): array
    {
        $newTagIds = [];

        foreach ($newTags as $newTag) {
            $newTagId = $this->create([
                'name' => ucwords($newTag),
                'slug' => Utility::Slug($newTag)
            ]);

            $newTagIds[] = $newTagId;
        }

        return $newTagIds;
    }
}
