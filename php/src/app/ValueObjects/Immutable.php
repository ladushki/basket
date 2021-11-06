<?php

namespace Netrebel\ValueObjects;

use Netrebel\Exceptions\ImmutableObjectException;

trait Immutable
{
    /**
     * Indicator if the object was initialized.
     *
     * @var boolean
     */
    private bool $initialized = false;

    /**
     * Init properties.
     *
     * @param array $properties Data array.
     * @return \Netrebel\ValueObjects\Immutable
     * @throws ImmutableObjectException If the property does not exist.
     */
    public function with(array $properties): Immutable
    {
        $object = $this;

        if ($this->isInitialized()) {
            $object = clone $this;
        }

        foreach ($properties as $name => $value) {
            if (!property_exists($this, $name)) {
                throw ImmutableObjectException::new($this, "Property '$name' does not exists");
            }

            $object->$name = $value;
        }

        return $object;
    }

    /**
     * Serialize.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $variables = get_object_vars($this);
        unset($variables['initialized']);

        return $variables;
    }

    /**
     * Check if initialized.
     *
     * @return boolean
     */
    public function isInitialized(): bool
    {
        return $this->initialized;
    }

    /**
     * Don't allow to call a property directly.
     * This will enforce the use of Accessors methods to get their values.
     *
     * @param string $propertyName The property name.
     * @return void
     * @throws ImmutableObjectException When we try to call directly a property in the class.
     */
    public function __get(string $propertyName): void
    {
        throw ImmutableObjectException::new($this, "Can't get property {$propertyName} directly");
    }

    /**
     * @param string         $propertyName The property name.
     * @param integer|string $value        The property value to be set.
     * @return  void
     * @throws ImmutableObjectException When we try to set or create a property in the class.
     */
    public function __set(string $propertyName, int|string $value): void
    {
        if ($propertyName !== 'initialized') {
            throw ImmutableObjectException::new($this, "Can't set property {$propertyName} to {$value}");
        }
    }

    /**
     * @param string $propertyName The property name.
     * @return void
     * @throws ImmutableObjectException When we try to unset a property in the class.
     */
    public function __unset(string $propertyName): void
    {
        throw ImmutableObjectException::new($this, "Can't unset property {$propertyName}");
    }

}