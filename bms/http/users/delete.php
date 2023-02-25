<?php 

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

$user = $container->get(Core\Models\User::class);
$flash = $container->get(Core\Flash::class);

$id = $user->get('id', $_GET['user_id'] ?? null)['id'] ?? null;

if (!$id) {
    $flash->set('error', 'Invalid action');
    Utility::redirect($config->site->url . '/bms/users/');
} 

$result = $user->delete(['id' => $id]);

if ($result > 0) {
    $flash->set('success', 'User deleted');
    Utility::redirect($config->site->url . '/bms/users/');    
} 

$flash->set('error', 'Unable to delete user');
Utility::redirect($config->site->url . '/bms/users/');    

