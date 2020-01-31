<?php

namespace ConvenientImmutability;

trait Immutable
{
    private $_defaultValues = [];
    private $_userDefinedValues = [];
    private $_userDefinedProperties = [];

    private static $_doNotTakeOverProperties = [
        '_defaultValues' => true,
        '_userDefinedValues' => true,
        '_userDefinedProperties' => true,
    ];

    public function __construct()
    {
        // take over all user-defined non-static properties
        foreach ((new \ReflectionObject($this))->getProperties() as $property) {
            $propertyName = $property->getName();

            if (isset(self::$_doNotTakeOverProperties[$propertyName]) || $property->isStatic()) {
                continue;
            }

            $this->_userDefinedProperties[$propertyName] = true;
            if ($property->isInitialized($this)) {
                $this->_defaultValues[$propertyName] = $property->getValue($this);
            }
            unset($this->{$propertyName});
        }
    }

    final public function __set($name, $value)
    {
        if (!isset($this->_userDefinedProperties[$name])) {
            throw new \LogicException('Unknown property "' . $name . '"');
        }

        if (array_key_exists($name, $this->_userDefinedValues)) {
            throw new \LogicException('You can not overwrite the value for property "' . $name . '"');
        }

        $this->_userDefinedValues[$name] = $value;
    }

    final public function __get($name)
    {
        if (!isset($this->_userDefinedProperties[$name])) {
            throw new \LogicException('Unknown property "' . $name . '"');
        }

        if (array_key_exists($name, $this->_userDefinedValues)) {
            return $this->_userDefinedValues[$name];
        }

        return $this->_defaultValues[$name];
    }

    final public function __wakeup()
    {
        foreach ($this->_userDefinedProperties as $property => $defined) {
            unset($this->{$property});
        }
    }
}
