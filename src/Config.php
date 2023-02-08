<?php

namespace Core;

class Config
{
    private $registry = [];

    /**
     * Checks if an entry exists in the registry
     *
     * @param string $key Key to check for in the registry
     *
     * @return bool
     */
    public function __isset($key)
    {
        return array_key_exists($key, $this->registry);
    }

    /**
     * Sets a record in the registry
     *
     * @param string $key Array key for the entry
     * @param mixed $val Value for the entry
     */
    public function __set($key, $val)
    {
        if (!array_key_exists($key, $this->registry)) {
            $this->registry[$key] = (object)$val;
        }
    }

    /**
     * Get a record from the registry
     *
     * @param string $key Array key for the record to get
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->registry)) {
            return $this->registry[$key];
        }

        return null;
    }
}
