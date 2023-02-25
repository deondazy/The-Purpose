<?php 

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

$user = $container->get(Core\Models\User::class);
$flash = $container->get(Core\Flash::class);

$id = $user->get('id', $_POST['userId'] ?? null)['id'] ?? null;

if (!$id) {
    $flash->set('error', 'Invalid action');
    return;
} 

// Delete Avatar Image File
$username = $user->get('username', $id)['username'];
$imageName = $user->get('avatar', $id)['avatar'];
$imageFile = CORE_ROOT . "/public/uploads/avatar/{$username}/{$imageName}";
unlink($imageFile);

$result = $user->update(['id' => $id], ['avatar' => null]);

if ($result > 0) {
    $flash->set('success', 'Avatar removed');
    return;
} 

$flash->set('error', 'Unable to remove avatar');
return;

