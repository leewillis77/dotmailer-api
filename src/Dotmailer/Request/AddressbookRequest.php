<?php

namespace Dotmailer\Request;

use Dotmailer\Config;
use Dotmailer\Entity\Addressbook;
use Dotmailer\Entity\Contact;
use Dotmailer\Entity\Campaign;
use Dotmailer\Entity\Resubscription;
use Dotmailer\Collection\AddressbookCollection;
use Dotmailer\Collection\CampaignCollection;
use Dotmailer\Collection\ContactCollection;

class AddressbookRequest
{
    private $request;

    /**
     * Constructor. Set the default endpoint, and create a request ready for processing.
     *
     * @param Config $config A Dotmailer config object
     */
    public function __construct(Config $config)
    {
        $this->request = new Request($config);
        $this->request->setEndpoint('address-books');
    }

    /**
     * Helper function to extract an addressbook ID from either an int, or an addressbook object.
     * @param  int|Addressbook $book The variable to extract the ID from.
     * @return int                   An addressbook ID.
     */
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

    /**
     * Helper function to extract a contact ID from either an int, or an contact object.
     * @param  int|Contact $contact The variable to extract the ID from.
     * @return int                  A contact ID.
     */
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

    /**
     * Get all public addressbooks.
     * https://api.dotmailer.com/v2/address-books/public?select={select}&skip={skip}
     *
     * @param  array                 $args An array of (optional) query args.
     * @return AddressbookCollection       An object containing all matching addressbooks.
     */
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

    /**
     * Get all private addressbooks.
     * https://api.dotmailer.com/v2/address-books/private?select={select}&skip={skip}
     *
     * @param  array                 $args An array of (optional) query args.
     * @return AddressbookCollection       An object containing all matching addressbooks.
     */
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

    /**
     * Get all addressbooks.
     * https://api.dotmailer.com/v2/address-books?select={select}&skip={skip}
     *
     * @param  array                 $args An array of (optional) query args.
     * @return AddressbookCollection       An object containing all matching addressbooks.
     */
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

    /**
     * Get a specific addressbook.
     * https://api.dotmailer.com/v2/address-books/{id}
     *
     * @param  int         $addressbook_id The ID of the addressbook to retrieve.
     * @return Addressbook                 The addressbook object.
     */
    public function getById($addressbook_id)
    {
        $book = $this->request->send('get', '/' . $addressbook_id);
        if ($book) {
            return new Addressbook($book);
        } else {
            throw new Exception('Could not retrieve book details.');
        }
    }

    /**
     * Get a list of campaigns for the given addressbook.
     * https://api.dotmailer.com/v2/address-books/{addressBookId}/campaigns?select={select}&skip={skip}
     *
     * @param  int|Addressbook    $book  The addressbook, or addressbook ID to retrieve
     *                                   campaigns for.
     * @param  array              $args  An array of (optional) query args.
     * @return CampaignCollection        A list of the matching campaigns.
     */
    public function getCampaigns($book, $args = array())
    {
        $this->request->setArgs($args);
        $campaigns = $this->request->send('get', '/' . $this->findId($book) . '/campaigns');

        if (count($campaigns)) {
            return new CampaignCollection($campaigns);
        } else {
            throw new Exception('Could not retrieve campaign details.');
        }
    }

    /**
     * Get a list of contacts subscribed to the addressbook.
     * https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts?withFullData={withFullData}&select={select}&skip={skip}
     *
     * @param  int|Addressbook   $book The addressbook to get contacts for.
     * @param  array             $args An array of (optional) query args.
     * @return ContactCollection       A list of the matching contacts.
     */
    public function getContacts($addressbook_id, $args = array())
    {
        return $this->doGetContacts($addressbook_id, '', null, $args);
    }

    /**
     * Get a list of contacts subscribed to the addressbook modified since a specified date.
     * https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts/modified-since/{date}?withFullData={withFullData}&select={select}&skip={skip}
     *
     * @param  int|Addressbook $addressbook_id The addressbook to get contacts for.
     * @param  string          $date           The date constraint for the query.
     * @param  array           $args           An array of (optional) query args.
     * @return ContactCollection               A list of the matching contacts.
     */
    public function getContactsModifiedSince($addressbook_id, $date, $args = array())
    {
        return $this->doGetContacts($addressbook_id, '/modified-since/', $date, $args);
    }

	/**
     * Get a list of contacts subscribed to the addressbook unsubscribed since a specified date.
     * https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts/unsubscribed-since/{date}?withFullData={withFullData}&select={select}&skip={skip}
     *
     * @param  int|Addressbook $addressbook_id The addressbook to get contacts for.
     * @param  string          $date           The date constraint for the query.
     * @param  array           $args           An array of (optional) query args.
     * @return ContactCollection               A list of the matching contacts.
     */
    public function getContactsUnsubscribedSince($addressbook_id, $date, $args = array())
    {
        return $this->doGetContacts($addressbook_id, '/unsubscribed-since/', $date, $args);
    }

    /**
     * Internal helper function for getContact enquiries
     * @param  int|Addressbook   $addressbook_id The addressbook to get contacts for.
     * @param  string            $slug           The slug of the enquiry endpoint.
     * @param  string            $date           The date constraint for the query.
     * @param  array             $args           An array of (optional) query args.
     * @return ContactCollection                 A list of the matching contacts.
     */
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

    /**
     * Create an addressbook entry.
     * https://api.dotmailer.com/v2/address-books
     *
     * @param  Addressbook $book The addressbook to create.
     * @return Addressbook       The created addressbook object.
     */
    public function create(Addressbook $book)
    {
        return new Addressbook($this->request->send('post', '', $book));
    }

    /**
     * Update an addressbook entry.
     * https://api.dotmailer.com/v2/address-books/{id}
     *
     * @param  Addressbook $book The addressbook to create.
     * @return Addressbook       The updated addressbook object.
     */
    public function update(Addressbook $book)
    {
        return new Addressbook($this->request->send('put', '/' . $this->findId($book), $book));
    }

    /**
     * Delete an addressbook.
     * https://api.dotmailer.com/v2/address-books/{id}
     * @todo  Wwhat does this return?
     *
     * @param  Addressbook|Int $book Either a fully loaded Addressbook object, or an Addressbook ID.
     */
    public function delete($book)
    {
        return $this->request->send('delete', '/' . $this->findId($book));
    }

    /**
     * Add a contact to an addressbook.
     * https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts
     *
     * @param int|Addressbook  $book    The addressbook to add the contact to.
     * @param Contact          $contact The contact record.
     */
    public function addContact($book, Contact $contact)
    {
        $contact = $this->request->send('post', '/' . $this->findId($book) . '/contacts', $contact);
        return new Contact($contact);
    }

    /**
     * Removes all contacts from an addressbook.
     * https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts
     * @todo   What does this return?
     *
     * @param  int|Addressbook  $book The addressbook to remove contacts from.
     * @return [type]       [description]
     */
    public function removeAllContacts($book)
    {
        return $this->request->send('delete', '/' . $this->findId($book) . '/contacts');
    }

    /**
     * Remove a specific contact from an addressbook.
     * https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts/{contactId}
     * @todo   What does this return?
     *
     * @param  int|Addressbook $book    The addressbook to remove the contact from.
     * @param  int|Contact     $contact The contact record to remove.
     * @return [type]          [description]
     */
    public function removeContact($book, $contact)
    {
        return $this->request->send(
            'delete',
            '/' . $this->findId($book) . '/contacts/' . $this->findContactId($contact)
        );
    }

    /**
     * Remove multiple contacts from an addressbook.
     * http://api.dotmailer.com/v2/help/wadl#AddressBookContactsDelete
     *
     * @param  int|Addressbook   $book     The addresssbook to remove contacts from.
     * @param  array             $contacts A plain array of contact IDs to be removed.
     */
    public function removeContacts($book, $contacts)
    {
        return $this->request->send(
            'post',
            '/' . $this->findId($book) . '/contacts/delete',
            $contacts
        );
    }

    /**
     * Unsubscribes a contact from an addressbook.
     * https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts/unsubscribe
     *
     * @param  int|Addressbook $book    The addressbook to unsubscribe the contact from.
     * @param  Contact         $contact The contact to be unsubscribed.
     */
    public function unsubscribeContact($book, $contact)
    {
        $response = $this->request->send(
            'post',
            '/' . $this->findId($book) . '/contacts/unsubscribe',
            $contact
        );
    }

    /**
     * Resubscribes a contact to an addressbook.
     * https://api.dotmailer.com/v2/address-books/{addressBookId}/contacts/resubscribe
     *
     * @param  int|Addressbook $book    The addressbook to resubscribe the contact from.
     * @param  Contact         $contact The contact to be resubscribed.
     */

    public function resubscribeContact($book, $contact)
    {
        $resubscription = new Resubscription();
        $resubscription->unsubscribedContact = $contact;
        $response = $this->request->send(
            'post',
            '/' . $this->findId($book) . '/contacts/resubscribe',
            $resubscription
        );
    }
}
