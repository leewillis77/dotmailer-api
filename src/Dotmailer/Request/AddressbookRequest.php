<?php

namespace Dotmailer\Request;

use Dotmailer\Config;
use Dotmailer\Entity\Addressbook;
use Dotmailer\Entity\Contact;
use Dotmailer\Entity\Campaign;
use Dotmailer\Collection\AddressbookCollection;
use Dotmailer\Collection\CampaignCollection;
use Dotmailer\Collection\ContactCollection;

class AddressbookRequest
{
    private $request;

    public function __construct(Config $config)
    {
        $this->request = new Request($config);
        $this->request->setEndpoint('address-books');
    }

    private function findId($book)
    {
        if (is_scalar($book)) {
            $book_id = $book;
        } elseif (is_object($book)) {
            $book_id = $book->id;
        } else {
            throw new Exception('Invalid book reference.');
        }
        return $book_id;
    }

    private function findContactId($contact)
    {
        if (is_scalar($contact)) {
            $contact_id = $contact;
        } elseif (is_object($contact)) {
            $contact_id = $contact->id;
        } else {
            throw new Exception('Invalid contact reference.');
        }
        return $contact_id;
    }

    public function getAllPublic($args = array())
    {
        $this->request->setArgs($args);
        $books = $this->request->send('get', '/public');
        if (count($books)) {
            return new AddressbookCollection($books);
        } else {
            return $books;
        }
    }

    public function getAllPrivate($args = array())
    {
        $this->request->setArgs($args);
        $books = $this->request->send('get', '/private');
        if (count($books)) {
            return new AddressbookCollection($books);
        } else {
            return $books;
        }
    }

    public function getAll($args = array())
    {
        $this->request->setArgs($args);
        $books = $this->request->send('get', '');
        if (count($books)) {
            return new AddressbookCollection($books);
        } else {
            return $books;
        }
    }

    public function getById($addressbook_id)
    {
        $book = $this->request->send('get', '/' . $addressbook_id);
        if ($book) {
            return new Addressbook($book);
        }
    }

    public function getCampaigns($addressbook_id, $args = array())
    {
        $this->request->setArgs($args);
        $campaigns = $this->request->send('get', '/' . $addressbook_id . '/campaigns');

        if (count($campaigns)) {
            return new CampaignCollection($campaigns);
        } else {
            return $campaigns;
        }
    }

    public function getContacts($addressbook_id, $args = array())
    {
        return $this->doGetContacts($addressbook_id, '', null, $args);
    }

    public function getContactsModifiedSince($addressbook_id, $date, $args = array())
    {
        return $this->doGetContacts($addressbook_id, '/modified-since/', $date, $args);
    }

    public function getContactsUnsubscribedSince($addressbook_id, $date, $args = array())
    {
        return $this->doGetContacts($addressbook_id, '/unsubscribed-since/', $date, $args);
    }

    private function doGetContacts($addressbook_id, $slug = '', $date = null, $args = array())
    {
        $path = maybeAddDate($date, $slug, $path);
        $this->request->setArgs($args);
        $contacts = $this->request->send('get', '/' . $addressbook_id . '/contacts');
        if (count($contacts)) {
            return new ContactCollection($contacts);
        } else {
            return $contacts;
        }
    }

    public function create(Addressbook $book)
    {
        return new Addressbook($this->request->send('post', '', $book));
    }

    public function update(Addressbook $book)
    {
        return $this->request->send('put', '/' . $this->findId($book), $book);
    }

    /**
     * @param  Addressbook|Int $book Either a fully loaded Addressbook object, or an Addressbook ID
     */
    public function delete($book)
    {
        return $this->request->send('delete', '/' . $this->findId($book));
    }

    public function addContact($book, Contact $contact)
    {
        return $this->request->send('post', '/' . $this->findId($book) . '/contacts', $contact);
    }

    public function removeContacts($book)
    {
        return $this->request->send('delete', '/' . $this->findId($book) . '/contacts');
    }

    public function removeContact($book, $contact)
    {
        return $this->request->send(
            'delete',
            '/' . $this->findId($book) . '/contacts/' . $this->findContactId($contact)
        );
    }
}
