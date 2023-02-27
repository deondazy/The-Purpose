<?php 

require_once __DIR__ . '/../../bootstrap.php';

if (!isset($currentUserId)) {
    $flash->set('error', 'Please sign in');
    Core\Utility::redirect($config->site->url . '/bms/sign-in/?refurl='.urlencode($_SERVER['REQUEST_URI']));
}
