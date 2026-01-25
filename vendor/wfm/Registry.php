<?php

namespace Wfm;

class Registry
{
    use TSingleton;

    /**
     * @var array
     */
    protected static array $properties = [];

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setProperty(string $name, mixed $value): void
    {
        self::$properties[$name] = $value;
    }
    /**
     * @param string $name
     * @return mixed
     */
    public function getProperty(string $name): mixed
    {
        return self::$properties[$name] ?? null;
    }
    /**
     * @return array
     */
    public function getProperties(): array
    {
        return self::$properties;
    }
}