<?php
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

// Set default timezone, we'll base off of this later
date_default_timezone_set('UTC');

// Require Autoloader
require_once(CORE_ROOT . '/vendor/autoload.php');

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

if ($_ENV['APP_DEBUG'] === 'true') {
    // Use our own exception handler (with Whoops)
    Core\Exception\CoreException::handle();
}

// Require the configuration file
require_once(CORE_ROOT . '/config.php');

// Get Database configuration details
$db = $config->database;

// Connect to the Database
try {
    Core\Database::instance()->connect("mysql:host=$db->host;dbname=$db->name", $db->user, $db->password);
} catch (Core\Exception\DatabaseException $e) {
    $config->debug->logPath = __DIR__ . '/logs/db.log';
    $logger = Core\Log::factory($config);
    $logger->error($e->getMessage());
}
