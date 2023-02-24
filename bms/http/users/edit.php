<?php

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$user = new Core\Models\User($connection);

$id = $user->get('id', $_POST['user_id'] ?? null)['id'] ?? null;

if (!$id) {
    $flash->set('error', 'Invalid Action');
    Utility::redirect($config->site->url . '/bms/users/');
}

try {
    $input = [
        'first_name'   => trim($_POST['first_name']),
        'last_name'    => trim($_POST['last_name']),
        'display_name' => $_POST['display_name'],
        'email'        => trim($_POST['email']),
        'website'      => trim($_POST['website']),
        'bio'          => trim($_POST['bio']),
        'password'     => trim($_POST['password']),
    ];

    $validator = new Core\Validator([
        'display_name' => 'required',
        'email'        => 'required|email',
        'password'     => 'min:8',
        'website'      => 'url',
    ]);

    $messages = [
        'password' => [
            'min' => 'Password must be at least 8 characters'
        ],
        'email' => [
            'email' => 'Please enter a valid email address'
        ],
        'website' => [
            'url' => 'Please enter a valid website URL'
        ],
    ];

    if (!$validator->validate($input, $messages)) {
        foreach ($validator->getErrors() as $error) {
            $flash->set('error', $error[0]);
        }
        Utility::redirect($config->site->url . '/bms/users/edit/'.$id);
    }

    if (!empty($input['password'])) {
        $input['password'] = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    }

    // Handle Avatar upload if it is set
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $username = $user->get('username', $id)['username'];
        $uploadPath = CORE_ROOT . "/public/uploads/avatar/{$username}/";
        $uploader = new Core\ImageUploader($uploadPath);
        
        // Resize image
        $uploader->resizeImage($_FILES['avatar'], '119', '119');

        // Upload Image
        $imageFile = $uploader->upload($_FILES['avatar']);
    
        // Add avatar to input
        $input['avatar'] = $imageFile;
    }

    // Remove empty fields
    $input = array_filter($input, function ($value) {
        return !empty($value);
    });

    // Remove any value that has not changed
    foreach ($input as $key => $value) {
        if($user->get($key, $id)[$key] == $value) {
            unset($input[$key]);
        }
    }

    if (empty($input)) {
        $flash->set('error', 'No changes to update');
        Utility::redirect($config->site->url . '/bms/users/edit/'.$id);
    }

    $result = $user->update(['id' => $id], $input);

    if ($result > 0) {
        // Check for role
        $role = $_POST['role'];

        // Check if role has changed
        $userRole = new Core\Models\UserRole($connection);

        if ($userRole->getUserRoleId($id) != $role) {
            $userRole->update(['user_id' => $id], ['role_id' => $role]);
        }
        
        $flash->set('success', 'User updated');
        Utility::redirect($config->site->url . '/bms/users/edit/'.$id);
    }

    $flash->set('error', 'Error updating user');
    Utility::redirect($config->site->url . '/bms/users/edit/'.$id);
} catch (Core\Exception\FileSizeExceededException $e) {
    $flash->set('error', $e->getMessage());
    Utility::redirect($config->site->url . '/bms/users/edit/'.$id);
} catch (Core\Exception\UnsupportedFileTypeException $e) {
    $flash->set('error', $e->getMessage());
    Utility::redirect($config->site->url . '/bms/users/edit/'.$id);
} catch (Core\Exception\InvalidFileException $e) {
    $flash->set('error', $e->getMessage());
    Utility::redirect($config->site->url . '/bms/users/edit/'.$id);
} catch (Core\Exception\InvalidImageException $e) {
    $flash->set('error', $e->getMessage());
    Utility::redirect($config->site->url . '/bms/users/edit/'.$id);
} catch (Exception $e) {
    $flash->set('error', 'Something went wrong, please try again.');
    Utility::redirect($config->site->url . '/bms/users/edit/'.$id);
}
