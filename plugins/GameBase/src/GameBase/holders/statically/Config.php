<?php

declare(strict_types=1);

namespace GameBase\holders\statically;

use ArrayAccess;

class Config implements ArrayAccess
{

    private static $data = [];

    static function init(array $data) : Config
    {
        $originalData = &static::$data;
        foreach($data as $lang => $dat)
        {
            foreach ($dat as $key => $value)
            {
                if(is_array($value))
                {
                    $originalData[$key] = Nested::push($value);
                }else{
                    $originalData[$key] = $value;
                }
            }
        }
        return new static;
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    public function compareData() : array
    {

    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}