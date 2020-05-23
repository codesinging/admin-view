<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-21 14:44:35
 */

namespace CodeSinging\AdminView\Foundation;

class Attribute extends Buildable
{
    /**
     * @var Property[] All of the attribute's Property items.
     */
    protected $items = [];

    /**
     * Attribute constructor.
     *
     * @param array ...$attributes
     */
    public function __construct(...$attributes)
    {
        foreach ($attributes as $attribute) {
            $this->set($attribute);
        }
    }

    /**
     * Add an property to the attribute items.
     *
     * @param string $name
     * @param mixed  $value
     * @param mixed  $default
     *
     * @return $this
     */
    public function add(string $name, $value = null, $default = null)
    {
        $property = new Property($name, $value, $default);
        $this->items[$property->name()] = $property;

        return $this;
    }

    /**
     * Set one or multiple properties.
     *
     * @param string|array $name
     * @param mixed        $value
     * @param mixed        $default
     *
     * @return $this
     */
    public function set($name, $value = null, $default = null)
    {
        if (is_string($name)) {
            $this->add($name, $value, $default);
        } elseif (is_array($name)) {
            $defaults = is_array($value) ? $value : [];
            foreach ($name as $key => $val) {
                is_int($key) and [$key, $val] = [$val, null];
                $this->add($key, $val, $defaults[$key] ?? null);
            }
        }

        return $this;
    }

    /**
     * Determine if the given Property exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name)
    {
        return array_key_exists($name, $this->items);
    }

    /**
     * Determine if the attribute items is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Clear all items.
     *
     * @return $this
     */
    public function clear()
    {
        $this->items = [];
        return $this;
    }

    /**
     * Get all of the attribute items.
     *
     * @return Property[]
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function build()
    {
        $array = [];
        foreach ($this->items as $property) {
            $array[] = $property->build();
        }

        return implode(' ', $array);
    }
}