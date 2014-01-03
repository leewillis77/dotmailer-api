<?php

namespace Dotmailer;

use Symfony\Component\Yaml\Parser;

class Config
{
    protected $config;

    public function __construct($config_params)
    {
        $this->load($config_params);
    }

    private function load($filename) {
        $parser = new Parser();
        $this->config = $parser->parse(file_get_contents($filename));
    }
    
    public function __get($key)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        } else {
            return null;
        }
    }
}
