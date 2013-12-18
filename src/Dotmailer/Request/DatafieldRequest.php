<?php

namespace Dotmailer\Request;

use Dotmailer\Config;
use Dotmailer\Collection\DatafieldCollection;
use Dotmailer\Entity\Datafield;

class DatafieldRequest
{
    private $request;

    public function __construct(Config $config)
    {
        $this->request = new Request($config);
        $this->request->setEndpoint('data-fields');
    }

    public function getAll()
    {
        $fields = $this->request->send('get', '');
        if (count($fields)) {
            return new DatafieldCollection($fields);
        } else {
            return $fields;
        }
    }

    public function create(Datafield $datafield)
    {
        return $this->request->send('post', '', $datafield);
    }

    public function delete($datafield)
    {
        if (is_scalar($datafield)) {
            $datafield_name = $datafield;
        } elseif (is_object($datafield)) {
            $datafield_name = $datafield->getName();
        } else {
            throw new Exception('Invalid datafield reference.');
        }
        return $this->request->send('delete', '/' . $datafield_name);
    }
}
