<?php 

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

$postId = $_GET['post_id'];

$post = $container->get(Core\Models\Post::class);
$flash = $container->get(Core\Models\Flash::class);

$id = ($post->get('id', $postId)['id']) ?? null;

if ($id) {
    // Set post status to DRAFT
    $result = $post->update(['id' => $id], ['status' => 'DRAFT']);

    if ($result > 0) {
        $flash->set('success', 'Post restored');
        Utility::redirect($config->site->url . '/bms/posts/status/trash/');    
    } else {
        $flash->set('error', 'Unable to restore post');
        Utility::redirect($config->site->url . '/bms/posts/status/trash/');    
    }
} else {
    $flash->set('error', 'Invalid action');
    Utility::redirect($config->site->url . '/bms/posts/status/trash/');
}

