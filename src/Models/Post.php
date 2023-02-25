<?php 

namespace Core\Models;

use Core\Models\Base;
use Core\Utility;

use Atlas\Query\Insert;
use Atlas\Query\Select;
use Atlas\Pdo\Connection;

class Post extends Base
{
    protected $table = 'posts';

    public function __construct(protected Connection $connection, private PostCategory $postCategory, private PostTag $postTag, private Tag $tag)
    {
    }

    public function saveTags($postId, $tags, $tagsNew)
    {
        if (empty($tags) && empty($tagsNew)) {
            $this->postTag->deleteAllTags($postId);
            return;
        }

        // Remove the tags that are not in the tags array
        // but exists on the post_tags table
        $this->postTag->deleteRemovedTags($postId, $tags);

        // Get existing tags
        $exitingTags = $this->postTag->getAll('tag_id', ['where' => ['post_id' => $postId]]);
        $exitingTags = array_column($exitingTags, 'tag_id');

        // Add only tags that do not already exist
        foreach($tags as $tag) {
            if (!in_array($tag, $exitingTags)) {
                Insert::new($this->connection)
                    ->into('post_tags')
                    ->columns([
                        'post_id' => $postId,
                        'tag_id' => $tag
                    ])->perform();
            }
        }

        // Add new tags to tags table then to post_tags table
        foreach ($tagsNew as $tag) {
            $result = Select::new($this->connection)
                ->columns('id')
                ->from('tags')
                ->whereEquals(['name' => $tag])
                ->fetchOne();

            if ($result) {
                $tagId = $result['id'];
            } else {
                $result = Insert::new($this->connection)
                    ->into('tags')
                    ->columns([
                        'name' => ucwords($tag),
                        'slug' => Utility::Slug($tag)
                    ]);

                $result->perform();
                
                $tagId = $result->getLastInsertId();
            }

            $result = Select::new($this->connection)
                ->columns('id')
                ->from('post_tags')
                ->whereEquals(['post_id' => $postId])
                ->whereEquals(['tag_id' => $tagId])
                ->fetchOne();

            if (!$result) {
                Insert::new($this->connection)
                    ->into('post_tags')
                    ->columns([
                    'post_id' => $postId,
                    'tag_id' => $tagId
                ])->perform();
            }
        }

        return true;
    }

    public function categories($postId)
    {
        return $this->postCategory->getCategoriesByPostId($postId);

    }
}