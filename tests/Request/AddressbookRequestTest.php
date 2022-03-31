<?php

namespace Dotmailer;

use Dotmailer\Entity\Addressbook;
use Dotmailer\Entity\DataItem;
use Dotmailer\Entity\Contact;
use Dotmailer\Collection\DataItemCollection;
use Dotmailer\Request\AddressbookRequest;
use PHPUnit\Framework\TestCase;

require('tests/bootstrap.php');

class AddressbookRequestTest extends TestCase
{
    private $config;
    private $request;

    public function __construct()
    {
        $this->config = new Config('config/config.yml');
    }

    public function setUp(): void
    {
        $this->request = new AddressbookRequest($this->config);
    }

    public function tearDown(): void
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
        return $response;
    }

    /**
     * @depends testCreatePublic
     * @depends testAddContact
     */
    public function testUnsubscribeContact($book, $contact)
    {
        try {
            $response = $this->request->unsubscribeContact($book->id, $contact);
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
        return array($book, $contact);
    }

    /**
     * @depends testUnsubscribeContact
     */
    public function testResubscribeContact($objects)
    {
        $book = $objects[0];
        $contact = $objects[1];
        try {
            $response = $this->request->resubscribeContact($book->id, $contact);
        } catch (\Exception $e) {
            $this->fail('Request exception received');
        }
    }

    /**
     * @depends testCreatePublic
     */
    public function testRemoveContacts($book)
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
        $contacts[0] = new Contact(
            array(
                'email' => 'delete_test1@example.com',
                'dataFields' => new DataItemCollection(
                    array(
                        $firstname,
                        $lastname,
                    )
                )
            )
        );
        $contacts[1] = new Contact(
            array(
                'email' => 'delete_test2@example.com',
                'dataFields' => new DataItemCollection(
                    array(
                        $firstname,
                        $lastname,
                    )
                )
            )
        );
        $contacts[2] = new Contact(
            array(
                'email' => 'delete_test3@example.com',
                'dataFields' => new DataItemCollection(
                    array(
                        $firstname,
                        $lastname,
                    )
                )
            )
        );
        try {
            // Add the three contacts to the addressbook.
            $response = $this->request->addContact($book->id, $contacts[0]);
            $to_remove[] = $response->id;
            $response = $this->request->addContact($book->id, $contacts[1]);
            $to_remove[] = $response->id;
            $response = $this->request->addContact($book->id, $contacts[2]);
            $to_remove[] = $response->id;
            // Try and bulk remove them.
            $response = $this->request->removeContacts($book->id, $to_remove);
        } catch (\Exception $e) {
            $this->fail('Request exception received: ');
        }
        return $response;
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
