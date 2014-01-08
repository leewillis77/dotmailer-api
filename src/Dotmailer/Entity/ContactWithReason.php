<?php

namespace Dotmailer\Entity;

/**
 * A contact record with reason field - used to reflect responses from import jobs.
 *
 * @extends Dotmailer\Entity\Contact
 */
class ContactWithReason extends Contact
{
    public $reason;

    function __construct($input)
    {
        $this->non_serial_properties[] = 'reason';
        parent::__construct($input);
    }
}
