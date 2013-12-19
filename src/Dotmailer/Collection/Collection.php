<?php

namespace Dotmailer\Collection;

/**
 * Base class for collection classes.
 *
 * @implements ArrayAccess
 * @implements Iterator
 */
abstract class Collection implements \ArrayAccess, \Iterator, \Countable
{
    protected $collection;
    private $position;
    protected $entity_type;

    public function __construct($input)
    {
        $collection = array_map(array($this, 'callback'), $input);
        $this->collection = $collection;
        $this->position = 0;
    }

    /**
     * ArrayAccess functions
     */

    public function offsetExists($offset)
    {
        return isset($this->collection[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->collection[$offset]) ? $this->collection[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->collection[$offset]);
    }

    /**
     * Iterator functions
     */

    public function current()
    {
        return $this->collection[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return isset($this->collection[$this->position]);
    }

    /**
     * Countable functions
     */

    public function count()
    {
        return count($this->collection);
    }

    /*
     * Class specific functions
     */
    protected function callback($element)
    {
        return new $this->entity_type($element);
    }

    public function hasItemWith($keyname, $reqvalue)
    {
        foreach ($this->collection as $key => $value) {
            if ($value->$keyname == $reqvalue) {
                return true;
            }
        }
        return false;
    }

    public function toArray()
    {
        foreach ($this->collection as $key => $value) {
            $return[$key] = $value->toStdClass();
        }
        return $return;
    }
}
