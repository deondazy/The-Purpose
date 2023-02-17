<?php 

namespace Core\Models;

use Core\Models\Base;
use Core\Utility;

class Post extends Base
{
    private $postCategory;
    private $postTag;
    private $tag;

    public function __construct(PostCategory $postCategory, PostTag $postTag, Tag $tag)
    {
        parent::__construct('posts');

        $this->postCategory = $postCategory;
        $this->postTag      = $postTag;
        $this->tag          = $tag;
    }

    public function saveCategories($postId, $categories)
    {
        if (empty($categories)) {
            $categories = [];
        } elseif (is_string($categories)) {
            if (strpos($categories, ',') !== false) {
                $categories = explode(',', $categories);
            } else {
                $categories = [$categories];
            }
        }
        
        if ($this->postCategory->save($postId, $categories)) {
            return true;
        }

        return false;
    }

    public function saveTags($postId, $tags, $tagsNew)
    {
        // If new tags array are added, save them first,
        // then get their ids and add them to the tags array
        if (!empty($tagsNew)) {
            $newTagIds = $this->tag->saveNewTags($tagsNew);
            $tags = array_merge($tags, $newTagIds);
        }

        if (!empty($tags)) {
            // Insert new tags for this post
            foreach ($tags as $tag) {
                $this->postTag->create([
                    'post_id' => $postId,
                    'tag_id' => $tag
                ]);
            }
        }

        return true;
    }

    public function categories($postId)
    {
        return $this->postCategory->get('*', ['where' => ['id', $postId]]);

    }
}