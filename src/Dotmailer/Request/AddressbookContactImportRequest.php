<?php

namespace Dotmailer\Request;

use Dotmailer\Config;
use Dotmailer\Entity\ContactImport;
use Dotmailer\Collection\ContactCollection;
use Dotmailer\Request\AbstractContactImportRequest;


class AddressbookContactImportRequest extends AbstractContactImportRequest
{

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->request = new Request($config);
        $this->request->setEndpoint('address-books');
    }

    /**
     * Import a list of new contacts.
     * http://api.dotmailer.com/v2/help/wadl#AddressBookContactsImport
     *
     * @param  ContactCollection $contacts    A collection of contacts to import.
     * @param  Addressbook|int   $addressbook An addressbook, or addressbook ID to import to.
     * @return ContactImport                  A ContactImport record, including the import ID.
     */
    public function create(ContactCollection $contacts, $addressbook)
    {
        $csv = $this->createCSVFromCollection($contacts);
        $args = array(
            'filename' => time().'.csv',
            'data' => base64_encode($csv)
        );
        $addressbook_id = $this->findId($addressbook);
        $response = $this->request->send('post', '/'.$addressbook_id.'/contacts/import', $args);
        return new ContactImport($response);
    }


}
