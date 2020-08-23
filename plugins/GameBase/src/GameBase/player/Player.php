<?php

declare(strict_types=1);

namespace GameBase\player;

use pocketmine\level\Position;
use pocketmine\Player as _Player;

class Player
{
    public function __construct(_Player $player)
    {
        static::$player = $player;
        static::init();
    }

    public function getPlayer() : _Player
    {
        return static::$player;
    }

    private static function init() : void
    {

    }

    public function save() : void
    {

    }

    /**
     * @var _Player
     */
    private static
        $player;

    /** Implementations */

    public function getPosition() : Position
    {
        return static::$player->getPosition();
    }

    public function getName() : string
    {
        return static::$player->getName();
    }

    public function getDisplayName() : string
    {
        return static::$player->getDisplayName();
    }

    public function setDisplayName(string $newName) : void
    {
        static::$player->setDisplayName($newName);
    }

}