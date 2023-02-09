<?php

namespace Core\Exception;

use Exception;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

class CoreException extends Exception
{
    protected $message = '';

    public function __construct($message = 'CoreError', $code = 0)
    {
        parent::__construct($message, $code);
    }

    public static function handle()
    {
        $run = new Run;
        $handler = new PrettyPageHandler;
        $run->pushHandler($handler);
        $run->register();
    }
}
