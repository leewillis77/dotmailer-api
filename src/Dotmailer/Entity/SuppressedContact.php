<?php

namespace Dotmailer\Entity;

/**
 * A suppressed contact record.
 * http://api.dotmailer.com/v2/help/wadl#ApiContactSuppression
 *
 * @extends Dotmailer\Entity
 */
class SuppressedContact extends Entity
{
    public $suppressedContact;
    protected $dateRemoved;
    protected $reason;

    public function __construct($input = null)
    {
        parent::__construct($input);
        if (!empty($this->suppressedContact)) {
          $this->suppressedContact = new Contact($this->suppressedContact);
        }
    }
}
