<?php

declare(strict_types=1);

namespace GameBase\event\player;

use GameBase\Loader;
use GameBase\player\Player;
use pocketmine\event\Event;

use function is_subclass_of;

use Exception;

class SetPlayerClassEvent extends Event
{

    public static $handlerList = null;

    /**
     * @var string $class
     * @var string $lastClass
     */

    public function __construct(string $class)
    {
        $this->class = $class;
        $this->lastClass = Loader::getPlayerClass();
    }

    /**
     * @return string
     */
    public function getClass() : string
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @throws Exception
     */
    public function setClass(string $class)
    {
        if(!is_subclass_of(Player::class, $class))
        {
            throw new Exception($class.' must be subclass of '.Player::class);
        }
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getOldClass() : string
    {
        return $this->lastClass;
    }

    private
        $lastClass,
        $class;

}