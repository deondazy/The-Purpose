<?php 

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

$commentId = $_GET['comment_id'];

$comment = $container->get(Core\Models\Comment::class);

$ref = $_SERVER['HTTP_REFERER'];
$ref = explode('/', $ref);

$ref = $ref[6] ?? null;

if (!is_null($ref) && !in_array($ref, ['spam', 'trash'])) {
    $flash->set('error', 'Invalid Action');
    Utility::redirect($config->site->url . '/bms/comments/');
}

$id = ($comment->get('id', $commentId)['id']) ?? null;

if ($id) {
    $result = $comment->delete(['id' => $id]);

    if ($result > 0) {
        $flash->set('success', 'Comment deleted');
        Utility::redirect($config->site->url . '/bms/comments/status/'.$ref);    
    } else {
        $flash->set('error', 'Unable to delete comment');
        Utility::redirect($config->site->url . '/bms/comments/status/'.$ref);    
    }
} else {
    $flash->set('error', 'Invalid action');
    Utility::redirect($config->site->url . '/bms/comments/status/'.$ref);
}

