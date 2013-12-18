<?php

namespace Dotmailer\Request;

use Dotmailer\Config;
use Dotmailer\Collection\SegmentCollection;

class SegmentRequest
{
    private $request;

    public function __construct(Config $config)
    {
        $this->request = new Request($config);
        $this->request->setEndpoint('segments');
    }

    public function getAll($args = array())
    {
        $this->request->setArgs($args);
        $segments = $this->request->send('get', '');
        if (count($segments)) {
            return new SegmentCollection($segments);
        } else {
            return $segments;
        }
    }
}
