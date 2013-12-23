<?php

namespace Dotmailer;

use Dotmailer\Entity\Addressbook;
use Dotmailer\Entity\DataItem;
use Dotmailer\Entity\Contact;
use Dotmailer\Collection\DataItemCollection;
use Dotmailer\Request\AddressbookRequest;

require('tests/bootstrap.php');

class AddressbookRequestTest extends \PHPUnit_Framework_TestCase
{
    private $config;
    private $request;

    public function __construct()
    {
        $this->config = new Config('config/config.yml');
    }

    public function setUp()
    {
        $this->request = new AddressbookRequest($this->config);
    }

    public function tearDown()
    {
        unset($this->request);
    }

    public function testCreatePrivate()
    {
        $book = new Addressbook();
        $book->name = 'API Private addressbook ('.time().')';
        $book->visibility = 'Private';
        try {
            $response = $this->request->create($book);
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Entity\Addressbook', $response);
        $this->assertGreaterThan(0, $response->id);
        return $response;
    }

    public function testCreatePublic()
    {
        $book = new Addressbook();
        $book->name = 'API Public addressbook ('.time().')';
        $book->visibility = 'Public';
        try {
            $response = $this->request->create($book);
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Entity\Addressbook', $response);
        $this->assertGreaterThan(0, $response->id);
        return $response;
    }

    /**
     * @depends testCreatePublic
     */
    public function testGetById($book)
    {
        try {
            $response = $this->request->getById($book->id);
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Entity\Addressbook', $response);
        $this->assertEquals($book->id, $response->id);
    }

    /**
     * @depends testCreatePublic
     */
    public function testAddContact($book)
    {
        $firstname = new DataItem(
            array(
                'key' => 'FIRSTNAME',
                'value' => time(),
            )
        );
        $lastname = new DataItem(
            array(
                'key' => 'LASTNAME',
                'value' => 'Test user',
            )
        );
        $contact = new Contact(
            array(
                'email' => 'test@example.com',
                'dataFields' => new DataItemCollection(
                    array(
                        $firstname,
                        $lastname,
                    )
                )
            )
        );
        try {
            $response = $this->request->addContact($book->id, $contact);
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Entity\Contact', $response);
    }

    /**
     * @depends testCreatePublic
     */
    public function testGetAllPublic($book)
    {
        try {
            $response = $this->request->getAllPublic();
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Collection\AddressbookCollection', $response);
        $this->assertGreaterThan(0, count($response));
        $this->assertTrue($response->hasItemWith('id', $book->id));
    }

    /**
     * @depends testCreatePrivate
     */
    public function testGetAllPrivate($book)
    {
        try {
            $response = $this->request->getAllPrivate();
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Collection\AddressbookCollection', $response);
        $this->assertGreaterThan(0, count($response));
        $this->assertTrue($response->hasItemWith('id', $book->id));
    }

    /**
     * @depends testCreatePublic
     * @depends testCreatePrivate
     */
    public function testGetAll()
    {
        try {
            $response = $this->request->getAll();
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Collection\AddressbookCollection', $response);
        $this->assertGreaterThan(1, count($response));
    }

    /**
     * @depends testCreatePublic
     * @depends testCreatePrivate
     */
    public function testGetAllWithSelectLimit()
    {
        try {
            $response = $this->request->getAll(array('select' => 1));
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Collection\AddressbookCollection', $response);
        $this->assertCount(1, $response);
        return $response;
    }

    /**
     * @depends testGetAllWithSelectLimit
     */
    public function testGetAllWithSelectAndSkipLimit($books)
    {
        try {
            $response = $this->request->getAll(array('select' => 1, 'skip' => 1));
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Collection\AddressbookCollection', $response);
        $this->assertCount(1, $response);
        $this->assertNotEquals($response[0]->id, $books[0]->id);
    }

    /**
     * @depends testGetAllWithSelectLimit
     */
    public function testGetAllWithSkipLimit($books)
    {
        try {
            $response = $this->request->getAll(array('skip' => 1));
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertInstanceOf('Dotmailer\Collection\AddressbookCollection', $response);
        $this->assertNotEquals($response[0]->id, $books[0]->id);
    }

    /**
     * @depends testCreatePublic
     * @depends testCreatePrivate
     */
    public function testDelete($publicBook, $privateBook)
    {
        try {
            $response = $this->request->delete($publicBook);
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        try {
            $response = $this->request->delete($privateBook);
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        $this->assertTrue(true);
    }

}
