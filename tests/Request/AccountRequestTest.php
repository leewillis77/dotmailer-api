<?php

namespace Dotmailer;

use PHPUnit\Framework\TestCase;
use Dotmailer\Request\AccountRequest;

require('tests/bootstrap.php');

class AccountRequestTest extends TestCase
{
    private $config;
    private $request;

    public function __construct()
    {
        $this->config = new Config('config/config.yml');
    }

    public function setUp(): void
    {
        $this->request = new AccountRequest($this->config);
    }

    public function tearDown(): void
    {
        unset($this->request);
    }

    public function testAccountRequest()
    {
        try {
            $info = $this->request->info();
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertGreaterThan(0, count($info));
        $this->assertInstanceOf('Dotmailer\Entity\Account', $info);
        $this->assertNotEmpty($info->id);
    }
}
