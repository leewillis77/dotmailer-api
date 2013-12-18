<?php

namespace Dotmailer\Entity;

/**
 * Account summary.
 * http://api.dotmailer.com/v2/help/wadl#ApiAccount
 *
 * @extends Dotmailer\Entity
 */
class Account extends Entity
{
    protected $id;
    protected $properties; // @TODO - map the individual properties

    public function getProperty($name)
    {
        foreach ($this->properties as $key => $value) {
            if ($value->name == $name) {
                return $value->value;
            }
        }
        trigger_error(
            'Undefined account property: ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE
        );
        return null;
    }
}
