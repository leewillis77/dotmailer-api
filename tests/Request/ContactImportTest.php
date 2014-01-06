<?php

namespace Dotmailer;

use Dotmailer\Collection\ContactCollection;
use Dotmailer\Collection\DataItemCollection;
use Dotmailer\Entity\Contact;
use Dotmailer\Entity\DataItem;
use Dotmailer\Request\ContactRequest;

require('tests/bootstrap.php');

class ContactImportTest extends \PHPUnit_Framework_TestCase
{
    private $config;
    private $request;

    public function __construct()
    {
        $this->config = new Config('config/config.yml');
    }

    public function setUp()
    {
        $this->request = new ContactRequest($this->config);
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
        $contact_collection = new ContactCollection($contact_list);

        try {
            $response = $this->request->doImport($contact_collection);
        } catch (\Exception $e) {
            print_r($e->getMessage());
            // $this->fail('Request exception received: '.$e->api_response);
        }
        $this->assertInstanceOf('Dotmailer\Entity\Contact', $response); // FIXME
        return $response;
    }


}
