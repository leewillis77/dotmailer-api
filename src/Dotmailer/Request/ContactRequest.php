<?php

namespace Dotmailer\Request;

use Dotmailer\Config;
use Dotmailer\Entity\Contact;
use Dotmailer\Entity\ContactSuppression;
use Dotmailer\Entity\Resubscription;
use Dotmailer\Collection\AddressbookCollection;
use Dotmailer\Collection\ContactCollection;


class ContactRequest
{
    private $request;

    public function __construct(Config $config)
    {
        $this->request = new Request($config);
        $this->request->setEndpoint('contacts');
    }

    private function findId($contact)
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

    public function getAddressbooks($contact_id, $args = array())
    {
        $this->request->setArgs($args);
        $books = $this->request->send('get', '/' . $contact_id . '/address-books');
        if (count($books)) {
            return new AddressbookCollection($books);
        } else {
            return $books;
        }
    }

    public function getByEmail($email)
    {
        $contact = $this->request->send('get', '/' . urlencode($email));
        if (count($contact)) {
            return new Contact($contact);
        } else {
            return $contact;
        }
    }

    public function get($contact_id)
    {
        $contact = $this->request->send('get', '/' . $contact_id);
        if (count($contact)) {
            return new Contact($contact);
        } else {
            return $contact;
        }
    }

    private function getAllBy($slug, $date, $args = array())
    {
        $path = '';
        $path = maybeAddDate($date, $slug, $path);
        $this->request->setArgs($args);
        $contacts = $this->request->send('get', $path);
        if (count($contacts)) {
            return new ContactCollection($contacts);
        } else {
            return $contacts;
        }
    }

    public function getCreatedSince($date, $args = array())
    {
        return $this->getAllBy('/created-since/', $date, $args);
    }

    public function getUpdatedSince($date, $args = array())
    {
        return $this->getAllBy('/modified-since/', $date, $args);
    }

    public function getSuppressedSince($date, $args = array())
    {
        return $this->getAllBy('/suppressed-since/', $date, $args);
    }

    public function getUnsubscribedSince($date, $args = array())
    {
        return $this->getAllBy('/unsubscribed-since/', $date, $args);
    }

    public function getAll($args = array())
    {
        $this->request->setArgs($args);
        $contacts = $this->request->send('get', '');
        if (count($contacts)) {
            return new ContactCollection($contacts);
        } else {
            return $contacts;
        }
    }

    public function create(Contact $contact)
    {
        return new Contact($this->request->send('post', '', $contact));
    }

    public function update(Contact $contact)
    {
        return new Contact($this->request->send('put', '/' . $this->findId($contact), $contact));
    }

    public function delete($contact)
    {
        return $this->request->send('delete', '/' . $this->findId($contact));
    }

    /**
     * Unsubscribes a contact.
     * http://api.dotmailer.com/v2/help/wadl#ContactsUnsubscribe
     *
     * @param  Contact $contact   The contact to be unsubscribed.
     * @return ContactSuppression The contact suppression object.
     */
    public function unsubscribe($contact)
    {
        $response = $this->request->send(
            'post',
            '/unsubscribe',
            $contact
        );
        return new ContactSuppression($response);
    }

    /**
     * Resubscribes a contact.
     * http://api.dotmailer.com/v2/help/wadl#ContactsResubscribe
     *
     * @param  Contact $contact The contact to be resubscribed.
     * @return Contact          The contact record of the resubscribed user.
     */

    public function resubscribe($contact)
    {
        $resubscription = new Resubscription();
        $resubscription->unsubscribedContact = $contact;
        $response = $this->request->send(
            'post',
            '/resubscribe',
            $resubscription
        );
        return new Contact($response);
    }
}
