<?php

$config = new Core\Config;

// Database configuration settings
$config->database = [
    'host'         => $_ENV['DB_HOST'],
    'name'         => $_ENV['DB_NAME'],
    'user'         => $_ENV['DB_USER'],
    'password'     => $_ENV['DB_PASSWORD'],
    'table_prefix' => $_ENV['DB_TABLE_PREFIX'],
];

// Database table configurations
$config->database_tables = [
    'users'    => $config->database->table_prefix . 'users',
    'sessions' => $config->database->table_prefix . 'sessions',
    'requests' => $config->database->table_prefix . 'requests',
];

// Debug configuration settings
$config->debug = [
    'on'       => $_ENV['APP_DEBUG'],
    'logPath'  => __DIR__ . '/error.log',
];

// Site configuration settings
$config->site = [
    'name'             => $_ENV['APP_NAME'],
    'url'              => $_ENV['APP_URL'],
    'key'              => $_ENV['APP_KEY'],
    'captcha_secret'   => $_ENV['CAPTCHA_SECRET'],
    'captcha_site_key' => $_ENV['CAPTCHA_SITEKEY'],
];

// Cookie configuration settings
$config->cookie = [
    'login' => [
        'name'   => '__auth',
        'expire' => strtotime('+30 days'),
    ],
];

// Mail configuration settings
$config->mail = [
    'mailgun_api_key' => $_ENV['MAILGUN_API_KEY'],
    'domain'          => $_ENV['MAILGUN_DOMAIN'],
];
