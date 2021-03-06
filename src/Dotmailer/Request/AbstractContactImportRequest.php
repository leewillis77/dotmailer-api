<?php

namespace Dotmailer\Request;

use Dotmailer\Config;
use Dotmailer\Exception;
use Dotmailer\Entity\ContactImport;
use Dotmailer\Entity\ContactImportReport;
use Dotmailer\Entity\ContactWithReason;
use Dotmailer\Collection\ContactCollection;
use Dotmailer\Request\DatafieldRequest;


abstract class AbstractContactImportRequest
{
    protected $request;
    protected $config;

    abstract public function __construct(Config $config);

    protected function findId($object)
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
        $response = $this->csvToContactCollection($response);
        return $response;
    }

    protected function csvToContactCollection($input) {
        $input = str_getcsv($input, "\n"); //parse the rows
        $headings = array_shift($input);
        $headings = str_getcsv($headings, ',');
        $contacts = array();
        while($row = array_shift($input)) {
            $row = str_getcsv($row, ","); //parse the items in rows
            $item = array();
            $reason = $row[0];
            $email = $row[1];
            $contact = new ContactWithReason(
                array(
                    'email' => $email,
                    'reason' => $reason,
                )
            );
            foreach ($row as $idx => $value) {
                if ($idx < 2)
                    continue;
                $contact->setDataField(strtoupper($headings[$idx]), $value);
            }
            $contacts[] = $contact;
        }
        $collection = new ContactCollection($contacts);
        return $collection;
    }

    /**
     * Creates a CSV representation of a ContactCollection.
     *
     * @param  ContactCollection  $contacts  The contacts to be transformed into CSV.
     * @return string                        A CSV representation of the passed ContactCollection.
     */
    protected function createCSVFromCollection($contacts)
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
    protected function csvescape($string) {
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
    protected function getDatafieldsForImport()
    {
        $req = new DataFieldRequest($this->config);
        $datafields = $req->getAll();
        return $datafields;
    }

}
