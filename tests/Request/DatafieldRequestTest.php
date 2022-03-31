<?php

namespace Dotmailer;

use Dotmailer\Config;
use Dotmailer\Request\DatafieldRequest;
use PHPUnit\Framework\TestCase;

require('tests/bootstrap.php');

class DatafieldRequestTest extends TestCase
{
    private $config;
    private $request;

    public function __construct()
    {
        $this->config = new Config('config/config.yml');
    }

    public function setUp(): void
    {
        $this->request = new DatafieldRequest($this->config);
    }

    public function tearDown(): void
    {
        unset($this->request);
    }

    public function testGetAll()
    {
        try {
            $response = $this->request->getAll();
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Collection\DatafieldCollection', $response);
        $this->assertGreaterThan(0, count($response));
    }
}
