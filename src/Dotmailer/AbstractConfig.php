<?php

namespace Dotmailer;

abstract class AbstractConfig
{
    /**
     * @var array
     */
    protected $config;

    public function __get($key)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        } else {
            return null;
        }
    }
}
