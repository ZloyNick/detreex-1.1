<?php


namespace GameBase;


use GameBase\holders\dynamic\PlayerList;

class Server
{

    /**
     * @var Loader $loader
     * @var PlayerList $playerList
     */
    private static $loader;
    private static $playerList;

    public function __construct(Loader $loader)
    {
        static::$playerList = new PlayerList;
        static::$loader = $loader;
    }

    public static function getPlayerList() : PlayerList
    {
        return static::$playerList;
    }

}