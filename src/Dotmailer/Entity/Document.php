<?php

namespace Dotmailer\Entity;

/**
 * A document record.
 * http://api.dotmailer.com/v2/help/wadl#ApiDocument
 *
 * @extends Dotmailer\Entity
 */
class Document extends Entity
{
    protected $id;
    public $name;
    public $fileName;
    public $fileSize;
    public $dateCreated;
    public $dateModified;
}
