<?php

namespace Dotmailer;

use Symfony\Component\Yaml\Parser;

class Config extends AbstractConfig
{
    public function __construct($config_file)
    {
        $parser = new Parser();
        $this->config = $parser->parse(file_get_contents($config_file));
    }
}
