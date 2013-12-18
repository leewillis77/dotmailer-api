<?php

namespace Dotmailer\Entity;

/**
 * A data field.
 * http://api.dotmailer.com/v2/help/wadl#ApiDataField
 *
 * @extends Dotmailer\Entity
 */
class Datafield extends Entity
{
    protected $name;
    public $type;
    public $visibility;
    public $defaultValue;

    public function getName()
    {
        return $this->name;
    }
}
