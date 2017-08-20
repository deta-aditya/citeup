<?php

namespace App\Modules\Electrons\Settings;

use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;

class Category implements Jsonable, JsonSerializable
{
    /**
     * The property list.
     *
     * @var array
     */
    protected $properties = [];

    /**
     * Get the category's property list.
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->properties, $options);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->getProperties();
    }

    /**
     * Dynamically get a property.
     *
     * @param  string  $property
     * @return mixed
     */
    public function __get($property)
    {
        return array_get($this->properties, $property, null);
    }

    /**
     * Dynamically set a property.
     *
     * @param  string  $property
     * @param  mixed   $val
     * @return void
     */
    public function __set($property, $val)
    {
        $this->properties[$property] = $val;
    }

    /**
     * Get the string representation of this class.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}