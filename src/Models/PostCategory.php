<?php 

namespace Core\Models;

use Core\Models\Base;
use Atlas\Query\Delete;

class PostCategory extends Base
{
    protected $table = 'post_categories';

    public function __construct($connection)
    {
        parent::__construct($connection, $this->table);
    }
    
    private function deletePostCategories(int $postId)
    {
        if ($this->get(['post_id', $postId])) {
            $this->delete(['post_id', $postId]);
        }
    }
    
    public function saveCategories(int $postId, $categoryIds): void
    {
        $categoryIds = explode(',', $categoryIds);

        if (is_array($categoryIds) && count($categoryIds) < 2 && empty($categoryIds[0])) {
            $this->deleteRemovedCategories($postId, $categoryIds);
            $this->create(['post_id' => $postId]);
            return;
        }

        $this->deleteRemovedCategories($postId, $categoryIds);
        
        foreach ($categoryIds as $categoryId) {
            $this->create([
                'post_id' => $postId,
                'category_id' => $categoryId
            ]);
        }
    }

    public function deleteRemovedCategories($postId, $categoryIds)
    {
        $delete = Delete::new($this->connection)
            ->from($this->table)
            ->whereEquals(['post_id' => $postId])
            ->andWhereSprintf('category_id NOT IN %s', $categoryIds);
        $delete->perform();
    }

    public function getCategoriesByPostId(int $postId): array
    {
        $categories = $this->query->table($this->table)->select()->where('post_id', $postId)->run();

        var_dump($categories); die;

        $categoryIds = [];
        
        if ($categories) {
            foreach ($categories as $category) {
                $categoryIds[] = $category->category_id;
            }
        }
        
        return $categoryIds;
    }
}