<?php

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

$status = $_GET['status'] ?? null;
$commentId = $_GET['comment_id'] ?? null;
$comment = $container->get(Core\Models\Comment::class);

$ref = $_SERVER['HTTP_REFERER'];
$ref = explode('/', $ref);

$ref = $ref[6] ?? null;

if (!is_null($ref) && !in_array($ref, ['mine', 'pending', 'approved', 'spam', 'trash'])) {
    $flash->set('error', 'Invalid Action');
    Utility::redirect($config->site->url . '/bms/comments/');
}

if (!in_array($status, ['pending', 'approved', 'spam', 'trash', 'notspam', 'restore'])) {
    $flash->set('error', 'Invalid Action');
    Utility::redirect($config->site->url . '/bms/comments/');
}

if (!$comment->get('id', $commentId)) {
    $flash->set('error', 'Invalid Action');
    Utility::redirect($config->site->url . '/bms/comments/');
}

try {   
    if (in_array($status, ['spam', 'trash'])) {
        $statusHistory = $comment->get('status', $commentId)['status'];
    }

    if (in_array($status, ['notspam', 'restore'])) {
        $status = $comment->get('status_history', $commentId)['status_history'];
    }

    if ($ref == 'trash' && $status == 'spam') {
        $status = 'spam';
        $statusHistory = $comment->get('status_history', $commentId)['status_history'];
    }
    
    $affected = $comment->update(['id' => $commentId], [
        'status'         => strtoupper($status),
        'status_history' => $statusHistory ?? null
    ]);

    if ($affected > 0) {
        $flash->set('success', 'Comment status updated');
        Utility::redirect($config->site->url . '/bms/comments/'. (!is_null($ref) ? '/status/' . $ref : ''));
    } 

    $flash->set('error', 'Unable to ' . ucfirst($status) . ' comment');
    Utility::redirect($config->site->url . '/bms/comments/'. (!is_null($ref) ? '/status/' . $ref : ''));
} catch (Exception $e) {
    $flash->set('error', 'An error occurred.');
    Utility::redirect($config->site->url . '/bms/comments/'. (!is_null($ref) ? '/status/' . $ref : ''));
}
