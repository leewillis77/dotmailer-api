<?php

namespace Dotmailer\Entity;

/**
 * An addressbook record.
 * http://api.dotmailer.com/v2/help/wadl#ApiAddressBook
 *
 * @extends Dotmailer\Entity
 */
class Addressbook extends Entity
{
    protected $id;
    public $name;
    public $visibility;
    protected $contacts;
}
