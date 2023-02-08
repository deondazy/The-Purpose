<?php

namespace CFXP\Core;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log
{
    private static $logger;
    private static $config;

    private function __construct() {}

    public static function factory($config)
    {
        self::$config = $config;

        if (!self::$logger) {
            self::$logger = new Logger('Log');
            self::$logger->pushHandler(new StreamHandler(self::$config->debug->logPath, Logger::DEBUG));
        }

        return self::$logger;
    }

    public static function log($message, $type, array $args = [])
    {
        $logger = self::factory(self::$config);
        $logger->$type($message, $args);
    }

    public static function info($message, array $args = [])
    {
        self::log($message, 'info', $args);
    }

    public static function notice($message, array $args = [])
    {
        self::log($message, 'notice', $args);
    }

    public static function warning($message, array $args = [])
    {
        self::log($message, 'warning', $args);
    }

    public static function error($message, array $args = [])
    {
        self::log($message, 'error', $args);
    }
}
