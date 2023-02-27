<?php
declare(strict_types=1);

use Atlas\Pdo\Connection;

/**
 * The Core Bootstrap File
 *
 */

// Define the app version
define('CORE_VERSION', '1.0.0');

// Define the DATABASE version
define('CORE_DB_VERSION', '1'); // Increment on every DB change.

// Define required PHP version
define('CORE_PHP', '8.1');

// Define installation root path
define('CORE_ROOT', __DIR__);

// Compare PHP versions against our required version
if (!version_compare(PHP_VERSION, CORE_PHP, '>=')) {
    exit(
        'Core require PHP ' . CORE_PHP . ' or higher, you currently have PHP ' . PHP_VERSION
    );
}

var_dump('here'); exit;

// Set default timezone, we'll base off of this later
date_default_timezone_set('UTC');

// Require Autoloader
require_once(CORE_ROOT . '/vendor/autoload.php');

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Initialize the session, flash and form
$session = new Core\Session();
$flash = new Core\Flash($session);
$form = new Core\Form($session, $flash);

if ($_ENV['APP_DEBUG'] === 'true') {
    // Use our own exception handler (with Whoops)
    Core\Exception\CoreException::handle();
}

// Check if the configuration file exists
if (!file_exists(CORE_ROOT . '/config.php')) {
    exit('Configuration file not found.');
}

require_once CORE_ROOT . '/config.php';

// Get Database configuration details
$dbConfig = $config->database;

$connection = Connection::new("mysql:host=$dbConfig->host;dbname=$dbConfig->name;charset=$dbConfig->charset", $dbConfig->user, $dbConfig->password);
