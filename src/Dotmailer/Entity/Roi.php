<?php

namespace Dotmailer\Entity;

/**
 * An ROI record.
 * @todo reference
 *
 * @extends Dotmailer\Entity
 */
class Roi extends Entity
{
    protected $contactId;
    protected $email;
    protected $markerName;
    protected $dataType;
    protected $value;
    protected $dateEntered;
}
