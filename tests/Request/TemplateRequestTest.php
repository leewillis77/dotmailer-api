<?php

namespace Dotmailer;

use Dotmailer\Entity\Template;
use Dotmailer\Request\TemplateRequest;
use PHPUnit\Framework\TestCase;

require('tests/bootstrap.php');

class TemplateRequestTest extends TestCase
{
    private $config;
    private $request;

    public function __construct()
    {
        $this->config = new Config('config/config.yml');
    }

    public function setUp(): void
    {
        $this->request = new TemplateRequest($this->config);
    }

    public function tearDown(): void
    {
        unset($this->request);
    }

    public function testCreate()
    {
        $template = new Template();
        $template->name             = 'Test Template';
        $template->subject          = 'Test subject';
        $template->fromName         = 'Test user';
        $template->htmlContent      = '<html><a href="http://$UNSUB$">Unsubscribe</a></html>';
        $template->plainTextContent = 'Test Template - $UNSUB$';
        try {
            $response = $this->request->create($template);
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Entity\Template', $response);
        $this->assertGreaterThan(0, $response->id);
        return $response;
    }

    /**
     * @depends testCreate
     *
     * This depends on testCreate so that we can assert that at least one record
     * is returned. The parameter is unused however.
     */
    public function testGetAll($ignored)
    {
        try {
            $response = $this->request->getAll();
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Collection\TemplateCollection', $response);
        $this->assertGreaterThan(0, count($response));
        return $response[0];
    }

    /**
     * @depends testGetAll
     */
    public function testGet($template)
    {
        try {
            $response = $this->request->get($template->id);
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Entity\Template', $response);
        $this->assertGreaterThan(0, count($response));
        return $response;
    }

    /**
     * @depends testCreate
     */
    public function testUpdate($template)
    {
        $template->name .= " - ".time();
        try {
            $response = $this->request->update($template);
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Entity\Template', $response);
        $this->assertGreaterThan(0, count($response));
    }
}
