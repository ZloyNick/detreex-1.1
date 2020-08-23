<?php

declare(strict_types=1);

namespace GameBase\event;

use GameBase\Loader;
use GameBase\player\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use GameBase\Server;

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
            $list->{$player->getName()} = new (Loader::getPlayerClass())($player);
        }
    }

}