<?php 

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

$postId = $_GET['post_id'];

$postCategory = $container->get(Core\Models\PostCategory::class);
$post = $container->get(Core\Models\Post::class);

$id = ($post->get('id', $postId)['id']) ?? null;

if ($id) {
    // Delete Post Tags
    $postTag->delete(['post_id' => $id]);

    // TODO: Delete Post Comments

    // TODO: Delete Post Featured Image

    // TODO: Delete all images in post content

    // Delete Post Categories
    $postCategory->delete(['post_id' => $id]);

    // Delete Post
    $result = $post->delete(['id' => $id]);

    if ($result > 0) {
        $flash->set('success', 'Post permanently deleted');
        Utility::redirect($config->site->url . '/bms/posts/');    
    } else {
        $flash->set('error', 'Unable to delete post');
        Utility::redirect($config->site->url . '/bms/posts/');    
    }
} else {
    $flash->set('error', 'Invalid action');
    Utility::redirect($config->site->url . '/bms/posts/');
}

