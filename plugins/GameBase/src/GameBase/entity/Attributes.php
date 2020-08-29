<?php


namespace GameBase\entity;

use ReflectionClass;
use ReflectionException;
use ArrayAccess;

class Attributes implements ArrayAccess
{

    /** @var int[] */
    private $attributes = [];

    //attributes
    
    const STRENGTH = "strength";
    const INTELLIGENCE = "intelligence";

    const AGILITY = "agility";

    const VITALITY = "vitality";
    const WISDOM = "wisdom";

    /**
     * @throws ReflectionException
     */
    public function __construct()
    {
        $class = new ReflectionClass($this);
        foreach ($class->getConstants() as $k => $v)
        {
            $this->attributes[$v] = 0;
        }
    }

    /**
     * With checking
     *
     * @param array $attributes
     */
    public function push(array $attributes)
    {
        foreach ($attributes as $attribute => $value)
        {
            if(isset($this->{$attribute}) && (is_float($value) || is_int($value)))
            {
                $this->{$attribute} = $value;
            }
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    /**
     * Attributes are strong.
     *
     * @param mixed $offset
     * @return int|mixed
     */
    public function offsetGet($offset)
    {
        return $this->attributes[$offset];
    }

    public function offsetSet($offset, $value)
    {
        // Cancelled mutation of original keys
        // Attributes data keys not changeable.
        if($this->offsetExists($offset) && (is_float($value) || is_int($value)))
        {
            $this->attributes[$offset] = $value;
        }
    }

    /**
     * Attributes not changeable.
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset){}

}