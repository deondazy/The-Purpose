<?php

$config = new Core\Config;

// TODO: Use an environment variable to set this


// Database configuration settings
$config->database = [
    'name'         => '',
    'host'         => '',
    'user'         => '',
    'password'     => '',
    'table_prefix' => '',
];

// Database table configurations
$config->database_tables = [
    'users'    => $config->database->table_prefix . 'users',
    'sessions' => $config->database->table_prefix . 'sessions',
    'requests' => $config->database->table_prefix . 'requests',
];

// Debug configuration settings
$config->debug = [
    'on'       => true,
    'logPath'  => __DIR__ . '/error.log',
];

// Site configuration settings
$config->site = [
    'name'             => '',
    'url'              => '',
    'desc'             => '',
    'key'              => '',
    'phone'            => '',
    'email'            => '', // The site Admin email
    'security_email'   => '', // Site security email
    'noreply_email'    => '', // Site noreply email
    'career_email'     => '', // Careers email
    'request_expire'   => strtotime('+1 day'),
    'captcha_secret'   => '',
    'captcha_site_key' => '',
    'address'          => '',
];

// Cookie configuration settings
$config->cookie = [
    'login' => [
        'name'   => '__auth',
        'expire' => strtotime('+30 days'),
    ],
    '_2fa' => [
        'name' => '__2fa_auth',
        'secret' => '',
        'expire' => strtotime('+30 days'),
    ]
];

// Mail configuration settings
$config->mail = [
    'mailgun_api_key' => '',
    'domain'          => '',
];
