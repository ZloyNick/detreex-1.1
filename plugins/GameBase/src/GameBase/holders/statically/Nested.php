<?php


namespace GameBase\holders\statically;

use ArrayAccess;

use function is_array;

class Nested implements ArrayAccess
{

    /** @var string[]|Nested  */
    private static $data = [];

    public function offsetExists($offset)
    {
        return static::$data;
    }

    public static function push(array $data) : Nested
    {
        $originalData = &static::$data;
        foreach ($data as $key => $value)
        {
            if(is_array($data[$key]))
            {
                $originalData[$key] = Nested::push($value);
            }else{
                $originalData[$key] = $value;
            }
        }
        return new static;
    }

    public function offsetGet($offset)
    {
        return static::$data;
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }
}