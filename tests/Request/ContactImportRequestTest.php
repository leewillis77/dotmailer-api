<?php

namespace Dotmailer;

use Dotmailer\Config;
use Dotmailer\Collection\ContactCollection;
use Dotmailer\Collection\DataItemCollection;
use Dotmailer\Entity\Contact;
use Dotmailer\Entity\DataItem;
use Dotmailer\Request\ContactImportRequest;
use Dotmailer\Request\ContactRequest;


require('tests/bootstrap.php');

class ContactImportRequestTest extends \PHPUnit_Framework_TestCase
{
    private $config;
    private $request;

    public function __construct()
    {
        $this->config = new Config('config/config.yml');
    }

    public function setUp()
    {
        $this->request = new ContactImportRequest($this->config);
    }

    public function tearDown()
    {
        unset($this->request);
    }

    public function testImport()
    {
        $firstname = new DataItem(array('key' => 'FIRSTNAME', 'value' => 'Lee'));
        $lastname = new DataItem(array('key' => 'LASTNAME', 'value' => 'Willis'));
        $arr = array(
            'email' => 'lee@example.com',
            'dataFields' => new DataItemCollection(array($firstname, $lastname)),
        );
        $contact_list[] = new Contact($arr);
        
        $firstname = new DataItem(array('key' => 'FIRSTNAME', 'value' => 'Joe'));
        $lastname = new DataItem(array('key' => 'LASTNAME', 'value' => 'Bloggs'));
        $arr = array(
            'email' => 'joe@example.com',
            'dataFields' => new DataItemCollection(array($firstname, $lastname)),
        );
        $contact_list[] = new Contact($arr);
        
        $firstname = new DataItem(array('key' => 'FIRSTNAME', 'value' => 'Fred'));
        $lastname = new DataItem(array('key' => 'LASTNAME', 'value' => 'Flintstone'));
        $arr = array(
            'email' => 'fred@example.com',
            'dataFields' => new DataItemCollection(array($firstname, $lastname)),
        );
        $contact_list[] = new Contact($arr);
        
        $firstname = new DataItem(array('key' => 'FIRSTNAME', 'value' => 'Invisible'));
        $lastname = new DataItem(array('key' => 'LASTNAME', 'value' => 'Man'));
        $arr = array(
            'email' => 'invisible',
            'dataFields' => new DataItemCollection(array($firstname, $lastname)),
        );
        $contact_list[] = new Contact($arr);

        $contact_collection = new ContactCollection($contact_list);

        try {
            $response = $this->request->create($contact_collection);
        } catch (\Exception $e) {
            $this->fail('Request exception received: '.$e->api_response);
        }
        $this->assertInstanceOf('Dotmailer\Entity\ContactImport', $response);
        return $response;
    }

    /**
     * @depends testImport
     */
    public function testGetImport($import) {
        try {
            $response = $this->request->get($import->id);
        } catch (\Exception $e) {
            $this->fail('Request exception received: '.$e->api_response);
        }
        $this->assertInstanceOf('Dotmailer\Entity\ContactImport', $response);
        while(1) {
            sleep(2); // Give the import time to complete.
            try {
                $response = $this->request->get($import);
            } catch (\Exception $e) {
                $this->fail('Request exception received: '.$e->api_response);
            }
            if ($response->status == 'Finished') {
                break;
            } else {
                echo "Import not completed, re-trying.\n";
            }
        }
        $this->assertEquals('Finished', $response->status);
        return $import;
    }

    /**
     * @depends testGetImport
     */
    public function testGetImportReport($import) {
        try {
            $response = $this->request->getReport($import);
        } catch (\Exception $e) {
            $this->fail('Request exception received: '.$e->api_response);
        }
        $this->assertInstanceOf('Dotmailer\Entity\ContactImportReport', $response);
        if ($response->newContacts == 3 ||
            $response->updatedContacts == 3) {
            $this->assertTrue(true); // True if the contacts are flagged as new OR updated.
        } else {
            $this->assertTrue(false); // Fail if they're not
        }
        $this->assertEquals(1, $response->invalidEntries);
    }

    /**
     * @depends testGetImport
     */
    public function testGetImportReportFaults($import) {
        try {
            $response = $this->request->getReportFaults($import);
        } catch (\Exception $e) {
            $this->fail('Request exception received: '.$e->api_response);
        }
        $this->assertContains('Invalid Email,invisible', $response);
    }

    public static function tearDownAfterClass() {
        $config = new Config('config/config.yml');
        $request = new ContactRequest($config);
        $contact = $request->getByEmail('lee@example.com');
        if ($contact) {
            $request->delete($contact);
        }
        $contact = $request->getByEmail('joe@example.com');
        if ($contact) {
            $request->delete($contact);
        }
        $contact = $request->getByEmail('fred@example.com');
        if ($contact) {
            $request->delete($contact);
        }
    }
}
