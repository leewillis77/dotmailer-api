<?php

namespace Dotmailer\Entity;

/**
 * A contact import record.
 * http://api.dotmailer.com/v2/help/wadl#ApiContactImport
 *
 * @extends Dotmailer\Entity
 */
class ContactImport extends Entity
{
    protected $id;
    protected $status;
}
