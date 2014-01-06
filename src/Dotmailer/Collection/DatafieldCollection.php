<?php

namespace Dotmailer\Collection;

/**
 * A collection of Dotmailer\Datafield objects.
 *
 * @extends Dotmailer\Collection
 */
class DatafieldCollection extends Collection
{
    protected $entity_type = 'Dotmailer\Entity\Datafield';

    public function hasField($field_name)
    {
      foreach ($this->collection as $field) {
        if ($field->getName() == $field_name)
          return true;
      }
      return false;
    }
}
