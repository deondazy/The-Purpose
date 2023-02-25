<?php

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$flash = $container->get(Core\Flash::class);

try {
    $username    = trim($_POST['username']);
    $firstName   = trim($_POST['first_name']) ?? null;
    $lastName    = trim($_POST['last_name']) ?? null;
    $displayName = !empty($firstName) ? ($lastName ? $firstName . ' ' . $lastName : $firstName) : ($lastName ?: $username);

    $input = [
        'username'     => $username,
        'email'        => trim($_POST['email']),
        'first_name'   => $firstName,
        'last_name'    => $lastName,
        'website'      => trim($_POST['website']) ?? null,
        'display_name' => $displayName,
        'password'     => trim($_POST['password']),
    ];

    $validator = new Core\Validator([
        'username' => 'required|min:3|max:255',
        'email'    => 'required|email',
        'password' => 'min:8',
    ]);

    if (!$validator->validate($input)) {
        foreach ($validator->getErrors() as $error) {
            $flash->set('error', $error[0]);
        }
        Utility::redirect($config->site->url . '/bms/users/new/');
    }

    $input['password'] = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    $user = $container->get(Core\Models\User::class);

    $userId = $user->create($input);

    if ($userId > 0) {
        // if somehow role is not set or anything not in roles ID, default to Reader (1)
        $role = (!empty($_POST['role']) && in_array($_POST['role'], ['1', '2', '3', '4'])) ? $_POST['role'] : 4;

        ($container->get(Core\Models\UserRole::class))->create(['user_id' => $userId, 'role_id' => $role]);
        
        $flash->set('success', 'New User Added');
        Utility::redirect($config->site->url . '/bms/users/');
    }

    $flash->set('error', 'Error adding user');
    Utility::redirect($config->site->url . '/bms/users/new/');
} catch (Exception $e) {
    $flash->set('error', 'An error occurred while adding user.');
    Utility::redirect($config->site->url . '/bms/users/new/');
}
