<?php

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$auth = new Core\Auth(new Core\Models\User($connection), new Core\Models\Session($connection));

if ($auth->isLogged()) {
    $hash = $_COOKIE[$config->cookie->login['name']];
    

    if ($auth->logout($hash)) {
        if (isset($_GET['ref']) && !empty($_GET['ref'])) {
            Utility::redirect($config->site->url . $_GET['ref']);
        }

        $flash->set('success', 'You are now signed out');
        Utility::redirect($config->site->url . '/bms/sign-in/');
    }
}
