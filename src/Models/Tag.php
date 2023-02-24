<?php 

namespace Core\Models;

use Core\Models\Base;
use Core\Utility;

class Tag extends Base
{
    protected $table = 'tags';

    public function __construct($connection)
    {
        parent::__construct($connection, $this->table);
    }

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
