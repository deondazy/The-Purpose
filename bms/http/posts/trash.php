<?php 

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

$postId = $_GET['post_id'];

$post = $container->get(Core\Models\Post::class);
$flash = $container->get(Core\Flash::class);

$id = ($post->get('id', $postId)['id']) ?? null;

if ($id) {
    // Set post status to TRASH
    $result = $post->update(['id' => $id], ['status' => 'TRASH']);

    if ($result > 0) {
        $flash->set('success', 'Post moved to trash');
        Utility::redirect($config->site->url . '/bms/posts/');    
    } else {
        $flash->set('error', 'Unable to move post to trash');
        Utility::redirect($config->site->url . '/bms/posts/');    
    }
} else {
    $flash->set('error', 'Invalid action');
    Utility::redirect($config->site->url . '/bms/posts/');
}

