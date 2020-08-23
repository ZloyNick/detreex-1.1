<?php

declare(strict_types=1);

namespace GameBase;

use GameBase\event\EventListener;
use GameBase\event\player\SetPlayerClassEvent;
use GameBase\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginManager;

use function is_subclass_of;

use Exception;

class Loader extends PluginBase
{

    /**
     * Static variables
     *
     * @var Player $playerClass
     * @var Server $_server
     */
    private static
        $_server,
        $playerClass = '';

    /**
     * Enables plugin
     */
    public function onEnable() : void
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener, $this);
        static::$_server = new Server($this);
        $this->setPlayerClass(Player::class);
    }

    /**
     * Returns instance of current Loader
     *
     * @return Loader
     */
    public static function getInstance() : Loader
    {
        return new static;
    }

    public function _getServer() : Server
    {
        return static::$_server;
    }

    /**
     * @param string $class
     * @throws Exception
     */
    public function setPlayerClass(string $class) : void
    {
        if($class != Player::class && !is_subclass_of($class, Player::class))
        {
            throw new Exception($class.' must be subclass of '.Player::class);
        }
        $this->getServer()->getPluginManager()->callEvent($ev = new SetPlayerClassEvent($class));
        static::$playerClass = $ev->getClass();
    }

    /**
     * @return string
     */
    public static function getPlayerClass() : string
    {
        return static::$playerClass;
    }

}