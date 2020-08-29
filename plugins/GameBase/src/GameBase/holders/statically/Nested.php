<?php


namespace GameBase\holders\statically;

use ArrayAccess;
use Countable;

use function is_array;

class Nested implements ArrayAccess, Countable
{

    /** @var string[]|Nested  */
    private static $data = [];

    public function offsetExists($offset)
    {
        return static::$data;
    }

    /**
     * Recursive fill
     *
     * @param array $data
     * @return Nested
     */
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

    public function compareData(){
        $data = [];
        foreach (static::$data as $k => $v)
        {
            if($v instanceof Nested)
                $data[$k] = $v->compareData();
            else
                $data[$k] = $v;
        }
        return $data;
    }

    public function offsetGet($offset)
    {
        return static::$data ?: null;
    }

    public function offsetSet($offset, $value)
    {
        static::$data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if($this->offsetExists($offset))
            unset(static::$data[$offset]);
    }

    public function count()
    {
        return count(static::$data);
    }

    public function countAll() : int
    {
        $c = 0;
        foreach (static::$data as $k => $v)
        {
            $c++;
            if($v instanceof Nested)
            {
                $c += $v->countAll();
            }
        }
        return $c;
    }
}