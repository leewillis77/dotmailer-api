<?php

namespace Dotmailer\Entity;

/**
 * Base class for entity classes.
 *
 * Implements generic methods for constructing from an object, or array.
 */
abstract class Entity
{
    protected $non_serial_properties = array('non_serial_properties');

    /**
     * Construct the class from a set of values. The input can be either
     * an array or an object, and the constructor will attempt to map
     * the fields onto the selected object's properties.
     *
     * @param object|array $input The values to instantiate the object with.
     */
    public function __construct($input = null)
    {
        if (is_array($input)) {
            $this->constructFromArray($input);
        } elseif (is_object($input)) {
            $this->constructFromObject($input);
        }
    }

    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE
        );
        return null;
    }

    public function __isset($name)
    {
        return isset($this->$name);
    }

    /**
     * Construct the class from an array.
     *
     * @param  Array  $arr The input array
     */
    private function constructFromArray(Array $arr)
    {
        // Get the properties of the target class.
        $reflector  = new \ReflectionClass(get_called_class());
        $properties = $reflector->getProperties();
        if (count($properties)) {
            // Map array elements to object properties
            foreach ($properties as $property) {
                $name = $property->name;
                if (isset($arr[$name])) {
                    $this->$name = $arr[$name];
                }
            }
        }
    }

    /**
     * Construct the class from an object.
     *
     * @param  Object  $obj The input object
     */
    private function constructFromObject($obj)
    {
        $reflector  = new \ReflectionClass(get_called_class());
        $properties = $reflector->getProperties();
        if (count($properties)) {
            foreach ($properties as $property) {
                $name = $property->name;
                if (isset ($obj->$name)) {
                    $this->$name = $obj->$name;
                }
            }
        }
    }

    /**
     * Serialize the class to a JSON string.
     *
     * Excludes any properties listed in the non_serial_properties property.
     *
     * @return string  A JSON representation of the class
     */
    public function toJson()
    {
        // Find all properties of the class
        $reflector  = new \ReflectionClass(get_called_class());
        $properties = $reflector->getProperties();

        $return = new \stdClass();
        // Loop through all properties, and create an array containing
        // only those properties that aren't excluded.
        if (count($properties)) {
            foreach ($properties as $property) {
                $name = $property->name;
                // Exclude any properties the class wants to exclude
                if (in_array($name, $this->non_serial_properties)) {
                    continue;
                }
                // Exclude any empty properties
                if (is_null($this->$name)) {
                    continue;
                }
                $return->$name = $this->$name;
            }
        }
        return json_encode($return);
    }
}
