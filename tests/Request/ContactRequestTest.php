<?php

namespace Dotmailer;

use Dotmailer\Entity\Contact;
use Dotmailer\Entity\ContactSuppression;
use Dotmailer\Entity\DataItem;
use Dotmailer\Collection\DataItemCollection;
use Dotmailer\Request\ContactRequest;
use PHPUnit\Framework\TestCase;

require('tests/bootstrap.php');

class ContactRequestTest extends TestCase
{
    private $config;
    private $request;

    public function __construct()
    {
        $this->config = new Config('config/config.yml');
    }

    public function setUp(): void
    {
        $this->request = new ContactRequest($this->config);
    }

    public function tearDown(): void
    {
        unset($this->request);
    }

    public function testCreate()
    {
        $dataitem = array('key' => 'FIRSTNAME', 'value' => 'Lee');
        $firstname = new DataItem($dataitem);
        $arr = array(
            'email' => 'lee@example.com',
            'dataFields' => new DataItemCollection(array($firstname)),
        );
        $new_contact = new Contact($arr);
        try {
            $response = $this->request->create($new_contact);
        } catch (\Exception $e) {
            $this->fail('Request exception received: '.$e->api_response);
        }
        $this->assertInstanceOf('Dotmailer\Entity\Contact', $response);
        return $response;
    }

    public function testUnsubscribe()
    {
        $dataitem = array('key' => 'FIRSTNAME', 'value' => 'Lee');
        $firstname = new DataItem($dataitem);
        $arr = array(
            'email' => 'testunsubscribe'.time().'@example.com',
            'dataFields' => new DataItemCollection(array($firstname)),
        );
        $new_contact = new Contact($arr);
        try {
            $contact = $this->request->create($new_contact);
            $response = $this->request->unsubscribe($contact);
        } catch (\Exception $e) {
            $this->fail('Request exception received: '.$e->getMessage());
        }
        $this->assertInstanceOf('Dotmailer\Entity\ContactSuppression', $response);
        return $response;
    }

    /**
     * @depends testUnsubscribe
     */
    public function testResubscribe($contact)
    {
        try {
            $response = $this->request->resubscribe($contact->suppressedContact);
        } catch (\Exception $e) {
            $this->fail('Request exception received: '.$e->getMessage());
        }
        $this->assertInstanceOf('Dotmailer\Entity\Contact', $response);
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
        $this->assertInstanceOf('Dotmailer\Collection\ContactCollection', $response);
        $this->assertGreaterThan(0, count($response));

        try {
            $response = $this->request->getAll(array('select' => 1));
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Collection\ContactCollection', $response);
        $this->assertCount(1, $response);
        return $response[0];
    }

    /**
     * @depends testCreate
     *
     * This depends on testCreate so that we can assert that at least one record
     * is returned. The parameter is unused however.
     */
    public function testGetByEmail($ignored)
    {
        try {
            $response = $this->request->getByEmail('lee@example.com');
        } catch (\Exception $e) {
            $this->fail('Request exception received: '.$e->raw_api_response);
        }
        $this->assertInstanceOf('Dotmailer\Entity\Contact', $response);
        $this->assertGreaterThan(0, count($response));
        print_r($response);
    }


}
