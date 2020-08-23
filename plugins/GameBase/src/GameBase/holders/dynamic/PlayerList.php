<?php


namespace GameBase\holders\dynamic;

function replace(&$offset) : void
{
    $offset = str_replace(' ', '_', $offset);
}

use ArrayAccess;
use Exception;

use GameBase\player\Player;

class PlayerList implements ArrayAccess
{

    /**
     * @var Player[]
     */
    private static $players = [];

    public function offsetExists($offset)
    {
        replace($offset);
        return isset(static::$players[$offset]);
    }

    public function offsetGet($offset)
    {
        replace($offset);
        return
            isset(static::$players[$offset]) ? static::$players[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws Exception
     */
    public function offsetSet($offset, $value)
    {
        replace($offset);
        if($value instanceof Player)
            static::$players[$offset] = $value;

        throw new Exception('Value must be instance of '.Player::class);
    }

    public function offsetUnset($offset)
    {
        replace($offset);
        if(isset(static::$players[$offset]))
        {
            static::$players[$offset]->save();
        }
    }
}