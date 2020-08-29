<?php

declare(strict_types=1);

namespace GameBase\event;

use GameBase\Loader;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use GameBase\Server;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener
{

    /**
     * @priority 10
     * @param PlayerPreLoginEvent $event
     */
    public function callPlayerPreLoginEvent(PlayerPreLoginEvent $event) : void
    {
        if(isset(($list = Server::getPlayerList())->{($player = $event->getPlayer())->getName()}))
        {
            //TODO: kick message
        }else{
            $class = Loader::getPlayerClass();
            $list->{$player->getName()} = new $class($player);
        }
    }

    /**
     * @priority 0
     * @param PlayerQuitEvent $event
     */
    public function callPlayerQuitEvent(PlayerQuitEvent $event) : void
    {
        unset(Server::getPlayerList()->{$event->getPlayer()->getName()});
    }

}