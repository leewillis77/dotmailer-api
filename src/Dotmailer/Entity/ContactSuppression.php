<?php

namespace Dotmailer\Entity;

/**
 * A contact suppression record.
 * http://api.dotmailer.com/v2/help/wadl#ApiContactSuppression
 *
 * @extends Dotmailer\Entity
 */
class ContactSuppression extends Entity
{
    public $suppressedContact;
}
