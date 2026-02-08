<?php

namespace Wfm;

use Exception;

trait TSingleton
{
    protected static ?self $instance = null;

    private function __construct()
    {
        //
    }

    private function __clone()
    {
        //
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception('Cannot unserialize singleton');
    }
    /**
     * @return static
     */
    public static function getInstance(): static
    {
        return static::$instance ??= new static();
    }
}