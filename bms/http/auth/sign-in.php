<?php

use Core\Utility;

require_once __DIR__ . '/../../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$refUrl = !empty($_POST['refurl']) ? "?refurl=".urlencode($_POST['refurl']) : null;

try {
    $input = [
        'email'    => trim($_POST['email']),
        'password' => trim($_POST['password']),
    ];

    $validator = new Core\Validator([
        'email'    => 'required|email',
        'password' => 'required'
    ]);

    $messages = [
        'email' => [
            'required' => 'Please enter your email',
            'email' => 'Please enter a valid email address',
        ],
        'password' => [
            'required' => 'Please enter your password',
        ]
        ];

    if (!$validator->validate($input, $messages)) {
        foreach ($validator->getErrors() as $error) {
            $flash->set('error', $error[0]);
        }
        Utility::redirect($config->site->url . '/bms/sign-in/'.$refUrl);
    }

    $user = new Core\Models\User($connection);
    $session = new Core\Models\Session($connection);
    $auth = new Core\Auth($user, $session);

    if ($auth->login($input['email'], $input['password'])) {
        $flash->set('success', 'Welcome to your dashboard!');

        if (!empty($refUrl)) {
            $refUrl = ltrim($refUrl, "?refurl=");
            Utility::redirect($config->site->url . urldecode($refUrl));
        }
        
        Utility::redirect($config->site->url . '/bms/');
    }

    $flash->set('error', 'Email or Password is incorrect');
    Utility::redirect($config->site->url . '/bms/sign-in/'.$refUrl);
} catch (Exception $e) {
    $flash->set('error', $e->getMessage());
    Utility::redirect($config->site->url . '/bms/sign-in/'.$refUrl);
}
