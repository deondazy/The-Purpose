<?php 

namespace Core\Models;

use Core\Models\Base;

class PostCategory extends Base
{
    public function __construct()
    {
        parent::__construct('post_categories');
    }

    public function save(int $postId, array $categoryIds): bool
    {
        try {
            // $this->deletePostCategories($postId);
            $this->insertPostCategories($postId, $categoryIds);
            return true;
        } catch (\Exception $e) {
                return false;
        }
    }
    
    private function deletePostCategories(int $postId)
    {
        if ($this->get(['post_id', $postId])) {
            $this->delete(['post_id', $postId]);
        }
    }
    
    private function insertPostCategories(int $postId, array $categoryIds): void
    {
        if (empty($categoryIds)) {
            $this->create(['post_id' => $postId]);
            return;
        }
        
        foreach ($categoryIds as $categoryId) {
            $this->create([
                'post_id' => $postId,
                'category_id' => $categoryId
            ]);
        }
    }
}