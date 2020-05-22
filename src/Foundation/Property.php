<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-21 11:03:52
 */

namespace CodeSinging\AdminView\Foundation;

use CodeSinging\AdminView\Support\Str;

class Property extends Buildable
{

    /**
     * @var string Property name.
     */
    protected $name;

    /**
     * @var mixed Property value.
     */
    protected $value;

    /**
     * @var bool If the property is a `v-bind` property.
     */
    protected $isBind = false;

    /**
     * @var mixed The property's default value.
     */
    protected $default = null;

    /**
     * Property constructor.
     *
     * @param string $name
     * @param mixed  $value
     * @param mixed  $default
     */
    public function __construct(string $name, $value = null, $default = null)
    {
        $this->init($name, $value, $default);
    }

    /**
     * Initialize the property.
     *
     * @param string $name
     * @param mixed  $value
     * @param mixed  $default
     *
     * @return $this;
     */
    public function init(string $name, $value = null, $default = null)
    {
        if (Str::startsWith($name, ':')) {
            $this->name = ltrim($name, ':');
            $this->isBind = true;
        } else {
            $this->name = $name;
        }

        if (is_string($value)) {
            if (Str::startsWith($value, ':')) {
                $this->value = substr($value, 1);
                $this->isBind = true;
            } elseif (Str::startsWith($value, ['\:', '\\'])) {
                $this->value = substr($value, 1);
            } else {
                $this->value = $value;
            }
        } elseif ($value === true) {
            $this->value = 'true';
            $this->isBind = true;
        } elseif ($value === false) {
            $this->value = 'false';
            $this->isBind = true;
        } elseif ($this->isBind === true && is_null($value)) {
            $this->value = 'true';
        } elseif (is_int($value) || is_float($value) || is_double($value)) {
            $this->isBind = true;
            $this->value = $value;
        } elseif (is_array($value)) {
            $this->value = json_encode($value);
            $this->isBind = true;
        }

        $this->default = $default;

        return $this;
    }

    /**
     * Get the property name without colon.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get default value of the property.
     *
     * @return mixed
     */
    public function default()
    {
        return $this->default;
    }

    /**
     * Determine if the property has default value
     *
     * @return bool
     */
    public function hasDefault()
    {
        return !is_null($this->default);
    }

    /**
     * Determine if the property is a `v-bind` property.
     *
     * @return bool
     */
    public function isBind()
    {
        return $this->isBind;
    }

    /**
     * Determine if a property is the same with this property.
     *
     * @param $property
     *
     * @return bool
     */
    public function is($property)
    {
        if (is_string($property)) {
            return $this->name === $property;
        }

        if ($property instanceof self) {
            return $this->name === $property->name();
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function build()
    {
        if (empty($this->name)) {
            return null;
        }

        if (!is_string($this->name)) {
            return null;
        }

        if (is_null($this->value)) {
            return sprintf('%s', $this->name);
        }

        if ($this->isBind) {
            return sprintf(':%s="%s"', $this->name, $this->value);
        } else {
            return sprintf('%s="%s"', $this->name, $this->value);
        }
    }
}