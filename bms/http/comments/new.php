<?php 

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$user = new Core\Models\User($connection);

$postSlug = Utility::escape($_POST['post_slug']);

try {
    $createdAt = Carbon\Carbon::now()->format('Y-m-d H:i:s');

    $input = [
        'author_name'    => isset($_POST['name']) ? Utility::escape($_POST['name']) : null,
        'author_email'   => isset($_POST['email']) ? Utility::escape($_POST['email']) : null,
        'author_website' => isset($_POST['website']) ? Utility::escape($_POST['website']) : null,
        'content'        => isset($_POST['comment']) ? Utility::escape($_POST['comment']) : null,
        'post_id'        => isset($_POST['post_id']) ? Utility::escape($_POST['post_id']) : null,
        'parent'         => isset($_POST['parent']) ? Utility::escape($_POST['parent']) : 0,
        'status'         => 'PENDING',
        'user_id'        => !empty($_POST['user_id']) ? Utility::escape($_POST['user_id']) : 0,
        'created_at'     => $createdAt,
    ];

    $validator = new Core\Validator([
        'post_id'   => 'required|numeric',
        'content'    => 'required',
    ]);

    $messages = [
        'content' => [
            'required' => 'You cannot post an empty comment'
        ],
    ];

    if (!$validator->validate($input, $messages)) {
        foreach ($validator->getErrors() as $error) {
            $flash->set('error', $error[0]);
        }
        Utility::redirect($config->site->url . '/blog/' . $postSlug . '#comment_box');
    }

    $userRole = new Core\Models\UserRole($connection);
    $role = new Core\Models\Role($connection);

    if ($input['user_id'] != 0 && $role->get('name', $userRole->getUserRoleId($input['user_id']))['name'] == 'Administrator') {
        $input['status'] = 'APPROVED';
        $pending = false;
    } elseif ($input['user_id'] != 0 && $role->get('name', $userRole->getUserRoleId($input['user_id']))['name'] != 'Administrator') {
        $pending = true;
        $email = $user->get('email', $input['user_id'])['email'];
        $name = $user->get('display_name', $input['user_id'])['display_name'];
    } else {
        $pending = true;
        $email = $input['author_email'];
        $name = $input['author_name'];
    }

    $comment = new Core\Models\Comment($connection);

    $commentId = $comment->create($input);

    if ($commentId > 0) {
        if ($pending) {
            $flash->set('pending_comment', [
                'comment_id' => $commentId,
                'email'      => $email,
                'name'       => $name, 
                'date'       => $createdAt,
                'comment'    => $input['content'],
            ]);
        }
        
        Utility::redirect($config->site->url . '/blog/' . $postSlug . '#comment-'.$commentId);
    }

    $flash->set('error', 'Error posting comment');
    Utility::redirect($config->site->url . '/blog/' . $postSlug . '#comment_box');
} catch (Exception $e) {
    $flash->set('error', 'Something went wrong, please try again');
    Utility::redirect($config->site->url . '/blog/' . $postSlug . '#comment_box');
}
