<?php

namespace Dotmailer\Entity;

/**
 * A resubscription request
 * http://api.dotmailer.com/v2/help/wadl#ApiContactResubscription
 *
 * @extends Dotmailer\Entity
 */
class Resubscription extends Entity
{
    public $unsubscribedContact;
}
