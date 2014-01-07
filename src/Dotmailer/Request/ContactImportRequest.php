<?php

namespace Dotmailer\Request;

use Dotmailer\Config;
use Dotmailer\Entity\ContactImport;
use Dotmailer\Entity\ContactImportReport;
use Dotmailer\Collection\ContactCollection;
use Dotmailer\Request\DatafieldRequest;


class ContactImportRequest
{
    private $request;
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->request = new Request($config);
        $this->request->setEndpoint('contacts');
    }

    private function findId($object)
    {
        if (is_scalar($object)) {
            $object_id = $object;
        } elseif (is_object($object)) {
            $object_id = $object->id;
        } else {
            throw new Exception('Invalid object reference.');
        }
        return $object_id;
    }

    /**
     * Import a list of new contacts. 
     * http://api.dotmailer.com/v2/help/wadl#AddressBookContactsImport
     * 
     * @param  ContactCollection $contacts A collection of contacts to import.
     * @return ContactImport               A ContactImport record, including the import ID
     */
    public function create(ContactCollection $contacts)
    {
        $csv = $this->createCSVFromCollection($contacts);
        $args = array(
            'filename' => time().'.csv',
            'data' => base64_encode($csv)
        );
        $response = $this->request->send('post', '/import', $args);
        return new ContactImport($response);
    }

    /**
     * Retrieve the details of a contact import from either a ContactImport object, or
     * the import ID.
     * 
     * @param  ContactImport|int  $import  A ContactImport object to enquire about, or the import ID.
     * @return ContactImport               The ContactImport object, or false.
     */
    public function get($import)
    {
        $response = $this->request->send('get', '/import/'.$this->findId($import));
        return new ContactImport($response);
    }

    /**
     * Get a report about the results of an import from either a ContactImport object, or the 
     * import ID.
     * 
     * @param  ContactImport|int  $import  A ContactImport object to enquire about, or the import ID.
     * @return ContactImportReport         The ContactImportReport for the selected import.
     */
    public function getReport($import)
    {
        $response = $this->request->send('get', '/import/'.$this->findId($import).'/report');
        return new ContactImportReport($response);
    }

    /**
     * Get a list of details that failed to be imported. 
     *
     * @param  ContactImport|int  $import  A ContactImport object to enquire about, or the import ID.
     * @return String                      CSV of the entries that failed
     * @todo                               What could we more usefully return here, extended ContactCollection?
     */
    public function getReportFaults($import)
    {
        $response = $this->request->send('get', '/import/'.$this->findId($import).'/report-faults');
        return $response;
    }

    /**
     * Creates a CSV representation of a ContactCollection.
     * 
     * @param  ContactCollection  $contacts  The contacts to be transformed into CSV.
     * @return string                        A CSV representation of the passed ContactCollection.
     */
    private function createCSVFromCollection($contacts)
    {
        $csv = 'Email'; // Email is always required

        // Output the additional CSV headings, one per data item configured in the account.
        $datafields = $this->getDatafieldsForImport();
        foreach ($datafields as $field) {
            $csv .= ',';
            $csv .= $this->csvescape($field->name);
        }
        $csv .= "\n";

        // Add each contact in turn
        foreach ($contacts as $contact) {
            // Output the email first
            $csv .= $this->csvescape($contact->email);
            // Then any datafields
            foreach ($datafields as $field) {
                $csv .= ',';
                $csv .= $this->csvescape($contact->getDataField($field->name));
            }
            $csv .= "\n";
        }
        return $csv;
    }

    /**
     * Escape a string for inclusion in a CSV file.
     * @param  string  $string  The string to be escaped.
     * @return string           The escaped string.
     */
    private function csvescape($string) {
        $doneescape = false;
        if (stristr($string,'"')) {
            $string = str_replace('"','""',$string);
            $string = "\"$string\"";
            $doneescape = true;
        }
        $string = str_replace("\n",' ',$string);
        $string = str_replace("\r",' ',$string);
        if (stristr($string,',') && !$doneescape) {
            $string = "\"$string\"";
        }
        return $string;
    }

    /**
     * Get a collection of all of the data fields on the account.
     * 
     * @return DatafieldCollection The list of datafields.
     */
    private function getDatafieldsForImport()
    {
        $req = new DataFieldRequest($this->config);
        $datafields = $req->getAll();
        return $datafields;
    }

}
