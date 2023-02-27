<?php 

require_once __DIR__ . '/../../bootstrap.php';

$user = new Core\Models\User($connection);
$session =new Core\Models\Session($connection);
$auth = new Core\Auth($user, $session);

if (!$auth->isLogged()) {
    $flash->set('error', 'Please sign in to access this page');
    Core\Utility::redirect($config->site->url . '/bms/sign-in/?refurl='.urlencode($_SERVER['REQUEST_URI']));
}

$currentUserId = $auth->currentUserId();
