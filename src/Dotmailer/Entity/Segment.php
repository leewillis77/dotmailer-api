<?php

namespace Dotmailer\Entity;

/**
 * A segment record.
 * http://api.dotmailer.com/v2/help/wadl#ApiSegment
 *
 * @extends Dotmailer\Entity
 */
class Segment extends Entity
{
    protected $id;
    protected $name;
    protected $contacts;
}
